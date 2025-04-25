<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    die("Access denied.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User_Dashboard</title>
    <style>
        button{
            background-color: #dc3545;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        }
    </style>
</head>
<body>
<h1>Welcome <?= htmlspecialchars($_SESSION['user']['Name']) ?></h1>
<a href="categories/view.php"><button style="background-color:blue;">My Categories</button></a>
<a href="logout.php"><button>Logout</button></a>
</body>
</html>
