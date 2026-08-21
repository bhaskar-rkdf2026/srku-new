<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? '');
$pageData = getPageBySlug($slug);

if (!$pageData) {
    header("HTTP/1.0 404 Not Found");
    $pageTitle = "Page Not Found - SRK University";
    require_once __DIR__ . '/includes/header.php';
    echo '<section class="py-5 text-center my-5">
            <div class="container-xl py-5">
                <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                <h1 class="fw-bold text-navy mb-2">404 - Page Not Found</h1>
                <p class="text-muted mb-4">The university page you are looking for does not exist or has been updated.</p>
                <a href="' . BASE_URL . '" class="btn btn-srku px-4 py-2"><i class="fas fa-home me-1"></i> Return to Homepage</a>
            </div>
          </section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $pageData['title'] . " - Sarvepalli Radhakrishnan University, Bhopal";
$metaDesc = $pageData['meta_description'] ?? '';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner($slug, $pageData['title'], $pageData['banner_subtitle'] ?? '', $pageData['banner_img'] ?? ''); ?>

<!-- Breadcrumb Bar -->
<div class="bg-light py-2 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active text-danger fw-semibold" aria-current="page"><?php echo sanitize($pageData['title']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3" style="max-width: 1040px;">
        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4">
            <div class="page-content text-dark" style="line-height: 1.9; font-size:1.02rem;">
                <?php echo $pageData['content']; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
