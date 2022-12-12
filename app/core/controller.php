<?php 

class Controller
{
    function view($view, $data = [])
    {
        if(file_exists(PROJ_ROOT . "/app/views/". $view  . ".php"))
        {
            include PROJ_ROOT . "/app/views/". $view  . ".php";
        } else {
            include PROJ_ROOT . "/app/views/404.php";
        }
    }

    function loadModel($model)
    {
        if(file_exists(PROJ_ROOT . "/app/models/". $model  . ".php"))
        {
            include PROJ_ROOT . "/app/models/". $model  . ".php";
            return $model = new $model();
        }

        return false;
    }
}