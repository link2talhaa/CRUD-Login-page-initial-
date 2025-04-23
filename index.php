<form method="GET" action="" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search by name - email - ID" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Search</button>
</form>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include "connection.php";
//search for the user


if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = "%" . $_GET['search'] . "%";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :exactId OR Name LIKE :term OR Email LIKE :term");
    $stmt->execute([
        'exactId' => $_GET['search'], // No % for exact ID match
        'term' => $searchTerm
    ]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// search code end 

?>

<form method="POST" action="logout.php" style="text-align:right;">
    <button type="submit" style="
        background-color: #dc3545;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    ">Logout</button>
</form>

<h2>All Users</h2>
<table border="1" cellpadding="10">
  <tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Actions</th>
  </tr>
  <?php foreach ($users as $user): ?>
    <tr>
      <td><?= $user['id'] ?></td>
      <td><?= htmlspecialchars($user['Name']) ?></td>
      <td><?= htmlspecialchars($user['Email']) ?></td>
      <td><?= htmlspecialchars($user['pass']) ?></td> <!-- Ensure column name is 'pass' -->
      <td>
        <?php if ($user['profile_image']): ?>
          <img src="<?= htmlspecialchars($user['profile_image']) ?>" width="60" height="60" style="object-fit: cover; border-radius: 50%;">
        <?php else: ?>
          No Image
        <?php endif; ?>
      </td>
      <td>
        <a href="edit.php?id=<?= $user['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?');">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<br>

<div style="text-align: center; margin-top: 20px;">
    <form action="form.php" method="GET">
        <button type="submit" style="
            padding: 10px 25px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        ">
            ➕ Add New Record
        </button>
    </form>
</div>
