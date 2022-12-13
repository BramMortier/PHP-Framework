<?php 

class UserModel extends Model 
{
    public $username;
    public $username_err;

    public $password;
    public $password_err;

    public $confirm_password;
    public $confirm_password_err;

    public $login_err;
    public $register_err;

    public function checkUniqueUser($user)
    {
        $db = $this->db_connect();

        $sql = 
        "SELECT id 
        FROM mvc_auth.users 
        WHERE username = :username";

        if($stmt = $db->prepare($sql)){
            $stmt->bindValue(":username", trim($user), PDO::PARAM_STR);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $this->username_err = "This username is already taken";
                } else {
                    $this->username = trim($_POST["username"]);
                }
            } else{
                $this->register_err =  "Oops! Something went wrong";
            }
        }
        unset($stmt);
        unset($db);
    }

    public function createUser()
    {
        $db = $this->db_connect();

        $sql = 
        "INSERT INTO mvc_auth.users
            (username, password_hash) 
        VALUES 
            (:username, :password)";

        if($stmt = $db->prepare($sql))
        {
            $stmt->bindValue(":username", $this->username, PDO::PARAM_STR);
            $stmt->bindValue(":password", password_hash($this->password, PASSWORD_DEFAULT), PDO::PARAM_STR);

            if($stmt->execute())
            {
                header("location: /auth/login");
            } else {
                $this->register_err = "Oops! Something went wrong";
            }
        }
        unset($stmt);
        unset($db);
    }

    public function checkCredentials()
    {
        $db = $this->db_connect();

        $sql = 
        "SELECT id, username, password_hash 
        FROM mvc_auth.users 
        WHERE username = :username";

        if($stmt = $db->prepare($sql))
        {
            $stmt->bindValue(":username", $this->username, PDO::PARAM_STR);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($user = $stmt->fetch()){
                        $user_id = $user["id"];
                        $username = $user["username"];
                        $password_hash = $user["password_hash"];

                        if(password_verify($this->password, $password_hash)){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $user_id;
                            $_SESSION['username'] = $username;

                            header("location: /home");
                        } else {
                            $this->login_err = "Invalid username or password";
                        }
                    }
                } else {
                    $this->login_err = "Invalid username or password";
                }
            } else {
                $this->login_err = "Oops! Something went wrong";
            }
            unset($stmt);
            unset($db);
        }
    }
}