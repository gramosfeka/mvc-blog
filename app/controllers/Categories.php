<?php

class Categories extends Controller
{
    public function __construct()
    {

        if(!isAdmin()){
            redirect('home');
        }
        $this->categoryModel = $this->model('Category');


    }

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

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $categories = $this->categoryModel->getCategories();

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'categories' => $categories,
                'created_at' => date('Y-m-d H:i:s'),
                'name_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            if (empty($data['name_err'])) {

                if ($this->categoryModel->addCategory($data)) {
                    flash('category_success', 'Category has been added');
                    redirect('categories/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('categories/index', $data);
            }
        } else {
            $data = [
                'name' => '',
                'name_err' => ''
            ];

            $this->view('categories/index', $data);
        }

    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'name_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            if (empty($data['name_err'])) {
                if ($this->categoryModel->editCategory($data)) {
                    flash('category_success', 'Category has been updated');
                    redirect('categories/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('category/index', $data);
            }
        } else {
            $category = $this->categoryModel->getCategoryById($id);
            $data = [
                'id' => $id,
                'name' => $category->name,
                'name_err' => ''
            ];
        }
        $this->view('categories/edit', $data);
    }

    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if($this->categoryModel->deleteCategory($id)){
                flash('category_success', 'Category has been removed');
                redirect('categories');
            }else{
                die('Something went wrong');
            }
        } else {
            redirect('categories');
        }
    }

}