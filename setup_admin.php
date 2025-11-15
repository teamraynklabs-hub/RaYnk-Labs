<?php
/**
 * Admin Credentials Setup
 * Updates admin email and password in database
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';

// New credentials
$newEmail = 'team.raynklabs@gmail.com';
$newPassword = 'Mittar@Raynk2025';

try {
    $pdo = getPDOConnection();
    
    // Delete old admin records
    $stmt = $pdo->prepare('DELETE FROM admins');
    $stmt->execute();
    
    // Create password hash
    $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 10]);
    
    // Insert new admin credentials
    $stmt = $pdo->prepare('INSERT INTO admins (email, password_hash) VALUES (:email, :hash)');
    $stmt->execute([
        ':email' => $newEmail,
        ':hash' => $passwordHash
    ]);
    
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Credentials Set</title>
        <style>
            body {
                background: #0D0D0D;
                color: #FFFFFF;
                font-family: Arial, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
            }
            .container {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(59, 167, 255, 0.3);
                border-radius: 20px;
                padding: 40px;
                max-width: 500px;
                text-align: center;
            }
            h1 {
                background: linear-gradient(135deg, #3BA7FF, #A26BFF);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 30px;
            }
            .success {
                background: rgba(76, 175, 80, 0.1);
                border: 1px solid rgba(76, 175, 80, 0.3);
                color: #4CAF50;
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .cred-box {
                background: rgba(59, 167, 255, 0.1);
                border: 1px solid rgba(59, 167, 255, 0.3);
                border-radius: 10px;
                padding: 20px;
                margin: 20px 0;
                text-align: left;
            }
            .label {
                color: #3BA7FF;
                font-weight: bold;
                margin-top: 10px;
            }
            .value {
                background: rgba(0, 0, 0, 0.3);
                padding: 10px;
                border-radius: 5px;
                margin-top: 5px;
                font-family: monospace;
                word-break: break-all;
                color: #A26BFF;
            }
            a {
                display: inline-block;
                background: linear-gradient(135deg, #3BA7FF, #A26BFF);
                color: white;
                padding: 12px 30px;
                border-radius: 25px;
                text-decoration: none;
                margin-top: 20px;
                font-weight: bold;
            }
            a:hover {
                opacity: 0.9;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>✅ Admin Credentials Updated</h1>
            <div class="success">Admin credentials have been successfully set in the database!</div>
            
            <div class="cred-box">
                <div class="label">📧 Email (ID):</div>
                <div class="value">team.raynklabs@gmail.com</div>
                
                <div class="label">🔑 Password:</div>
                <div class="value">RaYnk@2025</div>
            </div>
            
            <p style="color: rgba(255, 255, 255, 0.7);">
                Use these credentials to login to the admin panel
            </p>
            
            <a href="admin/index.php">Go to Admin Login</a>
        </div>
    </body>
    </html>';
    
} catch (Exception $e) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <style>
            body {
                background: #0D0D0D;
                color: #FFFFFF;
                font-family: Arial, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }
            .container {
                background: rgba(255, 0, 0, 0.1);
                border: 1px solid rgba(255, 0, 0, 0.3);
                border-radius: 20px;
                padding: 40px;
                max-width: 500px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>❌ Error</h1>
            <p>' . htmlspecialchars($e->getMessage()) . '</p>
        </div>
    </body>
    </html>';
}
