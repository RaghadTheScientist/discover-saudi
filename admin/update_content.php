<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM places WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

$images_sql = "SELECT * FROM gallery_images 
               WHERE place_id = $id 
               ORDER BY image_order ASC";

$images_result = mysqli_query($conn, $images_sql);

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $features = $_POST['features'];
    $activities = $_POST['activities'];
    $top_landmarks = $_POST['top_landmarks'];

    $main_image = $data['main_image'];

    if (!empty($_FILES['main_image']['name'])) {

        $main_image = $_FILES['main_image']['name'];

        move_uploaded_file(
            $_FILES['main_image']['tmp_name'],
            "../public/images/" . $main_image
        );
    }

    $update = "UPDATE places SET

        name='$name',
        description='$description',
        location='$location',
        features='$features',
        activities='$activities',
        top_landmarks='$top_landmarks',
        main_image='$main_image'

        WHERE id=$id";

    mysqli_query($conn, $update);

    if (!empty($_FILES['gallery_images']['name'][0])) {

        mysqli_query($conn,
            "DELETE FROM gallery_images WHERE place_id = $id"
        );

        for ($i = 0; $i < count($_FILES['gallery_images']['name']); $i++) {

            $image_name = $_FILES['gallery_images']['name'][$i];
            $tmp_name = $_FILES['gallery_images']['tmp_name'][$i];
            $order = $i + 1;

            if (!empty($image_name)) {

                move_uploaded_file(
                    $tmp_name,
                    "../public/images/" . $image_name
                );

                $insert_img = "INSERT INTO gallery_images
                (place_id, image_path, image_order)

                VALUES

                ($id, '$image_name', $order)";

                mysqli_query($conn, $insert_img);
            }
        }
    }

    header("Location: dashboard.php?msg=تم تحديث المحتوى بنجاح");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>تحديث المحتوى</title>

    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="../public/css/details.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

</head>

<body>

<header class="site-header">

    <nav class="navbar">

        <a href="../public/index.php" class="nav-brand">
            اكتشف السعودية
        </a>

        <ul class="nav-menu">

            <li>
                <a href="dashboard.php" class="nav-link active">
                    لوحة التحكم
                </a>
            </li>

            <li>
                <a href="logout.php" class="nav-link">
                    تسجيل الخروج
                </a>
            </li>
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

    <h1 class="form-title">
        تحديث المحتوى
    </h1>

    <form method="POST" enctype="multipart/form-data">

        <label>اسم المكان</label>

        <input
            type="text"
            name="name"
            value="<?php echo $data['name']; ?>"
            required
        >

        <label>الوصف</label>

        <textarea
            name="description"
            required
        ><?php echo $data['description']; ?></textarea>

        <label>الموقع</label>

        <input
            type="text"
            name="location"
            value="<?php echo $data['location']; ?>"
        >

        <label>المميزات</label>

        <textarea
            name="features"
        ><?php echo $data['features']; ?></textarea>

        <label>الأنشطة</label>

        <textarea
            name="activities"
        ><?php echo $data['activities']; ?></textarea>

        <label>أهم المعالم</label>

        <textarea
            name="top_landmarks"
        ><?php echo $data['top_landmarks']; ?></textarea>

        <label>الصورة الرئيسية الحالية</label>

        <img
            src="../public/<?php echo $data['main_image']; ?>"
            class="main-image"
            alt=""
        >

        <input
            type="file"
            name="main_image"
            accept="image/*"
        >

        <label>صور المعرض الإضافية</label>

        <input
            type="file"
            name="gallery_images[]"
            accept="image/*"
            multiple
        >

        <div class="gallery-images">

    <?php while($img = mysqli_fetch_assoc($images_result)) { ?>

        <img
            src="../public/<?php echo $img['image_path']; ?>"
            class="gallery-img"
            alt=""
        >

    <?php } ?>

</div>

        <button type="submit" name="update">
            حفظ التعديلات
        </button>

    </form>

</div>

</main>

<footer class="site-footer">

    <p>
    © اكتشف السعودية — جامعة الملك سعود
    </p>

</footer>
<script src="../public/js/home.js"></script>
</body>
</html>