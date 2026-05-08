<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_config.php';

$sql = "SELECT * FROM regions";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>

    <link rel="stylesheet" href="../public/css/shared.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>

<header class="site-header">
    <nav class="navbar">
        <a href="index.php" class="nav-brand">اكتشف السعودية</a>

        <ul class="nav-menu">
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
    <div class="dashboard-container">

        <h1 class="dashboard-title">إدارة المحتوى</h1>

        <?php if(isset($_GET['msg'])) { ?>
            <div class="success-message">
                <?php echo $_GET['msg']; ?>
            </div>
        <?php } ?>

        <table>
    <tr>
        <th>#</th>
        <th>المنطقة</th>
        <th>التصنيف</th>
        <th>الوصف</th>
        <th>الإجراءات</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['direction']; ?></td>
        <td><?php echo $row['description']; ?></td>

        <td>
            <a class="edit-btn" href="update_content.php?id=<?php echo $row['id']; ?>">
                تعديل
            </a>

            <a
               class="delete-btn"
              href="delete.php?id=<?php echo $row['id']; ?>"
              onclick="confirmDelete(event, this.href)"
            >
                حذف
            </a>
        </td>
    </tr>

    <?php } ?>

</table>

    </div>
</main>

<footer class="site-footer">
    <p>© اكتشف السعودية — جامعة الملك سعود</p>
</footer>

<script src="../public/js/confirm.js"></script>
<div id="deleteModal" class="modal">

    <div class="modal-content">

        <h3>تأكيد الحذف</h3>

        <p>
            هل أنت متأكد من حذف هذا المحتوى؟
        </p>

        <div class="modal-buttons">

            <button id="confirmBtn">
                نعم، حذف
            </button>

            <button onclick="document.getElementById('deleteModal').style.display='none'">
                إلغاء
            </button>

        </div>

    </div>

</div>

<script src="../public/js/home.js"></script>

</body>
</html>