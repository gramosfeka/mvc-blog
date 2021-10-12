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
                    'created_at' => date('Y-m-d H:i:s'),
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
                    $this->userModel->register($data);
                    flash('register_success', 'Now you are registered, please check your email to verify account!');
                     redirect('users/login');

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
                    'remember' => $_POST['remember'],
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

                if(!empty($data['remember'])){
                    setcookie ("user_email",$data['email'],time()+ (10 * 365 * 24 * 60 * 60));

                    setcookie ("user_password",$data['password'],time()+ (10 * 365 * 24 * 60 * 60));
                } else {
                    if (isset($_COOKIE["user_email"])) {
                        setcookie("user_email", "");
                        if (isset($_COOKIE["user_password"])) {
                            setcookie("user_password", "");
                        }
                    }
                }


                if(empty($data['email_err']) && empty($data['password_err'])){
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    if($loggedInUser){
                        $this->createUserSession($loggedInUser);
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

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_role'] = $user->role;

            redirect('pages/index');
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_role']);
            session_destroy();
            redirect('users/login');
        }

        public function verify(){
            $this->userModel->verify();
            $data = [
                'email' =>'',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            flash('register_success', 'Your account has been verified, now you can log in!');

            $this->view('users/login',$data );
        }


    }