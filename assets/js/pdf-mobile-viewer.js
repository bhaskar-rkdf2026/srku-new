/**
 * SRKU Responsive PDF Viewer Engine
 * Automatically upgrades PDF iframes on mobile devices (iOS/Android/tablets)
 * using Mozilla PDF.js to render crisp, native HTML5 canvas pages.
 */
(function() {
    function isMobileOrTouch() {
        var isMobileWidth = window.innerWidth <= 991;
        var isMobileUA = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        var isTouch = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
        return isMobileWidth || isMobileUA || (isTouch && isMobileWidth);
    }

    function initPdfViewer(container, pdfUrl, title) {
        if (!pdfUrl) return;

        // Prevent duplicate initializations
        if (container.dataset.pdfLoaded === 'true') return;
        container.dataset.pdfLoaded = 'true';

        container.classList.add('srku-pdf-viewer-active');
        container.style.height = 'auto';
        container.style.minHeight = '480px';
        container.innerHTML = '';

        // Create UI
        var wrapper = document.createElement('div');
        wrapper.className = 'srku-pdf-container';
        wrapper.innerHTML = 
            '<div class="srku-pdf-toolbar">' +
                '<div class="srku-pdf-nav">' +
                    '<button type="button" class="srku-pdf-btn pdf-prev" title="Previous Page" disabled><i class="fas fa-chevron-left"></i></button>' +
                    '<span class="srku-pdf-page-info">Page <span class="pdf-curr-page">1</span> / <span class="pdf-total-pages">-</span></span>' +
                    '<button type="button" class="srku-pdf-btn pdf-next" title="Next Page"><i class="fas fa-chevron-right"></i></button>' +
                '</div>' +
                '<div class="srku-pdf-actions">' +
                    '<button type="button" class="srku-pdf-btn pdf-zoom-out" title="Zoom Out"><i class="fas fa-search-minus"></i></button>' +
                    '<span class="srku-pdf-zoom-val">100%</span>' +
                    '<button type="button" class="srku-pdf-btn pdf-zoom-in" title="Zoom In"><i class="fas fa-search-plus"></i></button>' +
                    '<a href="' + pdfUrl + '" target="_blank" class="srku-pdf-btn pdf-external" title="Open in New Tab"><i class="fas fa-external-link-alt"></i></a>' +
                '</div>' +
            '</div>' +
            '<div class="srku-pdf-canvas-wrap">' +
                '<div class="srku-pdf-loader">' +
                    '<div class="spinner-border text-danger" role="status"></div>' +
                    '<div class="mt-2 text-muted small fw-semibold">Loading Official PDF Document...</div>' +
                '</div>' +
                '<canvas class="srku-pdf-canvas"></canvas>' +
            '</div>';

        container.appendChild(wrapper);

        var pdfDoc = null;
        var pageNum = 1;
        var pageRendering = false;
        var pageNumPending = null;
        var scale = 1.0;
        var canvas = wrapper.querySelector('.srku-pdf-canvas');
        var ctx = canvas.getContext('2d');
        var loader = wrapper.querySelector('.srku-pdf-loader');
        var btnPrev = wrapper.querySelector('.pdf-prev');
        var btnNext = wrapper.querySelector('.pdf-next');
        var currPageSpan = wrapper.querySelector('.pdf-curr-page');
        var totalPagesSpan = wrapper.querySelector('.pdf-total-pages');
        var zoomValSpan = wrapper.querySelector('.srku-pdf-zoom-val');
        var btnZoomIn = wrapper.querySelector('.pdf-zoom-in');
        var btnZoomOut = wrapper.querySelector('.pdf-zoom-out');

        function renderPage(num) {
            pageRendering = true;
            loader.style.display = 'flex';

            pdfDoc.getPage(num).then(function(page) {
                var canvasWrap = wrapper.querySelector('.srku-pdf-canvas-wrap');
                var containerWidth = canvasWrap.clientWidth || 340;
                var availableWidth = Math.max(260, containerWidth - 24);
                var unscaledViewport = page.getViewport({ scale: 1.0 });
                var targetScale = (availableWidth / unscaledViewport.width) * scale;
                var viewport = page.getViewport({ scale: targetScale });

                var dpr = window.devicePixelRatio || 1;
                canvas.height = viewport.height * dpr;
                canvas.width = viewport.width * dpr;
                canvas.style.height = viewport.height + 'px';
                canvas.style.width = viewport.width + 'px';

                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                renderTask.promise.then(function() {
                    pageRendering = false;
                    loader.style.display = 'none';
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            currPageSpan.textContent = num;
            btnPrev.disabled = (num <= 1);
            btnNext.disabled = (num >= pdfDoc.numPages);
            zoomValSpan.textContent = Math.round(scale * 100) + '%';
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        btnPrev.addEventListener('click', function(e) {
            e.preventDefault();
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        });

        btnNext.addEventListener('click', function(e) {
            e.preventDefault();
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        });

        btnZoomIn.addEventListener('click', function(e) {
            e.preventDefault();
            if (scale >= 2.5) return;
            scale = Math.min(2.5, scale + 0.25);
            queueRenderPage(pageNum);
        });

        btnZoomOut.addEventListener('click', function(e) {
            e.preventDefault();
            if (scale <= 0.6) return;
            scale = Math.max(0.6, scale - 0.25);
            queueRenderPage(pageNum);
        });

        // Swipe Gestures for Mobile
        var touchStartX = 0;
        var touchEndX = 0;
        canvas.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        canvas.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            var diff = touchEndX - touchStartX;
            if (Math.abs(diff) > 55) {
                if (diff < 0 && pdfDoc && pageNum < pdfDoc.numPages) {
                    pageNum++;
                    queueRenderPage(pageNum);
                } else if (diff > 0 && pageNum > 1) {
                    pageNum--;
                    queueRenderPage(pageNum);
                }
            }
        }, { passive: true });

        // Ensure PDF.js worker is properly configured
        var baseUrl = window.SRKU_BASE_URL || '/srku-new/';
        pdfjsLib.GlobalWorkerOptions.workerSrc = baseUrl + 'assets/js/pdf.worker.min.js';

        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
            pdfDoc = pdf;
            totalPagesSpan.textContent = pdf.numPages;
            renderPage(pageNum);
        }).catch(function(error) {
            console.error('PDF.js Error:', error);
            loader.innerHTML = 
                '<div class="p-4 text-center">' +
                    '<i class="fas fa-file-pdf text-danger fa-3x mb-3"></i>' +
                    '<div class="text-navy fw-bold mb-2">' + (title || 'PDF Document') + '</div>' +
                    '<p class="text-muted small mb-3">Tap below to view or download the complete official document on your device.</p>' +
                    '<a href="' + pdfUrl + '" target="_blank" class="btn btn-danger btn-sm rounded-pill px-4 py-2 shadow-sm">' +
                        '<i class="fas fa-download me-1"></i> Open & Download PDF' +
                    '</a>' +
                '</div>';
        });
    }

    function scanAndUpgradePdfIframes() {
        if (!isMobileOrTouch()) return;

        var iframes = document.querySelectorAll('iframe');
        iframes.forEach(function(iframe) {
            var src = iframe.getAttribute('src') || '';
            var cleanSrc = src.split('#')[0].split('?')[0];
            if (cleanSrc.toLowerCase().endsWith('.pdf')) {
                var parent = iframe.parentElement;
                if (!parent) return;

                var title = iframe.getAttribute('title') || 'PDF Document';
                var pdfUrl = src.split('#')[0];

                initPdfViewer(parent, pdfUrl, title);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', scanAndUpgradePdfIframes);
    } else {
        scanAndUpgradePdfIframes();
    }

    // Also support resize to mobile view in DevTools
    var resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (isMobileOrTouch()) {
                scanAndUpgradePdfIframes();
            }
        }, 300);
    });
})();
