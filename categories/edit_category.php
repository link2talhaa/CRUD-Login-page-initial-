<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit;
}

$cat_id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

// Fetch the category details
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ? AND user_id = ?");
$stmt->execute([$cat_id, $user_id]);
$category = $stmt->fetch();

if (!$category) {
    echo "Category not found!";
    exit;
}

if (isset($_POST['update'])) {
    $new_name = ucfirst(trim($_POST['name']));
    
    if (!empty($new_name)) {
        $update = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ? AND user_id = ?");
        $update->execute([$new_name, $cat_id, $user_id]);
        
        header("Location: view.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Edit Category</h2>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary w-100">Update Category</button>
        </form>

        <div class="mt-3 text-center">
            <a href="view.php" class="btn btn-secondary btn-sm">Back to Categories</a>
        </div>
    </div>
</div>

</body>
</html>
