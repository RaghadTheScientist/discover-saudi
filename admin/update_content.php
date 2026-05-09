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

$sql = "SELECT * FROM places WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: dashboard.php");
    exit();
}

$images_sql = "SELECT * FROM gallery_images 
               WHERE place_id = $id 
               ORDER BY image_order ASC";
$images_result = mysqli_query($conn, $images_sql);

if (isset($_POST['update'])) {

    $name          = $_POST['name'];
    $region        = $_POST['region'];
    $description   = $_POST['description'];
    $location      = $_POST['location'];
    $features      = $_POST['features'];
    $activities    = $_POST['activities'];
    $top_landmarks = $_POST['top_landmarks'];

    $main_image = $data['main_image'];

    if (!empty($_FILES['main_image']['name'])) {
        $folder_name = preg_replace('/\s+/', '_', trim($name));
        $ext         = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $main_image  = "images/" . $folder_name . "/main." . $ext;
        move_uploaded_file(
            $_FILES['main_image']['tmp_name'],
            "../public/" . $main_image
        );
    }

    $update = "UPDATE places SET
        name          = '$name',
        region        = '$region',
        description   = '$description',
        location      = '$location',
        features      = '$features',
        activities    = '$activities',
        top_landmarks = '$top_landmarks',
        main_image    = '$main_image'
        WHERE id = $id";

    mysqli_query($conn, $update);

    if (!empty($_FILES['gallery_images']['name'][0])) {

        mysqli_query($conn, "DELETE FROM gallery_images WHERE place_id = $id");

        $folder_name = preg_replace('/\s+/', '_', trim($name));

        for ($i = 0; $i < count($_FILES['gallery_images']['name']); $i++) {

            $ext        = pathinfo($_FILES['gallery_images']['name'][$i], PATHINFO_EXTENSION);
            $tmp_name   = $_FILES['gallery_images']['tmp_name'][$i];
            $order      = $i + 1;
            $image_name = "gallery" . $order . "." . $ext;
            $image_path = "images/" . $folder_name . "/" . $image_name;

            if (!empty($_FILES['gallery_images']['name'][$i])) {
                move_uploaded_file($tmp_name, "../public/" . $image_path);

                $insert_img = "INSERT INTO gallery_images (place_id, image_path, image_order)
                               VALUES ($id, '$image_path', $order)";

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

</script>

    <meta charset="UTF-8">
    <title>تحديث المحتوى</title>
    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>

<body>

<header class="site-header" id="site-header" role="banner">
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
    <section class="form-container" aria-labelledby="update-title">

        <h1 class="form-title" id="update-title">تحديث المحتوى</h1>

        <form method="POST" enctype="multipart/form-data">

            <label for="name">اسم المكان *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo $data['name']; ?>"
                required>

            <label for="region">المنطقة *</label>
            <select id="region" name="region" required>
                <option value="" disabled>اختر المنطقة</option>
                <?php
                $regions = [
                    'الرياض', 'مكة المكرمة', 'المدينة المنورة', 'الشرقية',
                    'عسير', 'تبوك', 'حائل', 'الحدود الشمالية',
                    'الجوف', 'القصيم', 'جازان', 'نجران', 'الباحة'
                ];
                foreach ($regions as $r) {
                    $selected = ($data['region'] === $r) ? 'selected' : '';
                    echo "<option value=\"$r\" $selected>$r</option>";
                }
                ?>
            </select>

            <label for="description">الوصف *</label>
            <textarea id="description" name="description" required><?php echo $data['description']; ?></textarea>

            <label for="location">الموقع</label>
            <input
                type="text"
                id="location"
                name="location"
                value="<?php echo $data['location']; ?>">

            <label for="features">المميزات</label>
            <textarea id="features" name="features"><?php echo $data['features']; ?></textarea>

            <label for="activities">الأنشطة</label>
            <textarea id="activities" name="activities"><?php echo $data['activities']; ?></textarea>

            <label for="top_landmarks">أهم المعالم</label>
            <textarea id="top_landmarks" name="top_landmarks"><?php echo $data['top_landmarks']; ?></textarea>

            <label>الصورة الرئيسية الحالية</label>
            <figure>
                <img
                    src="../public/<?php echo $data['main_image']; ?>"
                    class="main-image"
                    alt="الصورة الرئيسية لـ <?php echo $data['name']; ?>">
            </figure>

            <label for="main_image">تحديث الصورة الرئيسية (اختياري)</label>
            <input type="file" id="main_image" name="main_image" accept="image/*">

            <label>صور المعرض الحالية</label>
            <figure class="gallery-images">
                <?php while ($img = mysqli_fetch_assoc($images_result)) { ?>
                    <img
                        src="../public/<?php echo $img['image_path']; ?>"
                        class="gallery-img"
                        alt="صورة معرض لـ <?php echo $data['name']; ?>">
                <?php } ?>
            </figure>

            <label for="gallery_images">تحديث صور المعرض (اختياري)</label>
            <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple>

            <button type="submit" name="update">حفظ التعديلات</button>

        </form>

    </section>
</main>

<footer class="site-footer" role="contentinfo">
    <p>اكتشف السعودية</p>
</footer>

<script src="../public/js/home.js"></script>
</body>
</html>