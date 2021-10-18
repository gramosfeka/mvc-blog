<?php

class Home extends Controller
{
    public function __construct()
    {

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

    public function about()
    {
        $this->view('home/about');
    }


    public function db()
    {
        $this->view('home/about');
    }



}