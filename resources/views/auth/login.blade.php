<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIBAS - Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #084627;
            --primary-dark: #063a20;
            --primary-gradient: linear-gradient(135deg, #07351e 0%, #0d522d 100%);
            --bg: #f1f5f9;
            --surface: #ffffff;
            --border: #cbd5e1;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* Institutional Logos Banner */
        .institutional-banner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .institutional-banner img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .institutional-banner .ib-divider {
            width: 1px;
            height: 32px;
            background: #cbd5e1;
            flex-shrink: 0;
        }

        .institutional-banner .ib-text {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--text-muted);
            line-height: 1.45;
            text-align: left;
            max-width: 160px;
        }

        @media (max-width: 400px) {
            .institutional-banner {
                gap: 10px;
            }
            .institutional-banner img {
                height: 32px;
            }
            .institutional-banner .ib-text {
                font-size: 0.6rem;
                max-width: 120px;
            }
            .institutional-banner .ib-divider {
                height: 26px;
            }
        }

        /* Logo Area */
        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 54px;
            height: 54px;
            background: var(--primary-gradient);
            border-radius: 4px 16px 4px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(8, 70, 39, 0.25);
            flex-shrink: 0;
        }

        .logo-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .logo-text {
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-logo h1 {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.5px;
            line-height: 1;
            margin-bottom: 4px;
        }

        .auth-logo p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
            font-weight: 500;
        }

        /* Card */
        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        .auth-card h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .auth-card .subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        /* Form */
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.9rem;
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background: #f8fafc;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(8, 70, 39, 0.1);
            background: white;
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            background: #fff8f8;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Password toggle */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 44px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 1rem;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        /* Submit button */
        .btn-auth {
            width: 100%;
            padding: 12px;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            letter-spacing: 0.2px;
            margin-top: 8px;
        }

        .btn-auth:hover {
            opacity: 0.9;
        }

        .btn-auth:active {
            transform: scale(0.99);
        }

        /* Alert error */
        .auth-alert {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 0.875rem;
            color: #be123c;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        /* Divider */
        .auth-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border);
        }

        .auth-divider span {
            position: relative;
            background: var(--surface);
            padding: 0 12px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Footer link */
        .auth-footer {
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .mb-3 { margin-bottom: 16px; }
        .mb-4 { margin-bottom: 20px; }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-card {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <!-- Institutional Logos Banner -->
        <div class="institutional-banner">
            <img src="{{ asset('images/kemendiksaintek.png') }}" alt="Kemdiktisaintek">
            <img src="{{ asset('images/unmer_malang.png') }}" alt="Universitas Merdeka Malang">
            <img src="{{ asset('images/um.png') }}" alt="Universitas Negeri Malang">
            <div class="ib-divider"></div>
            <div class="ib-text">Program Hibah Pengabdian kepada Masyarakat DPPM 2026</div>
        </div>

        <!-- Logo -->
        <div class="auth-logo">
            <div class="logo-icon">
                <i class="bi bi-recycle"></i>
            </div>
            <div class="logo-text">
                <h1>SIBAS</h1>
                <p>Sistem Bank Sampah</p>
            </div>
        </div>

        <!-- Card -->
        <div class="auth-card">
            <h2>Masuk ke Akun</h2>
            <p class="subtitle">Silakan masukkan email atau nomor HP kamu.</p>

            @if (session('error'))
                <div class="auth-alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="login-form">
                @csrf

                {{-- Email / Nomor HP --}}
                <div class="mb-3">
                    <label for="login" class="form-label">Email atau Nomor HP</label>
                    <input
                        type="text"
                        id="login"
                        name="login"
                        class="form-control @if($errors->has('login') || $errors->has('email')) is-invalid @endif"
                        value="{{ old('login', old('email')) }}"
                        placeholder="contoh@email.com atau 08123456789"
                        autocomplete="username"
                        autofocus
                    >
                    @error('login')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    @if (!$errors->has('login'))
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    @endif
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Tampilkan password">
                            <i class="bi bi-eye" id="password-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-auth" id="btn-login">
                    Masuk
                </button>
            </form>

            <div class="auth-divider">
                <span>belum punya akun?</span>
            </div>

            <div class="auth-footer">
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>
