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

// Delete the category
$stmt = $pdo->prepare("DELETE FROM categories WHERE id = ? AND user_id = ?");
$stmt->execute([$cat_id, $user_id]);

header("Location: view.php");
exit;
?>
