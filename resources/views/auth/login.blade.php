<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — EbookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f7f4; }
        .brand span { color: #e94560; }
        .left-panel { background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); min-height: 100vh; display: flex; flex-direction: column; justify-content: center; padding: 60px; color: #fff; }
        .right-panel { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px; }
        .form-box { width: 100%; max-width: 400px; }
        .btn-danger { background: #e94560; border-color: #e94560; }
        .btn-danger:hover { background: #c62a47; border-color: #c62a47; }
        .feature-item { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; font-size: 14px; color: rgba(255,255,255,.8); }
        .feature-icon { width: 36px; height: 36px; background: rgba(255,255,255,.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">

        {{-- Kiri --}}
        <div class="col-md-6 d-none d-md-flex left-panel">
            <div>
                <h2 class="brand fw-bold mb-2" style="font-size:28px">📚 Ebook<span>Store</span></h2>
                <p style="color:rgba(255,255,255,.6);font-size:15px;margin-bottom:40px">
                    Platform jual beli ebook digital terpercaya.<br>Mulai belajar, mulai berkembang.
                </p>
                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <span>Pembayaran aman & terverifikasi</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⬇️</div>
                    <span>Unduh ebook selamanya setelah beli</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📈</div>
                    <span>Dashboard lengkap untuk penjual</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⚙️</div>
                    <span>Kontrol penuh untuk admin</span>
                </div>
            </div>
        </div>

        {{-- Kanan --}}
        <div class="col-md-6 right-panel">
            <div class="form-box">
                <h3 class="fw-bold mb-1">Masuk ke Akun</h3>
                <p class="text-muted mb-4" style="font-size:14px">
                    Belum punya akun? <a href="{{ route('register') }}" style="color:#e94560;text-decoration:none">Daftar gratis →</a>
                </p>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 mb-3" style="font-size:13px">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="email@kamu.com" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold" style="font-size:13px">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-muted" for="remember" style="font-size:13px">
                                Ingat saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               style="font-size:13px;color:#e94560;text-decoration:none">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                        Masuk →
                    </button>

                    <p class="text-center text-muted mt-3" style="font-size:12px">
                        Dengan masuk, kamu menyetujui syarat & ketentuan kami.
                    </p>
                </form>

                {{-- Demo accounts hint --}}
                <hr class="my-3">
                <p class="text-muted text-center mb-2" style="font-size:12px">Akun demo:</p>
                <div style="font-size:11px;color:#6b7280;text-align:center;line-height:2">
                    <code>admin@ebook.com</code> · <code>penjual@ebook.com</code> · <code>pembeli@ebook.com</code><br>
                    Password semua: <code>password</code>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>