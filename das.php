<?php
if(isset($_POST["login"]))
{
    if(empty($_POST["username"]) || empty($_POST["password"]))
    {
        $message = '<label>All fields are required</label>';
    }
    else
    {
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                'username'     =>     $_POST["username"],
                'password'     =>     $_POST["password"]
            )
        );
        $count = $statement->rowCount();
        if($count > 0)
        {
            $_SESSION["username"] = $_POST["username"];
            header("location:login_success.php");
        }
        else