document.addEventListener('DOMContentLoaded', function () {

    // 1. Night Mode Toggle 
    const nightModeBtn = document.getElementById('nightModeBtn');
    const body = document.body;
    const modeIcon = document.querySelector('.mode-icon');
    const modeText = document.querySelector('.mode-text');

    nightModeBtn.addEventListener('click', function () {
        if (body.classList.contains('night-mode')) {
            disableNightMode();
        } else {
            enableNightMode();
        }
    });

    function enableNightMode() {
        body.classList.add('night-mode');
        modeIcon.textContent = '☀️';
        modeText.textContent = 'الوضع النهاري';
        nightModeBtn.setAttribute('aria-pressed', 'true');
        nightModeBtn.setAttribute('aria-label', 'تفعيل الوضع النهاري');
        localStorage.setItem('nightMode', 'enabled');
    }

    function disableNightMode() {
        body.classList.remove('night-mode');
        modeIcon.textContent = '🌙';
        modeText.textContent = 'الوضع الليلي';
        nightModeBtn.setAttribute('aria-pressed', 'false');
        nightModeBtn.setAttribute('aria-label', 'تفعيل الوضع الليلي');
        localStorage.setItem('nightMode', 'disabled');
    }


    // 2. Mobile Hamburger Menu
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const navMenu = document.getElementById('navMenu');

    hamburgerBtn.addEventListener('click', function () {
        const isOpen = navMenu.classList.toggle('open');
        hamburgerBtn.setAttribute('aria-expanded', isOpen);
        hamburgerBtn.setAttribute('aria-label', isOpen ? 'إغلاق القائمة' : 'فتح القائمة');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (e) {
        if (!hamburgerBtn.contains(e.target) && !navMenu.contains(e.target)) {
            navMenu.classList.remove('open');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
        }
    });


    //3. Animate stat numbers on scroll 
    const statNumbers = document.querySelectorAll('.stat-number');

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                animateNumber(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    statNumbers.forEach(function (el) {
        observer.observe(el);
    });

    function animateNumber(el) {
        const raw = el.textContent.replace(/\D/g, '');
        const target = parseInt(raw);
        const prefix = el.textContent.includes('+') ? '+' : '';

        if (isNaN(target)) return;

        let current = 0;
        const duration = 1200;
        const step = Math.ceil(target / (duration / 16));

        const timer = setInterval(function () {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = prefix + current;
        }, 16);
    }


    //  Scroll animation for feature cards 
    const featureCards = document.querySelectorAll('.feature-card');

    const cardObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                cardObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    featureCards.forEach(function (card) {
        card.classList.add('hidden');
        cardObserver.observe(card);
    });


    // 5. Sticky header shadow on scroll 
    const header = document.getElementById('site-header');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 10) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

});