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
</body>
</html>
