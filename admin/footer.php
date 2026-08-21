        </div>
    </main>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- CKEditor Global Initializer -->
<script>
document.addEventListener('DOMContentLoaded', () => {
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
