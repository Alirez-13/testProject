<?php
$server = "localhost";
$username = "root";
$password = "";
$dsn = "mysql:host=$server;dbname=test";


try {
    // Connect to DB
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";

    if (isset($_POST["login"])) {

        $user_email = $_POST['email'];
        $user_password = trim($_POST['password']);

        $stmt = $connection->prepare("SELECT * FROM users WHERE USER_Email = :email AND USER_Password = :password");

        $stmt->execute(array(":email" => $_POST['email'], ":password" => $_POST['password']));

        $user_stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        $passH = password_hash($user_password, PASSWORD_DEFAULT);

        if ($user_stmt && password_verify($passH, $user_stmt['USER_Password'])) {
            echo "Login successfully";
        } else {
            echo "Login failed";
        }
    }


} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>

<h2>Login</h2>
<form method="POST" action="UserLogin.php">
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" name="login">
</form>

</body>
</html>
