<?php

    class Users extends Controller{

        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function register(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $data = [
                    'name' => rtrim($_POST['name']),
                    'email' => rtrim($_POST['email']),
                    'password' => rtrim($_POST['password']),
                    'confirm_password' =>rtrim($_POST['confirm_password']),
                    'name_err' =>'',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }else{
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = 'Email is already taken!';
                    }
                }

                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter name';
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'Please must be at least 6 characters';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please enter confirm password';
                }else{
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }


                if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are registered and can log in');
                         redirect('users/login');
                    }
                }else{
                    $this->view('users/register', $data);
                }


            }else{
                $data = [
                    'name' => '',
                    'email' =>'',
                    'password' => '',
                    'confirm_password' =>'',
                    'name_err' =>'',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                $this->view('users/register', $data);
            }
        }


        public function login(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'email' => rtrim($_POST['email']),
                    'password' => rtrim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }

                if($this->userModel->findUserByEmail($data['email'])){

                }else{
                    $data['email_err'] = 'No user found';
                }

                if(empty($data['email_err']) && empty($data['password_err'])){
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    if($loggedInUser){
                        die('success');
                    }else{
                        $data['password_err'] = 'Password incorrect';
                        $this->view('users/login',$data);
                    }
                }else{
                    $this->view('users/login', $data);
                }

            }else{
                $data = [
                    'email' =>'',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                $this->view('users/login', $data);
            }
        }


    }