<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete query
    $delete= $pdo->prepare("DELETE FROM users WHERE id = :id");
    $delete->execute(['id' => $id]);

    // Redirect to the view page
    header("Location: index.php");
    exit;
} else {
    // If no id is provided
    echo "No ID provided.";
}
?>
