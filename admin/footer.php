        </div>
    </main>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mobile Sidebar Drawer & CKEditor Global Initializer -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Mobile Drawer Toggle
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminSidebarOverlay');
    const toggleBtn = document.getElementById('adminSidebarToggle');
    const closeBtn = document.getElementById('adminSidebarClose');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('show');
        if (overlay) overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(syncAdminSidebarPosition, 60);
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('show');
        if (overlay) overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // Auto close sidebar on nav link tap on mobile
    if (window.innerWidth < 992 && sidebar) {
        sidebar.querySelectorAll('.sidebar-nav-link').forEach(link => {
            link.addEventListener('click', closeSidebar);
        });
    }

    // Sticky Auto-Scroll to Active Menu / Tab in Sidebar
    function syncAdminSidebarPosition() {
        if (!sidebar) return;

        // Prioritize active submenu tab (e.g. Ph.D Admissions) before parent nav link
        const activeItem = sidebar.querySelector('.sidebar-sub-link.active') || 
                           sidebar.querySelector('.sidebar-nav-link.active');

        if (activeItem) {
            const sidebarRect = sidebar.getBoundingClientRect();
            const activeRect = activeItem.getBoundingClientRect();
            
            // Target position: upper-middle (~35% of sidebar height) so section title and adjacent items are visible
            const currentScroll = sidebar.scrollTop;
            const targetScroll = currentScroll + (activeRect.top - sidebarRect.top) - (sidebar.clientHeight * 0.35);
            sidebar.scrollTop = Math.max(0, Math.round(targetScroll));
        } else {
            // Restore last manual scroll position if no specific item is active
            const savedScroll = sessionStorage.getItem('admin_sidebar_scroll_top');
            if (savedScroll !== null) {
                sidebar.scrollTop = parseInt(savedScroll, 10);
            }
        }
    }

    // Trigger on load and layout frames to ensure accurate scroll position
    syncAdminSidebarPosition();
    requestAnimationFrame(syncAdminSidebarPosition);
    setTimeout(syncAdminSidebarPosition, 80);
    setTimeout(syncAdminSidebarPosition, 250);

    // Preserve scroll position whenever user scrolls sidebar
    if (sidebar) {
        sidebar.addEventListener('scroll', () => {
            sessionStorage.setItem('admin_sidebar_scroll_top', sidebar.scrollTop);
        }, { passive: true });

        sidebar.querySelectorAll('.sidebar-nav-link, .sidebar-sub-link').forEach(link => {
            link.addEventListener('click', () => {
                sessionStorage.setItem('admin_sidebar_scroll_top', sidebar.scrollTop);
            });
        });
    }

    // CKEditor Initializer
    const richEditors = document.querySelectorAll('textarea.rich-editor, textarea.ckeditor-classic, textarea.ckeditor');
    richEditors.forEach(el => {
        if (typeof ClassicEditor !== 'undefined') {
            ClassicEditor.create(el, {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'link', '|',
                    'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', 'undo', 'redo'
                ]
            }).catch(error => {
                console.error('CKEditor initialization error:', error);
            });
        }
    });
});
</script>

<!-- Global Site Media Gallery & Asset Picker Modal -->
<?php require_once __DIR__ . '/media_modal.php'; ?>

<!-- Global Media Picker Engine JS -->
<script src="<?php echo BASE_URL; ?>assets/js/admin_media_picker.js?v=<?php echo @filemtime(__DIR__ . '/../assets/js/admin_media_picker.js') ?: time(); ?>"></script>

</body>
</html>
