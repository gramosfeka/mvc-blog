<?php

class TagRequest{

    /**
     * @param $data
     * @return mixed
     *
     * Validate Tag From
     */
    public function ValidateForm($data){

        if ($data['name'] == "") {

            $data['errors']['name_err'] = 'Please enter name';
        }

        return $data;

    }
}