<?php

class User
{
    private $db;

    /**
     * User constructor.
     * Load database
     */
    public function __construct()
    {
        $this->db = new Database();
    }


    /**
     * @param $data
     * @return bool
     * Add user to database
     */
    public function register($data)
    {
        $hash = md5(rand(0, 1000));
        $this->db->query('INSERT INTO users (name, email, password, created_at, hash) VALUES (:name, :email, :password, :created_at, :hash)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':hash', $hash);


        if ($this->db->execute()) {
            $to = $data['email'];
            $subject = 'Confirm Email';
            $message = "Please click the link below to verify your account
                                http://localhost:8081/mvc-blog/users/verify?hash=$hash";
            $headers = 'From: gramosfeka@gmail.com';
            mail($to, $subject, $message, $headers);
        } else {
            return false;
        }
    }

    /**
     * @param $data
     * Send link on mail to reset password
     */
    public function send_link($data)
    {
        $email = md5($data['email']);
        $to = $data['email'];
        $subject = 'Reset Password';
        $message = "Click On This Link to Reset Password
                                http://localhost:8081/mvc-blog/users/reset_pass_form?email=$email";
        $headers = 'From: gramosfeka@gmail.com';
        mail($to, $subject, $message, $headers);

    }

    /**
     * @param $data
     * @return bool
     * Reset password
     */
    public function reset_pas($data)
    {

        $this->db->query('SELECT * FROM users WHERE md5(email) = :email');
        $this->db->bind(':email', $data['email']);
        $user = $this->db->single();


        if ($this->db->rowCount() > 0) {

            $this->db->query('UPDATE users SET password = :password WHERE email = :email');
            $this->db->bind(':email', $user->email);
            $this->db->bind(':password', $data['password']);
            $this->db->execute();

        } else {
            return false;
        }
    }


    /**
     * @return bool
     * Verify user
     */
    public function verify()
    {
        $this->db->query('SELECT * FROM users WHERE hash = :hash and active = :active');
        $this->db->bind('hash', $_GET['hash']);
        $this->db->bind('active', 0);
        $user = $this->db->single();

        $this->db->query('UPDATE users SET active = :active WHERE hash = :hash');
        $this->db->bind('hash', $user->hash);
        $this->db->bind(':active', 1);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * Login user
     */
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_password = $row->password;

        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }

    }

    /**
     * @param $email
     * @return bool
     * Find user by email
     */
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind('email', $email);

        $this->db->single();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * @return mixed
     * returns all users
     */
    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");

        $results = $this->db->resultset();

        return $results;
    }


}