<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kyu-Pay — Sistem Informasi Penggajian') ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- CSRF Token Meta untuk Integrasi API -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="<?= csrf_header() ?>">

    <!-- Inject Session & App State dari Backend CI4 ke Frontend React -->
    <script>
        window.__APP_DATA__ = <?= json_encode($appData ?? []) ?>;
    </script>
</head>
<body class="bg-darkBg text-slate-200 min-h-screen">
    <div id="root"></div>

    <!-- Load React Bundle Assets -->
    <?php
        helper('react');
        echo load_react_assets();
    ?>
</body>
</html>
