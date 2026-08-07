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
    <title>Admin Login - SRKU CMS</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">

    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 w-100" style="max-width: 420px;">
        <div class="text-center mb-4">
            <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-logo.webp" alt="SRKU Logo" height="46" class="mb-3" onerror="this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/srk-logo-real.webp'">
            <h2 class="h4 fw-bold text-maroon mb-1">SRKU CMS Admin</h2>
            <p class="text-muted small mb-0">Sign in to manage university portal</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger small py-2"><?php echo sanitize($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">Username</label>
                <input type="text" name="username" class="form-control py-2" placeholder="admin" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold text-dark small">Password</label>
                <input type="password" name="password" class="form-control py-2" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
                <i class="fas fa-lock me-1"></i> Sign In to Dashboard
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted d-block mb-1">Default Credentials: <strong>admin</strong> / <strong>admin123</strong></small>
            <a href="<?php echo BASE_URL; ?>" class="text-maroon fw-bold small text-decoration-none">&larr; Back to Main Website</a>
        </div>
    </div>

</body>
</html>
