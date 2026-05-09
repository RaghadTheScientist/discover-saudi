<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include '../includes/db_config.php';


$sql = "SELECT * FROM regions";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">

    <title>معرض المناطق</title>
    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="../public/css/gallery.css">
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

    <h1 class="page-title">
        معرض مناطق المملكة العربية السعودية
    </h1>
    <div class="filters">

    <button onclick="filterRegions('all')">
        الكل
    </button>

    <button onclick="filterRegions('وسطى')">
        الوسطى
    </button>

    <button onclick="filterRegions('غربية')">
        الغربية
    </button>

    <button onclick="filterRegions('شرقية')">
        الشرقية
    </button>

    <button onclick="filterRegions('شمالية')">
        الشمالية
    </button>

    <button onclick="filterRegions('جنوبية')">
        الجنوبية
    </button>

</div>
    <div class="gallery-container">

        <?php while($region = mysqli_fetch_assoc($result)) { ?>

            <?php

            $region_id = $region['id'];

            // جلب أول صورة مرتبطة بالمنطقة
            $img_sql = "
                SELECT *
                FROM gallery_images
                WHERE place_id = $region_id
                ORDER BY image_order ASC
                LIMIT 1
            ";

            $img_result = mysqli_query($conn, $img_sql);

            $img = mysqli_fetch_assoc($img_result);

            ?>

            <div class="card" data-direction="<?php echo $region['direction']; ?>">

                <?php if($img){ ?>

                    <img
                        src="<?php echo $img['image_path']; ?>"
                        alt="<?php echo $region['name']; ?>"
                    >

                <?php } else { ?>

                    <img
                        src="images/default.jpg"
                        alt="No Image"
                    >

                <?php } ?>

                <div class="card-content">

                    <h2>
                        <?php echo $region['name']; ?>
                    </h2>

                    <p class="direction">
                        <?php echo $region['direction']; ?>
                    </p>

                    <p class="description">
                        <?php echo $region['description']; ?>
                    </p>

                    <a
                        href="details.php?id=<?php echo $region['id']; ?>"
                        class="details-btn"
                    >
                        عرض التفاصيل
                    </a>

                </div>

            </div>

        <?php } ?>

    </div>

</main>

<footer>

    © اكتشف السعودية — جامعة الملك سعود

</footer>
<script>

function filterRegions(direction){

    let cards = document.querySelectorAll('.card');

    cards.forEach(card => {

        if(direction === 'all'){

            card.style.display = 'block';

        } else {

            let cardDirection = card.dataset.direction;

            if(cardDirection === direction){

                card.style.display = 'block';

            } else {

                card.style.display = 'none';
            }
        }

    });

}

</script>
<script src="js/home.js"></script>
</body>

</html>