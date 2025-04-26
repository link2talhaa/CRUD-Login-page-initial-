<?php
session_start();
include "connection.php"; // adjust the path if needed

// ✅ Only allow admin to access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Check if ID is provided
if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$user_id = $_GET['id'];

// ✅ Fetch user info
$stmtUser = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmtUser->execute([$user_id]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// ✅ Fetch categories of this user
$stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ?");
$stmt->execute([$user_id]);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($user['Name']); ?>'s Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4"><?php echo htmlspecialchars($user['Name']); ?>'s Categories</h2>

    <?php if (count($categories) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Serial</th>
                    <th>Category ID</th>
                    <th>Category Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial = 1;
                foreach ($categories as $category) {
                    echo "<tr>";
                    echo "<td>" . $serial++ . "</td>";
                    echo "<td>" . $category['id'] . "</td>";
                    echo "<td>" . $category['name'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No categories found for this user.</div>
    <?php endif; ?>

    <a href="admin_category.php" class="btn btn-secondary mt-3">Back to Manage Users</a>
</div>

</body>
</html>
