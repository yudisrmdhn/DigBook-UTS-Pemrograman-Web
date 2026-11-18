<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Controllers\AuthController;

$auth = new AuthController();

// Hanya Member yang boleh mengakses halaman ini
$auth->requireRole('member');

$user = $auth->getCurrentUser();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Member Dashboard - DigBook</title>

    <link rel="stylesheet" href="/assets/css/auth.css">
</head>

<body>

    <?php
    require_once __DIR__ . '/../views/member/dashboard.php';
    ?>

</body>

</html>
