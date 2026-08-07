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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, var(--dark-navy), var(--primary-maroon)); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">

    <div style="background: #ffffff; width: 100%; max-width: 440px; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
        <div style="text-align: center; margin-bottom: 30px;">
            <div class="logo-icon" style="margin: 0 auto 15px;">SRK</div>
            <h2 style="font-family: var(--font-heading); color: var(--primary-maroon); font-weight: 800;">SRKU CMS Admin</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Sign in to manage university portal</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger" style="font-size: 0.88rem;"><?php echo sanitize($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="admin" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer; padding: 12px;">
                <i class="fas fa-lock"></i> Sign In to Dashboard
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px; border-top: 1px solid var(--border-color); padding-top: 15px;">
            <small style="color: var(--text-muted);">Default Credentials: <strong>admin</strong> / <strong>admin123</strong></small><br>
            <a href="<?php echo BASE_URL; ?>" style="font-size: 0.85rem; color: var(--primary-maroon); font-weight: 600; margin-top: 5px; display: inline-block;">
                &larr; Back to Main Website
            </a>
        </div>
    </div>

</body>
</html>
