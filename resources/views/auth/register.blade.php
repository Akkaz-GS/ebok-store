<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - EbookStore</title>

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
            flex: 1.05;
            position: relative;
            background:
                radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.06), transparent 55%),
                linear-gradient(160deg, #2e3650 0%, #14171f 80%);
            color: #fff;
            padding: 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
        }

        .visual-pattern {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                90deg,
                rgba(255, 255, 255, 0.025) 0px,
                rgba(255, 255, 255, 0.025) 2px,
                transparent 2px,
                transparent 70px
            );
            pointer-events: none;
        }

        .visual-main { z-index: 1; }

        .brand-large {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 36px;
        }

        .visual-main h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.4rem;
            line-height: 1.25;
            margin-bottom: 20px;
            max-width: 520px;
        }

        .visual-desc {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.98rem;
            line-height: 1.7;
            max-width: 480px;
            margin-bottom: 40px;
        }

        .feature-item {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            max-width: 480px;
        }

        .feature-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(163, 37, 63, 0.18);
            color: #f3a9b8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .feature-title {
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.06em;
            margin-bottom: 4px;
        }

        .feature-desc {
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.88rem;
            line-height: 1.5;
        }

        .visual-footer {
            position: absolute;
            bottom: 32px;
            left: 56px;
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

        .auth-form-container { width: 100%; max-width: 440px; }

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

        .form-label-upper {
            font-weight: 600;
            font-size: 0.72rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-dark);
            display: block;
            margin-bottom: 6px;
        }

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

        .terms-check {
            font-size: 0.88rem;
            color: #555;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .terms-check input { margin-top: 4px; }

        .terms-check a {
            color: var(--accent);
            font-weight: 500;
            text-decoration: none;
        }

        .terms-check a:hover { text-decoration: underline; }

        .btn-signup {
            background: var(--accent);
            border: none;
            color: #fff;
            font-weight: 600;
            height: 50px;
            border-radius: 8px;
            font-size: 0.85rem;
            letter-spacing: 0.08em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s ease;
        }

        .btn-signup:hover { background: var(--accent-dark); color: #fff; }

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
            font-weight: 600;
            text-decoration: none;
        }

        .signup-text a:hover { text-decoration: underline; }

        .trusted-text {
            text-align: center;
            margin-top: 32px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @media (max-width: 900px) {
            .auth-visual { display: none; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">

        {{-- Left: brand panel --}}
        <div class="auth-visual">
            <div class="visual-pattern"></div>

            <div class="visual-main">
                <div class="brand-large">EbookStore</div>

                <h1>Start your literary journey today.</h1>
                <p class="visual-desc">
                    Bergabunglah dengan komunitas pembaca yang terus bertumbuh. Akses edisi
                    eksklusif, daftar bacaan tersinkronisasi, dan rekomendasi personal dari
                    kurator kami.
                </p>

                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-book"></i></div>
                    <div>
                        <div class="feature-title">UNLIMITED ACCESS</div>
                        <div class="feature-desc">
                            Jelajahi ribuan judul premium dari berbagai genre.
                        </div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-phone"></i></div>
                    <div>
                        <div class="feature-title">CROSS-DEVICE SYNC</div>
                        <div class="feature-desc">
                            Baca di tablet, ponsel, atau desktop dengan progres yang selalu
                            tersinkron.
                        </div>
                    </div>
                </div>
            </div>

            <div class="visual-footer">
                &copy; {{ date('Y') }} EbookStore. All rights reserved.
            </div>
        </div>

        {{-- Right: form panel --}}
        <div class="auth-form-panel">
            <div class="auth-form-container">
                <h2>Create Account</h2>
                <p class="subtitle">Bergabung dengan marketplace digital kami.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label-upper">Full Name</label>
                        <div class="input-icon-group">
                            <i class="bi bi-person"></i>
                            <input id="name" type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="John Doe"
                                   required autofocus autocomplete="name">
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email Address --}}
                    <div class="mb-3">
                        <label for="email" class="form-label-upper">Email Address</label>
                        <div class="input-icon-group">
                            <i class="bi bi-envelope"></i>
                            <input id="email" type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="name@example.com"
                                   required autocomplete="username">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password & Confirm --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="password" class="form-label-upper">Password</label>
                            <div class="input-icon-group">
                                <i class="bi bi-lock"></i>
                                <input id="password" type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="••••••••"
                                       required autocomplete="new-password">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="password_confirmation" class="form-label-upper">Confirm</label>
                            <div class="input-icon-group">
                                <i class="bi bi-shield-check"></i>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       class="form-control"
                                       placeholder="••••••••"
                                       required autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="terms-check mb-3">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-signup w-100">
                        SIGN UP <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <div class="divider"><span>OR CONTINUE WITH</span></div>

                <div class="social-buttons">
                    <button type="button" class="btn btn-social">
                        <i class="bi bi-google"></i> Google
                    </button>
                    <button type="button" class="btn btn-social">
                        <i class="bi bi-github"></i> GitHub
                    </button>
                </div>

                <p class="signup-text">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign In</a>
                </p>

                <p class="trusted-text">Trusted by educational institutions worldwide.</p>
            </div>
        </div>
    </div>
</body>
</html>