<?php

session_start();
require_once '../includes/db_config.php';

if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = MD5(trim($_POST['password']));
    $username = mysqli_real_escape_string($conn, $username);

    $sql = "SELECT * FROM admin 
            WHERE username = '$username' 
            AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin'] = $admin['username'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "اسم المستخدم أو كلمة المرور غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول المشرف – اكتشف السعودية</title>
    <meta name="description" content="صفحة تسجيل دخول المشرف لموقع اكتشف السعودية">
    <link rel="stylesheet" href="../public/css/shared.css">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>

<header class="site-header" id="site-header" role="banner">
    <nav class="navbar" aria-label="التنقل الرئيسي">
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
            <li><a href="../public/index.html" class="nav-link">الرئيسية</a></li>
            <li><a href="../public/gallery.php" class="nav-link">معرض المناطق</a></li>
            <li><a href="login.php" class="nav-link active">دخول المشرف</a></li>
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
    <section class="login-wrapper" aria-labelledby="login-title">
        <article class="login-box">

            <header class="login-header">
                <h1 id="login-title">تسجيل دخول المشرف</h1>
                <p class="login-subtitle">أدخل بياناتك للوصول إلى لوحة التحكم</p>
            </header>

            <?php if (!empty($error)): ?>
                <aside
                    class="error-message"
                    role="alert"
                    aria-live="assertive">
                    <span aria-hidden="true">⚠️</span>
                    <?php echo htmlspecialchars($error); ?>
                </aside>
            <?php endif; ?>

            <form
                action="login.php"
                method="POST"
                id="loginForm"
                novalidate
                aria-label="نموذج تسجيل الدخول">

                <fieldset>
                    <legend class="sr-only">بيانات تسجيل الدخول</legend>

                    <div class="form-group">
                        <label for="username">
                            اسم المستخدم
                            <abbr title="مطلوب">*</abbr>
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="مثال: admin"
                            required
                            autocomplete="username"
                            aria-required="true"
                            aria-describedby="usernameError"
                            spellcheck="false">
                        <span class="field-error" id="usernameError" role="alert" aria-live="polite"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            كلمة المرور
                            <abbr title="مطلوب">*</abbr>
                        </label>
                        <div class="password-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                                aria-required="true"
                                aria-describedby="passwordError"
                                minlength="4">
                            <button
                                type="button"
                                class="toggle-password"
                                id="toggleBtn"
                                aria-label="إظهار كلمة المرور"
                                aria-pressed="false"
                                onclick="togglePassword()">
                                <span aria-hidden="true">👁️</span>
                            </button>
                        </div>
                        <span class="field-error" id="passwordError" role="alert" aria-live="polite"></span>
                    </div>

                </fieldset>

                <button type="submit" class="login-btn" id="loginBtn">
                    دخول
                </button>

            </form>
        </article>
    </section>
</main>

<footer class="site-footer" role="contentinfo">
    <p>اكتشف السعودية</p>
</footer>

<script src="js/login.js"></script>
<script src="../public/js/home.js"></script>
</body>
</html>