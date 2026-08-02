<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Desa - {{ $laporan->judul }}</title>
    <style>
        @page { margin: 35px 30px 40px 30px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.7;
            color: #000;
        }
        p { text-indent: 1.2cm; margin-bottom: 8px; text-align: justify; }

        /* ── COVER ── */
        .cover { text-align: center; page-break-after: always; padding-top: 0; }
        .cover-header { margin-top: 60px; }
        .cover .gov-line { font-size: 13pt; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
        .cover .gov-line.bold { font-weight: bold; }
        .cover .gov-line.large { font-size: 14pt; font-weight: bold; }
        .cover .separator { height: 3px; width: 200px; background: #000; margin: 20px auto; }
        .cover .report-type { font-size: 16pt; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px; }
        .cover .report-abbr { font-size: 14pt; font-weight: bold; margin-bottom: 20px; }
        .cover .report-subtitle { font-size: 12pt; font-style: italic; margin-bottom: 4px; }
        .cover .report-period { font-size: 13pt; font-weight: bold; text-transform: uppercase; margin-bottom: 6px; }
        .cover .gap { height: 16px; }
        .cover .gap-lg { height: 80px; }
        .cover .author-section { margin-top: 0; }
        .cover .author-label { font-size: 11pt; margin-bottom: 3px; }
        .cover .author-name { font-size: 13pt; font-weight: bold; }
        .cover .author-role { font-size: 11pt; margin-bottom: 3px; }
        .cover .print-date { font-size: 11pt; margin-top: 8px; }

        /* ── PAGE HEADER WATERMARK ── */
        .page-header-watermark {
            position: running(header);
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #ccc;
            text-align: center;
            padding: 5px 0;
        }

        /* ── DAFTAR ISI ── */
        .toc { page-break-after: always; padding-top: 20px; }
        .toc-title { font-size: 14pt; font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 25px; letter-spacing: 1px; }
        .toc-item {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 4px 0;
            border-bottom: 1px dotted #ccc;
            font-size: 12pt;
        }
        .toc-item .toc-label { font-weight: bold; }
        .toc-item .toc-sub { font-weight: normal; padding-left: 24px; }
        .toc-item .toc-dots { flex: 1; border-bottom: 1px dotted #999; margin: 0 6px; height: 12px; align-self: flex-end; margin-bottom: 3px; }

        /* ── SECTIONS ── */
        .section { margin-bottom: 20px; text-align: justify; }
        .section-title {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 16px;
            text-decoration: underline;
            text-align: left;
        }
        .section-title.no-underline { text-decoration: none; }
        .subsection-title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 8px;
            margin-top: 12px;
            text-align: left;
        }
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
        .section-body p { margin-bottom: 8px; }

        /* ── LISTS ── */
        .item-list { margin: 8px 0 12px 40px; }
        .item-list li { margin-bottom: 4px; line-height: 1.6; text-align: justify; }

        /* ── DATA TABLES ── */
        .data-table { width: 100%; border-collapse: collapse; margin: 12px 0 18px 0; font-size: 11pt; }
        .data-table th, .data-table td { padding: 6px 10px; border: 1px solid #000; vertical-align: top; }
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

        /* ── KATA PENGANTAR ── */
        .pengantar { page-break-after: always; }
        .pengantar-title { font-size: 14pt; font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 20px; letter-spacing: 1px; }
        .pengantar-body { line-height: 1.8; text-align: justify; }
        .pengantar-body p { text-indent: 1.2cm; margin-bottom: 12px; }
        .pengantar-sign { margin-top: 40px; text-align: right; }
        .pengantar-sign .place-date { margin-bottom: 5px; }
        .pengantar-sign .sign-label { margin-bottom: 55px; }
        .pengantar-sign .sign-name { font-weight: bold; text-decoration: underline; }
        .pengantar-sign .sign-role { }

        /* ── SIGNATURE ── */
        .ttd-wrapper { margin-top: 50px; text-align: right; page-break-inside: avoid; }
        .ttd-tempat { font-size: 12pt; margin-bottom: 4px; }
        .ttd-jabatan { font-size: 12pt; margin-bottom: 4px; }
        .ttd-spasi { height: 50px; }
        .ttd-nama { font-weight: bold; font-size: 12pt; text-decoration: underline; }
        .ttd-nip { font-size: 11pt; }

        /* ── PAGE FOOTER ── */
        .page-footer { position: fixed; bottom: 15px; left: 0; right: 0; text-align: center; font-size: 9pt; color: #666; }
        .page-footer .page-number:before { content: counter(page); }
        .page-footer .page-label:before { content: "Halaman "; }

        /* ── UTILITIES ── */
        .page-break { page-break-before: always; }
        .avoid-break { page-break-inside: avoid; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .mb-10 { margin-bottom: 10px; }
        .mb-20 { margin-bottom: 20px; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* ── Rincian tables (appendix) ── */
        .rincian-table { width: 100%; border-collapse: collapse; margin: 12px 0 18px 0; font-size: 10pt; }
        .rincian-table th, .rincian-table td { padding: 4px 8px; border: 1px solid #000; vertical-align: top; }
        .rincian-table th { background: #e8e8e8; font-weight: bold; text-align: center; }
        .rincian-table td.num { text-align: right; }
        .rincian-table td.center { text-align: center; }
        .rincian-table .indent-1 { padding-left: 24px; }
        .rincian-table .indent-2 { padding-left: 40px; }
    </style>
</head>
<body>

    {{-- ═══════════════ COVER PAGE ═══════════════ --}}
    <div class="cover">
        <div class="cover-header">
            <div class="gov-line">PEMERINTAH {{ strtoupper(config('village.nama_kabupaten', 'KABUPATEN')) }}</div>
            <div class="gov-line">KECAMATAN {{ strtoupper(config('village.nama_kecamatan', 'KECAMATAN')) }}</div>
            <div class="gov-line large">PEMERINTAH DESA {{ strtoupper(config('village.nama_desa', 'DESA')) }}</div>
        </div>

        <div class="separator"></div>

        <div class="report-type">LAPORAN DESA KUANTITATIF</div>
        <div class="report-subtitle">{{ $laporan->judul }}</div>

        <div class="gap"></div>

        @php
            $periodeTipe = ucfirst(str_replace('_', ' ', $laporan->tipe_periode));
            $periodeLabel = $laporan->periode_label;
        @endphp

        <div class="report-period">{{ $periodeTipe }}</div>
        <div style="font-size:12pt;">{{ $periodeLabel }}</div>

        <div class="gap-lg"></div>

        <div class="author-section">
            <div class="author-label">Disusun oleh:</div>
            <div class="author-name">{{ $laporan->creator->name ?? 'Nama Penyusun' }}</div>
            @php $creatorRole = $laporan->creator ? ($laporan->creator->roles->first()->label ?? $laporan->creator->roles->first()->name ?? '') : ''; @endphp
            @if ($creatorRole)
                <div class="author-role">{{ $creatorRole }}</div>
            @endif
        </div>

        <div class="gap"></div>

        <div class="print-date">
            {{ config('village.nama_desa', 'Desa') }}<br>
            {{ $laporan->approved_at ? $laporan->approved_at->format('d F Y') : now()->format('d F Y') }}
        </div>
    </div>

    {{-- ═══════════════ KATA PENGANTAR ═══════════════ --}}
    <div class="pengantar">
        <div class="pengantar-title">Kata Pengantar</div>
        <div class="pengantar-body">
            <p>
                Puji syukur kami panjatkan kehadirat Tuhan Yang Maha Esa atas rahmat dan karunia-Nya,
                sehingga kami dapat menyelesaikan penyusunan Laporan Desa Kuantitatif
                Periode {{ $periodeLabel }}.
            </p>
            <p>
                Laporan ini merupakan bahan pertanggungjawaban penyelenggaraan pemerintahan desa
                serta sebagai bahan evaluasi dan tolok ukur dalam menentukan rencana kegiatan
                bagi {{ config('village.nama_desa', 'Desa') }} dalam menentukan program dan kegiatan
                pada periode berikutnya.
            </p>
            <p>
                Kami menyadari sepenuhnya bahwa tidak dapat menjalankan program kerja tanpa
                dukungan dan bantuan dari berbagai pihak yang ada di {{ config('village.nama_desa', 'Desa') }}.
                Oleh karena itu, ucapan terima kasih kami sampaikan kepada semua pihak, baik yang
                membantu secara langsung maupun tidak langsung, sehingga proses pelaksanaan
                program kerja di {{ config('village.nama_desa', 'Desa') }} dapat diselesaikan sebagaimana mestinya.
            </p>
            <p>
                Karena Laporan Desa Kuantitatif yang kami sampaikan ini masih jauh dari kesempurnaan,
                oleh karena itu kami mengharapkan koreksi maupun arahan dari semua pihak agar
                periode berikutnya kami dapat menjalankan program kerja lebih baik dari periode ini.
            </p>
        </div>

        <div class="pengantar-sign">
            <div class="place-date">{{ config('village.nama_desa', 'Desa') }}, {{ $laporan->approved_at ? $laporan->approved_at->format('d F Y') : now()->format('d F Y') }}</div>
            <div class="sign-label">Kepala Desa {{ config('village.nama_desa', 'Desa') }}</div>
            <div class="sign-name">{{ config('village.nama_kades', 'Kepala Desa') }}</div>
            <div class="sign-role">NIP. {{ config('village.nip_kades', '-') }}</div>
        </div>
    </div>

    {{-- ═══════════════ DAFTAR ISI ═══════════════ --}}
    <div class="toc">
        <div class="toc-title">Daftar Isi</div>

        <div class="toc-item">
            <span class="toc-label">Kata Pengantar</span>
            <span class="toc-dots"></span>
        </div>

        @php $romans = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII']; @endphp

        @foreach ($konten as $moduleKey => $section)
            <div class="toc-item">
                <span class="toc-label">{{ $romans[$loop->index] ?? ($loop->index + 1) }}. {{ $section['judul'] ?? $moduleKey }}</span>
                <span class="toc-dots"></span>
            </div>
        @endforeach

        <div class="toc-item">
            <span class="toc-label">Lampiran Data</span>
            <span class="toc-dots"></span>
        </div>
    </div>

    {{-- ═══════════════ CONTENT SECTIONS ═══════════════ --}}
    @php
        $romans = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $counter = 1;
    @endphp

    @foreach ($konten as $moduleKey => $section)
        @php
            $romNum = $romans[$loop->index] ?? ($loop->index + 1);
        @endphp

        <div class="section avoid-break">
            <div class="section-title">{{ $romNum }}. {{ $section['judul'] ?? $moduleKey }}</div>

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
                        <div class="table-caption">Tabel {{ $romNum }}.1 Data {{ $section['judul'] ?? $moduleKey }}</div>
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
                                        {{-- Nested array: render as sub-header + rows --}}
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
                                                    <td class="value">{{ $subValue }}</td>
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

    {{-- ═══════════════ LAMPIRAN ═══════════════ --}}
    <div class="page-break"></div>
    <div class="section">
        <div class="section-title">LAMPIRAN</div>
        <div class="section-title no-underline" style="font-size:12pt;">Data Rinci Modul Laporan</div>

        @foreach ($konten as $moduleKey => $section)
            @if (!empty($section['data']) && is_array($section['data']))
                @php
                    $allData = collect($section['data'])->filter(function($v) {
                        return !is_null($v) && $v !== '' && $v !== '-';
                    });
                @endphp

                @if ($allData->count() > 0)
                    <div class="table-container avoid-break">
                        <div class="table-caption">Lampiran {{ $romans[$loop->index] ?? ($loop->index + 1) }}. {{ $section['judul'] ?? $moduleKey }}</div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width:40%">Komponen</th>
                                    <th style="width:60%">Data / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($section['data'] as $key => $value)
                                    @if (is_array($value))
                                        @foreach ($value as $subKey => $subValue)
                                            @if (!is_null($subValue) && $subValue !== '' && !is_array($subValue))
                                                <tr>
                                                    <td class="label indent-1">{{ ucwords(str_replace('_', ' ', $subKey)) }}</td>
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
                                            <td class="label">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                            <td class="value">
                                                @if (is_numeric($value) && $value > 1000)
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
        @endforeach
    </div>

    {{-- ═══════════════ SIGNATURE ═══════════════ --}}
    <div class="page-break"></div>
    <div class="section">
        <div style="text-align:justify; line-height:1.8;">
            <p>
                Demikian Laporan Desa Kuantitatif Periode {{ $periodeLabel }} ini dibuat sebagai
                pertanggungjawaban penyelenggaraan pemerintahan {{ config('village.nama_desa', 'Desa') }}
                sesuai ketentuan yang berlaku.
            </p>
            <p>Atas perhatian dan dukungannya, kami ucapkan terima kasih.</p>
        </div>

        <div class="ttd-wrapper">
            <div class="ttd-tempat">{{ config('village.nama_desa', 'Desa') }}, {{ $laporan->approved_at ? $laporan->approved_at->format('d F Y') : now()->format('d F Y') }}</div>
            <div class="ttd-jabatan">Kepala Desa {{ config('village.nama_desa', 'Desa') }}</div>
            <div class="ttd-spasi"></div>
            <div class="ttd-nama">{{ config('village.nama_kades', 'Kepala Desa') }}</div>
            <div class="ttd-nip">NIP. {{ config('village.nip_kades', '-') }}</div>
        </div>
    </div>

    <div class="page-footer">
        <span class="page-label"></span><span class="page-number"></span>
    </div>

</body>
</html>
