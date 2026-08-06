<!DOCTYPE html>
<html>
<head>
    <title>GajiKita</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f8f9fa; }
        h1 { color: #333; }
        .btn-add { background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 15px; }
        
        /* Tambahkan CSS Logout di sini */
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            float: right; /* Agar tombol berada di kanan atas */
            margin-right: 20px;
        }
        .logout-btn:hover { background-color: #c82333; }

        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th { background: #343a40; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #dee2e6; }
        tr:hover { background-color: #f1f1f1; }
        .btn-edit { background: #ffc107; color: #333; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .btn-edit:hover { background: #e0a800; }
        .btn-delete { background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold; margin-left: 5px; }
        .btn-delete:hover { background: #c82333; }
    </style>
</head>
<body>

    <!-- Tombol Logout ini akan muncul di semua halaman -->
    <a href="<?= base_url('login/logout') ?>"
       class="logout-btn"
       onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
       Keluar
    </a>

    <?= $this->renderSection('content') ?>
</body>
</html>