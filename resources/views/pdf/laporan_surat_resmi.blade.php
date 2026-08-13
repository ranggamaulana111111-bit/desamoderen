<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Desa - {{ $laporan->judul }}</title>
    <style>
        @page { margin: 30px 30px 40px 30px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.7;
            color: #000;
            padding: 0 40px 50px 40px;
        }
        p { text-indent: 1.2cm; margin-bottom: 8px; text-align: justify; }

        /* ── KOP SURAT ── */
        .kop { text-align: center; margin-bottom: 2px; }
        .kop .gov-line { font-size: 12pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1px; }
        .kop .gov-line.large { font-size: 14pt; letter-spacing: 1.5px; }
        .kop .alamat { font-size: 10pt; margin-top: 3px; }
        .garis-tebal { border: none; border-top: 3px solid #000; margin: 6px 0 2px 0; }
        .garis-tipis { border: none; border-top: 1px solid #000; margin: 0 0 20px 0; }

        /* ── DOCUMENT HEADER ── */
        .nomor-surat { text-align: right; font-size: 11pt; margin-bottom: 10px; }
        .doc-title-block { text-align: center; margin: 16px 0 20px 0; }
        .doc-title-block .type { font-size: 14pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; }
        .doc-title-block .title { font-size: 13pt; font-weight: bold; text-transform: uppercase; margin-top: 4px; }
        .doc-title-block .period { font-size: 11pt; font-style: italic; margin-top: 4px; }
        .doc-title-block .underline { width: 300px; height: 2px; background: #000; margin: 8px auto 0; }

        /* ── SECTIONS ── */
        .section { margin-bottom: 16px; text-align: justify; }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 8px;
            margin-top: 14px;
        }
        .section-title.no-underline { text-decoration: none; }
        .section-body { margin-bottom: 8px; line-height: 1.8; }

        /* ── SUB-HEADINGS (Academic) ── */
        .sub-heading {
            font-weight: bold;
            font-size: 12pt;
            margin-top: 16px;
            margin-bottom: 6px;
            padding-bottom: 3px;
            border-bottom: 1px solid #ccc;
            color: #111;
        }
        .sub-heading:first-child { margin-top: 0; }

        /* ── DATA TABLES ── */
        .data-table { width: 100%; border-collapse: collapse; margin: 10px 0 15px 0; font-size: 11pt; }
        .data-table th, .data-table td { padding: 5px 8px; border: 1px solid #000; vertical-align: top; }
        .data-table th {
            background: #e8e8e8;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
        }
        .data-table td.label { font-weight: bold; width: 35%; }
        .data-table td.value { width: 65%; }
        .data-table td.num { text-align: right; white-space: nowrap; }
        .data-table td.center { text-align: center; }
        .table-caption {
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 6px;
            font-style: italic;
        }
        .table-container { page-break-inside: avoid; }

        /* ── CLOSING ── */
        .closing { margin-top: 30px; text-align: justify; line-height: 1.8; }
        .closing p { text-indent: 1.2cm; margin-bottom: 10px; }

        /* ── SIGNATURE ── */
        .ttd-wrapper { margin-top: 40px; text-align: right; page-break-inside: avoid; }
        .ttd-tempat { font-size: 12pt; margin-bottom: 4px; }
        .ttd-jabatan { font-size: 12pt; margin-bottom: 4px; }
        .ttd-spasi { height: 50px; }
        .ttd-nama { font-weight: bold; font-size: 12pt; text-decoration: underline; }
        .ttd-nip { font-size: 11pt; }

        /* ── PAGE FOOTER ── */
        .page-footer { position: fixed; bottom: 15px; left: 0; right: 0; text-align: center; font-size: 9pt; }
        .page-footer .page-number:before { content: "Halaman " counter(page); }

        /* ── UTILITIES ── */
        .page-break { page-break-before: always; }
        .avoid-break { page-break-inside: avoid; }
        .font-bold { font-weight: bold; }
        .indent-1 { padding-left: 24px; }

        /* ── LISTS ── */
        .item-list { margin: 8px 0 12px 40px; }
        .item-list li { margin-bottom: 4px; line-height: 1.6; text-align: justify; }
    </style>
</head>
<body>

    {{-- ═══════════════ KOP SURAT ═══════════════ --}}
    @php
        use Illuminate\Support\Facades\Storage;

        $kopMimeMap = fn (string $path) => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg'], true)
            ? 'jpeg'
            : 'png';

        $kopLogoPemda = null;
        if (config('village.logo_pemda') && Storage::disk('public')->exists(config('village.logo_pemda'))) {
            $kopLogoPemda = 'data:image/'.$kopMimeMap(config('village.logo_pemda')).';base64,'.base64_encode(Storage::disk('public')->get(config('village.logo_pemda')));
        }

        $kopLogoDesa = null;
        if (config('village.logo_desa') && Storage::disk('public')->exists(config('village.logo_desa'))) {
            $kopLogoDesa = 'data:image/'.$kopMimeMap(config('village.logo_desa')).';base64,'.base64_encode(Storage::disk('public')->get(config('village.logo_desa')));
        }
    @endphp
    <div class="kop">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:24%; text-align:center; vertical-align:middle;">
                    @if ($kopLogoPemda)
                        <img src="{{ $kopLogoPemda }}" alt="Logo Pemda" style="height:60px; width:auto;">
                    @endif
                </td>
                <td style="text-align:center; vertical-align:middle;">
                    <div class="gov-line large">PEMERINTAH {{ strtoupper(config('village.nama_kabupaten', 'KABUPATEN')) }}</div>
                    <div class="gov-line">KECAMATAN {{ strtoupper(config('village.nama_kecamatan', 'KECAMATAN')) }}</div>
                    <div class="gov-line large">PEMERINTAH DESA {{ strtoupper(config('village.nama_desa', 'DESA')) }}</div>
                    <div class="alamat">
                        {{ config('village.alamat_kantor', 'Alamat Kantor') }}
                        &mdash; Email: {{ config('village.email_desa', 'email@desa.id') }}
                        &mdash; Telp: {{ config('village.telepon_desa', '-') }}
                    </div>
                </td>
                <td style="width:24%; text-align:center; vertical-align:middle;">
                    @if ($kopLogoDesa)
                        <img src="{{ $kopLogoDesa }}" alt="Logo Desa" style="height:60px; width:auto;">
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <hr class="garis-tebal">
    <hr class="garis-tipis">

    {{-- ═══════════════ DOCUMENT HEADER ═══════════════ --}}
    <div class="nomor-surat">{{ $laporan->nomor_laporan }}</div>

    <div class="doc-title-block">
        <div class="type">Laporan Desa Kuantitatif</div>
        <div class="title">{{ strtoupper($laporan->judul) }}</div>
        @php
            $periodeTipe = ucfirst(str_replace('_', ' ', $laporan->tipe_periode));
        @endphp
        <div class="period">{{ $periodeTipe }} {{ $laporan->periode_label }}</div>
        <div class="underline"></div>
    </div>

    {{-- ═══════════════ CONTENT ═══════════════ --}}
    <p>
        Dengan hormat, bersama ini disampaikan Laporan Desa Kuantitatif
        Periode {{ $laporan->periode_label }} untuk {{ config('village.nama_desa', 'Desa') }},
        {{ config('village.nama_kecamatan', 'Kecamatan') }}, {{ config('village.nama_kabupaten', 'Kabupaten') }},
        yang memuat ringkasan kondisi desa dari berbagai aspek penyelenggaraan pemerintahan,
        pembangunan, dan pemberdayaan masyarakat.
    </p>

    @php
        $romans = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
    @endphp

    @foreach ($konten as $moduleKey => $section)
        <div class="section avoid-break">
            <div class="section-title">{{ $romans[$loop->index] ?? ($loop->index + 1) }}. {{ $section['judul'] ?? $moduleKey }}</div>

            <div class="section-body">
                @php
                    $teks = $section['teks'] ?? '';
                    $teks = nl2br(e($teks));
                    $teks = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $teks);
                    $teks = preg_replace('/<strong>([A-Za-z][A-Za-z\s&;]+)<\/strong><br><br>/', '<div class="sub-heading">$1</div>', $teks);
                @endphp
                {!! $teks !!}
            </div>

            {{-- Render data tables --}}
            @if (!empty($section['data']) && is_array($section['data']))
                @php
                    $flatData = collect($section['data'])->filter(fn($v) => !is_array($v) && !is_null($v) && $v !== '' && $v !== '-');
                @endphp

                @if ($flatData->count() > 0)
                    <div class="table-container">
                        <div class="table-caption">Tabel {{ $romans[$loop->index] ?? ($loop->index + 1) }}.1 Data {{ $section['judul'] ?? $moduleKey }}</div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th style="width:40%">Uraian</th>
                                    <th style="width:55%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rowNum = 1; @endphp
                                @foreach ($section['data'] as $key => $value)
                                    @if (is_array($value))
                                        <tr>
                                            <td class="center font-bold" colspan="3" style="background:#f0f0f0; text-align:left; padding-left:12px;">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </td>
                                        </tr>
                                        @foreach ($value as $subKey => $subValue)
                                            @if (!is_null($subValue) && $subValue !== '' && !is_array($subValue))
                                                <tr>
                                                    <td class="center">{{ $rowNum++ }}</td>
                                                    <td class="indent-1">{{ ucwords(str_replace('_', ' ', $subKey)) }}</td>
                                                    <td class="value">
                                                        @if (is_numeric($subValue) && $subValue > 1000)
                                                            {{ number_format((float) $subValue, 0, ',', '.') }}
                                                        @else
                                                            {{ $subValue }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @elseif (!is_null($value) && $value !== '' && $value !== '-')
                                        <tr>
                                            <td class="center">{{ $rowNum++ }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                            <td class="value">
                                                @if (is_numeric($value) && $value > 1000 && !in_array(strtolower($key), ['laki', 'perempuan', 'jiwa', 'orang', 'kk']))
                                                    {{ number_format((float) $value, 0, ',', '.') }}
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>
    @endforeach

    {{-- ═══════════════ CLOSING ═══════════════ --}}
    <div class="closing">
        <p>
            Demikian Laporan Desa Kuantitatif ini disampaikan sebagai pertanggungjawaban
            penyelenggaraan pemerintahan {{ config('village.nama_desa', 'Desa') }} sesuai
            ketentuan yang berlaku. Atas perhatian dan kerjasamanya, kami mengucapkan terima kasih.
        </p>
    </div>

    {{-- ═══════════════ SIGNATURE ═══════════════ --}}
    <div class="ttd-wrapper">
        <div class="ttd-tempat">{{ config('village.nama_desa', 'Desa') }}, {{ $laporan->approved_at ? $laporan->approved_at->format('d F Y') : now()->format('d F Y') }}</div>
        <div class="ttd-jabatan">Kepala Desa {{ config('village.nama_desa', 'Desa') }}</div>
        <div class="ttd-spasi"></div>
        <div class="ttd-nama">{{ config('village.nama_kades', 'Kepala Desa') }}</div>
        <div class="ttd-nip">NIP. {{ config('village.nip_kades', '-') }}</div>
    </div>

    <div class="page-footer">
        <span class="page-number"></span>
    </div>

</body>
</html>
