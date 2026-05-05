<?php


define('DB_HOST', 'localhost');
define('DB_USER', 'root');      
define('DB_PASS', 'root');           
define('DB_NAME', 'saudi_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

?>