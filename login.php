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

<h2>Login</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="pass" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<p>Not registered yet? <a href="Regform.php">Register here</a></p>
