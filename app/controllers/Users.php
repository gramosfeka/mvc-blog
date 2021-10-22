<?php
require_once '../app/requests/UserRequest.php';

class Users extends Controller
{

    /**
     * Users constructor.
     * Load models
     */
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->userRequest = new UserRequest();

    }

    /**
     * Load register form
     */
    public function register(){
        $data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];
        $this->view('users/register', $data);
    }

    /**
     * Register user
     */
    public function registerUser()
    {
        $data = [
            'name' => rtrim($_POST['name']),
            'email' => rtrim($_POST['email']),
            'password' => rtrim($_POST['password']),
            'confirm_password' => rtrim($_POST['confirm_password']),
            'created_at' => date('Y-m-d H:i:s'),
            'errors' => [],
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        $data = $this->userRequest->ValidateRegisterForm($data);

        if (!empty($data['errors'])) {
            $this->view('users/register', $data);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->userModel->register($data);
            flash('register_success', 'Now you are registered, please check your email to verify account!');
            redirect('users/login');
        }


    }

    /**
     * Load login form
     */
    public function login(){
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
            'remember' => '',
        ];

        $this->view('users/login', $data);
    }

    /**
     * Login user
     */
    public function loginUser()
    {
        $data = [
            'email' => rtrim($_POST['email']),
            'password' => rtrim($_POST['password']),
            'remember' => isset($_POST['remember']) ? $_POST['remember'] : "" ,
            'email_err' => '',
            'password_err' => '',

        ];

        $data = $this->userRequest->ValidateLoginForm($data);

        if (!empty($data['remember'])) {
            setcookie("user_email", $data['email'], time() + (10 * 365 * 24 * 60 * 60));

            setcookie("user_password", $data['password'], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE["user_email"])) {
                setcookie("user_email", "");
                if (isset($_COOKIE["user_password"])) {
                    setcookie("user_password", "");
                }
            }
        }

        if (empty($data['email_err']) && empty($data['password_err'])) {
            $loggedInUser = $this->userModel->login($data['email'], $data['password']);
            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
            } else {
                $data['password_err'] = 'Password incorrect';
                $this->view('users/login', $data);
            }
        } else {
            $this->view('users/login', $data);
        }

    }


    /**
     * @param $user
     * Create user session
     */
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->role;

        redirect('home/index');
    }

    /**
     * Logout, unset sessions
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('users/login');
    }

    /**
     *  Verify user
     */
    public function verify()
    {
        $this->userModel->verify();
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
        ];
        flash('register_success', 'Your account has been verified, now you can log in!');

        $this->view('users/login', $data);
    }

    /**
     * Load send link for resetting password form
     */
    public function send_link_form(){
        $data = [
            'email' => '',
            'email_err' => '',
        ];
        $this->view('users/send_link', $data);
    }

    /**
     * Send link to reset pass
     */
    public function send_link()
    {
        $data = [
            'email' => $_POST['email'],
            'email_err' => '',
        ];

        $data = $this->userRequest->ValidateSendLink($data);

        if (!empty($data['email_err'])) {
            $this->view('users/send_link', $data);
        } else {
            $this->userModel->send_link($data);
            flash('reset_pass', 'We have emailed your password reset link!');
            $this->view('users/send_link', $data);
        }

    }

    /**
     * Load reset password form
     */
    public function reset_pass_form(){
        $data = [
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'password_err' => '',
            'confirm_password_err' => '',
        ];
        $this->view('users/reset_pass', $data);
    }

    /**
     * Reset password
     */
    public function reset_pass()
    {
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password'],
            'password_err' => '',
            'confirm_password_err' => '',
            'errors' => [],
        ];


        $data = $this->userRequest->ValidateResetPass($data);

        if (!empty($data['errors'])) {
            $this->view('users/reset_pass', $data);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->userModel->reset_pas($data);
            flash('reset_pass', 'You just changed password, now you can log in with the new one');
            redirect('users/login');
        }

    }


}