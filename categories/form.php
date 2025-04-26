<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$success = '';

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user']['id'];
    $name = ucfirst(trim($_POST['name'])); // Make first letter capital, trim spaces

    if (!empty($name)) {
        $insert = $pdo->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
        $insert->execute([$user_id, $name]);
        $success = "Category added successfully!";
    } else {
        $success = "Please enter a category name!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Add New Category</h2>

        <?php if ($success): ?>
            <div class="alert alert-info"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Add Category</button>
        </form>

        <div class="mt-3 text-center">
            <a href="view.php" class="btn btn-secondary btn-sm">View My Categories</a>
        </div>
    </div>
</div>

</body>
</html>
