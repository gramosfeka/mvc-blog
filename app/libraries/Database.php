<?php

class Database extends Controller
{

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stm;
    private $error;

    /**
     * Database constructor.
     * Set DSNC and create PDO instance
     */
    public function __construct()
    {
        $dsn = 'mysql:host =' . $this->host . ';dbname=' . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (Exception $e) {
            if ($e) {
                $this->view('db/error');
                die();
            }
        }
    }

    /**
     * @param $sql
     * Prepare statement with query
     */
    public function query($sql)
    {
        $this->stm = $this->dbh->prepare($sql);
    }

    /**
     * @param $param
     * @param $value
     * @param null $type
     *
     * Bind values
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value) :
                    $type = PDO::PARAM_NULL;
                    break;
                default :
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stm->bindValue($param, $value, $type);
    }

    /**
     * @return mixed
     *
     * Execute the prepared statement
     */
    public function execute()
    {
        return $this->stm->execute();
    }

    /**
     * @return mixed
     *
     * Get result set as array of objects
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stm->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     *
     * Get result set as associative  array
     */
    public function resultSetASSOC()
    {
        $this->execute();
        return $this->stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     *
     * Get single record as object
     */
    public function single()
    {
        $this->execute();

        return $this->stm->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     *
     * Get row count
     */
    public function rowCount()
    {
        return $this->stm->rowCount();
    }

    /**
     * Insert tables into database
     */
    public function migrate()
    {

        $usersQuery = "
        
        DROP TABLE IF EXISTS `users`;
        CREATE TABLE `users`  (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          `role` enum('user','admin')  NOT NULL DEFAULT 'user',
          `hash` varchar(255) NOT NULL,
          `active` tinyint(1) DEFAULT 0,
          `created_at` datetime  ON UPDATE CURRENT_TIMESTAMP(0),
          PRIMARY KEY (`id`)
        )               
        
        ";

        $this->query($usersQuery);
        $this->execute();



        $categoriesQuery = "
        DROP TABLE IF EXISTS `categories`;
        CREATE TABLE `categories`  (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          PRIMARY KEY (`id`) 
          )
         
        ";
        $this->query($categoriesQuery);
        $this->execute();



        $tagsQuery="
                DROP TABLE IF EXISTS tags;
                CREATE TABLE tags  (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  name varchar(255) NOT NULL,
                  PRIMARY KEY (id) 
                )                   
            ";

        $this->query($tagsQuery);
        $this->execute();



        $articlesQuery = "
        
        DROP TABLE IF EXISTS `articles`;
        CREATE TABLE `articles`  (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `slug` varchar(255) NOT NULL,
          `body` varchar(255) NOT NULL,
          `image` varchar(255) NOT NULL,
          `user_id` int(11) NOT NULL,
          `category_id` int(11) NOT NULL,
          `status` tinyint(1) DEFAULT 0,
          `created_at` time NULL DEFAULT NULL,
          `position` int(255) DEFAULT 0,
          PRIMARY KEY (`id`),
          CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        )
        
        ";


        $this->query($articlesQuery);
        $this->execute();



        $article_tagQuery = "
        
        DROP TABLE IF EXISTS `article_tag`;
        CREATE TABLE `article_tag`  (
          `article_id` int(11) NOT NULL,
          `tag_id` int(11) NOT NULL,
          CONSTRAINT `article_id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        )
        
        ";

        $this->query($article_tagQuery);
        $this->execute();



    }


}