<?php
$server = "127.0.0.1:3307";
$username = "root";
$password = "";
$dsn = "mysql:host=$server;dbname=test";


try {
    // Connect to DB
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user_email = $_POST['email'];
        $user_password = $_POST['password'];

        $userQuery = "SELECT * FROM users WHERE USER_Email = :email AND USER_Password = :password";
        $stmt = $connection->prepare($userQuery);
//        $stmt->bindParam(':email', $user_email);

        $result = $stmt->execute(
            array(
                ":email" => $user_email,
                ":password" => $user_password
            )
        );
        $row = $stmt->rowCount();

        if ($row > 0) {
            echo "Worked successfully <br>";
        }

        $passH = password_hash($user_password, PASSWORD_DEFAULT);

        if (password_verify($user_password, $passH, )) {
            echo "Login successfully";
        } else {
            echo "Login failed ";
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
