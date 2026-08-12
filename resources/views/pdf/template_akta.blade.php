<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $jenis_label }} - {{ $nama_lengkap }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 35px 45px;
        }
        .kop { text-align: center; margin-bottom: 3px; }
        .kop h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .kop p { font-size: 11pt; margin-top: 1px; }
        .kop .alamat { font-size: 9pt; font-style: italic; }
        .garis-tebal { border: none; border-top: 3px solid #000; margin: 6px 0 3px 0; }
        .garis-tipis { border: none; border-top: 1px solid #000; margin: 0 0 25px 0; }
        .judul-surat { text-align: center; font-size: 14pt; font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
        .nomor-surat { text-align: center; font-size: 11pt; margin-bottom: 20px; }
        .pembuka { text-align: justify; text-indent: 40px; margin-bottom: 10px; }
        table.data { margin: 12px 0 12px 40px; border-collapse: collapse; font-size: 11.5pt; }
        table.data td { padding: 1.5px 6px; vertical-align: top; }
        table.data td.label { width: 130px; }
        table.data td.titik { width: 18px; text-align: center; }
        .isi-spesifik { text-align: justify; text-indent: 40px; margin: 10px 0; }
        .penutup { text-align: justify; text-indent: 40px; margin-top: 8px; }
        .berlaku { text-align: center; font-size: 10pt; font-style: italic; margin-top: 6px; color: #444; }
        .ttd-wrapper { margin-top: 35px; width: 100%; position: relative; }
        .ttd-left { float: left; width: 45%; text-align: center; font-size: 11pt; }
        .ttd-right { float: right; width: 45%; text-align: center; font-size: 11pt; position: relative; }
        .ttd-left .jabatan, .ttd-right .jabatan { margin-bottom: 70px; }
        .ttd-left .nama, .ttd-right .nama { font-weight: bold; text-decoration: underline; }
        .clearfix { clear: both; }
        .stempel-overlay {
            position: absolute;
            bottom: 30px;
            right: 70px;
            width: 85px;
            height: 85px;
            opacity: 0.85;
            z-index: 10;
        }
        .stempel-overlay img { width: 100%; height: 100%; }
        .ttd-overlay {
            position: absolute;
            bottom: 50px;
            right: 80px;
            width: 100px;
            height: 40px;
            z-index: 5;
        }
        .ttd-overlay img { width: 100%; height: 100%; object-fit: contain; }
    </style>
</head>
<body>

    @include('pdf._kop')
    <hr class="garis-tebal">
    <hr class="garis-tipis">

    <div class="judul-surat">{{ $jenis_label }}</div>
    <div class="nomor-surat">Nomor: {{ $nomor_surat }}</div>

    <div class="pembuka">
        Yang bertanda tangan di bawah ini, {{ $kades }}, menerangkan dengan sebenarnya bahwa:
    </div>

    <table class="data">
        <tr><td class="label">Nama Lengkap</td><td class="titik">:</td><td>{{ $nama_lengkap }}</td></tr>
        <tr><td class="label">NIK</td><td class="titik">:</td><td>{{ $nik }}</td></tr>
        <tr><td class="label">Tempat / Tgl Lahir</td><td class="titik">:</td><td>{{ $tempat_lahir }} / {{ $tgl_lahir ? \Carbon\Carbon::parse($tgl_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td class="titik">:</td><td>{{ $jenis_kelamin }}</td></tr>
        <tr><td class="label">Pekerjaan</td><td class="titik">:</td><td>{{ $pekerjaan }}</td></tr>
        <tr><td class="label">Alamat</td><td class="titik">:</td><td>{{ $alamat_lengkap }}</td></tr>
    </table>

    <div class="isi-spesifik">
        Bahwa orang tersebut di atas adalah benar warga Desa {{ config('village.nama_desa', 'Desa') }}, Kecamatan {{ config('village.nama_kecamatan', 'Kecamatan') }}, {{ config('village.nama_kabupaten', 'Kabupaten') }} dan surat ini dibuat sebagai pengantar yang sah untuk mengurus <strong>pembuatan akta {{ $jenis_akta }}</strong> di Dinas Kependudukan dan Pencatatan Sipil {{ config('village.nama_kabupaten', 'Kabupaten') }}.
    </div>

    @if (!empty($nama_anak) && $nama_anak !== '-')
    <table class="data">
        <tr><td class="label">Nama Anak / Ahli Waris</td><td class="titik">:</td><td>{{ $nama_anak }}</td></tr>
        <tr><td class="label">Tempat / Tgl Lahir</td><td class="titik">:</td><td>{{ $tempat_lahir_anak }} / {{ $tgl_lahir_anak ? \Carbon\Carbon::parse($tgl_lahir_anak)->locale('id')->translatedFormat('d F Y') : '-' }}</td></tr>
    </table>
    @endif

    <div class="penutup">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
    </div>

    <div class="berlaku">
        Berlaku sampai dengan {{ $tgl_berlaku_sampai }}
    </div>

    <div class="ttd-wrapper">
        <div class="ttd-left">
            <div class="jabatan">Mengetahui,<br>Camat {{ config('village.nama_kecamatan', 'Kecamatan') }},</div>
            <br><br><br>
            <div class="nama">{{ config('village.nama_camat', 'Camat') }}</div>
            <div>NIP. {{ config('village.nip_camat', '-') }}</div>
        </div>
        <div class="ttd-right">
            <div class="jabatan">{{ config('village.nama_desa', 'Desa') }}, {{ $tgl_cetak }}<br>{{ $penandatangan_jabatan }},</div>
            <br><br><br>
            <div class="nama">{{ $penandatangan_nama }}</div>
            <div>{{ $penandatangan_nip !== '-' ? 'NIP. ' . $penandatangan_nip : '' }}</div>
            @if ($stempel_desa)
                <div class="stempel-overlay">
                    <img src="data:image/png;base64,{{ $stempel_desa }}" alt="Stempel">
                </div>
            @endif
            @if ($ttd_kades)
                <div class="ttd-overlay">
                    <img src="data:image/png;base64,{{ $ttd_kades }}" alt="TTD">
                </div>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>

    <div style="margin-top: 30px; border-top: 1px solid #000; padding-top: 10px;">
        <table width="100%" style="font-size: 8pt; font-family: 'Times New Roman', Times, serif;">
            <tr>
                <td width="20%" style="text-align: center; vertical-align: middle;">
                    <img src="data:image/svg+xml;base64,{{ base64_encode($qr_svg) }}" width="70" height="70">
                </td>
                <td width="80%" style="padding-left: 10px; vertical-align: middle;">
                    <strong>Verifikasi Dokumen:</strong><br>
                    Scan QR Code atau kunjungi: {{ route('verifikasi.show', $hash) }}<br>
                    <small>Hash: {{ substr($hash, 0, 16) }}... | Cetak: {{ $tgl_cetak }}</small>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
