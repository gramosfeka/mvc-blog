<?php
require_once '../app/requests/ArticleRequest.php';

class Articles extends Controller
{
    /**
     * Articles constructor.
     * Load models
     */
    public function __construct()
    {
        $this->articlesModel = $this->model('Article');
        $this->categoryModel = $this->model('Category');
        $this->tagModel = $this->model('Tag');
        $this->userModel = $this->model('User');
        $this->articleRequest = new ArticleRequest();


    }

    /**
     * Shows all articles that has been created from user that is logged in
     */
    public function index()
    {
        if (isAdmin()) {
            $articles = $this->articlesModel->getArticlesNotApproved();
        } else {
            $articles = $this->articlesModel->getArticles();
        }

        $data = [
            'articles' => $articles
        ];

        $this->view('articles/index', $data);
    }

    /**
     * Load form for creat post
     */
    public function create()
    {

        if (isAdmin()) {
            redirect('home/index');
        }
        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTags();

        $data = [
            'title' =>'',
            'slug' => '',
            'body' => '',
            'created_at' => '',
            'categories' => $categories,
            'tags' => $tags,
            'date'=>'',
            'image' => '',
            'user_id' =>'',
            'status' =>'',

        ];
        $this->view('articles/create', $data);


    }


    /**
     * Add Article
     */
    public function store(){

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTags();


        if (isset($_FILES['image']['name'])) {
            $folder = "img/";
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }

        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower(rand(0,1000).'-'.$_POST['title'])));

        $data = [
            'title' => $_POST['title'],
            'body' => $_POST['body'],
            'slug' => $slug,
            'image' => $destination,
            'user_id' => $_SESSION['user_id'],
            'category_id' => $_POST['category_id'],
            'categories' => $categories,
            'created_at' => $_POST['created_at'],
            'tags' => $tags ,
            'selectedTags' => $_POST['tags'],
            'title_err' => '',
            'category_err' => '',
            'tags_err' => '',
            'image_err' => '',
            'body_err' => '',
            'created_at_err' => '',

        ];

        $data = $this->articleRequest->ValidationForm($data);

        if(!empty($data['errors'])){
            $this->view('articles/create', $data);
        } else{

            $this->articlesModel->createArticle($data);
            $this->articlesModel->tagsArticle($data);
            flash('articles_message','Article created successfully!');
            redirect('articles/index');
        }
    }

    /**
     * @param $id
     * Load edit form for specific article
     */
    public function edit($id)
    {

        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTags();
        $article = $this->articlesModel->getArticleById($id);
        $articleTags = $this->tagModel->getTagByArticle($id);

        if (isAdmin() || $_SESSION['user_id'] != $article->user_id) {
            redirect('home/index');
        }

        $data = [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'body' => $article->body,
                'categories' => $categories,
                'articleTags' => $articleTags,
                'article' => $article,
                'created_at' => $article->created_at,
                'tags' => $tags,
                'image' => '',
                'user_id' => '',

            ];

            $this->view('articles/edit', $data);

    }

    /**
     * @param $id
     * Edit specific article
     */
    public function update($id){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTags();
        $article = $this->articlesModel->getArticleById($id);

        $articleTags = $this->tagModel->getTagByArticle($id);

        if (isset($_FILES['image']['name'])) {
            $folder = "img/";
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }

        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(rand(0,1000).'-'.strtolower($_POST['title'])));

        $data = [
            'id' => $article->id,
            'title' => $_POST['title'],
            'body' => $_POST['body'],
            'image' => $destination,
            'category_id' => $_POST['category_id'],
            'created_at' => $_POST['created_at'],
            'categories' => $categories,
            'article' => $article,
            'tags' =>  $tags,
            'selectedTags' => $_POST['tags'],
            'slug' => $slug,
            'articleTags' => $articleTags,
            'title_err' => '',
            'category_err' => '',
            'tags_err' => '',
            'image_err' => '',
            'body_err' => '',

        ];

        $data = $this->articleRequest->ValidationForm($data);

        if(!empty($data['errors'])){
            $this->view('articles/edit', $data);
        } else{
            $this->articlesModel->editArticle($data);
            $this->articlesModel->editTagsArticle($data);
            flash('articles_message', 'Article updated successfully');
            redirect('articles/index');

        }
    }

    /**
     * @param $id
     * Delete specific article
     */
    public function delete($id)
    {
        if ($this->articlesModel->deleteArticle($id)) {
            flash('articles_message', 'Article Removed');
            redirect('articles/index');
        } else {
            die('Something went wrong');
        }

    }

    /**
     * @param $id
     * Approve specific article that created from user
     */
    public function approve($id)
    {
        if (!isAdmin()) {
            redirect('home/index');
        }

        $this->articlesModel->approve($id);
        flash('articles_message', 'Article has been approved');

        redirect('articles/index');
    }

    /**
     * @param $slug
     * Show single page of specific article
     */
    public function single($slug)
    {

        $article = $this->articlesModel->getArticleBySlug($slug);
        $categories = $this->categoryModel->getCategories();
        $users = $this->userModel->getUsers();
        $tags = $this->tagModel->getTagByArticle($article->id);
        $data = [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
            'users' => $users
        ];

        $this->view('articles/single', $data);
    }

    /**
     * @param $category
     * Shows articles of specific category
     */
    public function getArticlesByCategory($category)
    {
        $articles = $this->articlesModel->getArticlesByCategory($category);
        $categories = $this->categoryModel->getCategories();

        $data = [
            'articles' => $articles,
            'categories' => $categories,

        ];
        $this->view('home/index', $data);

    }


    /**
     * Change position of table rows on articles table
     */
    public function positions(){
        $this->articlesModel->positions();
    }


}