<?php

Class Auth extends Controller
{
    public function index() { $this->login(); }

    public function login()
    {
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        {
            header("location: /home");
            exit;
        }

        $login_user = $this->loadModel("user");

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(empty(trim($_POST["username"]))){
                $login_user->username_err = "Please enter username";
            } else{
                $login_user->username = trim($_POST["username"]);
            }

            if(empty(trim($_POST["password"]))){
                $login_user->password_err = "Please enter your password";
            } else{
                $login_user->password = trim($_POST["password"]);
            }

            if(
                empty($login_user->username_err) &&
                empty($login_user->password_err) &&
                empty($login_user->login_err) 
            ) {
                $login_user->checkCredentials();
            }
        }

        $data['login_data'] = (object) [
            "username" => $login_user->firstname ?? "",
            "password" => $login_user->password ?? "",

            "username_err" => $login_user->username_err ?? "",
            "password_err" => $login_user->password_err ?? "", 
            "login_err" => $login_user->register_err ?? "",
        ];

        $data['page_title'] = "Login";

        $this->view("/auth/login", $data);
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();

        header("location: /auth/login");
        exit;
    }

    public function register()
    {
        $register_user = $this->loadModel("user");

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(empty(trim($_POST["username"]))){
                $register_user->username_err = "Please enter a username";
            } else if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
                $register_user->username_err = "No special chars allowed";
            } else {
                $register_user->checkUniqueUser(trim($_POST["username"]));
            }

            if(empty(trim($_POST["password"]))){
                $register_user->password_err = "Please enter a password"; 
            } else if(strlen(trim($_POST["password"])) < 6){
                $register_user->password_err = "Password must have atleast 6 characters";
            } else {
                $register_user->password = trim($_POST["password"]);
            }

            if(empty(trim($_POST["confirm_password"]))){
                $register_user->confirm_password_err = "Please confirm password";     
            } else {
                $register_user->confirm_password = trim($_POST["confirm_password"]);
                if(
                    empty($register_user->password_err) && 
                    ($register_user->password != $register_user->confirm_password)
                ) {
                    $register_user->confirm_password_err = "Password did not match";
                }
            }

            if(
                empty($register_user->username_err) &&
                empty($register_user->password_err) &&
                empty($register_user->confirm_password_err) &&
                empty($register_user->register_err)
            ) {
                $register_user->createUser();
            }
        }

        $data['register_data'] = (object) [
            "username" => $register_user->firstname ?? "",
            "password" => $register_user->password ?? "",
            "confirm_password" => $register_user->confirm_password ?? "",

            "username_err" => $register_user->username_err ?? "",
            "password_err" => $register_user->password_err ?? "", 
            "confirm_password_err" => $register_user->confirm_password_err ?? "", 
            "register_err" => $register_user->register_err ?? "",
        ];

        $data['page_title'] = "Register";
        
        $this->view("/auth/register", $data);
    }
}