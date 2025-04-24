<?php
include "connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $delete->execute([$id]);

    header("Location: view.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
