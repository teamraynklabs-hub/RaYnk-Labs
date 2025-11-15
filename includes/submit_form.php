<?php
/**
 * Central form handler for Ranky Labs.
 *
 * Accepts all POST submissions (services, courses, community, meetups, etc.),
 * validates the payload, persists it to the database, and redirects back with
 * a success or error message.
 */

declare(strict_types=1);

session_start();

require_once __DIR__ . '/db.php';

/**
 * Helper to redirect back to the referring page (or home as fallback).
 *
 * @param string $status  success|error
 * @param string $message Flash message to display.
 * @return void
 */
function redirectWithMessage(string $status, string $message): void
{
    $_SESSION['flash'] = [
        'status'  => $status,
        'message' => $message,
    ];

    $redirect = $_SERVER['HTTP_REFERER'] ?? '/public/index.php';
    header("Location: {$redirect}");
    exit;
}

// Ensure we only accept POST submissions.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage('error', 'Invalid request method.');
}

// Sanitize and validate inputs.
$type        = isset($_POST['type']) ? strtolower(trim((string) $_POST['type'])) : '';
$originTitle = isset($_POST['origin_title']) ? trim((string) $_POST['origin_title']) : '';
$name        = isset($_POST['name']) ? trim((string) $_POST['name']) : '';
$email       = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
$phone       = isset($_POST['phone']) ? trim((string) $_POST['phone']) : '';
$message     = isset($_POST['message']) ? trim((string) $_POST['message']) : '';

$validTypes = ['service', 'course', 'community', 'meetup', 'contact'];
if (!in_array($type, $validTypes, true)) {
    redirectWithMessage('error', 'Unknown submission type.');
}

if ($originTitle === '') {
    redirectWithMessage('error', 'Missing form origin information.');
}

if ($name === '' || mb_strlen($name) < 2) {
    redirectWithMessage('error', 'Please provide a valid name.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectWithMessage('error', 'Please provide a valid email address.');
}

if ($phone === '' || !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
    redirectWithMessage('error', 'Please provide a valid phone number.');
}

if ($message === '') {
    redirectWithMessage('error', 'Please share more details in the message field.');
}

// Persist submission.
try {
    $pdo = getPDOConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO submissions (type, origin_title, name, email, phone, message)
         VALUES (:type, :origin_title, :name, :email, :phone, :message)'
    );

    $stmt->execute([
        ':type'         => $type,
        ':origin_title' => $originTitle,
        ':name'         => $name,
        ':email'        => $email,
        ':phone'        => $phone,
        ':message'      => $message,
    ]);
} catch (PDOException $e) {
    redirectWithMessage('error', 'Unable to save your request. Please try again later.');
}

redirectWithMessage('success', 'Thank you! We will reach out shortly.');

