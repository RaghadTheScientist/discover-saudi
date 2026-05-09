<?php
include '../includes/db_config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: gallery.php");
    exit();
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM places WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

$images_sql = "SELECT * FROM gallery_images WHERE place_id = $id ORDER BY image_order ASC";
$images_result = mysqli_query($conn, $images_sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

</script>

    <meta charset="UTF-8">
    <title><?php echo $data['name']; ?> – اكتشف السعودية</title>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/details.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>

<body>

<header class="site-header" id="site-header" role="banner">
    <nav class="navbar" aria-label="التنقل الرئيسي">
        <a href="index.html" class="nav-brand">اكتشف السعودية</a>

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
            <li><a href="index.html" class="nav-link">الرئيسية</a></li>
            <li><a href="gallery.php" class="nav-link">معرض المناطق</a></li>
            <li><a href="../admin/login.php" class="nav-link">دخول المشرف</a></li>
            <li>
                <button id="nightModeBtn" class="night-mode-btn" type="button" aria-pressed="false">
                    <span class="mode-icon">🌙</span>
                    <span class="mode-text">الوضع الليلي</span>
                </button>
            </li>
        </ul>
    </nav>
</header>

<main id="main-content" role="main">
    <article class="details-container" aria-labelledby="place-title">

        <figure>
            <img
                src="<?php echo $data['main_image']; ?>"
                alt="صورة رئيسية لـ <?php echo $data['name']; ?>"
                class="main-image">
        </figure>

        <h1 id="place-title"><?php echo $data['name']; ?></h1>

        <p class="main-description"><?php echo $data['description']; ?></p>

        <section class="info-section" aria-label="معلومات سريعة">

            <div class="info-box">
                <h2>المنطقة</h2>
                <p><?php echo $data['region']; ?></p>
            </div>

            <div class="info-box">
                <h2>الموقع</h2>
                <p><?php echo $data['location']; ?></p>
            </div>

            <div class="info-box">
                <h2>المميزات</h2>
                <p><?php echo $data['features']; ?></p>
            </div>

            <div class="info-box">
                <h2>الأنشطة</h2>
                <p><?php echo $data['activities']; ?></p>
            </div>

            <div class="info-box">
                <h2>أهم المعالم</h2>
                <p><?php echo $data['top_landmarks']; ?></p>
            </div>

        </section>

        <section class="gallery-section" aria-labelledby="gallery-title">
            <h2 class="gallery-title" id="gallery-title">معرض الصور</h2>
            <figure class="gallery-images">
                <?php while ($img = mysqli_fetch_assoc($images_result)) { ?>
                    <img
                        src="<?php echo $img['image_path']; ?>"
                        alt="صورة من معرض <?php echo $data['name']; ?>"
                        class="gallery-img">
                <?php } ?>
            </figure>
        </section>

    </article>
</main>

<footer class="site-footer" role="contentinfo">
    <p>© اكتشف السعودية — جامعة الملك سعود</p>
</footer>

<script src="js/home.js"></script>
</body>
</html>