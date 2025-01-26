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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user_email = $_POST['email'];
        $user_password = $_POST['password'];

        $userQuery = "SELECT * FROM users WHERE USER_Email = :email";
        $stmt = $connection->prepare($userQuery);
        $stmt->bindParam(':email', $user_email);

        $result = $stmt->execute();
        $fetch = $stmt->fetch();

        if ($fetch != NULL) {
            echo $stmt->execute();
        }


        $passH = password_hash($user_password, PASSWORD_DEFAULT);

        if ( password_verify($passH, $stmt['USER_Password'])) {
            echo "Login successfully" . htmlspecialchars($stmt['USER_Email']);
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
