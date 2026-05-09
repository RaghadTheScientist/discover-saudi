<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include '../includes/db_config.php';

$sql = "SELECT * FROM places";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

</script>

    <meta charset="UTF-8">
    <title>معرض المناطق – اكتشف السعودية</title>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/gallery.css">
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
            <li><a href="gallery.php" class="nav-link active">معرض المناطق</a></li>
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

    <section aria-labelledby="gallery-title">

        <h1 class="page-title" id="gallery-title">معرض مناطق المملكة العربية السعودية</h1>

        <nav class="filters" aria-label="تصفية المناطق">
            <button onclick="filterRegions('all', event)" class="filter-btn active">الكل</button>
            <button onclick="filterRegions('الرياض', event)" class="filter-btn">الرياض</button>
            <button onclick="filterRegions('مكة المكرمة', event)" class="filter-btn">مكة المكرمة</button>
            <button onclick="filterRegions('المدينة المنورة', event)" class="filter-btn">المدينة المنورة</button>
            <button onclick="filterRegions('الشرقية', event)" class="filter-btn">الشرقية</button>
            <button onclick="filterRegions('عسير', event)" class="filter-btn">عسير</button>
            <button onclick="filterRegions('تبوك', event)" class="filter-btn">تبوك</button>
            <button onclick="filterRegions('حائل', event)" class="filter-btn">حائل</button>
            <button onclick="filterRegions('الحدود الشمالية', event)" class="filter-btn">الحدود الشمالية</button>
            <button onclick="filterRegions('الجوف', event)" class="filter-btn">الجوف</button>
            <button onclick="filterRegions('القصيم', event)" class="filter-btn">القصيم</button>
            <button onclick="filterRegions('جازان', event)" class="filter-btn">جازان</button>
            <button onclick="filterRegions('نجران', event)" class="filter-btn">نجران</button>
            <button onclick="filterRegions('الباحة', event)" class="filter-btn">الباحة</button>
        </nav>

        <div class="gallery-container" role="list">

            <?php while ($place = mysqli_fetch_assoc($result)) { ?>

                <article class="card" data-region="<?php echo $place['region']; ?>" role="listitem">

                    <?php if (!empty($place['main_image'])) { ?>
                        <img
                            src="<?php echo $place['main_image']; ?>"
                            alt="صورة <?php echo $place['name']; ?>">
                    <?php } else { ?>
                        <img
                            src="images/default.jpg"
                            alt="لا توجد صورة">
                    <?php } ?>

                    <div class="card-content">

                        <h2><?php echo $place['name']; ?></h2>

                        <p class="region-label">
                            <?php echo $place['region']; ?>
                        </p>

                        <p class="description">
                            <?php echo $place['description']; ?>
                        </p>

                        <a href="details.php?id=<?php echo $place['id']; ?>" class="details-btn">
                            عرض التفاصيل
                        </a>

                    </div>

                </article>

            <?php } ?>

        </div>

    </section>

</main>

<footer class="site-footer" role="contentinfo">
    <p>© اكتشف السعودية — جامعة الملك سعود</p>
</footer>

<script>
function filterRegions(region, event) {
    const cards = document.querySelectorAll('.card');
    const buttons = document.querySelectorAll('.filter-btn');

    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    cards.forEach(card => {
        if (region === 'all') {
            card.style.display = 'block';
        } else {
            card.style.display = (card.dataset.region === region) ? 'block' : 'none';
        }
    });
}
</script>

<script src="js/home.js"></script>

</body>
</html> 