/**
 * Sarvepalli Radhakrishnan University (SRKU)
 * Constituent Units Draggable Infinite Marquee Engine
 * Supports:
 * - Continuous dual-direction infinite marquee (Row 1 Left, Row 2 Right)
 * - Mouse drag on desktop (grab & slide with inertia)
 * - Touch swipe on mobile & tablet (smooth 1:1 finger tracking)
 * - Preserves native vertical page scrolling on mobile (directional locking)
 * - Inertia momentum fling on release
 * - Click vs Drag disambiguation (prevents accidental card link opening while dragging)
 * - Pause on desktop hover
 * - IntersectionObserver to save battery/CPU when off-screen
 */
(function() {
    'use strict';

    function initMarquee() {
        const rows = document.querySelectorAll('.dept-marquee-row');
        if (!rows.length) return;

        rows.forEach(function(row) {
            const track = row.querySelector('.dept-marquee-track');
            if (!track) return;

            // Mark row as interactive (disables fallback CSS animation)
            row.classList.add('js-interactive');

            const isLeft = row.classList.contains('dept-marquee-row--left');
            const isMobile = window.innerWidth <= 768;
            // Row 1 moves left (-0.8px/frame), Row 2 moves right (+0.8px/frame)
            const baseSpeed = isLeft ? (isMobile ? -0.65 : -0.85) : (isMobile ? 0.65 : 0.85);

            let halfWidth = track.scrollWidth / 2;
            let currentX = isLeft ? 0 : -halfWidth;
            let targetSpeed = baseSpeed;
            let velocity = 0;
            let isPointerDown = false;
            let isDragging = false;
            let hasMoved = false;
            let directionLocked = false;
            let isHorizontalDrag = false;
            let isHovered = false;

            let startX = 0;
            let startY = 0;
            let dragStartX = 0;
            let lastX = 0;
            let lastMoveTime = 0;
            let isVisible = true;
            let animationFrameId = null;

            // Measure accurate halfWidth (recalculated on resize & image loads)
            function updateMeasurements() {
                const totalW = track.scrollWidth;
                if (totalW > 0) {
                    halfWidth = totalW / 2;
                }
            }
            updateMeasurements();
            window.addEventListener('resize', updateMeasurements, { passive: true });
            window.addEventListener('load', updateMeasurements);

            // Wrap position seamlessly within [-halfWidth, 0]
            function wrapPosition(pos) {
                if (halfWidth <= 0) return pos;
                while (pos <= -halfWidth) pos += halfWidth;
                while (pos > 0) pos -= halfWidth;
                return pos;
            }

            // Set initial position
            track.style.transform = 'translate3d(' + currentX.toFixed(2) + 'px, 0, 0)';

            // Animation Loop using requestAnimationFrame with delta time
            let lastTimestamp = performance.now();

            function tick(now) {
                if (!isVisible) {
                    lastTimestamp = now;
                    animationFrameId = requestAnimationFrame(tick);
                    return;
                }

                const elapsed = now - lastTimestamp;
                lastTimestamp = now;
                const dt = Math.min(Math.max(elapsed / 16.666, 0.5), 3); // normalized delta

                if (!isDragging) {
                    if (Math.abs(velocity) > 0.08) {
                        currentX += velocity * dt;
                        velocity *= Math.pow(0.92, dt); // smooth inertia friction
                    } else {
                        velocity = 0;
                        if (!isHovered) {
                            currentX += targetSpeed * dt;
                        }
                    }
                    currentX = wrapPosition(currentX);
                    track.style.transform = 'translate3d(' + currentX.toFixed(2) + 'px, 0, 0)';
                }

                animationFrameId = requestAnimationFrame(tick);
            }

            animationFrameId = requestAnimationFrame(tick);

            // Intersection Observer to pause when scrolled out of view
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        isVisible = entry.isIntersecting;
                    });
                }, { threshold: 0.05 });
                observer.observe(row);
            }

            // Unified Pointer Events (Mouse, Pen, Touch)
            function onPointerDown(e) {
                if (e.pointerType === 'mouse' && e.button !== 0) return;

                isPointerDown = true;
                isDragging = false;
                hasMoved = false;
                directionLocked = false;
                isHorizontalDrag = false;

                startX = e.clientX;
                startY = e.clientY;
                lastX = e.clientX;
                dragStartX = currentX;
                velocity = 0;
                lastMoveTime = performance.now();
            }

            function onPointerMove(e) {
                if (!isPointerDown) return;

                const dx = e.clientX - startX;
                const dy = e.clientY - startY;

                // Detect drag intention: horizontal vs vertical scroll
                if (!directionLocked) {
                    const absDx = Math.abs(dx);
                    const absDy = Math.abs(dy);

                    if (absDx > 6 || absDy > 6) {
                        directionLocked = true;
                        if (absDx >= absDy) {
                            // User intends to slide the cards horizontally
                            isHorizontalDrag = true;
                            isDragging = true;
                            hasMoved = true;
                            row.classList.add('is-dragging');
                            try {
                                row.setPointerCapture(e.pointerId);
                            } catch (err) {}
                        } else {
                            // User intends to scroll the page vertically
                            isHorizontalDrag = false;
                            isPointerDown = false;
                            return;
                        }
                    } else {
                        return;
                    }
                }

                if (!isHorizontalDrag) return;

                const now = performance.now();
                const dt = Math.max(now - lastMoveTime, 1);
                const stepDx = e.clientX - lastX;
                velocity = (stepDx / dt) * 16.666; // pixels per 60fps frame

                lastX = e.clientX;
                lastMoveTime = now;

                currentX = wrapPosition(dragStartX + dx);
                track.style.transform = 'translate3d(' + currentX.toFixed(2) + 'px, 0, 0)';
            }

            function onPointerUp(e) {
                if (!isPointerDown && !isDragging) return;

                const wasHorizontal = isHorizontalDrag;
                const wasMoved = hasMoved;

                isPointerDown = false;
                isDragging = false;
                directionLocked = false;
                isHorizontalDrag = false;
                row.classList.remove('is-dragging');

                try {
                    row.releasePointerCapture(e.pointerId);
                } catch (err) {}

                if (wasHorizontal) {
                    // Cap velocity for smooth glide
                    velocity = Math.max(-28, Math.min(28, velocity));

                    // If user dragged more than threshold, suppress accidental card link opening
                    if (wasMoved) {
                        const captureClick = function(ev) {
                            ev.preventDefault();
                            ev.stopPropagation();
                        };
                        row.addEventListener('click', captureClick, { capture: true, once: true });
                        setTimeout(function() {
                            row.removeEventListener('click', captureClick, { capture: true });
                        }, 350);
                    }
                }
            }

            function onPointerCancel(e) {
                isPointerDown = false;
                isDragging = false;
                directionLocked = false;
                isHorizontalDrag = false;
                row.classList.remove('is-dragging');
                try {
                    row.releasePointerCapture(e.pointerId);
                } catch (err) {}
            }

            row.addEventListener('pointerdown', onPointerDown);
            row.addEventListener('pointermove', onPointerMove);
            row.addEventListener('pointerup', onPointerUp);
            row.addEventListener('pointercancel', onPointerCancel);

            // Prevent browser default ghost dragging of images / links
            row.addEventListener('dragstart', function(e) {
                e.preventDefault();
            });

            // Pause auto-scroll on desktop mouse hover
            row.addEventListener('pointerenter', function(e) {
                if (e.pointerType === 'mouse') isHovered = true;
            });
            row.addEventListener('pointerleave', function(e) {
                if (e.pointerType === 'mouse') isHovered = false;
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMarquee);
    } else {
        initMarquee();
    }
})();
