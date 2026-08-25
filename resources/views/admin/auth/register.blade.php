<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBAS Admin - Aktivasi Undangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #084627;
            --primary-gradient: linear-gradient(135deg, #07351e 0%, #0d522d 100%);
            --bg: #f8fafc;
            --surface: #ffffff;
            --border: #cbd5e1;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
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

        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
        }

        /* Stepper header */
        .stepper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            position: relative;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
            transform: translateY(-50%);
        }

        .step-item {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-muted);
            z-index: 2;
            transition: all 0.3s;
        }

        .step-item.active {
            border-color: var(--primary);
            background: var(--primary);
            color: #ffffff;
        }

        .step-item.completed {
            border-color: var(--primary);
            background: #f0fdf4;
            color: var(--primary);
        }

        .btn-primary-custom {
            width: 100%;
            padding: 12px;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-primary-custom:hover {
            opacity: 0.95;
        }

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
        }

        .password-strength {
            display: flex;
            gap: 4px;
            margin-top: 8px;
        }

        .strength-bar {
            height: 4px;
            flex: 1;
            border-radius: 2px;
            background: #cbd5e1;
            transition: background 0.3s;
        }

        .strength-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Password Tooltip */
        .pwd-info-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .pwd-info-icon {
            font-size: 0.85rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .pwd-tooltip {
            position: absolute;
            bottom: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            width: 280px;
            max-width: calc(100vw - 32px);
            background: #1e293b;
            color: #f1f5f9;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 0.78rem;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.2s;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        .pwd-tooltip strong { display: block; margin-bottom: 6px; color: #a7f3d0; }
        .pwd-tooltip ul { list-style: none; padding: 0; margin: 0; }
        .pwd-tooltip ul li { display: flex; align-items: center; gap: 6px; }

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

        <div class="text-center mb-4">
            <h1 class="fw-bold fs-3 text-dark">Aktivasi Admin</h1>
            <p class="text-muted text-sm">Registrasi akun administrator baru via undangan</p>
        </div>

        <div class="auth-card">
            <!-- Stepper -->
            <div class="stepper">
                <div class="step-item active" id="step-dot-1">1</div>
                <div class="step-item" id="step-dot-2">2</div>
                <div class="step-item" id="step-dot-3">3</div>
            </div>

            <form action="{{ route('admin.register') }}" method="POST" id="admin-register-form">
                @csrf

                <!-- STEP 1: Cek Undangan Email -->
                <div id="step-1" class="step-content">
                    <h5 class="fw-bold mb-2">1. Cek Undangan Email</h5>
                    <p class="text-muted text-sm mb-4">Masukkan email yang telah diundang oleh Superadmin/Administrator.</p>

                    <div id="step1-alert" class="alert alert-danger d-none text-sm"></div>

                    <div class="mb-4">
                        <label for="invite_email" class="form-label fw-semibold text-sm">Email Undangan</label>
                        <input type="email" id="invite_email" class="form-control" placeholder="admin@contoh.com" required>
                    </div>

                    <button type="button" class="btn-primary-custom" id="btn-check-email" onclick="verifyEmailInvitation()">
                        Verifikasi Email
                    </button>
                </div>

                <!-- STEP 2: Data Diri -->
                <div id="step-2" class="step-content d-none">
                    <h5 class="fw-bold mb-2">2. Data Diri Administrator</h5>
                    <p class="text-muted text-sm mb-3">Lengkapi informasi profil administrator Anda.</p>

                    <input type="hidden" name="email" id="final_email">

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-sm">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="Nama Administrator">
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-semibold text-sm">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="tel" name="no_hp" id="no_hp" class="form-control" required placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-semibold text-sm">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required placeholder="Alamat lengkap"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary w-50 py-2" onclick="goToStep(1)">Kembali</button>
                        <button type="button" class="btn-primary-custom w-50" onclick="validateStep2()">Lanjut Password</button>
                    </div>
                </div>

                <!-- STEP 3: Password -->
                <div id="step-3" class="step-content d-none">
                    <h5 class="fw-bold mb-2">3. Buat Password</h5>
                    <p class="text-muted text-sm mb-3">Tentukan password aman untuk masuk ke portal admin.</p>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-sm d-flex align-items-center gap-1">
                            Password <span class="text-danger">*</span>
                            <span class="pwd-info-wrap">
                                <i class="bi bi-info-circle pwd-info-icon" id="pwd-info-icon"></i>
                                <div class="pwd-tooltip" id="pwd-tooltip">
                                    <strong>Tips Password Kuat:</strong>
                                    <ul>
                                        <li><i class="bi bi-check2 text-success"></i> Minimal <b>8 karakter</b></li>
                                        <li><i class="bi bi-check2 text-success"></i> Kombinasi <b>huruf & angka</b></li>
                                    </ul>
                                </div>
                            </span>
                        </label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Minimal 8 karakter" required oninput="checkStrength(this.value)">
                            <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="password-strength">
                            <div class="strength-bar" id="bar1"></div>
                            <div class="strength-bar" id="bar2"></div>
                            <div class="strength-bar" id="bar3"></div>
                            <div class="strength-bar" id="bar4"></div>
                        </div>
                        <div class="strength-text" id="strength-text"></div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold text-sm">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary w-50 py-2" onclick="goToStep(2)">Kembali</button>
                        <button type="submit" class="btn-primary-custom w-50">Selesaikan Aktivasi</button>
                    </div>
                </div>
            </form>

            <div class="text-center text-sm text-muted mt-4">
                Sudah aktif? <a href="{{ route('admin.login') }}" class="text-success fw-bold text-decoration-none">Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function goToStep(step) {
            currentStep = step;
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('d-none'));
            document.getElementById(`step-${step}`).classList.remove('d-none');

            document.querySelectorAll('.step-item').forEach((dot, idx) => {
                const stepNum = idx + 1;
                if (stepNum < step) {
                    dot.className = 'step-item completed';
                } else if (stepNum === step) {
                    dot.className = 'step-item active';
                } else {
                    dot.className = 'step-item';
                }
            });
        }

        function verifyEmailInvitation() {
            const emailElem = document.getElementById('invite_email');
            const emailInput = emailElem.value.trim();
            const alertBox = document.getElementById('step1-alert');
            const btn = document.getElementById('btn-check-email');

            // Reset UI State
            emailElem.classList.remove('is-invalid');
            alertBox.classList.add('d-none');
            alertBox.className = 'alert alert-danger d-none text-sm';

            if (!emailInput) {
                emailElem.classList.add('is-invalid');
                alertBox.classList.remove('d-none');
                alertBox.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i> Email wajib diisi.';
                return;
            }

            // Validasi Format Email Sederhana di Frontend
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput)) {
                emailElem.classList.add('is-invalid');
                alertBox.classList.remove('d-none');
                alertBox.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i> Format email tidak valid. Gunakan format seperti nama@contoh.com.';
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Verifikasi...';

            fetch('{{ route("admin.check_invitation") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: emailInput })
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) {
                    throw data;
                }
                return data;
            })
            .then(data => {
                btn.disabled = false;
                btn.innerText = 'Verifikasi Email';

                if (data.status === 'not_found') {
                    emailElem.classList.add('is-invalid');
                    alertBox.classList.remove('d-none');
                    alertBox.innerHTML = `<i class="bi bi-x-circle-fill me-1"></i> ${data.message}`;
                } else if (data.status === 'already_registered') {
                    alertBox.classList.remove('d-none', 'alert-danger');
                    alertBox.classList.add('alert-warning');
                    alertBox.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-1"></i> ${data.message} <br><a href="${data.redirect_url}" class="fw-bold text-dark mt-1 d-inline-block">Klik di sini untuk Login</a>`;
                } else if (data.status === 'valid') {
                    document.getElementById('final_email').value = data.data.email;
                    if (data.data.name) document.getElementById('name').value = data.data.name;
                    if (data.data.no_hp) document.getElementById('no_hp').value = data.data.no_hp;
                    if (data.data.alamat) document.getElementById('alamat').value = data.data.alamat;
                    goToStep(2);
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerText = 'Verifikasi Email';
                emailElem.classList.add('is-invalid');
                alertBox.classList.remove('d-none');
                
                if (err && err.message) {
                    alertBox.innerHTML = `<i class="bi bi-exclamation-circle-fill me-1"></i> ${err.message}`;
                } else {
                    alertBox.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i> Terjadi kesalahan sistem. Silakan coba lagi.';
                }
            });
        }

        function validateStep2() {
            const name = document.getElementById('name').value.trim();
            const no_hp = document.getElementById('no_hp').value.trim();
            const alamat = document.getElementById('alamat').value.trim();

            if (!name || !no_hp || !alamat) {
                alert('Silakan lengkapi semua bidang data diri wajib!');
                return;
            }
            goToStep(3);
        }

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
            const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
            const text = document.getElementById('strength-text');
            const hasLetter = /[a-zA-Z]/.test(value);
            const hasUpper  = /[A-Z]/.test(value);
            const hasLower  = /[a-z]/.test(value);
            const hasNumber = /[0-9]/.test(value);
            const hasSymbol = /[^A-Za-z0-9]/.test(value);
            const isLong    = value.length >= 8;

            let score = 0;
            if (value.length > 0) {
                score = 1;
                if (hasLetter && hasNumber) {
                    score = 2;
                    if (isLong && (hasUpper || hasSymbol)) {
                        score = 3;
                        if (hasUpper && hasLower && hasSymbol) {
                            score = 4;
                        }
                    }
                }
            }

            const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
            const labels = ['Lemah', 'Sedang', 'Cukup Kuat', 'Kuat'];

            bars.forEach((bar, i) => {
                bar.style.background = i < score ? colors[score - 1] : '#cbd5e1';
            });

            if (value.length === 0) text.textContent = '';
            else {
                text.textContent = 'Kekuatan: ' + labels[score - 1];
                text.style.color = colors[score - 1];
            }
        }

        @if ($errors->any())
            goToStep(3);
            const pwdField = document.getElementById('password');
            if (pwdField && pwdField.value) {
                checkStrength(pwdField.value);
            }
        @endif
    </script>
</body>
</html>
