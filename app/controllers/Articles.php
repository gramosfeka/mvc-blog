<?php

class Articles extends Controller{
    public function __construct()
    {
        $this->articlesModel = $this->model('Article');
        $this->categoryModel = $this->model('Category');
        $this->tagModel = $this->model('Tag');

    }

    public function index(){

        $articles = $this->articlesModel->getArticles();
        $data = [
            'articles' => $articles
        ];

        $this->view('articles/index',$data);
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $categories = $this->categoryModel->getCategories();
            $tags = $this->tagModel->getTags();


            if(isset($_FILES['image']['name']))
            {
                $folder = "img/";
                $destination = $folder . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            }

            $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['title']))) ;

            $data = [
                'title' => $_POST['title'],
                'slug' => $slug,
                'body' => $_POST['body'],
                'image' => $destination,
                'user_id' =>$_SESSION['user_id'],
                'category_id' =>$_POST['category_id'],
//                'status' =>$_POST['status'],
                'categories' => $categories,
                'created_at' => $_POST['created_at'],
                'tags' => $_POST['tags'],
                'title_err' => '',
                'slug_err' => '',
                'category_err' => '',
                'tags_err' => '',
                'image_err' => '',
                'body_err' => '',
                'created_at_err' => '',

            ];


            if(empty($data['title'])){
                $data['title_err'] = 'Please enter title';
            }

            if(empty($data['slug'])){
                $data['slug_err'] = 'Please enter slug';
            }

            if(empty($data['body'])){
                $data['body_err'] = 'Please enter body';
            }

            if(empty($data['category_id'])){
                $data['category_err'] = 'Please choose category';
            }
            if(empty($data['created_at'])){
                $data['created_at_err'] = 'Please choose date';
            }

            if(empty($data['image'])){
                $data['image_err'] = 'Please choose image';
            }

            if(empty($data['title_err']) && empty($data['slug_err']) && empty($data['body_err']) && empty($data['category_err']) && empty($data['tags_err']) && empty($data['image_err'])){
                if($this->articlesModel->createArticle($data)){

                  $this->articlesModel->tagsArticle($data);

                    flash('articles_message','Article created successfully');
                    redirect('articles/index');

                }else{
                    die('Something went wrong');
                }
            } else{
                $this->view('articles/create', $data);
            }


        }else{
            $categories = $this->categoryModel->getCategories();
            $tags = $this->tagModel->getTags();

            $data = [
                'title' =>'',
                'slug' => '',
                'body' => '',
                'categories' => $categories,
                'tags' => $tags,
                'image' => '',
                'user_id' =>'',
                'status' =>'',

            ];

            $this->view('articles/create', $data);
        }

    }

    public function edit($id){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $categories = $this->categoryModel->getCategories();
            $tags = $this->tagModel->getTags();

            if(isset($_FILES['image']['name']))
            {
                $folder = "img/";
                $destination = $folder . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            }

            $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['title'])));

            $data = [
                'id' => $id,
                'title' => $_POST['title'],
                'body' => $_POST['body'],
                'image' => $destination,
                'category_id' =>$_POST['category_id'],
                'created_at' => $_POST['created_at'],
                'categories' => $categories,
                'tags' => $_POST['tags'],
                'slug' => $slug,
                'title_err' => '',
                'category_err' => '',
                'tags_err' => '',
                'image_err' => '',
                'body_err' => '',

            ];


            if(empty($data['title'])){
                $data['title_err'] = 'Please enter title';
            }


            if(empty($data['body'])){
                $data['body_err'] = 'Please enter body';
            }

            if(empty($data['category_id'])){
                $data['category_err'] = 'Please choose category';
            }

            if(empty($data['created_at'])){
                $data['created_at_err'] = 'Please choose date';
            }

            if(empty($data['image'])){
                $data['image_err'] = 'Please choose image';
            }

            if(empty($data['title_err'])  && empty($data['body_err']) && empty($data['category_err']) && empty($data['tags_err']) && empty($data['image_err']) && empty($data['created_at_err'])){
                    $this->articlesModel->editArticle($data);
                    $this->articlesModel->editTagsArticle($data);
                    flash('articles_message','Article updated successfully');
                    redirect('articles/index');

            } else{
                $this->view('articles/edit', $data);
            }


        }else{
            $categories = $this->categoryModel->getCategories();
            $tags = $this->tagModel->getTags();
            $article = $this->articlesModel->getArticleById($id);

            $data = [
                'id' => $id,
                'title' =>$article->title,
                'slug' => $article->slug,
                'body' => $article->body,
                'categories' => $categories,
                'tags' => $tags,
                'image' => '',
                'user_id' =>'',
                'status' =>'',

            ];

            $this->view('articles/edit', $data);
        }
    }

    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if($this->articlesModel->deleteArticle($id)){
                flash('articles_message', 'Article Removed');
                redirect('articles/index');
            }else{
                die('Something went wrong');
            }
        } else {
            redirect('articles/index');
        }
    }

    public function approve($id){

        $this->articlesModel->approve($id);
        flash('articles_message', 'Article has been approved');


        $articles = $this->articlesModel->getArticles();
        $data = [
            'articles' => $articles
        ];
        $this->view('articles/index', $data);
    }

    public function single($id){

        $article = $this->articlesModel->getArticleById($id);
        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTagByArticle($id);
        $data = [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags
        ];

        $this->view('articles/single', $data);
    }





}