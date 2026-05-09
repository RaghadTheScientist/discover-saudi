<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = (int) $_GET['id'];

$sql    = "SELECT * FROM places WHERE id = $id";
$result = mysqli_query($conn, $sql);
$place  = mysqli_fetch_assoc($result);

if (!$place) {
    header("Location: dashboard.php");
    exit();
}

$folder_name = preg_replace('/\s+/', '_', trim($place['name']));
$folder_path = "../public/images/" . $folder_name . "/";


if (file_exists($folder_path)) {
    $files = glob($folder_path . "*");
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($folder_path);
}

mysqli_query($conn, "DELETE FROM places WHERE id = $id");

header("Location: dashboard.php?msg=تم حذف المحتوى بنجاح");
exit();
?>