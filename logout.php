<?php

declare(strict_types=1);

require_once __DIR__ . '/config/bootstrap.php';

use App\Controllers\AuthController;

$auth = new AuthController();

// Mengakhiri sesi pengguna
$auth->logout();

// Mengarahkan pengguna kembali ke halaman login
redirect('login.php');
