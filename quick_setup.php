<?php
/**
 * Quick Admin Setup - Run this once to create admin in database
 * 
 * USAGE:
 * 1. Make sure MySQL is running
 * 2. Open in browser: http://localhost:8080/RaYnkLabs(PHP)/quick_setup.php
 * 3. Wait for success message
 * 4. Then login at: http://localhost:8080/RaYnkLabs(PHP)/admin/index.php
 */

declare(strict_types=1);

// Database credentials
$dbHost = 'localhost:3307';
$dbName = 'ranky_labs_db';
$dbUser = 'root';
$dbPass = '';

// Admin credentials
$adminEmail = 'team.raynklabs@gmail.com';
$adminPassword = 'Mittar@Raynk2025';
$adminPasswordHash = password_hash($adminPassword, PASSWORD_BCRYPT, ['cost' => 10]);

try {
    // Create connection
    $pdo = new PDO(
        sprintf('mysql:host=%s;charset=utf8mb4', $dbHost),
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );

    // Step 1: Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // Step 2: Select database
    $pdo->exec("USE `$dbName`");
    
    // Step 3: Create admins table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `password_hash` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_email` (`email`),
            INDEX `idx_created_at` (`created_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Administrator login credentials'
    ");
    
    // Step 4: Create submissions table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `submissions` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `type` VARCHAR(50) NOT NULL COMMENT 'service, course, ai_tool, community, meetup, contact, turning_point',
            `origin_title` VARCHAR(255) NOT NULL COMMENT 'Title/name of the originating form/service',
            `name` VARCHAR(150) NOT NULL COMMENT 'Submitter full name',
            `email` VARCHAR(255) NOT NULL COMMENT 'Submitter email address',
            `phone` VARCHAR(25) NOT NULL COMMENT 'Submitter phone number',
            `message` TEXT NOT NULL COMMENT 'Detailed message from submitter',
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `idx_type` (`type`),
            INDEX `idx_email` (`email`),
            INDEX `idx_created_at` (`created_at`),
            FULLTEXT `idx_search` (`name`, `email`, `message`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User form submissions'
    ");
    
    // Step 5: Delete old admin if exists
    $pdo->prepare("DELETE FROM `admins` WHERE `email` = ?")->execute([$adminEmail]);
    
    // Step 6: Insert new admin
    $pdo->prepare("INSERT INTO `admins` (`email`, `password_hash`) VALUES (?, ?)")
        ->execute([$adminEmail, $adminPasswordHash]);
    
    // Success response
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>✅ Setup Complete</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                background: #0D0D0D;
                color: #FFFFFF;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
            }
            .container {
                background: rgba(255, 255, 255, 0.05);
                border: 2px solid rgba(76, 175, 80, 0.3);
                border-radius: 20px;
                padding: 50px;
                max-width: 500px;
                width: 100%;
                text-align: center;
            }
            h1 {
                color: #4CAF50;
                margin-bottom: 20px;
                font-size: 32px;
            }
            .success-icon {
                font-size: 60px;
                margin-bottom: 20px;
                animation: bounce 0.6s;
            }
            @keyframes bounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .step {
                background: rgba(76, 175, 80, 0.1);
                border-left: 4px solid #4CAF50;
                padding: 15px;
                margin: 15px 0;
                text-align: left;
                border-radius: 5px;
            }
            .step-title {
                color: #4CAF50;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .step-content {
                color: rgba(255, 255, 255, 0.8);
                font-size: 14px;
            }
            .credentials {
                background: rgba(59, 167, 255, 0.1);
                border: 2px solid rgba(59, 167, 255, 0.3);
                border-radius: 10px;
                padding: 20px;
                margin: 30px 0;
                text-align: left;
            }
            .cred-item {
                margin: 12px 0;
                padding: 10px;
                background: rgba(0, 0, 0, 0.3);
                border-radius: 5px;
            }
            .cred-label {
                color: #3BA7FF;
                font-weight: bold;
                display: block;
                margin-bottom: 5px;
            }
            .cred-value {
                color: #A26BFF;
                font-family: monospace;
                font-size: 13px;
                word-break: break-all;
            }
            .button-group {
                display: flex;
                gap: 10px;
                margin-top: 30px;
                flex-wrap: wrap;
            }
            a, button {
                flex: 1;
                padding: 12px 20px;
                border-radius: 25px;
                text-decoration: none;
                border: none;
                font-weight: 600;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.3s ease;
                min-width: 150px;
            }
            .btn-login {
                background: linear-gradient(135deg, #3BA7FF, #A26BFF);
                color: white;
            }
            .btn-login:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(59, 167, 255, 0.3);
            }
            .btn-home {
                background: rgba(255, 255, 255, 0.1);
                color: #3BA7FF;
                border: 1px solid rgba(59, 167, 255, 0.3);
            }
            .btn-home:hover {
                background: rgba(59, 167, 255, 0.1);
                border-color: #3BA7FF;
            }
            .note {
                background: rgba(255, 193, 7, 0.1);
                border-left: 4px solid #FFC107;
                padding: 12px;
                margin-top: 20px;
                text-align: left;
                border-radius: 5px;
                color: rgba(255, 255, 255, 0.8);
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="success-icon">✅</div>
            <h1>Setup Complete!</h1>
            
            <div class="step">
                <div class="step-title">✓ Database Created</div>
                <div class="step-content">ranky_labs_db with all tables</div>
            </div>
            
            <div class="step">
                <div class="step-title">✓ Tables Created</div>
                <div class="step-content">admins & submissions tables ready</div>
            </div>
            
            <div class="step">
                <div class="step-title">✓ Admin Account Created</div>
                <div class="step-content">Your credentials are set and ready to use</div>
            </div>
            
            <div class="credentials">
                <div class="cred-item">
                    <span class="cred-label">📧 Email:</span>
                    <span class="cred-value">team.raynklabs@gmail.com</span>
                </div>
                <div class="cred-item">
                    <span class="cred-label">🔑 Password:</span>
                    <span class="cred-value">Mittar@Raynk2025</span>
                </div>
            </div>
            
            <div class="button-group">
                <a href="../admin/index.php" class="btn-login">Go to Login</a>
                <a href="index.php" class="btn-home">Back to Home</a>
            </div>
            
            <div class="note">
                💡 <strong>Note:</strong> Your admin account has been created successfully. You can now login with the credentials above. This page can be deleted after first use.
            </div>
        </div>
    </body>
    </html>';

} catch (PDOException $e) {
    // Error response
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>❌ Setup Error</title>
        <style>
            body {
                background: #0D0D0D;
                color: #FFFFFF;
                font-family: Arial, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
            }
            .container {
                background: rgba(255, 0, 0, 0.1);
                border: 2px solid rgba(255, 0, 0, 0.3);
                border-radius: 20px;
                padding: 40px;
                max-width: 500px;
                text-align: center;
            }
            h1 {
                color: #FF6B6B;
                margin-bottom: 20px;
            }
            .error-details {
                background: rgba(0, 0, 0, 0.3);
                padding: 15px;
                border-radius: 10px;
                margin: 20px 0;
                text-align: left;
                font-family: monospace;
                font-size: 12px;
                color: #FFB6B6;
            }
            .solution {
                background: rgba(76, 175, 80, 0.1);
                border: 1px solid rgba(76, 175, 80, 0.3);
                padding: 15px;
                border-radius: 10px;
                margin: 20px 0;
                text-align: left;
                color: rgba(255, 255, 255, 0.8);
            }
            .solution-title {
                color: #4CAF50;
                font-weight: bold;
                margin-bottom: 10px;
            }
            ul {
                margin-left: 20px;
                color: rgba(255, 255, 255, 0.7);
                font-size: 14px;
            }
            li {
                margin: 8px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>❌ Setup Error</h1>
            
            <div class="error-details">
                ' . htmlspecialchars($e->getMessage()) . '
            </div>
            
            <div class="solution">
                <div class="solution-title">How to Fix:</div>
                <ul>
                    <li>✓ Make sure MySQL/MariaDB is running in XAMPP</li>
                    <li>✓ Check that port 3307 is correct (or update db.php)</li>
                    <li>✓ Verify MySQL root user has no password</li>
                    <li>✓ Try again or import database.sql manually</li>
                </ul>
            </div>
            
            <a href="javascript:location.reload()" style="display: inline-block; background: linear-gradient(135deg, #3BA7FF, #A26BFF); color: white; padding: 12px 30px; border-radius: 25px; text-decoration: none; margin-top: 20px;">Try Again</a>
        </div>
    </body>
    </html>';
}
?>
