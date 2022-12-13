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

        $userModel = $this->loadModel("userModel");

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(empty(trim($_POST["username"]))){
                $userModel->username_err = "Please enter username";
            } else{
                $userModel->username = trim($_POST["username"]);
            }

            if(empty(trim($_POST["password"]))){
                $userModel->password_err = "Please enter your password";
            } else{
                $userModel->password = trim($_POST["password"]);
            }

            if(
                empty($userModel->username_err) &&
                empty($userModel->password_err) &&
                empty($userModel->login_err) 
            ) {
                $userModel->checkCredentials();
            }
        }

        $data['login_data'] = (object) [
            "username" => $userModel->firstname ?? "",
            "password" => $userModel->password ?? "",

            "username_err" => $userModel->username_err ?? "",
            "password_err" => $userModel->password_err ?? "", 
            "login_err" => $userModel->register_err ?? "",
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
        $userModel = $this->loadModel("userModel");

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(empty(trim($_POST["username"]))){
                $userModel->username_err = "Please enter a username";
            } else if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
                $userModel->username_err = "No special chars allowed";
            } else {
                $userModel->checkUniqueUser(trim($_POST["username"]));
            }

            if(empty(trim($_POST["password"]))){
                $userModel->password_err = "Please enter a password"; 
            } else if(strlen(trim($_POST["password"])) < 6){
                $userModel->password_err = "Password must have atleast 6 characters";
            } else {
                $userModel->password = trim($_POST["password"]);
            }

            if(empty(trim($_POST["confirm_password"]))){
                $userModel->confirm_password_err = "Please confirm password";     
            } else {
                $userModel->confirm_password = trim($_POST["confirm_password"]);
                if(
                    empty($userModel->password_err) && 
                    ($userModel->password != $userModel->confirm_password)
                ) {
                    $userModel->confirm_password_err = "Password did not match";
                }
            }

            if(
                empty($userModel->username_err) &&
                empty($userModel->password_err) &&
                empty($userModel->confirm_password_err) &&
                empty($userModel->register_err)
            ) {
                $userModel->createUser();
            }
        }

        $data['register_data'] = (object) [
            "username" => $userModel->firstname ?? "",
            "password" => $userModel->password ?? "",
            "confirm_password" => $userModel->confirm_password ?? "",

            "username_err" => $userModel->username_err ?? "",
            "password_err" => $userModel->password_err ?? "", 
            "confirm_password_err" => $userModel->confirm_password_err ?? "", 
            "register_err" => $userModel->register_err ?? "",
        ];

        $data['page_title'] = "Register";
        
        $this->view("/auth/register", $data);
    }
}