<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db_config.php';
$sql = "SELECT * FROM places";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

</script>

    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
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
            <li><a href="dashboard.php" class="nav-link active">لوحة التحكم</a></li>
            <li><a href="add_content.php" class="nav-link">إضافة محتوى</a></li>
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
    <section class="dashboard-container" aria-labelledby="dashboard-title">

        <h1 class="dashboard-title" id="dashboard-title">إدارة المحتوى</h1>

        <?php if (isset($_GET['msg'])) { ?>
            <aside class="success-message" role="status" aria-live="polite">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </aside>
        <?php } ?>


        <table aria-label="جدول المحتوى">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">اسم المكان</th>
                    <th scope="col">المنطقة</th>
                    <th scope="col">الوصف</th>
                    <th scope="col">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['region']; ?></td>
                    <td><?php echo mb_substr($row['description'], 0, 60, 'UTF-8') . '...'; ?></td>
                    <td>
                        <a class="edit-btn" href="update_content.php?id=<?php echo $row['id']; ?>">تعديل</a>
                        <a class="delete-btn" href="delete.php?id=<?php echo $row['id']; ?>" onclick="confirmDelete(event, this.href)">حذف</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </section>
</main>

<footer class="site-footer">
    <p>اكتشف السعودية</p>
</footer>

<dialog id="deleteModal" class="modal" aria-labelledby="modal-title" aria-modal="true">
    <div class="modal-content">
        <h3 id="modal-title">تأكيد الحذف</h3>
        <p>هل أنت متأكد من حذف هذا المحتوى؟</p>
        <div class="modal-buttons">
            <button id="confirmBtn">نعم، حذف</button>
            <button onclick="document.getElementById('deleteModal').style.display='none'">إلغاء</button>
        </div>
    </div>
</dialog>

<script src="../public/js/confirm.js"></script>
<script src="../public/js/home.js"></script>
</body>
</html>