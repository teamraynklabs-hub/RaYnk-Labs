<?php
/**
 * Admin Password Reset Script
 * Run this script to set a new admin password
 * 
 * USAGE:
 * 1. Open this file in browser: http://localhost:8080/RaYnkLabs(PHP)/reset_admin_password.php
 * 2. Or run from command line: php reset_admin_password.php
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

// Set your new password here
$newPassword = 'admin@123';  // CHANGE THIS TO YOUR DESIRED PASSWORD
$adminEmail = 'admin@rankylabs.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if ($newPassword && $confirmPassword && $newPassword === $confirmPassword && strlen($newPassword) >= 6) {
        try {
            $pdo = getPDOConnection();
            $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 10]);
            
            $stmt = $pdo->prepare('UPDATE admins SET password_hash = :hash WHERE email = :email');
            $stmt->execute([
                ':hash' => $passwordHash,
                ':email' => $adminEmail
            ]);
            
            echo '<div style="background: #0D0D0D; color: #3BA7FF; padding: 20px; font-family: Arial; border-radius: 10px; max-width: 400px; margin: 50px auto; text-align: center;">';
            echo '<h2 style="color: #3BA7FF; margin-bottom: 20px;">✅ Password Updated Successfully!</h2>';
            echo '<p style="color: #FFFFFF; margin-bottom: 15px;"><strong>Email:</strong> ' . htmlspecialchars($adminEmail) . '</p>';
            echo '<p style="color: #FFFFFF; margin-bottom: 15px;"><strong>New Password:</strong> ' . htmlspecialchars($newPassword) . '</p>';
            echo '<p style="color: #A26BFF; margin-top: 20px; font-size: 12px;">You can now login with these credentials</p>';
            echo '<a href="admin/index.php" style="display: inline-block; background: linear-gradient(135deg, #3BA7FF, #A26BFF); color: white; padding: 10px 30px; border-radius: 25px; text-decoration: none; margin-top: 20px;">Go to Login</a>';
            echo '</div>';
            exit;
        } catch (Exception $e) {
            $error = 'Error updating password: ' . $e->getMessage();
        }
    } else {
        $error = 'Passwords do not match or are too short (min 6 characters)';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password - RaYnk Labs</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #0D0D0D;
            color: #FFFFFF;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(59, 167, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        
        h1 {
            background: linear-gradient(135deg, #3BA7FF, #A26BFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            font-size: 24px;
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #FF6B6B;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #FFFFFF;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #3BA7FF;
            background: rgba(59, 167, 255, 0.1);
            box-shadow: 0 0 10px rgba(59, 167, 255, 0.2);
        }
        
        input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #3BA7FF, #A26BFF);
            border: none;
            color: #FFFFFF;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(59, 167, 255, 0.3);
        }
        
        .info {
            background: rgba(59, 167, 255, 0.1);
            border: 1px solid rgba(59, 167, 255, 0.3);
            padding: 12px 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .info strong {
            color: #3BA7FF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Admin Password</h1>
        <p class="subtitle">Set a new password for admin@rankylabs.com</p>
        
        <?php if (isset($error)): ?>
            <div class="error">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" value="admin@rankylabs.com" disabled>
            </div>
            
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required minlength="6">
            </div>
            
            <button type="submit">Reset Password</button>
        </form>
        
        <div class="info">
            <strong>Note:</strong> Use at least 6 characters for your password. After resetting, you can login to the admin panel.
        </div>
    </div>
</body>
</html>
