<?php
/**
 * Migration script to add stream and skills columns to submissions table
 * Run this once to update your existing database
 */

require_once __DIR__ . '/includes/db.php';

try {
    $pdo = getPDOConnection();
    
    echo "Starting migration...\n";
    
    // Check if columns already exist
    $stmt = $pdo->query("DESCRIBE submissions");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
    $hasStream = in_array('stream', $columns);
    $hasSkills = in_array('skills', $columns);
    
    if (!$hasStream) {
        echo "Adding 'stream' column...\n";
        $pdo->exec("ALTER TABLE submissions ADD COLUMN stream VARCHAR(255) NULL COMMENT 'Stream/Field (for community submissions)' AFTER message");
        echo "✓ 'stream' column added\n";
    } else {
        echo "✓ 'stream' column already exists\n";
    }
    
    if (!$hasSkills) {
        echo "Adding 'skills' column...\n";
        $pdo->exec("ALTER TABLE submissions ADD COLUMN skills TEXT NULL COMMENT 'Skills list (for community submissions)' AFTER stream");
        echo "✓ 'skills' column added\n";
    } else {
        echo "✓ 'skills' column already exists\n";
    }
    
    echo "\n✅ Migration completed successfully!\n";
    echo "Your database is now ready to store stream and skills data.\n";
    
} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
