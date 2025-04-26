<?php
session_start(); // Start the session
include "connection.php";

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: index.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit;
}

// If form is submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Fetch user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Check user and verify password
    if ($user && $user['pass'] === $pass) { // You should replace this with password_verify() for hashed passwords
        $_SESSION['user'] = $user;

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: index.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    

<div style="margin: 0 auto; margin-right:650px; width: 300px; padding-top: 50px;" >
    
<h2 class="position-relative top-0 start-50 ">Login</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form class="position-relative top-0 start-50" method="POST" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="pass" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<p class="position-relative top-0 start-50">Not registered yet? <a href="Regform.php">Register here</a></p>
</div>
</body>
</html>