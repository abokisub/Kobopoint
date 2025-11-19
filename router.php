<?php
// Simple router for PHP built-in server to map pretty URLs to existing .php files

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing files (CSS, JS, images) directly if they exist
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

switch ($uri) {
    case '/dashboard/app':
        require __DIR__ . '/dashboard.php';
        break;

    case '/transfer/send':
        require __DIR__ . '/send-money.php';
        break;

    case '/transfer/send/bank':
        require __DIR__ . '/send-money-bank.php';
        break;

    case '/transfer/send/kobo':
        require __DIR__ . '/send-money-kobo.php';
        break;

    case '/':
    case '/dashboard':
        // Redirect canonical dashboard path to /dashboard/app
        header('Location: /dashboard/app', true, 302);
        exit;

    case '/auth/login':
        require __DIR__ . '/login.php';
        break;

    case '/auth/forget-password':
        require __DIR__ . '/forget-password.php';
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}