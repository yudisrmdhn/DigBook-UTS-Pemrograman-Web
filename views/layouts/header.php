
<?php
$pageTitle = $pageTitle ?? 'DigBook - Digital Book Library';
$pageDescription = $pageDescription ?? 'Temukan dan jelajahi berbagai koleksi buku digital di DigBook.';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <meta name="description"
          content="<?= htmlspecialchars($pageDescription) ?>">

    <meta name="theme-color" content="#6B1834">

    <!-- Favicon -->
    <link rel="icon"
          type="image/png"
          href="/assets/images/favicon.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap"
          rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Catalog CSS -->
    <link rel="stylesheet" href="/assets/css/catalog.css">
</head>

<body>
