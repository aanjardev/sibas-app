<!DOCTYPE html>
<html lang="id">
<head>
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

        /* Logo Area */
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: var(--primary-gradient);
            border-radius: 4px 20px 4px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px auto;
            box-shadow: 0 6px 20px rgba(8, 70, 39, 0.3);
        }

        .logo-icon i {
            font-size: 1.8rem;
            color: white;
        }

        .auth-logo h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .auth-logo p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 4px;
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
        <!-- Logo -->
        <div class="auth-logo">
            <div class="logo-icon">
                <i class="bi bi-recycle"></i>
            </div>
            <h1>SIBAS</h1>
            <p>Sistem Bank Sampah</p>
        </div>

        <!-- Card -->
        <div class="auth-card">
            <h2>Masuk ke Akun</h2>
            <p class="subtitle">Selamat datang kembali! Masukkan data kamu.</p>

            {{-- Global error --}}
            @if ($errors->has('email') && !$errors->has('email'))
                {{-- handled inline --}}
            @endif

            @if (session('error'))
                <div class="auth-alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="login-form">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        autocomplete="email"
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
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
