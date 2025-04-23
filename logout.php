<?php
session_start();
unset($_SESSION['user']); // 🔥 ONLY remove the user session
header("Location: login.php");
exit;
?>