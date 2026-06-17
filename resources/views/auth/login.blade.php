<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - EbookStore</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #1c2230;
            --bg-cream: #f8f6f1;
            --accent: #a3253f;
            --accent-dark: #882035;
            --text-dark: #20242f;
            --text-muted: #8b8d98;
            --input-bg: #eef1f6;
            --border-light: #e3e0d8;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== Left panel ===== */
        .auth-visual {
            flex: 1.1;
            position: relative;
            background:
                radial-gradient(circle at 20% 25%, rgba(163, 37, 63, 0.18), transparent 50%),
                linear-gradient(160deg, #2a3146 0%, #14171f 75%);
            color: #fff;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .auth-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                115deg,
                rgba(255, 255, 255, 0.03) 0px,
                rgba(255, 255, 255, 0.03) 1px,
                transparent 1px,
                transparent 64px
            );
            pointer-events: none;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.25rem;
            z-index: 1;
        }

        .brand i { font-size: 1.5rem; }

        .visual-content {
            max-width: 460px;
            z-index: 1;
        }

        .visual-content h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.25rem;
            line-height: 1.25;
            margin-bottom: 16px;
        }

        .visual-content p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        .visual-footer {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.35);
            z-index: 1;
        }

        /* ===== Right panel ===== */
        .auth-form-panel {
            flex: 1;
            background: var(--bg-cream);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
        }

        .auth-form-container { width: 100%; max-width: 420px; }

        .auth-form-container h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.9rem;
            margin-bottom: 6px;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 0.92rem;
            margin-bottom: 28px;
        }

        .form-label { font-weight: 500; font-size: 0.9rem; }

        .input-icon-group { position: relative; display: flex; align-items: center; }

        .input-icon-group > i {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
        }

        .input-icon-group .form-control {
            padding-left: 40px;
            background: var(--input-bg);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            height: 48px;
            font-size: 0.92rem;
            width: 100%;
        }

        .input-icon-group .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(163, 37, 63, 0.12);
            background: #fff;
            outline: none;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            left: auto;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover { text-decoration: underline; }

        .form-check-label { font-size: 0.9rem; color: #555; }

        .btn-signin {
            background: var(--accent);
            border: none;
            color: #fff;
            font-weight: 600;
            height: 48px;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: background 0.2s ease;
        }

        .btn-signin:hover { background: var(--accent-dark); color: #fff; }

        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            color: var(--text-muted);
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-light);
        }

        .divider span { padding: 0 12px; white-space: nowrap; }

        .social-buttons { display: flex; gap: 12px; }

        .btn-social {
            flex: 1;
            background: #fff;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            height: 46px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-social:hover { background: #f4f2ed; }

        .signup-text {
            text-align: center;
            margin-top: 24px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .signup-text a {
            color: var(--accent);
            font-weight: 500;
            text-decoration: none;
        }

        .signup-text a:hover { text-decoration: underline; }

        @media (max-width: 900px) {
            .auth-visual { display: none; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">

        {{-- Left: brand panel --}}
        <div class="auth-visual">
            <div class="brand">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>EbookStore</span>
            </div>

            <div class="visual-content">
                <h1>The world's premium digital repository.</h1>
                <p>
                    Akses ribuan judul ebook dari berbagai genre. Perjalanan literasi Anda
                    berlanjut di sini dengan alat baca yang nyaman dan pengalaman marketplace
                    yang aman.
                </p>
            </div>

            <div class="visual-footer">
                &copy; {{ date('Y') }} EbookStore. All rights reserved.
            </div>
        </div>

        {{-- Right: form panel --}}
        <div class="auth-form-panel">
            <div class="auth-form-container">
                <h2>Sign In</h2>
                <p class="subtitle">Masukkan kredensial Anda untuk mengakses pustaka.</p>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 small">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email Address --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-icon-group">
                            <i class="bi bi-envelope"></i>
                            <input id="email" type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="name@company.com"
                                   required autofocus autocomplete="username">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label mb-0">Password</label>
                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        <div class="input-icon-group mt-1">
                            <i class="bi bi-lock"></i>
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required autocomplete="current-password">
                            <i class="bi bi-eye toggle-password" onclick="togglePassword()"></i>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Remember Me on this device
                        </label>
                    </div>

                    <button type="submit" class="btn btn-signin w-100">Sign In</button>
                </form>

                <div class="divider"><span>OR CONTINUE WITH</span></div>

                <div class="social-buttons">
                    <button type="button" class="btn btn-social">
                        <i class="bi bi-google"></i> Google
                    </button>
                    <button type="button" class="btn btn-social">
                        <i class="bi bi-apple"></i> Apple ID
                    </button>
                </div>

                <p class="signup-text">
                    New to EbookStore?
                    <a href="{{ route('register') }}">Create an account</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            const isHidden = pwd.type === 'password';
            pwd.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isHidden);
            icon.classList.toggle('bi-eye-slash', isHidden);
        }
    </script>
</body>
</html>