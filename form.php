<?php
session_start(); 
 $success = false;
include "connection.php";
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    // ✅ Hash the password securely
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

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
     $insert->execute([
        'name' => $name,
        'email' => $email,
        'pass' => $pass,
        'profile_image' => $profileImage
    ]);
    
    // ✅ Set flash success message
    $_SESSION['success'] = "🎉 Registration successful! <a href='index.php'>Click here to back</a>.";

    // ✅ Redirect back to form
    header("Location: form.php");
    exit;  
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <title>Document</title>
</head>
<body>
<!-- ✅ Success Alert -->
<?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>  

<form action="" enctype="multipart/form-data" method="POST">
    <div class="mb-3  row" style="width: 300px;">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
          <input type="text"  class="form-control"  name="name" id="name" placeholder="Enter Name ">
        </div>
      </div>
    <div class="mb-3 row " style="width: 300px;">
        <label for="Email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="text"   name="email" class="form-control" id="Email" placeholder="email@gmail.com" >
        </div>
      </div>
      <div class="mb-3  row" style="width: 300px; ">
        <label for="inputPassword" class="col-sm-2 col-form-label">Pass</label>
        <div class="col-sm-10">
          <input type="password"  name="pass" class="form-control" id="inputPassword">
        </div>
      </div>
      <div class="mb-3 row" style="width: 300px;">
        <label  class="col-sm-2 col-form-label">Profile Image</label>
        <div class="col-sm-10">
          <input type="file"  name="profile_image" class="form-control " >
        </div>
      </div> 
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    <!-- Example Code End -->
    </form>
</body>
</html>