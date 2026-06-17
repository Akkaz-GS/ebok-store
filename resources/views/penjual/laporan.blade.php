@extends('layouts.seller')

@section('title', 'Laporan')
@section('search-placeholder', 'Cari laporan...')

@push('styles')
<style>
    .chart-bars-h { display:flex; align-items:flex-end; gap:7px; height:110px; }
    .chart-bar-h  {
        flex:1; border-radius:3px 3px 0 0; min-height:3px;
        background:#fce4e4; cursor:pointer; transition:background .15s;
    }
    .chart-bar-h:hover { background:var(--primary); }
    .chart-bar-h.active { background:var(--primary); }

    .donut {
        width:130px; height:130px;
        border-radius:50%;
        background: conic-gradient(
            var(--primary) 0% 45%,
            #374151 45% 75%,
            #d1d5db 75% 100%
        );
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 12px;
    }
    .donut-hole {
        width:84px; height:84px;
        border-radius:50%;
        background:#fff;
        display:flex; align-items:center; justify-content:center;
        flex-direction:column;
    }

    .highlight-card {
        background: var(--primary);
        border-radius: var(--card-radius);
        padding: 20px;
        color: #fff;
        height: 100%;
    }
    .highlight-card .lbl { font-size:.7rem; letter-spacing:.08em; text-transform:uppercase; opacity:.7; }
    .highlight-card .ttl { font-size:1.2rem; font-weight:800; margin:8px 0 4px; line-height:1.25; }
    .highlight-card .by  { font-size:.76rem; opacity:.65; margin-bottom:14px; }
    .highlight-card hr   { border-color:rgba(255,255,255,.2); margin:12px 0; }
    .highlight-card .num { font-size:1.4rem; font-weight:800; }
    .highlight-card .sub { font-size:.7rem; opacity:.65; }

    .legend-item { display:flex; align-items:center; justify-content:space-between; padding:4px 0; }
    .legend-dot  { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
</style>
@endpush

@section('content')
<div class="page-header d-flex align-items-start justify-content-between">
    <div>
        <h4>Laporan Penjualan</h4>
        <p>Ringkasan performa dan analitik ebook kamu</p>
    </div>
    <a href="#" class="btn-outline-gray"><i class="bi bi-download"></i> Export CSV</a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-pink"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-change text-up">+12.5%</div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value" style="font-size:1.25rem;">
                Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
            </div>
            <div style="font-size:.71rem;color:#6b7280;margin-top:3px;">
                dari {{ number_format($totalSalesCount ?? 0) }} transaksi
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-yellow"><i class="bi bi-star"></i></div>
            <div class="stat-change" style="color:#6b7280;">{{ $reviewCount ?? 0 }} ulasan</div>
            <div class="stat-label">Rating Rata-rata</div>
            <div class="stat-value">{{ number_format($avgRating ?? 0, 1) }}<span style="font-size:.85rem;color:#6b7280;font-weight:400;"> /5.0</span></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-blue"><i class="bi bi-collection"></i></div>
            <div class="stat-change" style="color:#6b7280;">{{ $categoryCount ?? 0 }} kategori</div>
            <div class="stat-label">Judul Aktif</div>
            <div class="stat-value">{{ $activeTitles ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon-wrap icon-green"><i class="bi bi-arrow-return-left"></i></div>
            <div class="stat-change text-up" style="font-size:.71rem;">Benchmark 2.10%</div>
            <div class="stat-label">Tingkat Refund</div>
            <div class="stat-value">{{ number_format($refundRate ?? 0, 2) }}%</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Monthly Chart --}}
    <div class="col-lg-7">
        <div class="content-card h-100">
            <div class="content-card-header">
                <div>
                    <h5>Performa Penjualan Bulanan</h5>
                    <p class="sub">Pertumbuhan pendapatan year-to-date</p>
                </div>
                <select class="form-select form-select-sm" style="width:auto;font-size:.78rem;">
                    <option>6 Bulan Terakhir</option>
                    <option>12 Bulan Terakhir</option>
                </select>
            </div>
            <div class="p-4">
                @php
                    $m6   = ['Jan','Feb','Mar','Apr','Mei','Jun'];
                    $d6   = $monthlySales6 ?? [0,0,0,0,0,0];
                    $max6 = max($d6) ?: 1;
                    $curI = min((int)date('n') - 1, 5);
                @endphp
                <div class="chart-bars-h">
                    @foreach($d6 as $i => $v)
                        <div class="chart-bar-h {{ $i === $curI ? 'active' : '' }}"
                             style="height:{{ max(round(($v/$max6)*100), 3) }}%"
                             title="{{ $m6[$i] }}: {{ $v }}"></div>
                    @endforeach
                </div>
                <div style="display:flex;gap:7px;margin-top:6px;">
                    @foreach($m6 as $i => $m)
                        <span style="flex:1;text-align:center;font-size:.66rem;
                                     color:{{ $i===$curI ? 'var(--primary)' : '#9ca3af' }};
                                     font-weight:{{ $i===$curI ? '700':'400' }};">{{ $m }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Donut --}}
    <div class="col-lg-5">
        <div class="content-card h-100">
            <div class="content-card-header"><h5>Pendapatan per Kategori</h5></div>
            <div class="p-4">
                <div class="donut">
                    <div class="donut-hole">
                        <div style="font-size:.68rem;color:#6b7280;text-align:center;line-height:1.4;">100%<br>Share</div>
                    </div>
                </div>
                @php
                    $catColors = ['#c0392b','#374151','#d1d5db','#6366f1','#f59e0b'];
                    $cats = $categoryRevenue ?? [
                        ['name'=>'Bisnis & Keuangan','pct'=>45],
                        ['name'=>'Self-Help','pct'=>30],
                        ['name'=>'Teknologi','pct'=>25],
                    ];
                @endphp
                <div class="d-flex flex-column gap-1 mt-2">
                    @foreach($cats as $i => $cat)
                        <div class="legend-item">
                            <div class="d-flex align-items-center gap-2">
                                <div class="legend-dot" style="background:{{ $catColors[$i] ?? '#ccc' }};"></div>
                                <span style="font-size:.81rem;color:#374151;">{{ $cat['name'] }}</span>
                            </div>
                            <span style="font-size:.81rem;font-weight:700;color:#111;">{{ $cat['pct'] }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- MVP --}}
    <div class="col-lg-4">
        <div class="highlight-card">
            <div class="lbl">Produk Terbaik</div>
            <div class="ttl">{{ $mvpEbook->title ?? 'Belum ada data' }}</div>
            <div class="by">Oleh {{ auth()->user()->name }}</div>
            <hr>
            <div class="d-flex gap-4 mb-4">
                <div>
                    <div class="num">{{ number_format($mvpEbook->orders_count ?? 0) }}</div>
                    <div class="sub">Terjual bulan ini</div>
                </div>
                <div>
                    <div class="num">Rp {{ number_format(($mvpEbook->orders_count ?? 0) * ($mvpEbook->price ?? 0) * .7, 0, ',', '.') }}</div>
                    <div class="sub">Estimasi royalti</div>
                </div>
            </div>
            <a href="{{ isset($mvpEbook) ? route('penjual.ebook.edit', $mvpEbook->id) : '#' }}"
               style="display:block;text-align:center;padding:9px;border-radius:6px;
                      border:1.5px solid rgba(255,255,255,.6);color:#fff;font-size:.82rem;
                      font-weight:700;text-decoration:none;transition:all .15s;"
               onmouseover="this.style.background='rgba(255,255,255,.15)'"
               onmouseout="this.style.background='transparent'">
                Optimasi Listing
            </a>
        </div>
    </div>

    {{-- Performa Terbaru --}}
    <div class="col-lg-8">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h5>Performa Ebook Terbaru</h5>
                <a href="#" class="btn-outline-gray" style="font-size:.76rem;padding:5px 10px;">
                    <i class="bi bi-download"></i> Export
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>JUDUL</th>
                            <th class="text-center">TREN</th>
                            <th>PENDAPATAN</th>
                            <th>RATING</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPerformance ?? [] as $ebook)
                            <tr>
                                <td>
                                    <div style="font-weight:600;font-size:.83rem;">{{ Str::limit($ebook->title, 30) }}</div>
                                    <div style="font-size:.72rem;color:#6b7280;">{{ $ebook->category->nama ?? '-' }}</div>
                                </td>
                                <td class="text-center">
                                    @php $trend = $ebook->trend ?? 'stable'; @endphp
                                    @if($trend === 'up')
                                        <i class="bi bi-graph-up-arrow" style="color:#16a34a;"></i>
                                    @elseif($trend === 'down')
                                        <i class="bi bi-graph-down-arrow" style="color:#dc2626;"></i>
                                    @else
                                        <i class="bi bi-arrow-right" style="color:#6b7280;"></i>
                                    @endif
                                </td>
                                <td style="font-weight:600;font-size:.83rem;">
                                    Rp {{ number_format($ebook->revenue ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span style="font-weight:700;color:var(--primary);">
                                        {{ number_format($ebook->avg_rating ?? 0, 1) }}
                                    </span>
                                    <i class="bi bi-star-fill" style="color:#f59e0b;font-size:.7rem;"></i>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4" style="font-size:.82rem;">
                                    Belum ada data laporan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
