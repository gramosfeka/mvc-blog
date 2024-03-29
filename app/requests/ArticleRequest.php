<?php
class ArticleRequest
{
    /**
     * @param $data
     * @return mixed
     *
     * Validate Article From
     */
    public function ValidationForm($data)
    {
        if($data['title'] == ""){
            $data['errors']['title_err'] = 'Please enter title';
        }
        if($data['body'] == ""){
            $data['errors']['body_err'] = 'Please enter body';
        }
        if($data['category_id'] == ""){
            $data['errors']['category_id_err'] = 'Please enter category';
        }
        if(empty($data['tags'])){
            $data['errors']['tags_err'] = 'Please select tags';
        }
        if($data['created_at'] == ""){
            $data['errors']['created_at_err'] = 'Please enter date';
        }
        if(empty($_FILES['image']['name'])){
            $data['errors']['image_err'] = 'Please select image';
        }
        return $data;
    }
}