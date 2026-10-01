<?php
require_once __DIR__ . '/../includes/functions.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
        $stmt->execute([':u' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username or password credentials.";
        }
    } else {
        $error = "Please fill in both username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SRKU Central CMS</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/favicon.png?v=<?php echo @filemtime(__DIR__ . '/../assets/images/favicon.png') ?: time(); ?>">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3" style="background: linear-gradient(135deg, #18183d 0%, #2a2a68 50%, #a30407 100%);">

    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 w-100 bg-white" style="max-width: 440px; box-shadow: 0 20px 45px rgba(0,0,0,0.25) !important;">
        <div class="text-center mb-4">
            <div class="p-3 bg-light rounded-3 d-inline-block mb-3 border shadow-sm">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-logo.webp" alt="SRKU Logo" style="max-height: 52px; width: auto;" onerror="this.src='<?php echo BASE_URL; ?>assets/images/SRK-logo.webp'">
            </div>
            <h2 class="h4 fw-bold text-navy mb-1" style="font-family: var(--font-heading);">SRKU CMS Portal</h2>
            <p class="text-muted small mb-0">Centralized Institutional Management Console</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger small py-2 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <div><?php echo sanitize($error); ?></div>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                    <input type="text" name="username" class="form-control py-2" placeholder="admin" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold text-dark small">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control py-2" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #a30407, #d62529);">
                <i class="fas fa-sign-in-alt me-1"></i> Sign In to Dashboard
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted d-block mb-2">Default Credentials: <strong>admin</strong> / <strong>admin123</strong></small>
            <a href="<?php echo BASE_URL; ?>" class="text-danger fw-bold small text-decoration-none d-inline-flex align-items-center gap-1">
                <i class="fas fa-arrow-left"></i> Back to Live Website
            </a>
        </div>
    </div>

</body>
</html>
