<?php

declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

use App\Controllers\AuthController;

$auth = new AuthController();

$error = '';
$success = '';

// Jika sudah login, arahkan sesuai role
if ($auth->isLoggedIn()) {
    $role = $_SESSION['user']['role'] ?? 'member';

    if ($role === 'admin') {
        redirect('admin/dashboard.php');
    }

    redirect('member/dashboard.php');
}

// Memproses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($password !== $confirmPassword) {

        $error = 'Konfirmasi password tidak cocok.';

    } else {

        $result = $auth->register(
            $name,
            $email,
            $password
        );

        if ($result['success']) {
            $success = $result['message'];
        } else {
            $error = $result['message'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - DigBook</title>

    <!-- Memanggil CSS Authentication -->
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>

<body>

    <main>
        <?php
        require_once __DIR__ . '/views/auth/register.php';
        ?>
    </main>

    <!-- Memanggil JavaScript Authentication -->
    <script src="/assets/js/auth.js"></script>

</body>

</html>
