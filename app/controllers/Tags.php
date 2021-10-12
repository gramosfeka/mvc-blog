<?php

class Tags extends Controller
{
    public function __construct()
    {

        if(!isAdmin()){
            redirect('home');
        }
        $this->tagModel = $this->model('Tag');


    }

    public function index()
    {
        $tags = $this->tagModel->getTags();

        $data = [
            'tags' => $tags,
            'name' => '',
            'name_err' => ''
        ];
        $this->view('tags/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $tags = $this->tagModel->getTags();

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'tags' => $tags,
                'created_at' => date('Y-m-d H:i:s'),
                'name_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            if (empty($data['name_err'])) {

                if ($this->tagModel->addTag($data)) {
                    flash('tag_success', 'Tag has been added');
                    redirect('tags/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('tags/index', $data);
            }
        } else {
            $data = [
                'name' => '',
                'name_err' => ''
            ];

            $this->view('tags/index', $data);
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
                if ($this->tagModel->editTag($data)) {
                    flash('tag_success', 'Tag has been updated');
                    redirect('tags/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('tags/index', $data);
            }
        } else {
            $tag = $this->tagModel->getTagById($id);
            $data = [
                'id' => $id,
                'name' => $tag->name,
                'name_err' => ''
            ];
        }
        $this->view('tags/edit', $data);
    }

    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if($this->tagModel->deleteTag($id)){
                flash('tag_success', 'Tag has been removed');
                redirect('tags');
            }else{
                die('Something went wrong');
            }
        } else {
            redirect('tags');
        }
    }

}