<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ?");
$stmt->execute([$user_id]);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">My Categories</h2>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User_ID</th>
                    <th>User Name</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php 
    if ($categories): 
        $counter = 1; // Start custom serial number
        $user_id = $_SESSION['user']['id']; // Get logged-in user's ID
    ?>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $counter++ ?></td> <!-- Serial number -->
                <td><?= $user_id ?></td>     <!-- User ID -->
                <td><?= htmlspecialchars($_SESSION['user']['Name']) ?></td> <!-- User Name -->
                <td><?= htmlspecialchars($cat['name']) ?></td> <!-- Category Name -->
                <td>
                    <a href="edit_category.php?id=<?= $cat['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_category.php?id=<?= $cat['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center">No categories found.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>

        <div class="text-center mt-3">
            <a href="form.php" class="btn btn-success">Add Another Category</a>
        </div>
        <div>
    <a href="../user_dashboard.php" class="btn btn-secondary mt-3">Back to User Dashboard </a>

        </div>
    </div>
</div>

</body>
</html>
