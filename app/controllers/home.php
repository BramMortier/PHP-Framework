<?php

Class Home extends Controller
{
    function index()
    {
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: /auth/login");
            exit;
        }

        $data['page_title'] = "Home";
        $this->view("home", $data);
    }
}