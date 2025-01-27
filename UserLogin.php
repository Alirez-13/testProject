<?php
$server = "127.0.0.1:3306";
$username = "root";
$hashed_password_db = "";
$dsn = "mysql:host=$server;dbname=test";


try {
    // Connect to DB
    $connection = new PDO($dsn, $username, $hashed_password_db);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $user_email = $_POST['email'];
        $user_password = trim($_POST['password']);

        $stmt =$connection->prepare("SELECT * FROM users WHERE USER_Email = :email");
        $stmt->bindParam(':email', $user_email);
        $result = $stmt->execute();

//        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $hashed_password_db = $row['USER_Password'];
//            var_dump($user_password);
//            var_dump($user_email);
//            var_dump($hashed_password_db);
//            var_dump(password_verify($user_password, $hashed_password_db));
//
//            var_dump($stmt->fetch(PDO::FETCH_ASSOC));
//        }

        if ($result&& $user_password == $hashed_password_db) {
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
