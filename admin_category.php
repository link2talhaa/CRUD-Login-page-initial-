<?php
session_start();
include "connection.php"; // adjust path if needed

// ✅ Only allow admin to access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Fetch all users
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Manage Users</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Serial</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Category</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $serial = 1;
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $serial++ . "</td>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['Name'] . "</td>";  // 🛑 make sure your DB has 'Name' with Capital N
                echo "<td>" . $user['Email'] . "</td>";
                echo "<td><a href='user_categories.php?id=" . $user['id'] . "' class='btn btn-primary btn-sm'>Show Categories</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

</body>
</html>
