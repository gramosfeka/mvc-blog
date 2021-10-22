<?php


class UserRequest extends Controller {

    /**
     * UserRequest constructor.
     * Load model
     */
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    /**
     * @param $data
     * @return mixed
     *
     * Validate User Register From
     */
    public function ValidateRegisterForm($data){


        if ($data['email'] == "") {
            $data['errors']['email_err'] = 'Please enter email';
        } else {
            if ($this->userModel->findUserByEmail($data['email'])) {
                $data['errors']['email_err'] = 'Email is already taken!';
            }
        }

        if ($data['name']== "") {
            $data['errors']['name_err'] = 'Please enter name';
        }

        if ($data['password'] == "") {
            $data['errors']['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
            $data['errors']['password_err'] = 'Please must be at least 6 characters';
        }

        if ($data['confirm_password'] == "") {
            $data['errors']['confirm_password_err'] = 'Please enter confirm password';
        } else {
            if ($data['password'] != $data['confirm_password']) {
                $data['errors']['confirm_password_err'] = 'Passwords do not match';
            }
        }


        return $data;

    }


    /**
     * @param $data
     * @return mixed
     *
     * Validate User Login From
     */
    public function ValidateLoginForm($data){

        if ($data['email']== "") {
            $data['email_err'] = 'Please enter email';
        }

        if ($data['password']== "") {
            $data['password_err'] = 'Please enter password';
        }

        if (!($this->userModel->findUserByEmail($data['email']))) {
            $data['email_err'] = 'No user found';
        }

        return $data;

    }



    public function ValidateSendLink($data){

        if (empty($data['email'])) {
            $data['email_err'] = 'Please enter email';
        }

        return $data;

    }


    public function ValidateResetPass($data){

        if (empty($data['password'])) {
            $data['errors']['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
            $data['errors']['password_err'] = 'Please must be at least 6 characters';
        }

        if (empty($data['confirm_password'])) {
            $data['errors']['confirm_password_err'] = 'Please enter confirm password';
        } else {
            if ($data['password'] != $data['confirm_password']) {
                $data['errors']['confirm_password_err'] = 'Passwords do not match';
            }
        }


        return $data;

    }








}