<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../login.php"); // adjust path as needed
  exit;
}
