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

    // ═══════════════════════════════════════════════════════════════
    // 6. GLOBAL REAL-TIME FORM VALIDATION & KEYSTROKE SANITIZATION
    // ═══════════════════════════════════════════════════════════════
    const isNameField = (el) => {
        if (!el || el.tagName !== 'INPUT') return false;
        const n = (el.name || '').toLowerCase();
        const id = (el.id || '').toLowerCase();
        // Exclude system fields
        if (n.includes('user') || n.includes('course') || n.includes('dept') || n.includes('college') || n.includes('file') || n.includes('cat') || n.includes('reg') || n.includes('pass') || n.includes('search')) return false;
        return n === 'name' || n === 'father_name' || n === 'candidate_name' || n === 'student_name' || n === 'full_name' ||
               id === 'homeenquiryname' || id === 'homeenquiryfathername' || id === 'admissionname' || id === 'admissionfathername';
    };

    const isPhoneField = (el) => {
        if (!el || el.tagName !== 'INPUT') return false;
        const t = (el.type || '').toLowerCase();
        const n = (el.name || '').toLowerCase();
        const id = (el.id || '').toLowerCase();
        return t === 'tel' || n === 'phone' || n === 'mobile' || n === 'contact' || n.includes('phone') || n.includes('mobile') || id.includes('phone') || id.includes('mobile');
    };

    const isCityStateField = (el) => {
        if (!el || el.tagName !== 'INPUT') return false;
        const n = (el.name || '').toLowerCase();
        return n === 'city' || n === 'state';
    };

    const isEmailField = (el) => {
        if (!el || el.tagName !== 'INPUT') return false;
        const t = (el.type || '').toLowerCase();
        const n = (el.name || '').toLowerCase();
        return t === 'email' || n === 'email';
    };

    // Helper: Find appropriate outside anchor element so feedback is never inside flex wrappers
    const getFeedbackAnchor = (input) => {
        const wrap = input.closest('.srku-input-wrap, .input-group');
        return wrap || input;
    };

    // Helper: Show/Clear Inline Tooltip Feedback
    const setValidationFeedback = (input, isValid, message) => {
        if (!input) return;

        input.classList.toggle('is-invalid', !isValid);
        input.classList.toggle('is-valid', isValid);

        const anchor = getFeedbackAnchor(input);
        const parent = anchor.parentElement;
        if (!parent) return;

        // If anchor is a wrapper (.srku-input-wrap or .input-group), update wrapper class
        if (anchor !== input) {
            anchor.classList.toggle('has-invalid', !isValid);
            anchor.classList.toggle('has-valid', isValid);
            // Clean up any accidentally nested feedback inside the flex wrapper
            const nested = anchor.querySelectorAll('.srku-val-feedback');
            nested.forEach(n => n.remove());
        }

        // Find existing feedback element placed immediately after anchor
        let feedback = anchor.nextElementSibling;
        if (!feedback || !feedback.classList.contains('srku-val-feedback')) {
            // Check within parent container
            feedback = parent.querySelector(':scope > .srku-val-feedback');
        }

        if (!isValid && message) {
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'srku-val-feedback';
                anchor.insertAdjacentElement('afterend', feedback);
            }
            feedback.innerHTML = '<i class="fas fa-circle-exclamation"></i><span>' + message + '</span>';
            feedback.style.display = 'flex';
        } else if (feedback) {
            feedback.style.display = 'none';
            feedback.innerHTML = '';
        }
    };

    // Helper: Show brief feedback on blocked keystrokes and auto-clear if value is valid
    const showKeystrokeBlockFeedback = (input, message) => {
        setValidationFeedback(input, false, message);
        if (input._srkuErrTimer) clearTimeout(input._srkuErrTimer);
        input._srkuErrTimer = setTimeout(() => {
            const val = input.value.trim();
            if (isNameField(input)) {
                if (val.length === 0 || (val.length >= 2 && /^[a-zA-Z\s\.\'-]+$/.test(val))) {
                    setValidationFeedback(input, true, '');
                }
            } else if (isPhoneField(input)) {
                if (val.length === 0 || (val.length === 10 && /^[6-9]\d{9}$/.test(val))) {
                    setValidationFeedback(input, true, '');
                }
            } else if (isCityStateField(input)) {
                if (val.length === 0 || /^[a-zA-Z\s\.\'-]+$/.test(val)) {
                    setValidationFeedback(input, true, '');
                }
            }
        }, 2500);
    };

    // 6.1 Real-Time Keystroke Blocker (keydown)
    document.addEventListener('keydown', (e) => {
        const el = e.target;
        // Ignore control keys (Tab, Backspace, Delete, Arrows, Ctrl combinations)
        if (e.key === 'Backspace' || e.key === 'Delete' || e.key === 'Tab' || e.key === 'Enter' ||
            e.key === 'ArrowLeft' || e.key === 'ArrowRight' || e.key === 'ArrowUp' || e.key === 'ArrowDown' ||
            e.ctrlKey || e.metaKey || e.altKey) {
            return;
        }

        // A. Block numbers in Name fields
        if (isNameField(el)) {
            if (/[0-9]/.test(e.key) || /[!@#$%^&*()_=+\[\]{};:"\\|<>,\/?]/.test(e.key)) {
                e.preventDefault();
                showKeystrokeBlockFeedback(el, 'Numbers and symbols are not allowed in name.');
                return;
            }
        }

        // B. Block non-digits in Phone fields & cap strictly at 10 digits
        if (isPhoneField(el)) {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
                showKeystrokeBlockFeedback(el, 'Only digits (0-9) are allowed in mobile number.');
                return;
            }
            const selStart = el.selectionStart || 0;
            const selEnd = el.selectionEnd || 0;
            const isReplacing = (selEnd - selStart) > 0;
            if (el.value.length >= 10 && !isReplacing) {
                e.preventDefault();
                showKeystrokeBlockFeedback(el, 'Mobile number cannot exceed 10 digits.');
                return;
            }
        }

        // C. Block numbers in City & State fields
        if (isCityStateField(el)) {
            if (/[0-9]/.test(e.key)) {
                e.preventDefault();
                showKeystrokeBlockFeedback(el, 'Numbers are not allowed in city or state.');
                return;
            }
        }
    });

    // 6.2 Real-Time Input Sanitizer (input event handles typing, pasting, autofill)
    document.addEventListener('input', (e) => {
        const el = e.target;

        // A. Name Sanitization: Strip any digits or illegal symbols immediately
        if (isNameField(el)) {
            const clean = el.value.replace(/[^a-zA-Z\s\.\'-]/g, '');
            if (el.value !== clean) {
                el.value = clean;
            }
            if (el.value.length >= 2) {
                setValidationFeedback(el, true, '');
            }
        }

        // B. Phone Sanitization: Strictly numeric, max 10 digits
        if (isPhoneField(el)) {
            let clean = el.value.replace(/\D/g, '');
            if (clean.length > 10) {
                // If user pasted with 91 country code (12 digits) or leading 0
                if (clean.length === 12 && clean.startsWith('91')) {
                    clean = clean.substring(2);
                } else if (clean.length === 11 && clean.startsWith('0')) {
                    clean = clean.substring(1);
                } else {
                    clean = clean.slice(0, 10);
                }
            }
            if (el.value !== clean) {
                el.value = clean;
            }

            if (clean.length === 10) {
                if (/^[6-9]/.test(clean)) {
                    setValidationFeedback(el, true, '');
                } else {
                    setValidationFeedback(el, false, 'Mobile number should start with 6, 7, 8 or 9.');
                }
            } else if (clean.length > 0) {
                setValidationFeedback(el, false, `Enter 10 digits (${clean.length}/10 entered)`);
            }
        }

        // C. City / State Sanitization: Strip numbers
        if (isCityStateField(el)) {
            const clean = el.value.replace(/[^a-zA-Z\s\.\'-]/g, '');
            if (el.value !== clean) {
                el.value = clean;
            }
        }
    });

    // 6.3 Blur / Change Event Verification
    document.addEventListener('focusout', (e) => {
        const el = e.target;

        if (isNameField(el) && el.value.trim().length > 0) {
            if (el.value.trim().length < 2) {
                setValidationFeedback(el, false, 'Name must have at least 2 characters.');
            } else {
                setValidationFeedback(el, true, '');
            }
        }

        if (isPhoneField(el) && el.value.length > 0) {
            if (el.value.length !== 10) {
                setValidationFeedback(el, false, 'Please enter a valid 10-digit mobile number.');
            } else if (!/^[6-9]\d{9}$/.test(el.value)) {
                setValidationFeedback(el, false, 'Mobile number must start with 6, 7, 8 or 9.');
            } else {
                setValidationFeedback(el, true, '');
            }
        }

        if (isEmailField(el) && el.value.trim().length > 0) {
            const emailPattern = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(el.value.trim())) {
                setValidationFeedback(el, false, 'Please enter a valid email address (e.g. name@domain.com).');
            } else {
                setValidationFeedback(el, true, '');
            }
        }
    });

    // 6.4 Form Submit Guard (Blocks invalid submission on all forms)
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!form || form.id === 'searchForm') return;

        let hasError = false;
        let firstInvalidField = null;

        // Check Name inputs
        const nameInputs = form.querySelectorAll('input[name="name"], input[name="father_name"], input[name="candidate_name"], #admissionName, #homeEnquiryName');
        nameInputs.forEach((inp) => {
            if (inp.required || inp.value.trim().length > 0) {
                const val = inp.value.trim();
                if (val.length < 2 || !/^[a-zA-Z\s\.\'-]+$/.test(val)) {
                    hasError = true;
                    setValidationFeedback(inp, false, 'Please enter a valid name (alphabets only, no numbers).');
                    if (!firstInvalidField) firstInvalidField = inp;
                }
            }
        });

        // Check Phone inputs
        const phoneInputs = form.querySelectorAll('input[type="tel"], input[name="phone"], input[name="mobile"], #admissionPhone, #homeEnquiryPhone');
        phoneInputs.forEach((inp) => {
            if (inp.required || inp.value.trim().length > 0) {
                const val = inp.value.trim();
                if (val.length !== 10 || !/^[6-9]\d{9}$/.test(val)) {
                    hasError = true;
                    setValidationFeedback(inp, false, 'Please enter a valid 10-digit mobile number (starts with 6-9).');
                    if (!firstInvalidField) firstInvalidField = inp;
                }
            }
        });

        // Check Email inputs
        const emailInputs = form.querySelectorAll('input[type="email"], input[name="email"], #admissionEmail, #homeEnquiryEmail');
        emailInputs.forEach((inp) => {
            if (inp.required || inp.value.trim().length > 0) {
                const val = inp.value.trim();
                const emailPattern = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(val)) {
                    hasError = true;
                    setValidationFeedback(inp, false, 'Please enter a valid email address (e.g. name@domain.com).');
                    if (!firstInvalidField) firstInvalidField = inp;
                }
            }
        });

        if (hasError) {
            e.preventDefault();
            e.stopPropagation();
            if (firstInvalidField) {
                firstInvalidField.focus();
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        }
    }, true);

});

