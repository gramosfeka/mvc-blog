<?php

    class User{
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }


        public function register($data){
            $hash = md5( rand(0,1000) );
            $this->db->query('INSERT INTO users (name, email, password, created_at, hash) VALUES (:name, :email, :password, :created_at, :hash)');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':created_at', $data['created_at']);
            $this->db->bind(':hash', $hash);


            if($this->db->execute()){
                $to      = $data['email'];
                $subject = 'Hello From Gramos Feka';
                $message = "Confirm Your Email, Click the link below to verify your account
                                http://localhost:8081/mvc-blog/users/verify?hash=$hash";
                $headers = 'From: gramosfeka@gmail.com';
                mail($to, $subject, $message, $headers);
            }else{
                return false;
            }
        }


        public function verify(){
            $this->db->query('SELECT * FROM users WHERE hash = :hash and active = :active');
            $this->db->bind('hash', $_GET['hash']);
            $this->db->bind('active', 0);
            $user = $this->db->single();

            $this->db->query('UPDATE users SET active = :active WHERE hash = :hash');
            $this->db->bind('hash',  $user->hash);
            $this->db->bind(':active', 1);

            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function login($email, $password){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            $hashed_password = $row->password;

            if(password_verify($password,$hashed_password)){
                return $row;
            }else{
                return false;
            }

        }

        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind('email', $email);

            $this->db->single();

            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }

        }



    }