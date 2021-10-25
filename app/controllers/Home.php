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

        if (!isLoggedIn()) {
            redirect('users/login');
        }

    }

    /**
     * Shows all approved articles
     */
    public function index($page_nr = 1)
    {

        $articles = $this->articlesModel->getArticlesApproved();
        $categories = $this->categoryModel->getCategories();
        $pagination = $this->articlesModel->pagination($page_nr);

        $data = [
            'articles' => $articles,
            'categories' => $categories,
            'pagination' => $pagination

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