<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ $rabInfo->Kegiatan }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2c3e50;
            line-height: 1.6;
            padding: 2rem;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--primary-gradient);
        }

        .header {
            background: var(--primary-gradient);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .header h2 {
            font-size: 1.5rem;
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .header-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .content {
            padding: 3rem 2rem;
        }

        .info-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 3rem;
            border-left: 5px solid #667eea;
        }

        .info-section h3 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .info-section h3 i {
            margin-right: 0.5rem;
            color: #667eea;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: #7f8c8d;
        }

        .info-value {
            font-weight: 600;
            color: #2c3e50;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1.2rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        thead th {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            position: relative;
        }

        thead th i {
            margin-right: 0.5rem;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }

        td:nth-child(3), td:nth-child(4), td:nth-child(5) {
            text-align: right;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 500;
        }

        .total-row {
            font-weight: 700;
            background: linear-gradient(135deg, #ecf0f1 0%, #d5dbdb 100%);
            border-top: 3px solid #667eea;
        }

        .positive {
            color: #27ae60;
            font-weight: 600;
        }

        .negative {
            color: #e74c3c;
            font-weight: 600;
        }

        .actions {
            text-align: center;
            margin-top: 3rem;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 15px;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            margin: 0 0.5rem;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(149, 165, 166, 0.4);
        }

        .btn-success {
            background: var(--success-gradient);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
        }

        .code-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .amount {
            font-weight: 600;
            font-size: 1rem;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .actions {
                display: none;
            }
            
            .header::before {
                display: none;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .header {
                padding: 2rem 1rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .header h2 {
                font-size: 1.2rem;
            }
            
            .content {
                padding: 2rem 1rem;
            }
            
            .header-stats {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.85rem;
            }
            
            th, td {
                padding: 0.8rem 0.5rem;
            }
            
            .btn {
                display: block;
                margin: 0.5rem 0;
            }
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <h1><i class="fas fa-chart-line me-3"></i>Laporan Anggaran & Realisasi</h1>
                <h2>{{ $rabInfo->Kegiatan }}</h2>
                
                <div class="header-stats">
                    <div class="stat-card">
                        <div class="stat-number">{{ $rabInfo->NOMOR_RAB }}</div>
                        <div class="stat-label">Nomor RAB</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $rabInfo->TANGGAL_RAP->format('d M Y') }}</div>
                        <div class="stat-label">Tanggal RAB</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">Rp {{ number_format($totalRab / 1000000, 1) }}M</div>
                        <div class="stat-label">Total RAB</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">Rp {{ number_format($totalRealization / 1000000, 1) }}M</div>
                        <div class="stat-label">Total Realisasi</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="info-section">
                <h3><i class="fas fa-info-circle"></i>Informasi RAB</h3>
                <div class="info-grid">
                    <div>
                        <div class="info-item">
                            <span class="info-label">Nomor RAB:</span>
                            <span class="info-value">{{ $rabInfo->NOMOR_RAB }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Kegiatan:</span>
                            <span class="info-value">{{ $rabInfo->Kegiatan }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="info-item">
                            <span class="info-label">Tanggal RAB:</span>
                            <span class="info-value">{{ $rabInfo->TANGGAL_RAP->format('d F Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status:</span>
                            <span class="info-value">
                                @if($totalSelisih >= 0)
                                    <span class="positive">✓ Hemat</span>
                                @else
                                    <span class="negative">⚠ Over Budget</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i>Kode Anggaran</th>
                            <th><i class="fas fa-tag"></i>Nama</th>
                            <th><i class="fas fa-file-invoice-dollar"></i>RAB</th>
                            <th><i class="fas fa-clipboard-check"></i>Realisasi</th>
                            <th><i class="fas fa-balance-scale"></i>Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $item)
                        <tr>
                            <td>
                                <span class="code-badge">{{ $item->Kode_Anggaran }}</span>
                            </td>
                            <td>
                                <strong>{{ $item->Nama }}</strong>
                                @if($item->Nama_Anggaran)
                                    <br><small class="text-muted">{{ $item->Nama_Anggaran }}</small>
                                @endif
                            </td>
                            <td class="amount">Rp {{ number_format($item->RAB, 0, ',', '.') }}</td>
                            <td class="amount">Rp {{ number_format($item->Realisasi, 0, ',', '.') }}</td>
                            <td class="amount {{ $item->Selisih >= 0 ? 'positive' : 'negative' }}">
                                @if($item->Selisih >= 0)
                                    <i class="fas fa-arrow-up me-1"></i>
                                @else
                                    <i class="fas fa-arrow-down me-1"></i>
                                @endif
                                Rp {{ number_format(abs($item->Selisih), 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="2">
                                <strong><i class="fas fa-calculator me-2"></i>TOTAL</strong>
                            </td>
                            <td class="amount">
                                <strong>Rp {{ number_format($totalRab, 0, ',', '.') }}</strong>
                            </td>
                            <td class="amount">
                                <strong>Rp {{ number_format($totalRealization, 0, ',', '.') }}</strong>
                            </td>
                            <td class="amount {{ $totalSelisih >= 0 ? 'positive' : 'negative' }}">
                                <strong>
                                    @if($totalSelisih >= 0)
                                        <i class="fas fa-check-circle me-1"></i>
                                    @else
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                    @endif
                                    Rp {{ number_format(abs($totalSelisih), 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="actions">
                <a href="{{ route('rab.detail', $rabInfo->NOMOR_RAB) }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                </a>
                <a href="{{ route('rab.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list me-2"></i>Daftar RAB
                </a>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        function printReport() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<div class="loading me-2"></div>Menyiapkan...';
            btn.disabled = true;
            
            setTimeout(() => {
                window.print();
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 1000);
        }
    </script>
</body>
</html>
