<?php

class Home extends Controller
{
    private $db;
    private $seeders;

    /**
     * Home constructor.
     * Load database and models
     */
    public function __construct()
    {
        $this->db = new Database();
        $this->seeders = new Seeders();

        $this->articlesModel = $this->model('Article');

        $this->categoryModel = $this->model('Category');
    }

    /**
     * Shows all approved articles
     */
    public function index()
    {

        $articles = $this->articlesModel->getArticlesApproved();
        $categories = $this->categoryModel->getCategories();

        $data = [
            'articles' => $articles,
            'categories' => $categories,

        ];
        $this->view('home/index', $data);
    }


    /**
     * Insert tables into database
     */
    public function migration(){
        $this->db->migrate();

        redirect('home/index');
    }

    /**
     * Insert data into specific tables
     */
    public function seeder(){
        $this->seeders->seeder();

            redirect('home/index');
        }



}