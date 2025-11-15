<?php
/**
 * Global form processor for Ranky Labs.
 *
 * Handles submissions from every interactive element on the site:
 * services, courses, AI tools, community, meetups, contact, and
 * Turning Point. Stores each record inside the submissions table
 * with proper type tagging.
 */

declare(strict_types=1);

session_start();

require_once __DIR__ . '/db.php';

/**
 * Helper: redirect back to landing page with flash message.
 */
function redirectWithFlash(string $status, string $message): void
{
    $_SESSION['flash'] = [
        'status'  => $status,
        'message' => $message,
    ];

    header('Location: ../public/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithFlash('error', 'Invalid request method.');
}

$type        = strtolower(trim($_POST['type'] ?? ''));
$originTitle = trim($_POST['origin_title'] ?? '');
$name        = trim($_POST['name'] ?? '');
$email       = trim($_POST['email'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$message     = trim($_POST['message'] ?? '');
$stream      = trim($_POST['stream'] ?? '');
$skills      = trim($_POST['custom_skills'] ?? '');

$validTypes = [
    'service',
    'course',
    'ai_tool',
    'community',
    'meetup',
    'contact',
    'turning_point',
];

if (!in_array($type, $validTypes, true)) {
    redirectWithFlash('error', 'Unknown submission type.');
}

if ($originTitle === '') {
    redirectWithFlash('error', 'Missing form information.');
}

if ($name === '' || mb_strlen($name) < 2) {
    redirectWithFlash('error', 'Please provide your full name.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectWithFlash('error', 'Please provide a valid email address.');
}

if ($phone === '' || !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
    redirectWithFlash('error', 'Please provide a valid phone number.');
}

if ($message === '') {
    redirectWithFlash('error', 'Please share more details in the message field.');
}

try {
    $pdo = getPDOConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO submissions (type, origin_title, name, email, phone, message, stream, skills)
         VALUES (:type, :origin_title, :name, :email, :phone, :message, :stream, :skills)'
    );

    $stmt->execute([
        ':type'         => $type,
        ':origin_title' => $originTitle,
        ':name'         => $name,
        ':email'        => $email,
        ':phone'        => $phone,
        ':message'      => $message,
        ':stream'       => $stream ?: null,
        ':skills'       => $skills ?: null,
    ]);
} catch (PDOException $e) {
    redirectWithFlash('error', 'Something went wrong while saving your request.');
}

redirectWithFlash('success', 'Sweet! Your request is in. Expect a reply soon.');

