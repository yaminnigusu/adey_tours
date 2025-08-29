<?php
// public/submit_contact.php
session_start();

// If you put database.php somewhere else change this path:
require_once __DIR__ . '/../config/database.php'; // must set $pdo (PDO)

// Helper: send JSON response for AJAX
function json_response($status, $data = [], $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['status' => $status], $data));
    exit;
}

// Basic helper to redirect with flash
function redirect_with_flash($url, $msg, $level = 'success') {
    $_SESSION['flash'] = ['msg' => $msg, 'level' => $level];
    header("Location: $url");
    exit;
}

// Accept only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) {
        json_response('error', ['message' => 'Invalid request method'], 405);
    }
    header('Location: /adey_tours/public/contact.php');
    exit;
}

// Simple honeypot (add an input named "website" in your form hidden via CSS)
$honeypot = trim($_POST['website'] ?? '');
if ($honeypot !== '') {
    // probably a bot - silently drop or return success to confuse bots
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        json_response('ok', ['message' => 'Thank you.']);
    }
    redirect_with_flash('/adey_tours/public/contact.php', 'Thank you for your message.');
}

// Collect & validate inputs
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Basic validation rules
$errors = [];

if ($name === '') {
    $errors[] = 'Name is required.';
} elseif (mb_strlen($name) > 100) {
    $errors[] = 'Name is too long (max 100 characters).';
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}
if ($email !== '' && mb_strlen($email) > 100) {
    $errors[] = 'Email is too long (max 100 characters).';
}

if ($message === '') {
    $errors[] = 'Message is required.';
} elseif (mb_strlen($message) > 20000) {
    $errors[] = 'Message is too long.';
}

if ($subject !== '' && mb_strlen($subject) > 255) {
    $errors[] = 'Subject is too long (max 255 characters).';
}

// Respond with errors
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if ($errors) {
    if ($isAjax) {
        json_response('error', ['errors' => $errors], 422);
    } else {
        // save old inputs to session so you can repopulate the form if you want
        $_SESSION['contact_form_old'] = ['name'=>$name,'email'=>$email,'subject'=>$subject,'message'=>$message];
        $_SESSION['contact_form_errors'] = $errors;
        header('Location: /adey_tours/public/contact.php');
        exit;
    }
}

// OPTIONAL: Basic rate limiting (very simple - per session)
// You can replace with IP-based or DB-based rate limiting.
$limit_seconds = 30; // minimum seconds between submissions
$last = $_SESSION['last_contact_submit'] ?? 0;
if (time() - $last < $limit_seconds) {
    $wait = $limit_seconds - (time() - $last);
    $msg = "Please wait {$wait} seconds before sending another message.";
    if ($isAjax) json_response('error', ['message' => $msg], 429);
    redirect_with_flash('/adey_tours/public/contact.php', $msg, 'warning');
}

// Prepare & insert into DB
try {
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name ?: 'Anonymous', $email ?: null, $subject ?: null, $message]);

    // mark last submit time
    $_SESSION['last_contact_submit'] = time();

    // optional: send admin email (uncomment and customize)
    /*
    $adminEmail = 'your-admin@example.com';
    $mailSubject = "New contact from {$name} - " . ($subject ?: 'No subject');
    $mailBody = "Name: {$name}\nEmail: {$email}\nSubject: {$subject}\n\nMessage:\n{$message}\n\n--\nFrom your website.";
    @mail($adminEmail, $mailSubject, $mailBody, "From: no-reply@yourdomain.com\r\nReply-To: {$email}");
    */

    if ($isAjax) {
        json_response('ok', ['message' => 'Thank you — your message has been received.']);
    } else {
        redirect_with_flash('/adey_tours/public/contact.php', 'Thank you — your message has been received.');
    }
} catch (PDOException $e) {
    // Log error somewhere server-side; do not expose raw DB errors to users
    error_log("Contact form insert error: " . $e->getMessage());

    if ($isAjax) {
        json_response('error', ['message' => 'Server error while saving your message. Please try again later.'], 500);
    } else {
        redirect_with_flash('/adey_tours/public/contact.php', 'Server error while saving your message. Please try again later.', 'danger');
    }
}
