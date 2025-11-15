<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../includes/db.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: /admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $pdo = getPDOConnection();
        $stmt = $pdo->prepare('SELECT id, email, password_hash FROM admins WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = (int) $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            header('Location: /projects/admin/dashboard.php');
            exit;
        }
    }

    $error = 'Invalid credentials. Try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RaYnk Labs Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f0f1e;
        }
        .admin-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(59, 167, 255, 0.3);
            border-radius: 20px;
            padding: 50px;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .admin-title {
            background: linear-gradient(90deg, #00d4ff, #7b00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
            font-size: 2.2rem;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #00d4ff;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.4);
            color: white;
        }
        .btn-primary {
            background: linear-gradient(45deg, #00d4ff, #7b00ff);
            border: none;
            padding: 14px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(123, 0, 255, 0.4);
        }
        .back-btn {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 9999;
    background: #111;
    color: #fff;
    padding: 8px 18px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    transition: 0.3s;
}

.back-btn:hover {
    background: #3BA7FF;
    color: #fff;
    transform: translateX(-5px);
}

    </style>
</head>
<body class="admin-login-container">
    <a href="../index.php" class="back-btn">
    <i class="fas fa-arrow-left"></i> Back to Home
</a>

    <div class="admin-card">
        <h1 class="h3 fw-bold admin-title text-center">RaYnk Labs Admin</h1>
        <p class="text-center text-white-50 mb-4">Secure Access Panel</p>
        
        <?php if ($error): ?>
            <div class="alert alert-danger rounded-pill" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label text-white">Email Address</label>
                <input 
            type="email" 
            class="form-control" 
            name="email" 
            placeholder="Enter your email (e.g. rohit@example.com)" 
            required 
            autocomplete="email">
            </div>
            <div class="mb-4">
                <label class="form-label text-white">Password</label>
                <input 
            type="password" 
            class="form-control" 
            name="password" 
            placeholder="Enter your password (min. 6 characters)" 
            minlength="6" 
            required 
            autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        
        <p class="text-center text-white-50 mt-4 small">
            <i class="fas fa-lock"></i> Secure login for administrators only
        </p>
    </div>
</body>
</html>