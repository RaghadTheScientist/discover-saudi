<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_config.php';

$id = $_GET['id'];

$sql = "DELETE FROM regions WHERE id = $id";

mysqli_query($conn, $sql);

header("Location: dashboard.php?msg=تم حذف المحتوى بنجاح");

exit();
?>