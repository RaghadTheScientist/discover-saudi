<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(
    MYSQLI_REPORT_ERROR |
    MYSQLI_REPORT_STRICT
);


session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: login.php");
    exit();
}

include '../includes/db_config.php';

if (isset($_POST['add'])) {

    $name = $_POST['name'];

    $description = $_POST['description'];

    $location = $_POST['location'];

    $features = $_POST['features'];

    $activities = $_POST['activities'];

    $top_landmarks = $_POST['top_landmarks'];

    // الصورة الرئيسية
    $main_image = "";

    // يجب اختيار صورة
    if (
        empty($_FILES['main_image']['name'])
    ) {

        die("يجب اختيار صورة");
    }

    // رفع الصورة الرئيسية
    $main_image =

        "images/" .

        basename(
            $_FILES['main_image']['name']
        );

    move_uploaded_file(

        $_FILES['main_image']['tmp_name'],

        "../public/" . $main_image
    );

    // إضافة المنطقة
    $insert_region = "

        INSERT INTO regions

        (
            name,
            direction,
            description
        )

        VALUES

        (
            '$name',
            '$location',
            '$description'
        )
    ";

    if(
        !mysqli_query(
            $conn,
            $insert_region
        )
    ){

        die(
            "REGION ERROR: "
            . mysqli_error($conn)
        );
    }

    // أخذ region_id
    $region_id = mysqli_insert_id($conn);
    //$place_id = mysqli_insert_id($conn);
    // إضافة المكان
    $insert_place = "

        INSERT INTO places

        (
            region_id,
            name,
            description,
            location,
            features,
            activities,
            top_landmarks,
            main_image
        )

        VALUES

        (
            '$region_id',
            '$name',
            '$description',
            '$location',
            '$features',
            '$activities',
            '$top_landmarks',
            '$main_image'
        )
    ";

    if(
        !mysqli_query(
            $conn,
            $insert_place
        )
    ){

        die(
            "PLACE ERROR: "
            . mysqli_error($conn)
        );
    }

    // أخذ place_id
    // $place_id = $region_id;

    // إضافة الصورة في gallery_images
    $insert_img = "

        INSERT INTO gallery_images

        (
            place_id,
            image_path,
            image_order
        )

        VALUES

        (
            '$region_id',
            '$main_image',
            1
        )
    ";

    if(
        !mysqli_query(
            $conn,
            $insert_img
        )
    ){

        die(
            "GALLERY ERROR: "
            . mysqli_error($conn)
        );
    }

   // حفظ رسالة النجاح
    header("Location: dashboard.php?msg=تم إضافة المحتوى بنجاح");
    exit();

    
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>
        إضافة محتوى
    </title>

    <link rel="stylesheet" href="../public/css/shared.css">

    <link rel="stylesheet" href="../public/css/details.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap"
        rel="stylesheet"
    >

</head>

<body>

<header class="site-header">

    <nav class="navbar">

        <a href="../public/index.php" class="nav-brand">

            اكتشف السعودية

        </a>

        <ul class="nav-menu">

            <li>
                <a href="dashboard.php" class="nav-link">
                    لوحة التحكم
                </a>
            </li>

            <li>
                <a href="add_content.php" class="nav-link active">
                    إضافة محتوى
                </a>
            </li>

            <li>
                <a href="logout.php" class="nav-link">
                    تسجيل الخروج
                </a>
            </li>

        </ul>

    </nav>

</header>

<main>

<div class="form-container">

    <h1 class="form-title">

        إضافة محتوى جديد

    </h1>
    <?php if (isset($success_message)) : ?>

    <div class="success-message">
        <?php echo $success_message; ?>
    </div>

    <?php endif; ?>
    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <label>
            اسم المكان
        </label>

        <input
            type="text"
            name="name"
            required
        >

        <label>
            الوصف
        </label>

        <textarea
            name="description"
            required
        ></textarea>

        <label>
            الموقع / الاتجاه
        </label>

        <input
            type="text"
            name="location"
        >

        <label>
            المميزات
        </label>

        <textarea
            name="features"
        ></textarea>

        <label>
            الأنشطة
        </label>

        <textarea
            name="activities"
        ></textarea>

        <label>
            أهم المعالم
        </label>

        <textarea
            name="top_landmarks"
        ></textarea>

        <label>
            الصورة الرئيسية
        </label>

        <input
            type="file"
            name="main_image"
            accept="image/*"
            required
        >

        <button
            type="submit"
            name="add"
        >

            إضافة المحتوى

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