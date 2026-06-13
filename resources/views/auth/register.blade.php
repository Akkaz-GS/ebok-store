<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — EbookStore</title>
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
                    <span>Akun aman & terverifikasi</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📚</div>
                    <span>Akses ribuan ebook berkualitas</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⬇️</div>
                    <span>Unduh & baca kapan saja</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⭐</div>
                    <span>Berikan ulasan & rating</span>
                </div>
            </div>
        </div>

        {{-- Kanan --}}
        <div class="col-md-6 right-panel">
            <div class="form-box">
                <h3 class="fw-bold mb-1">Buat Akun Baru</h3>
                <p class="text-muted mb-1" style="font-size:14px">
                    Sudah punya akun? <a href="{{ route('login') }}" style="color:#e94560;text-decoration:none">Masuk di sini →</a>
                </p>

                {{-- Info role --}}
                <div class="alert alert-info py-2 px-3 mb-4" style="font-size:13px;background:#eff6ff;border-color:#bfdbfe;color:#1e40af">
                    <i class="bi bi-info-circle"></i>
                    Daftar sebagai <strong>Pembeli</strong>. Ingin menjadi penjual? Hubungi admin.
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px">Nama Lengkap</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Nama kamu" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="email@kamu.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimal 8 karakter" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:13px">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold">
                        Daftar Sekarang
                    </button>

                    <p class="text-center text-muted mt-3" style="font-size:12px">
                        Dengan mendaftar, kamu menyetujui syarat & ketentuan kami.
                    </p>
                </form>
            </div>
        </div>

    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>