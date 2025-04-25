<?php
include "connection.php";
include "check_login.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);



if (!isset($_GET['id'])) {
    die("No ID provided.");
}

$id = $_GET['id'];

// Fetch category to edit
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die("Category not found.");
}

// Fetch all users for dropdown
$users = $pdo->query("SELECT id, name FROM users")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];

    $update = $pdo->prepare("UPDATE categories SET user_id = ?, name = ? WHERE id = ?");
   
    $update->execute([
        $user_id,
        $name,
        $id
    ]);
    header("Location: view.php");
    exit;
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Category</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>Edit Category</h2>
  <form method="post">
    <div class="mb-3">
      <label for="user_id" class="form-label">User</label>
      <select name="user_id" id="user_id" class="form-select" required>
        <?php foreach($users as $user): ?>
          <option value="<?= $user['id'] ?>" <?= $user['id'] == $category['user_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($user['name']) ?> (ID: <?= $user['id'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="name" class="form-label">Category Name</label>
      <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
    </div>

    <button type="submit" name="update" class="btn btn-success">Update</button>
    <a href="view.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
