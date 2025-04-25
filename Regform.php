<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>LOGIN FORM</title>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">

  
    <!-- ✅ Success Alert -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Example Code Start-->
     <form action="insert.php" enctype="multipart/form-data" method="POST">
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
      <button type="submit" name="submit" class="btn btn-primary">Register</button>
    <!-- Example Code End -->
    </form>
 
  

 
  </body>
</html>
