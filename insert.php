<?php
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

    // Insert data into the database including image
    $insert = $pdo->prepare("INSERT INTO users (name, email, pass, profile_image) VALUES (:name, :email, :pass, :profile_image)");
    var_dump($profileImage);
    $insert->execute([
        'name' => $name,
        'email' => $email,
        'pass' => $pass,
        'profile_image' => $profileImage
    ]);
       
    header("Location: index.php");
    exit;
}
?>
