<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_config.php';

if (isset($_POST['add'])) {

    $name          = $_POST['name'];
    $region        = $_POST['region'];
    $description   = $_POST['description'];
    $location      = $_POST['location'];
    $features      = $_POST['features'];
    $activities    = $_POST['activities'];
    $top_landmarks = $_POST['top_landmarks'];

    $folder_name = preg_replace('/\s+/', '_', trim($name));
    $folder_path = "../public/images/" . $folder_name . "/";

    if (!file_exists($folder_path)) {
        mkdir($folder_path, 0755, true);
    }

    if (empty($_FILES['main_image']['name'])) {
        die("يجب اختيار صورة رئيسية");
    }

    $main_ext   = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
    $main_image = "images/" . $folder_name . "/main." . $main_ext;

    move_uploaded_file(
        $_FILES['main_image']['tmp_name'],
        "../public/" . $main_image
    );

    $insert_place = "
        INSERT INTO places
        (name, region, description, location, features, activities, top_landmarks, main_image)
        VALUES
        ('$name', '$region', '$description', '$location', '$features', '$activities', '$top_landmarks', '$main_image')
    ";

    mysqli_query($conn, $insert_place);

    $place_id = mysqli_insert_id($conn);

    $gallery_fields = ['gallery_image_1', 'gallery_image_2', 'gallery_image_3'];
    $gallery_order  = 1;

    foreach ($gallery_fields as $field) {
        if (!empty($_FILES[$field]['name'])) {
            $ext          = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
            $gallery_path = "images/" . $folder_name . "/gallery" . $gallery_order . "." . $ext;

            move_uploaded_file(
                $_FILES[$field]['tmp_name'],
                "../public/" . $gallery_path
            );

            $insert_img = "
                INSERT INTO gallery_images (place_id, image_path, image_order)
                VALUES ('$place_id', '$gallery_path', '$gallery_order')
            ";

            mysqli_query($conn, $insert_img);
            $gallery_order++;
        }
    }

    header("Location: dashboard.php?msg=تم إضافة المحتوى بنجاح");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

</script>


    <meta charset="UTF-8">
    <title>إضافة محتوى</title>
    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>

<body>

<header class="site-header" id="site-header">
    <nav class="navbar">
        <a href="../public/index.html" class="nav-brand">اكتشف السعودية</a>
        <button
            class="hamburger"
            id="hamburgerBtn"
            aria-label="فتح القائمة"
            aria-expanded="false"
            aria-controls="navMenu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-menu" id="navMenu">
            <li><a href="dashboard.php" class="nav-link">لوحة التحكم</a></li>
            <li><a href="add_content.php" class="nav-link active">إضافة محتوى</a></li>
            <li><a href="logout.php" class="nav-link">تسجيل الخروج</a></li>
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
<div class="form-container">

    <h1 class="form-title">إضافة محتوى جديد</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>اسم المكان *</label>
        <input type="text" name="name" required>

        <label>المنطقة *</label>
        <select name="region" required>
            <option value="" disabled selected>اختر المنطقة</option>
            <option value="الرياض">الرياض</option>
            <option value="مكة المكرمة">مكة المكرمة</option>
            <option value="المدينة المنورة">المدينة المنورة</option>
            <option value="الشرقية">الشرقية</option>
            <option value="عسير">عسير</option>
            <option value="تبوك">تبوك</option>
            <option value="حائل">حائل</option>
            <option value="الحدود الشمالية">الحدود الشمالية</option>
            <option value="الجوف">الجوف</option>
            <option value="القصيم">القصيم</option>
            <option value="جازان">جازان</option>
            <option value="نجران">نجران</option>
            <option value="الباحة">الباحة</option>
        </select>

        <label>الوصف *</label>
        <textarea name="description" required></textarea>

        <label>الموقع</label>
        <input type="text" name="location">

        <label>المميزات</label>
        <textarea name="features"></textarea>

        <label>الأنشطة</label>
        <textarea name="activities"></textarea>

        <label>أهم المعالم</label>
        <textarea name="top_landmarks"></textarea>

        <label>الصورة الرئيسية *</label>
        <input type="file" name="main_image" accept="image/*" required>

        <label>صورة المعرض الأولى *</label>
        <input type="file" name="gallery_image_1" accept="image/*" required>

        <label>صورة المعرض الثانية (اختياري)</label>
        <input type="file" name="gallery_image_2" accept="image/*">

        <label>صورة المعرض الثالثة (اختياري)</label>
        <input type="file" name="gallery_image_3" accept="image/*">

        <button type="submit" name="add">إضافة المحتوى</button>

    </form>

</div>
</main>

<footer class="site-footer">
    <p>اكتشف السعودية</p>
</footer>

<script src="../public/js/home.js"></script>

</body>
</html>