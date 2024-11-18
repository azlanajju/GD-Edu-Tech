<?php
require_once __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwtSecretKey = "your_secret_key_here";

if (!isset($_COOKIE['auth_token'])) {
    header("Location: login.php");
    exit();
}

try {
    $jwt = $_COOKIE['auth_token'];
    $decoded = JWT::decode($jwt, new Key($jwtSecretKey, 'HS256'));

    // Access user details from the token
    $user_id = $decoded->user_id;
    $username = $decoded->username;
    $role = $decoded->role;

    // Show dashboard content
    echo "Welcome, $username! You are logged in as $role.";

} catch (Exception $e) {
    echo "Unauthorized: " . $e->getMessage();
    header("Location: login.php");
    exit();
}
?>

<!-- Logout Button Form -->
<form action="logout.php" method="POST">
    <button type="submit">Logout</button>
</form>
