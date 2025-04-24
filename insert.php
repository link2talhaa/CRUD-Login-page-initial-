<?php
session_start(); 
 $success = false;
include "connection.php";
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Handle image upload
    $profileImage = null;

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['profile_image']['tmp_name'];
        $imageName = basename($_FILES['profile_image']['name']);
        $uploadDir = 'uploads/';
        $destination = $uploadDir . $imageName;

        if (move_uploaded_file($imageTmpPath, $destination)) {
            $profileImage = $destination;
        }
    }

    // Ilocalnsert data into the database including image
    $insert = $pdo->prepare("INSERT INTO users (name, email, pass, profile_image) VALUES (:name, :email, :pass, :profile_image)");
    var_dump($profileImage);
    $insert->execute([
        'name' => $name,
        'email' => $email,
        'pass' => $pass,
        'profile_image' => $profileImage
    ]);
    // ✅ Set flash success message
    $_SESSION['success'] = "🎉 Registration successful! <a href='login.php'>Click here to login</a>.";

    // ✅ Redirect back to form
    header("Location: form.php");
    exit;  
}
?>
