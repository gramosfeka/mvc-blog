<?php

class Home extends Controller
{
    private $db;
    private $seeders;
    public function __construct()
    {
        $this->db = new Database();
        $this->seeders = new Seeders();

        $this->articlesModel = $this->model('Article');

        $this->categoryModel = $this->model('Category');
    }

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


    public function migration(){
        $this->db->migrate();


        redirect('home/index');
    }

    public function seeder(){
        $this->seeders->seeder();

            redirect('home/index');
        }



}