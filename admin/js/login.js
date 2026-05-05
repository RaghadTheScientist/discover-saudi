function togglePassword() {
    const passwordInput = document.getElementById('password');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    let valid = true;

    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');


    usernameError.textContent = '';
    passwordError.textContent = '';

    if (username === '') {
        usernameError.textContent = 'يرجى إدخال اسم المستخدم';
        valid = false;
    }

    if (password === '') {
        passwordError.textContent = 'يرجى إدخال كلمة المرور';
        valid = false;
    } else if (password.length < 8) {
        passwordError.textContent = 'كلمة المرور قصيرة جداً';
        valid = false;
    }


    if (!valid) {
        e.preventDefault();
    } else {

        const btn = document.getElementById('loginBtn');
        btn.textContent = 'جارٍ التحقق...';
        btn.disabled = true;
    }
});