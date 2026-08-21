/**
 * SRK University - Interactive UI Engine & Scroll Animations
 * Handcrafted Production Suite
 */
document.addEventListener('DOMContentLoaded', () => {

    // 1. Scroll-Triggered Reveal Animations (Intersection Observer)
    const revealElements = document.querySelectorAll('.reveal-on-scroll, .reveal-up, .reveal-left, .reveal-right, .prog-card, .faculty-card, .stat-box');
    
    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Staggered reveal delay
                    setTimeout(() => {
                        entry.target.classList.add('is-revealed');
                    }, (index % 4) * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => {
            el.classList.add('reveal-init');
            revealObserver.observe(el);
        });
    } else {
        // Fallback for older browsers
        revealElements.forEach(el => el.classList.add('is-revealed'));
    }

    // 2. Dynamic Animated Stats Counter
    const statCounters = document.querySelectorAll('.stat-val, .stat-number');
    let countersDone = false;

    const animateCounters = () => {
        statCounters.forEach(counter => {
            const text = counter.innerText.trim();
            const numMatch = text.match(/\d+/g);
            if (!numMatch) return;

            const targetNum = parseInt(numMatch.join(''), 10);
            const prefix = text.split(/\d+/)[0] || '';
            const suffix = text.split(/\d+/).pop() || '';
            const duration = 1800;
            const startTime = performance.now();

            const updateCount = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                // EaseOutQuad smoothing
                const easeProgress = 1 - (1 - progress) * (1 - progress);
                const currentVal = Math.floor(easeProgress * targetNum);

                counter.innerText = `${prefix}${currentVal.toLocaleString()}${suffix}`;

                if (progress < 1) {
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = text;
                }
            };

            requestAnimationFrame(updateCount);
        });
    };

    const statsStrip = document.querySelector('.stats-strip');
    if (statsStrip && 'IntersectionObserver' in window) {
        const statsObserver = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && !countersDone) {
                countersDone = true;
                animateCounters();
            }
        }, { threshold: 0.2 });
        statsObserver.observe(statsStrip);
    } else if (statCounters.length) {
        animateCounters();
    }

    // 3. Back To Top Button & Scroll Progress
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        }, { passive: true });

        backToTopBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // 4. Interactive Notice Board Tabs (if present)
    const noticeTabs = document.querySelectorAll('.notice-tab-btn');
    const noticeItems = document.querySelectorAll('.notice-item');
    if (noticeTabs.length && noticeItems.length) {
        noticeTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                noticeTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const cat = this.getAttribute('data-cat');
                noticeItems.forEach(item => {
                    if (cat === 'all' || item.getAttribute('data-cat') === cat) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // 5. Dynamic Lazy Loading Engine for Images and Iframes
    const lazyMedia = document.querySelectorAll('img:not([loading="lazy"]), img[data-src], iframe:not([loading="lazy"])');
    if ('IntersectionObserver' in window) {
        const mediaObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    if (el.dataset.src) {
                        el.src = el.dataset.src;
                        el.removeAttribute('data-src');
                    }
                    if (el.tagName === 'IMG') {
                        el.setAttribute('loading', 'lazy');
                        el.setAttribute('decoding', 'async');
                        el.classList.add('is-loaded');
                    }
                    observer.unobserve(el);
                }
            });
        }, {
            rootMargin: '250px 0px'
        });

        lazyMedia.forEach(media => mediaObserver.observe(media));
    }

});
