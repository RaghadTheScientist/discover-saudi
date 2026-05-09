document.addEventListener('DOMContentLoaded', function () {

    var nightModeBtn = document.getElementById('nightModeBtn');
    var modeIcon = document.querySelector('.mode-icon');
    var modeText = document.querySelector('.mode-text');

    if (nightModeBtn) {
        nightModeBtn.addEventListener('click', function () {
            document.documentElement.classList.toggle('night-mode');

            if (document.documentElement.classList.contains('night-mode')) {
                if (modeIcon) modeIcon.textContent = '\u2600\uFE0F';
                if (modeText) modeText.textContent = '\u0627\u0644\u0648\u0636\u0639 \u0627\u0644\u0646\u0647\u0627\u0631\u064A';
                nightModeBtn.setAttribute('aria-pressed', 'true');
                } else {
                if (modeIcon) modeIcon.textContent = '\uD83C\uDF19';
                if (modeText) modeText.textContent = '\u0627\u0644\u0648\u0636\u0639 \u0627\u0644\u0644\u064A\u0644\u064A';
                nightModeBtn.setAttribute('aria-pressed', 'false');
            }
        });
    }

    var hamburgerBtn = document.getElementById('hamburgerBtn');
    var navMenu = document.getElementById('navMenu');

    if (hamburgerBtn && navMenu) {
        hamburgerBtn.addEventListener('click', function () {
            var isOpen = navMenu.classList.toggle('open');
            hamburgerBtn.setAttribute('aria-expanded', isOpen);
        });

        document.addEventListener('click', function (e) {
            if (!hamburgerBtn.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('open');
                hamburgerBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    var statNumbers = document.querySelectorAll('.stat-number');
    if (statNumbers.length > 0) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateNumber(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        statNumbers.forEach(function (el) { observer.observe(el); });
    }

    function animateNumber(el) {
        var raw = el.textContent.replace(/\D/g, '');
        var target = parseInt(raw);
        var prefix = el.textContent.includes('+') ? '+' : '';
        if (isNaN(target)) return;
        var current = 0;
        var step = Math.ceil(target / (1200 / 16));
        var timer = setInterval(function () {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = prefix + current;
        }, 16);
    }

    var featureCards = document.querySelectorAll('.feature-card');
    if (featureCards.length > 0) {
        var cardObserver = new IntersectionObserver(function (entries) {
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
    }

    var header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', function () {
            header.classList.toggle('scrolled', window.scrollY > 10);
        });
    }

});