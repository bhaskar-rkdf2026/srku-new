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
    echo '<section class="section" style="text-align: center; padding: 100px 20px;">
            <div class="container">
                <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: var(--accent-gold); margin-bottom: 20px;"></i>
                <h1 style="font-family: var(--font-heading); color: var(--dark-navy);">404 - Page Not Found</h1>
                <p style="color: var(--text-muted); margin-bottom: 30px;">The page you are looking for does not exist or has been moved.</p>
                <a href="' . BASE_URL . '" class="btn-primary">Return to Homepage</a>
            </div>
          </section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $pageData['title'];
require_once __DIR__ . '/includes/header.php';
?>

<div style="background: linear-gradient(135deg, var(--dark-navy), var(--primary-maroon)); color: #ffffff; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h1 style="font-family: var(--font-heading); font-size: 2.8rem; font-weight: 800;"><?php echo sanitize($pageData['title']); ?></h1>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width: 900px; background: #ffffff; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
        <div class="page-content" style="line-height: 1.8; color: var(--text-dark);">
            <?php echo $pageData['content']; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
