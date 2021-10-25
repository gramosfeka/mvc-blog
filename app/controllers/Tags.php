<?php

require_once '../app/requests/TagRequest.php';

class Tags extends Controller
{
    /**
     * Tags constructor
     * Load models
     */
    public function __construct()
    {

        if (!isAdmin()) {
            redirect('home');
        }
        $this->tagModel = $this->model('Tag');
        $this->tagRequest = new TagRequest();

    }

    /**
     * Shows all tags that has been created and load form to create another one
     */
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

    /**
     * Add tag
     */
    public function store()
    {
        $tags = $this->tagModel->getTags();
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'name' => trim($_POST['name']),
            'tags' => $tags,
            'errors' => [],
            'name_err' => ''
        ];

        $data = $this->tagRequest->ValidateForm($data);

        if (!empty($data['errors'])) {
            $this->view('tags/index', $data);
        } else {
            $this->tagModel->addTag($data);
            flash('tag_success', 'Tag has been added');
            redirect('tags/index');
        }
    }

    /**
     * @param $id
     * Load edit tag form for specific category
     */
    public function edit($id)
    {
        $tag = $this->tagModel->getTagById($id);
        $data = [
            'id' => $id,
            'name' => $tag->name,
            'name_err' => ''
        ];
        $this->view('tags/edit', $data);
    }

    /**
     * @param $id
     * Edit tag
     */
    public function update($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'id' => $id,
            'name' => trim($_POST['name']),
            'name_err' => '',
            'errors' => [],
        ];

        $data = $this->tagRequest->ValidateForm($data);

        if (!empty($data['errors'])) {
            $this->view('tags/edit', $data);
        } else {
            $this->tagModel->editTag($data);
            flash('tag_success', 'Tag has been updated');
            redirect('tags/index');
        }
    }

    /**
     * @param $id
     * Delete tag
     */
    public function delete($id)
    {
        $this->tagModel->deleteTag($id);
        flash('tag_success', 'Tag has been removed');
        redirect('tags');
    }

}