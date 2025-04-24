session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
<?php
// Include connection
include "connection.php";
session_start();

// Check if ID is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID");
}
$userId = $_GET['id'];

// Fetch current user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found");
}

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $profileImage = $user['profile_image']; // Default to old image

    // Check if a new image was uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['profile_image']['tmp_name'];
        $imageName = basename($_FILES['profile_image']['name']);
        $uploadDir = 'uploads/';
        $destination = $uploadDir . $imageName;

        if (move_uploaded_file($imageTmpPath, $destination)) {
            $profileImage = $destination;
        }
    }

    // Update user info including image
    $update = $pdo->prepare("UPDATE users SET name = :name, email = :email, pass = :pass, profile_image = :profile_image WHERE id = :id");
    $update->execute([
        'name' => $name,
        'email' => $email,
        'pass' => $pass,
        'profile_image' => $profileImage,
        'id' => $userId
    ]);

    header("Location: index.php");
    exit;
}
?>


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-3 m-0 border-0 bd-example m-0 border-0">
    <div class="container">
        <h2>Edit User</h2>
        <form action="edit.php?id=<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($user['Name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" id="pass" value="<?= htmlspecialchars($user['pass']) ?>" required>
            </div>

            <label>Current Image:</label><br>
            <?php if ($user['profile_image']): ?>
                <img src="<?= $user['profile_image'] ?>" width="100"><br>
            <?php endif; ?>
            
            <label>Change Image:</label>
            <input type="file" name="profile_image"><br><br>

            <button type="submit" name="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</body>
</html>
