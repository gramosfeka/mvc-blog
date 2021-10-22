<?php
    session_start();
    /**
     * @param string $name
     * @param string $message
     * @param string $class
     * Flash message helper
     */
    function flash($name = '' , $message = '', $class = 'alert alert-success'){
            if(!empty($name)){
                if(!empty($message) && empty($_SESSION[$name])){
                    if(!empty($_SESSION[$name])){
                        unset($_SESSION[$name]);
                    }

                    if(!empty($_SESSION[$name.'_class'])){
                        unset($_SESSION[$name.'_class']);
                    }

                    $_SESSION[$name] = $message;
                    $_SESSION[$name. '_class'] = $class;
                }elseif (!empty($_SESSION[$name]) && empty($message)){
                    $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : 'success';
                    echo  '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].' </div>';
                    unset($_SESSION[$name]);
                    unset($_SESSION[$name]);
                }
            }
        }

    /**
     * @return bool
     * check if user is logged in
     */
    function isLoggedIn(){

            if(isset($_SESSION['user_id'])){
                return true;
            }else{
                return false;
            }

        }

    /**
     * @param $user
     * add to session id of user
     */
    function remember($user)
        {
            $_SESSION["user_id"]= $user->id;

        }

    /**
     * @return bool
     * Check if user is admin or not
     */
    function isAdmin(){

            if($_SESSION['user_role'] == 'admin') {
                return true;
            }else{
                return false;
            }
    }
