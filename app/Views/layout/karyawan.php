<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Karyawan') ?> — GajiKita</title>
    <meta name="description" content="Sistem Informasi Penggajian - Panel Karyawan">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 268px;
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #34d399;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            /* Dark Theme — Emerald variant */
            --bg: #060f12;
            --sidebar-bg: #081519;
            --sidebar-border: rgba(148, 163, 184, 0.07);
            --topbar-bg: rgba(6, 15, 18, 0.85);
            --card-bg: rgba(10, 25, 30, 0.7);
            --card-border: rgba(148, 163, 184, 0.08);
            --card-hover-border: rgba(5, 150, 105, 0.3);
            --table-head: rgba(255, 255, 255, 0.03);
            --table-hover: rgba(5, 150, 105, 0.07);
            --input-bg: rgba(255, 255, 255, 0.04);
            --input-border: rgba(148, 163, 184, 0.12);
            --text: #e2e8f0;
            --text-muted: #94a3b8;
            --text-dim: #475569;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ── GLOBAL BACKGROUND MESH ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 70% 60% at 0% 0%, rgba(5, 150, 105, 0.12) 0%, transparent 55%),
                radial-gradient(ellipse 50% 50% at 100% 100%, rgba(6, 182, 212, 0.08) 0%, transparent 55%);
            pointer-events: none;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 1px; height: 100%;
            background: linear-gradient(180deg, transparent, rgba(5, 150, 105, 0.5), rgba(6, 182, 212, 0.3), transparent);
        }

        /* ── SIDEBAR LOGO ── */
        .sidebar-logo {
            padding: 28px 22px 22px;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .logo-img {
            width: 150px;
            height: auto;
            display: block;
            margin-bottom: 8px;
            filter: brightness(1.15);
        }

        .logo-sub {
            font-size: 10px;
            color: var(--text-dim);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        /* ── SIDEBAR NAV ── */
        .sidebar-nav {
            flex: 1;
            padding: 18px 12px;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(5, 150, 105, 0.3); border-radius: 4px; }

        .nav-section { margin-bottom: 28px; }

        .nav-section-label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: var(--text-dim);
            padding: 0 12px;
            margin-bottom: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 13px;
            border-radius: 11px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            border: 1px solid transparent;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(5, 150, 105, 0.1);
            color: var(--primary-light);
            border-color: rgba(5, 150, 105, 0.15);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.2) 0%, rgba(4, 120, 87, 0.15) 100%);
            color: #34d399;
            border-color: rgba(5, 150, 105, 0.3);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2), inset 0 1px 0 rgba(255,255,255,0.05);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 20%; bottom: 20%;
            width: 3px;
            background: linear-gradient(180deg, var(--primary-light), var(--accent));
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            font-size: 17px;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }

        /* ── PROFILE CARD IN SIDEBAR ── */
        .sidebar-profile {
            margin: 0 12px 12px;
            padding: 16px;
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.15) 0%, rgba(6, 182, 212, 0.08) 100%);
            border: 1px solid rgba(5, 150, 105, 0.2);
            border-radius: 14px;
            text-align: center;
        }

        .profile-avatar-lg {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            color: white;
            margin: 0 auto 10px;
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        }

        .profile-avatar-img {
            width: 60px; height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(52, 211, 153, 0.4);
            margin: 0 auto 10px;
            display: block;
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
        }

        .profile-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 3px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-role {
            display: inline-block;
            font-size: 10px;
            color: var(--primary-light);
            background: rgba(5, 150, 105, 0.15);
            border: 1px solid rgba(5, 150, 105, 0.25);
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ── SIDEBAR USER ── */
        .sidebar-user {
            padding: 16px;
            border-top: 1px solid var(--sidebar-border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 12px;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.4);
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            max-width: 140px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-role {
            font-size: 10px;
            color: var(--primary-light);
            font-weight: 500;
            display: block;
            margin-top: 2px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 9px 14px;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.18);
            border-radius: 10px;
            color: #fca5a5;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.16);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* ── MAIN CONTENT ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--topbar-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--sidebar-border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 24px rgba(0, 0, 0, 0.3);
        }

        .page-title {
            font-size: 19px;
            font-weight: 700;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-time {
            font-size: 12.5px;
            color: var(--text-dim);
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 8px;
            padding: 5px 12px;
        }

        /* ── CONTENT AREA ── */
        .content-area {
            flex: 1;
            padding: 30px 32px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: alertIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes alertIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #6ee7b7; }
        .alert-error   { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; }
        .alert-warning  { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); color: #fcd34d; }

        /* ── CARDS ── */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
        }

        .card:hover {
            border-color: var(--card-hover-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(5, 150, 105, 0.1);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
            transition: left 0.4s ease;
        }
        .btn:hover::before { left: 100%; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.45);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.09);
            color: var(--text);
            border-color: rgba(255, 255, 255, 0.14);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.25);
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.35);
        }

        .btn-sm { padding: 6px 13px; font-size: 12px; border-radius: 8px; }

        /* ── TABLE ── */
        .table-responsive { overflow-x: auto; border-radius: 12px; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: var(--table-head);
            color: var(--text-dim);
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 13px 18px;
            text-align: left;
            border-bottom: 1px solid var(--card-border);
        }

        tbody td {
            padding: 14px 18px;
            font-size: 13.5px;
            color: var(--text);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        tbody tr { transition: background 0.15s ease; }
        tbody tr:hover { background: var(--table-hover); }
        tbody tr:last-child td { border-bottom: none; }

        /* ── FORM ── */
        .form-group { margin-bottom: 22px; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 9px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 11px;
            padding: 12px 16px;
            font-size: 14px;
            color: var(--text);
            font-family: 'Inter', sans-serif;
            transition: all 0.25s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: rgba(5, 150, 105, 0.6);
            background: rgba(5, 150, 105, 0.06);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.12);
        }

        .form-control::placeholder { color: rgba(148, 163, 184, 0.35); }

        select.form-control option { background: #081519; color: var(--text); }
        textarea.form-control { min-height: 100px; resize: vertical; }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-success { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.25); }
        .badge-warning { background: rgba(245,158,11,0.15); color: #fbbf24; border: 1px solid rgba(245,158,11,0.25); }
        .badge-danger  { background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.25); }

        /* ── SLIP GAJI HIGHLIGHT CARD ── */
        .salary-highlight {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%);
            border: 1px solid rgba(5, 150, 105, 0.25);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 16px;
        }

        /* ── MOBILE ── */
        .sidebar-overlay { display: none; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay {
                display: block;
                position: fixed; inset: 0;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(4px);
                z-index: 99;
                display: none;
            }
            .sidebar-overlay.open { display: block; }
            .main-wrapper { margin-left: 0; }
            .content-area { padding: 20px 16px; }
            .topbar { padding: 14px 20px; }
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
        ::-webkit-scrollbar-thumb { background: rgba(5,150,105,0.35); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(5,150,105,0.55); }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <img src="<?= base_url('assets/images/LOGO.png') ?>" alt="GajiKita" class="logo-img">
        <div class="logo-sub">Portal Karyawan</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-label">Menu</div>
            <a href="<?= base_url('karyawan/slip-gaji') ?>" class="nav-item <?= (str_contains(uri_string(), 'karyawan/slip-gaji') || uri_string() === 'karyawan/dashboard') ? 'active' : '' ?>">
                <span class="nav-icon">📄</span> Slip Gaji Saya
            </a>
            <a href="<?= base_url('karyawan/akun/ubah-password') ?>" class="nav-item <?= (uri_string() === 'karyawan/akun/ubah-password') ? 'active' : '' ?>">
                <span class="nav-icon">🔑</span> Ubah Password
            </a>
        </div>
    </nav>

    <div class="sidebar-user">
        <div class="user-info">
            <div class="user-avatar"><?= strtoupper(substr(session()->get('nama_karyawan') ?? session()->get('username') ?? 'K', 0, 1)) ?></div>
            <div>
                <div class="user-name" title="<?= esc(session()->get('nama_karyawan') ?? session()->get('username')) ?>">
                    <?= esc(session()->get('nama_karyawan') ?? session()->get('username')) ?>
                </div>
                <span class="user-role">Karyawan</span>
            </div>
        </div>
        <a href="<?= base_url('login/logout') ?>" class="btn-logout"
           onclick="return confirm('Yakin ingin keluar?')">
            🚪 Keluar dari Sistem
        </a>
    </div>
</aside>

<!-- ── MAIN CONTENT ── -->
<div class="main-wrapper">
    <header class="topbar">
        <div style="display:flex; align-items:center; gap:14px;">
            <button onclick="toggleSidebar()" style="background:none;border:none;color:var(--text-muted);font-size:20px;cursor:pointer;display:none;padding:6px;" id="menuBtn">☰</button>
            <h1 class="page-title"><?= esc($title ?? 'Dashboard') ?></h1>
        </div>
        <div class="topbar-right">
            <span class="topbar-time" id="clock"></span>
        </div>
    </header>

    <main class="content-area">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✅ <?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">⚠️ <?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-warning">
                ⚠️
                <ul style="list-style:none; margin:0;">
                    <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</div>

<script>
function updateClock() {
    const now = new Date();
    document.getElementById('clock').textContent =
        now.toLocaleString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}
updateClock();
setInterval(updateClock, 1000);

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
}

if (window.innerWidth <= 768) {
    document.getElementById('menuBtn').style.display = 'block';
}

function formatRupiah(angka) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
}

// Auto-dismiss alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>
</body>
</html>
