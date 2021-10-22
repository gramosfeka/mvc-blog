<?php

require_once '../app/requests/CategoryRequest.php';

class Categories extends Controller
{

    private $categoryRequest;

    /**
     * Categories constructor.
     * Load models
     */
    public function __construct()
    {
        if (!isAdmin()) {
            redirect('home');
        }
        $this->categoryModel = $this->model('Category');
        $this->categoryRequest = new CategoryRequest();

    }

    /**
     * Shows all categories that has been created and load form to create another one
     */
    public function index()
    {
        $categories = $this->categoryModel->getCategories();

        $data = [
            'categories' => $categories,
            'name' => '',
            'name_err' => ''
        ];
        $this->view('categories/index', $data);
    }

    /**
     * Add category
     */
    public function store()
    {
        $categories = $this->categoryModel->getCategories();

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'name' => trim($_POST['name']),
            'categories' => $categories,
            'created_at' => date('Y-m-d H:i:s'),
            'name_err' => '',
            'errors' => [],
        ];


        $data = $this->categoryRequest->ValidateForm($data);
        if(!empty($data['errors'])){
            $this->view('categories/index', $data);
        }else{
            $this->categoryModel->addCategory($data);
            flash('category_success', 'Category has been added');
            redirect('categories/index');
        }

    }

    /**
     * @param $id
     * Load edit category form for specific category
     */
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        $data = [
            'id' => $id,
            'name' => $category->name,
            'name_err' => '',
            'errors' => [],
        ];
        $this->view('categories/edit', $data);

    }


    /**
     * @param $id
     * Edit category
     */
    public function update($id){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'id' => $id,
            'name' => trim($_POST['name']),
            'name_err' => '',
            'errors' => [],
        ];

        $data = $this->categoryRequest->ValidateForm($data);

        if(!empty($data['errors'])){
            $this->view('categories/edit', $data);
        } else {
            $this->categoryModel->editCategory($data);
            flash('category_success', 'Category has been updated');
            redirect('categories/index');
        }
    }

    /**
     * @param $id
     * Delete category
     */
    public function delete($id)
    {
        $this->categoryModel->deleteCategory($id);
        flash('category_success', 'Category has been removed');
        redirect('categories');
    }




}