<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    $conn = new mysqli(
        "127.0.0.1",
        "root",
        "root",
        "saudi_db",
        8889
    );

} catch (Exception $e) {

    die("Database Error: " . $e->getMessage());
}


$sql = "SELECT * FROM regions";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">

    <title>معرض المناطق</title>
    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="../public/css/details.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Tajawal', sans-serif;
            background:#f5f5f5;
        }

        header{
            background:#0b5d1e;
            padding:20px;
        }

        nav{
            width:90%;
            margin:auto;

            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .logo{
            color:white;
            font-size:28px;
            font-weight:bold;
            text-decoration:none;
        }

        .nav-links{
            list-style:none;
            display:flex;
            gap:20px;
        }

        .nav-links a{
            color:white;
            text-decoration:none;
            font-size:18px;
        }

        .page-title{
            text-align:center;
            margin:40px 0;
            font-size:42px;
            color:#0b5d1e;
        }

        .gallery-container{

            width:90%;
            margin:auto;

            display:grid;

            grid-template-columns:
            repeat(auto-fit,minmax(300px,1fr));

            gap:25px;

            padding-bottom:50px;
        }

        .card{

            background:white;

            border-radius:15px;

            overflow:hidden;

            box-shadow:0 4px 12px rgba(0,0,0,0.1);

            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-6px);
        }

        .card img{

            width:100%;
            height:230px;

            object-fit:cover;
        }

        .card-content{
            padding:20px;
            text-align:center;
        }

        .card-content h2{
            margin-bottom:10px;
            color:#0b5d1e;
        }

        .direction{
            color:#777;
            margin-bottom:15px;
            font-size:18px;
        }

        .description{
            color:#444;
            line-height:1.8;
        }

        .details-btn{

            display:inline-block;

            margin-top:20px;

            background:#0b5d1e;

            color:white;

            text-decoration:none;

            padding:10px 18px;

            border-radius:8px;

            transition:0.3s;
        }

        .details-btn:hover{
            background:#084615;
        }

        footer{

            background:#0b5d1e;

            color:white;

            text-align:center;

            padding:20px;

            margin-top:40px;
        }

        /* Dark mode for whole page */
body.night-mode {
    background-color: #121212;
    color: white;
}

/* Example navbar dark mode */
body.night-mode .site-header {
    background-color: #1e1e1e;
}

/* Example cards dark mode */
body.night-mode .feature-card,
body.night-mode .stat-card,
body.night-mode .about-section {
    background-color: #1f1f1f;
    color: white;
}

/* Button styling */
.night-mode-btn {
    border: none;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
}
body.night-mode .card {
    background-color: #1f1f1f;
    box-shadow: 0 4px 12px rgba(255,255,255,0.08);
}

body.night-mode .card-content h2 {
    color: #ffffff;
}

body.night-mode .direction {
    color: #cccccc;
}

body.night-mode .description {
    color: #e0e0e0;
}

body.night-mode .page-title {
    color: white;
}
.filters{

    text-align:center;

    margin-bottom:30px;
}

.filters button{

    background:#0b5d1e;

    color:white;

    border:none;

    padding:10px 18px;

    margin:5px;

    border-radius:8px;

    cursor:pointer;

    font-size:16px;

    transition:0.3s;
}

.filters button:hover{

    background:#084615;
}

body.night-mode .filters button{

    background:#333;
}

    </style>

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