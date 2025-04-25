<?php
include "connection.php";
include "check_login.php";

if(isset($_POST['submit'])) {
    try {
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
  // ✅ Check if user exists in the users table
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
  $stmt->execute([$user_id]);

  if ($stmt->fetchColumn() == 0) {
      die("❌ User ID does not exist. Please enter a valid user ID.");
  }

        $insert = $pdo->prepare("INSERT INTO categories (id, user_id, name) VALUES (:id, :user_id, :name)");
        $insert->execute([
            ':id' => $id,
            ':user_id' => $user_id,
            ':name' => $name
        ]);

        // Redirect after successful insert
        header("Location: view.php");
        exit;

    } catch (PDOException $e) {
        // Output the error message
        echo "Error: " . $e->getMessage();
    }
}
?>
