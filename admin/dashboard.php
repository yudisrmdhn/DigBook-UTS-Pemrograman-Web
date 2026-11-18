<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Controllers\AuthController;

$auth = new AuthController();

// Hanya Admin yang boleh mengakses halaman ini
$auth->requireRole('admin');

$user = $auth->getCurrentUser();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - DigBook</title>

</head>

<body>

    <?php
    // Memanggil tampilan Dashboard Admin
    require_once __DIR__ . '/../views/admin/dashboard.php';
    ?>

</body>

</html>
