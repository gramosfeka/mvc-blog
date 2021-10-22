<?php

class Article
{
    private $db;

    /**
     * Article constructor.
     * Load database
     */
    public function __construct()
    {
        $this->db = new Database();
    }


    /**
     * @return mixed
     * returns all articles of specific user that is logged in
     */
    public function getArticles()
    {
        $user_loggedIn = $_SESSION['user_id'];
        $this->db->query("SELECT * FROM articles WHERE user_id = :user_id ");
        $this->db->bind(':user_id', $user_loggedIn);


        $results = $this->db->resultset();

        return $results;
    }

    /**
     * @return mixed
     * returns all articles that are approved
     */
    public function getArticlesApproved()
    {
        $this->db->query("SELECT * FROM articles WHERE status = :status");
        $this->db->bind(':status', 1);

        $results = $this->db->resultset();


        return $results;
    }


    /**
     * @return mixed
     * returns all articles that are not approved
     */
    public function getArticlesNotApproved()
    {
        $this->db->query("SELECT * FROM articles WHERE status = :status ORDER BY position");
        $this->db->bind(':status', 0);

        $results = $this->db->resultset();

        return $results;
    }

    /**
     * @param $category
     * @return mixed
     * returns all articles of specific category
     */
    public function getArticlesByCategory($category)
    {
        $this->db->query("SELECT * FROM articles WHERE status = :status and category_id = :category_id");
        $this->db->bind(':status', 1);
        $this->db->bind(':category_id', $category);

        $results = $this->db->resultset();

        return $results;
    }


    /**
     * @param $id
     * @return mixed
     * return article of specific id
     */
    public function getArticleById($id)
    {
        $this->db->query("SELECT * FROM articles WHERE id = :id");

        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }


    /**
     * @param $slug
     * @return mixed
     * return article of specific slug
     */
    public function getArticleBySlug($slug)
        {
            $this->db->query("SELECT * FROM articles WHERE slug = :slug");

            $this->db->bind(':slug', $slug);

            $row = $this->db->single();

            return $row;
        }


    /**
     * @param $data
     * @return bool
     * Add article on database
     */
    public function createArticle($data)
    {
        $this->db->query('INSERT INTO articles (category_id, title, slug, body, user_id, image, created_at) VALUES (:category_id, :title, :slug, :body, :user_id,:image,:created_at)');

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':created_at', $data['created_at']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $data
     * Add tags that are selected for specific article on table article_tag
     */
    public function tagsArticle($data)
    {
        $this->db->query('SELECT id FROM articles WHERE slug = :slug');
        $this->db->bind(':slug', $data['slug']);
        $row = $this->db->single();

        foreach ($data['selectedTags'] as $tag) {

            $this->db->query('INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)');
            $this->db->bind(':article_id', $row->id);
            $this->db->bind(':tag_id', $tag);
            $this->db->execute();
        }

    }


    /**
     * @param $data
     * Edit tags that are selected for specific article on table article_tag
     */
    public function editTagsArticle($data)
    {
        $this->db->query('SELECT * FROM articles WHERE slug = :slug');
        $this->db->bind(':slug', $data['slug']);
        $article = $this->db->single();


        $this->db->query('DELETE FROM article_tag WHERE article_id = :id');
        $this->db->bind(':id', $article->id);
        $this->db->execute();

        foreach ($data['selectedTags'] as $tag) {
            $this->db->query('INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)');
            $this->db->bind(':article_id', $article->id);
            $this->db->bind(':tag_id', $tag);
            $this->db->execute();
        }


    }


    /**
     * @param $data
     * @return bool
     * Edit article
     */
    public function editArticle($data)
    {

        $this->db->query('UPDATE articles SET title = :title, slug = :slug, category_id = :category_id, body = :body, image = :image, created_at = :created_at WHERE id = :id');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':body', $data['body']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * Delete Article
     */
    public function deleteArticle($id)
    {
        $this->db->query('DELETE FROM articles WHERE id = :id');

        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * Approve article
     */
    public function approve($id)
    {
        $this->db->query('UPDATE articles SET status = :status WHERE id = :id');
        $this->db->bind(':status', 1);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Edit positions of table rows on articles table
     */
    public function positions()
    {
        foreach ($_POST['positions'] as $position){
            $index = $position[0];
            $newPosition = $position[1];
            $this->db->query('UPDATE articles SET position = :position WHERE id = :id');
            $this->db->bind(':position',$newPosition);
            $this->db->bind(':id', $index);


            $this->db->execute();

        }


    }

}