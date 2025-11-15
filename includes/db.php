<?php
/**
 * PDO connection bootstrap for the Ranky Labs project.
 *
 * This file centralizes the database credentials and returns an active
 * PDO instance so the rest of the application can reuse the same
 * connection. Update the DSN, username, or password if your hosting
 * environment uses different values.
 */

declare(strict_types=1);

// Database credentials (update as needed for your environment).
$dbHost = 'localhost:3307';
$dbName = 'ranky_labs_db';
$dbUser = 'root';
$dbPass = '';

/**
 * Create a PDO instance with sane defaults for error handling and charset.
 *
 * @return PDO Active database connection.
 */
function getPDOConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        global $dbHost, $dbName, $dbUser, $dbPass;

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $dbHost, $dbName);

        try {
            $pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // Fail fast with a clear message; in production you might want to log instead.
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    return $pdo;
}

