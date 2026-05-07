<?php
include '../includes/db_config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM places WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

$images_sql = "SELECT * FROM gallery_images WHERE place_id = $id ORDER BY image_order ASC";
$images_result = mysqli_query($conn, $images_sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['name']; ?></title>

    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="../public/css/details.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>

<body>

<header class="site-header">
    <nav class="navbar">
        <a href="../public/index.php" class="nav-brand">اكتشف السعودية</a>

        <ul class="nav-menu">
            <li><a href="index.html" class="nav-link">الرئيسية</a></li>
            <li><a href="gallery.php" class="nav-link">معرض المناطق</a></li>
            <li><a href="../admin/dashboard.php" class="nav-link">لوحة التحكم</a></li>
            <li>
    <button id="nightModeBtn" class="night-mode-btn" type="button" aria-pressed="false">
        <span class="mode-icon">🌙</span>
        <span class="mode-text">الوضع الليلي</span>
    </button>
</li>
        </ul>
    </nav>
</header>

<main>
    <div class="details-container">

    <img
    src="../public/<?php echo $data['main_image']; ?>"
    alt="<?php echo $data['name']; ?>"
    class="main-image"
>

        <h1><?php echo $data['name']; ?></h1>

        <p><?php echo $data['description']; ?></p>

        <div class="info-box">
            <h3>الموقع</h3>
            <p><?php echo $data['location']; ?></p>
        </div>

        <div class="info-box">
            <h3>المميزات</h3>
            <p><?php echo $data['features']; ?></p>
        </div>

        <div class="info-box">
            <h3>الأنشطة</h3>
            <p><?php echo $data['activities']; ?></p>
        </div>

        <div class="info-box">
            <h3>أهم المعالم</h3>
            <p><?php echo $data['top_landmarks']; ?></p>
        </div>
<br>
        <h2 class="gallery-title">معرض الصور</h2>

<div class="gallery-images">

    <?php while($img = mysqli_fetch_assoc($images_result)) { ?>

        <img
            src="../public/<?php echo $img['image_path']; ?>"
            alt="<?php echo $data['name']; ?>"
            class="gallery-img"
        >

    <?php } ?>

    </div>

    </div>
</main>

<footer class="site-footer">
    <p>© اكتشف السعودية — جامعة الملك سعود</p>
</footer>
<script src="../public/js/home.js"></script>
</body>
</html>