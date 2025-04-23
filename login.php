<?php
session_start(); // Start the session
include "connection.php";
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// If form is submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Check if email and password match in the DB
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :email AND pass = :pass");
    $stmt->execute([
        'email' => $email,
        'pass' => $pass
    ]);
    $user = $stmt->fetch();
    print_r($user);
    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
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

<p>Not registered yet? <a href="form.php">Register here</a></p>
