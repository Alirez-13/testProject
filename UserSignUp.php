<?php

$server = "localhost";
$username = "root";
$password = "";
$dsn = "mysql:host=$server;dbname=test";

// Database using PDO
$connection = new PDO($dsn, $username, $password);


try {

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";
    $createDB = "CREATE DATABASE IF NOT EXISTS test";

    $connection->exec($createDB);
    echo "Database created successfully<br>";

    $createTable = "CREATE TABLE IF NOT EXISTS users (
        USER_ID INT AUTO_INCREMENT PRIMARY KEY,
        USER_Password VARCHAR(30) NOT NULL,
        USER_Email VARCHAR(30) NOT NULL)";

    $connection->exec($createTable);
    echo "Table created successfully<br>";


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}

if (isset($_POST["submit"])) {
    try {
        // Sign Up

        $user_email = $_POST["email"];
        $user_password = $_POST["password"];

        $SignUpQuery = "INSERT INTO users (USER_Password, USER_Email) VALUES ('$user_password', '$user_email')";
        $stmt = $connection->prepare($SignUpQuery);
        $result = $stmt->execute();

        if ($result) {
            echo "Sign up successfully<br>";
        } else {
            echo "Sign up failed<br>";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
</head>
<body>
<form method="POST" action="UserLogin.php">
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit">
</form>
</body>
</html>