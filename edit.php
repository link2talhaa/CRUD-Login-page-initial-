
<?php
// Include the database connection file
include "connection.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
// Check if an ID is passed in the query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID");
}

// Get the user ID from the URL
$userId = $_GET['id'];

// Fetch the user data from the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user exists
if (!$user) {
    die("User not found");
}

// Handle the form submission to update the user data
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Update the user data in the database
    $update = $pdo->prepare("UPDATE users SET name = :name, email = :email, pass = :pass WHERE id = :id");
    $update->execute([
        'name' => $name,
        'email' => $email,
        'pass' => $pass,
        'id' => $userId
    ]);

    // Redirect to the view page after successful update
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-3 m-0 border-0 bd-example m-0 border-0">
    <div class="container">
        <h2>Edit User</h2>
        <form action="edit.php?id=<?= $user['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($user['Name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" id="pass" value="<?= htmlspecialchars($user['pass']) ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</body>
</html>
