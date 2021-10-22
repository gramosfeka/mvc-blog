<?php

class CategoryRequest{

    /**
     * @param $data
     * @return mixed
     *
     * Validate Category From
     */
    public function ValidateForm($data){

        if ($data['name'] == "") {

            $data['errors']['name_err'] = 'Please enter name';
        }

         return $data;


    }
}