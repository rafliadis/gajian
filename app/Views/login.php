<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — GajiKita</title>
    <meta name="description" content="Login ke Sistem Informasi Penggajian GajiKita. Masukkan kredensial Anda untuk mengakses sistem.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #7c3aed;
            --primary-dark: #6d28d9;
            --primary-light: #a78bfa;
            --accent: #06b6d4;
            --success: #10b981;
            --danger: #ef4444;
            --bg: #060b18;
            --surface: rgba(15, 23, 42, 0.85);
            --border: rgba(148, 163, 184, 0.1);
            --text: #f1f5f9;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            position: relative;
            overflow: hidden;
        }

        /* ── ANIMATED MESH BACKGROUND ── */
        .bg-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(124, 58, 237, 0.25) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 80%, rgba(6, 182, 212, 0.18) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 50% 50%, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            animation: orbFloat 12s ease-in-out infinite;
            pointer-events: none;
        }
        .orb-1 { width: 500px; height: 500px; background: rgba(124, 58, 237, 0.2); top: -150px; left: -150px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: rgba(6, 182, 212, 0.15); bottom: -100px; right: -100px; animation-delay: 4s; animation-direction: reverse; }
        .orb-3 { width: 300px; height: 300px; background: rgba(16, 185, 129, 0.12); top: 40%; left: 60%; animation-delay: 8s; }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(40px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.97); }
        }

        /* Subtle grid overlay */
        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(148,163,184,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148,163,184,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* ── LOGIN CARD ── */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            padding: 20px;
        }

        .login-card {
            background: rgba(13, 21, 38, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 28px;
            padding: 52px 44px;
            box-shadow:
                0 0 0 1px rgba(124, 58, 237, 0.05),
                0 32px 64px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            animation: cardSlideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardSlideUp {
            from { opacity: 0; transform: translateY(50px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── LOGO AREA ── */
        .logo-area {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-img {
            width: 260px;
            height: auto;
            display: block;
            margin: 0 auto 16px;
            filter: brightness(1.1);
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(124, 58, 237, 0.15);
            border: 1px solid rgba(124, 58, 237, 0.3);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 600;
            color: var(--primary-light);
            letter-spacing: 0.05em;
        }

        .logo-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--primary-light);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 10px;
        }

        /* ── ALERTS ── */
        .alert {
            border-radius: 14px;
            padding: 13px 16px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: alertSlide 0.4s ease;
        }
        @keyframes alertSlide { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #6ee7b7;
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 22px; }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 9px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .input-wrapper { position: relative; }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            pointer-events: none;
            z-index: 2;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 14px;
            padding: 15px 48px;
            font-size: 15px;
            color: var(--text);
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: rgba(124, 58, 237, 0.6);
            background: rgba(124, 58, 237, 0.06);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15), 0 0 20px rgba(124, 58, 237, 0.1);
        }

        input::placeholder { color: rgba(148, 163, 184, 0.4); }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 17px;
            color: var(--text-muted);
            user-select: none;
            transition: color 0.2s;
            z-index: 2;
        }
        .password-toggle:hover { color: var(--primary-light); }

        /* ── SUBMIT BUTTON ── */
        .btn-login {
            width: 100%;
            padding: 17px;
            background: linear-gradient(135deg, var(--primary) 0%, #6d28d9 50%, #5b21b6 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.03em;
            box-shadow: 0 8px 24px rgba(124, 58, 237, 0.35);
        }

        /* Shimmer sweep */
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
            transition: left 0.5s ease;
        }
        .btn-login:hover::before { left: 100%; }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(124, 58, 237, 0.45);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* ── FOOTER ── */
        .footer-text {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: rgba(148, 163, 184, 0.5);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 28px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(148, 163, 184, 0.1);
        }
        .divider span {
            font-size: 11px;
            color: rgba(148, 163, 184, 0.4);
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>

<!-- Background layers -->
<div class="bg-mesh"></div>
<div class="bg-grid"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="login-wrapper">
    <div class="login-card">
        <div class="logo-area">
            <img src="<?= base_url('assets/images/LOGO.png') ?>" alt="GajiKita Logo" class="logo-img">
            <span class="logo-badge">SISTEM PENGGAJIAN</span>
            <p class="subtitle">Masukkan kredensial Anda untuk melanjutkan</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                ⚠️ <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                ✅ <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" action="<?= base_url('login/auth') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="credential">Username atau Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">👤</span>
                    <input type="text" id="credential" name="credential"
                           placeholder="Masukkan username atau email"
                           value="<?= esc(old('credential')) ?>" required autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password" required autocomplete="current-password">
                    <span class="password-toggle" id="togglePass" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                Masuk ke Sistem &nbsp;→
            </button>
        </form>

        <div class="footer-text">
            Sistem Informasi Penggajian &nbsp;·&nbsp; v1.0 MVP
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const toggle = document.getElementById('togglePass');
    if (input.type === 'password') {
        input.type = 'text';
        toggle.textContent = '🙈';
    } else {
        input.type = 'password';
        toggle.textContent = '👁️';
    }
}

document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnLogin');
    btn.innerHTML = '<span style="display:inline-block;animation:spin 0.8s linear infinite">⟳</span> &nbsp;Memproses...';
    btn.disabled = true;
});
</script>
</body>
</html>