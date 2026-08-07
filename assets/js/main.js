// SRKU Application JavaScript
document.addEventListener('DOMContentLoaded', () => {
    // Dynamic Stats Counter Animation
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target') || 100;
        const duration = 2000;
        const step = Math.ceil(target / (duration / 30));
        let count = 0;

        const updateCounter = () => {
            count += step;
            if (count < target) {
                counter.innerText = count + (counter.dataset.suffix || '');
                setTimeout(updateCounter, 30);
            } else {
                counter.innerText = target + (counter.dataset.suffix || '');
            }
        };

        if (counter) {
            updateCounter();
        }
    });

    // Mobile Menu Toggle (if initialized)
    const mobileMenuBtn = document.querySelector('#mobile-menu-btn');
    const navMenu = document.querySelector('.nav-menu');
    if (mobileMenuBtn && navMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    }
});
