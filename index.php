<?php
// Simple landing router for local dev: redirect to dashboard or login
// If a token exists, go to dashboard; otherwise go to login
$token = isset($_COOKIE['kp_token']) ? $_COOKIE['kp_token'] : null;
if (!$token && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    // Some environments may pass token via Authorization header; ignore for redirect
}

// Allow localStorage-based tokens by checking a query hint
// If you visit /?to=dashboard it will go to dashboard
$to = isset($_GET['to']) ? $_GET['to'] : '';

if ($to === 'dashboard') {
    header('Location: /dashboard.php');
    exit;
}

if (!empty($token)) {
    header('Location: /dashboard.php');
    exit;
} else {
    header('Location: /login.php');
    exit;
}

// Fallback in case headers already sent
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kobopoint</title>
</head>
<body>
  <p>Redirecting… If you are not redirected, go to <a href="/login.php">Login</a> or <a href="/dashboard.php">Dashboard</a>.</p>
</body>
</html>