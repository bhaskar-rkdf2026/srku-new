<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? '');

$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :s AND status = 'published' LIMIT 1");
$stmt->execute([':s' => $slug]);
$pageData = $stmt->fetch();

if (!$pageData) {
    header("HTTP/1.0 404 Not Found");
    $pageTitle = "Page Not Found";
    require_once __DIR__ . '/includes/header.php';
    echo '<section class="py-5 text-center my-5">
            <div class="container-xl py-5">
                <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                <h1 class="fw-bold text-navy mb-2">404 - Page Not Found</h1>
                <p class="text-muted mb-4">The page you are looking for does not exist or has been moved.</p>
                <a href="' . BASE_URL . '" class="btn btn-srku px-4 py-2">Return to Homepage</a>
            </div>
          </section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $pageData['title'];
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <h1 class="fw-bold display-5 mb-0"><?php echo sanitize($pageData['title']); ?></h1>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3" style="max-width: 960px;">
        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4">
            <div class="page-content text-dark" style="line-height: 1.85;">
                <?php echo $pageData['content']; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
