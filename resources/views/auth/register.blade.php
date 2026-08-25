<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIBAS - Daftar Anggota</title>
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
            align-items: flex-start;
            justify-content: center;
            padding: 30px 20px;
            -webkit-font-smoothing: antialiased;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 480px;
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
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .auth-card .subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        /* Section separator */
        .form-section {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin: 20px 0 12px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border);
        }

        /* Form */
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
            display: block;
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
            width: 100%;
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

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
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

        /* Strength indicator */
        .password-strength {
            display: flex;
            gap: 4px;
            margin-top: 8px;
        }

        .strength-bar {
            height: 3px;
            flex: 1;
            border-radius: 2px;
            background: var(--border);
            transition: background 0.3s;
        }

        .strength-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Submit button */
        .btn-auth {
            width: 100%;
            padding: 13px;
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
            margin-top: 12px;
        }

        .btn-auth:hover { opacity: 0.9; }
        .btn-auth:active { transform: scale(0.99); }

        /* Info box */
        .info-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 0.8rem;
            color: #166534;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 20px;
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
            left: 0; right: 0;
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

        .auth-footer a:hover { text-decoration: underline; }

        .mb-3 { margin-bottom: 14px; }
        .mb-4 { margin-bottom: 20px; }

        /* Password Info Tooltip */
        .pwd-info-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .pwd-info-icon {
            font-size: 0.85rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s;
            user-select: none;
        }

        .pwd-info-icon:hover {
            color: var(--primary);
        }

        .pwd-tooltip {
            position: absolute;
            bottom: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            max-width: calc(100vw - 32px);
            background: #1e293b;
            color: #f1f5f9;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 0.78rem;
            font-weight: 400;
            line-height: 1.5;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            white-space: normal;
        }

        .pwd-tooltip strong {
            display: block;
            margin-bottom: 8px;
            font-size: 0.82rem;
            color: #a7f3d0;
        }

        .pwd-tooltip ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pwd-tooltip ul li {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pwd-tooltip ul li i {
            color: #4ade80;
            flex-shrink: 0;
            font-size: 0.85rem;
        }

        .pwd-tooltip-arrow {
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 12px;
            height: 6px;
            background: #1e293b;
            clip-path: polygon(0 0, 100% 0, 50% 100%);
        }

        /* Show on hover (desktop) */
        .pwd-info-wrap:hover .pwd-tooltip,
        .pwd-tooltip.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
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
            <h2>Daftar sebagai Anggota</h2>
            <p class="subtitle">Isi data di bawah untuk membuat akun baru.</p>

            <!-- <div class="info-box">
                <i class="bi bi-info-circle-fill flex-shrink-0" style="margin-top:1px;"></i>
                <span>Nomor anggota akan dibuat otomatis setelah kamu berhasil mendaftar.</span>
            </div> -->

            <form action="{{ route('register') }}" method="POST" id="register-form" novalidate>
                @csrf

                {{-- Data Pribadi --}}
                <div id="step-1">
                    <div class="form-section">Data Pribadi</div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap <span style="color:#ef4444">*</span></label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                        required
                        maxlength="50"
                    >
                    @error('name')
                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span style="color:#ef4444">*</span></label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        autocomplete="email"
                        required
                        maxlength="100"
                    >
                    @error('email')
                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP <span style="color:#ef4444">*</span></label>
                    <input
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        autocomplete="tel"
                        required
                        maxlength="15"
                    >
                    @error('no_hp')
                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat <span style="color:#ef4444">*</span></label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Masukkan alamat lengkap"
                        rows="3"
                        required
                        maxlength="100"
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="button" class="btn-auth" id="btn-next" onclick="nextStep()">
                    Lanjut <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>

            {{-- Keamanan --}}
            <div id="step-2" style="display: none;">
                <div class="form-section">Keamanan Akun</div>

                <div class="mb-3">
                    <label for="password" class="form-label" style="display:flex;align-items:center;gap:6px;">
                        Password <span style="color:#ef4444">*</span>
                        <span class="pwd-info-wrap" id="pwd-info-wrap">
                            <i class="bi bi-info-circle pwd-info-icon" id="pwd-info-icon"></i>
                            <div class="pwd-tooltip" id="pwd-tooltip" role="tooltip">
                                <strong>Tips Password Kuat:</strong>
                                <ul>
                                    <li><i class="bi bi-check2"></i> Minimal <b>8 karakter</b></li>
                                    <li><i class="bi bi-check2"></i> Mengandung <b>huruf besar</b> (A–Z)</li>
                                    <li><i class="bi bi-check2"></i> Mengandung <b>angka</b> (0–9)</li>
                                    <li><i class="bi bi-check2"></i> Mengandung <b>simbol</b> (!@#$...)</li>
                                </ul>
                                <div class="pwd-tooltip-arrow"></div>
                            </div>
                        </span>
                    </label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            value="{{ old('password') }}"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                            required
                            maxlength="50"
                            oninput="checkStrength(this.value)"
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Tampilkan password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="password-strength" id="strength-bars">
                        <div class="strength-bar" id="bar1"></div>
                        <div class="strength-bar" id="bar2"></div>
                        <div class="strength-bar" id="bar3"></div>
                        <div class="strength-bar" id="bar4"></div>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div class="strength-text" id="strength-text"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span style="color:#ef4444">*</span></label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                            required
                            maxlength="50"
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)" aria-label="Tampilkan konfirmasi password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-2">
                    <button type="button" class="btn-auth bg-secondary mt-0" id="btn-back" onclick="prevStep()" style="flex:1;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </button>
                    <button type="submit" class="btn-auth mt-0" id="btn-register" style="flex:2;">
                        Buat Akun
                    </button>
                </div>
            </div>
            </form>

            <div class="auth-divider">
                <span>sudah punya akun?</span>
            </div>

            <div class="auth-footer">
                <a href="{{ route('login') }}">Masuk sekarang</a>
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

        function checkStrength(value) {
            const bars = [
                document.getElementById('bar1'),
                document.getElementById('bar2'),
                document.getElementById('bar3'),
                document.getElementById('bar4'),
            ];
            const text = document.getElementById('strength-text');

            const hasLetter = /[a-zA-Z]/.test(value);
            const hasUpper  = /[A-Z]/.test(value);
            const hasLower  = /[a-z]/.test(value);
            const hasNumber = /[0-9]/.test(value);
            const hasSymbol = /[^A-Za-z0-9]/.test(value);
            const isLong    = value.length >= 8;

            // Tiered scoring:
            // 1 = Lemah      — ada input tapi belum kombinasi
            // 2 = Sedang     — huruf + angka (sudah ada kombinasi)
            // 3 = Cukup Kuat — huruf + angka + panjang >= 8 + huruf besar atau simbol
            // 4 = Kuat       — semua kriteria terpenuhi
            let score = 0;
            if (value.length > 0) {
                score = 1; // Lemah
                if (hasLetter && hasNumber) {
                    score = 2; // Sedang
                    if (isLong && (hasUpper || hasSymbol)) {
                        score = 3; // Cukup Kuat
                        if (hasUpper && hasLower && hasSymbol) {
                            score = 4; // Kuat
                        }
                    }
                }
            }

            const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
            const labels = ['Lemah', 'Sedang', 'Cukup Kuat', 'Kuat'];

            bars.forEach((bar, i) => {
                bar.style.background = i < score ? colors[score - 1] : '#cbd5e1';
            });

            if (value.length === 0) {
                text.textContent = '';
            } else {
                text.textContent = 'Kekuatan: ' + labels[score - 1];
                text.style.color = colors[score - 1];
            }
        }
        // ── Info tooltip tap toggle (mobile) ──────────────────────
        const infoIcon = document.getElementById('pwd-info-icon');
        const tooltip  = document.getElementById('pwd-tooltip');

        if (infoIcon && tooltip) {
            function clampTooltip() {
                // Reset ke posisi default dulu
                tooltip.style.left = '50%';
                tooltip.style.transform = 'translateX(-50%)';

                requestAnimationFrame(function () {
                    const rect   = tooltip.getBoundingClientRect();
                    const margin = 16;

                    if (rect.left < margin) {
                        // Overflow ke kiri — geser ke kanan
                        const wrapLeft = tooltip.parentElement.getBoundingClientRect().left;
                        tooltip.style.left      = (margin - wrapLeft) + 'px';
                        tooltip.style.transform = 'none';
                    } else if (rect.right > window.innerWidth - margin) {
                        // Overflow ke kanan — geser ke kiri
                        const excess = rect.right - (window.innerWidth - margin);
                        tooltip.style.left      = '50%';
                        tooltip.style.transform = `translateX(calc(-50% - ${excess}px))`;
                    }
                });
            }

            infoIcon.addEventListener('click', function (e) {
                e.stopPropagation();
                tooltip.classList.toggle('is-open');
                if (tooltip.classList.contains('is-open')) {
                    clampTooltip();
                }
            });

            // Close when tapping anywhere else
            document.addEventListener('click', function () {
                tooltip.classList.remove('is-open');
            });

            // Prevent closing when clicking inside tooltip
            tooltip.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }

        // Trigger strength meter saat load (jika ada old password)
        const pwdField = document.getElementById('password');
        if (pwdField && pwdField.value) {
            checkStrength(pwdField.value);
        }

        function nextStep() {
            const form = document.getElementById('register-form');
            const formData = new FormData(form);
            
            // clear previous step-1 errors
            document.querySelectorAll('#step-1 .is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('#step-1 .invalid-feedback').forEach(el => el.remove());

            const btnNext = document.getElementById('btn-next');
            const originalText = btnNext.innerHTML;
            btnNext.innerHTML = 'Memeriksa...';
            btnNext.disabled = true;

            fetch('{{ route('register.validate_step1') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok && response.status !== 422) {
                    throw new Error('Terjadi kesalahan jaringan.');
                }
                return response.json();
            })
            .then(data => {
                btnNext.innerHTML = originalText;
                btnNext.disabled = false;

                if (data.errors) {
                    for (const field in data.errors) {
                        const input = document.getElementById(field);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> ' + data.errors[field][0];
                            input.parentNode.appendChild(errorDiv);
                        }
                    }
                } else if (data.success) {
                    document.getElementById('step-1').style.display = 'none';
                    document.getElementById('step-2').style.display = 'block';
                }
            })
            .catch(error => {
                btnNext.innerHTML = originalText;
                btnNext.disabled = false;
                alert(error.message);
            });
        }

        function prevStep() {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-1').style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->has('password') || $errors->has('password_confirmation'))
                document.getElementById('step-1').style.display = 'none';
                document.getElementById('step-2').style.display = 'block';
            @endif
        });
    </script>
</body>
</html>
