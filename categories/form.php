<?php
// form.php

include "connection.php";

// Fetch users from database
$users = $pdo->query("SELECT id, name FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Insert Form</title>
</head>
<body>

<form action="insert.php" method="post" class="container mt-5">
  <div class="mb-3">
    <label for="id" class="form-label">ID</label>
    <input type="number" class="form-control" name="id" id="id">
  </div>

  <div class="mb-3">
    <label for="user_id" class="form-label">User</label>
    <select name="user_id" id="user_id" class="form-select" required>
      <option value="">-- Select User --</option>
      <?php foreach($users as $user): ?>
        <option value="<?= htmlspecialchars($user['id']) ?>">
          <?= htmlspecialchars($user['name']) ?> (ID: <?= $user['id'] ?>)
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label for="name" class="form-label"> Name</label>
    <input type="text" class="form-control" name="name" id="name" required>
  </div>

  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>

</body>
</html>
