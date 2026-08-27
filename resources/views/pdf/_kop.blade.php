@php
    use Illuminate\Support\Facades\Storage;

    // Use per-template kop surat if available, fallback to village settings
    $kop = $letterConfig ?? null;

    $namaDesaKop = trim((string) ($kop->kop_nama_desa ?? config('village.nama_desa', 'Desa')));
    $namaDesaKop = preg_replace('/^(Desa|Kelurahan)\s+/i', '', $namaDesaKop) ?: $namaDesaKop;
    $namaKabKop = trim((string) ($kop->kop_nama_kabupaten ?? config('village.nama_kabupaten', 'Kabupaten')));
    $namaKecKop = trim((string) ($kop->kop_nama_kecamatan ?? config('village.nama_kecamatan', 'Kecamatan')));
    $alamatKop = $kop->kop_alamat_kantor ?? config('village.alamat_kantor', 'Alamat Kantor');
    $emailKop = $kop->kop_email_desa ?? config('village.email_desa', 'email@desa.id');
    $teleponKop = $kop->kop_telepon_desa ?? config('village.telepon_desa', '');

    $kopMimeMap = fn (string $path) => strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'jpg'
        || strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'jpeg'
            ? 'jpeg'
            : 'png';

    $logoPemdaSrc = null;
    $logoPemdaPath = $kop->kop_logo_pemda_path ?? config('village.logo_pemda');
    if ($logoPemdaPath && Storage::disk('public')->exists($logoPemdaPath)) {
        $logoPemdaSrc = 'data:image/'.$kopMimeMap($logoPemdaPath).';base64,'.base64_encode(Storage::disk('public')->get($logoPemdaPath));
    }

    $logoDesaSrc = null;
    $logoDesaPath = $kop->kop_logo_desa_path ?? config('village.logo_desa');
    if ($logoDesaPath && Storage::disk('public')->exists($logoDesaPath)) {
        $logoDesaSrc = 'data:image/'.$kopMimeMap($logoDesaPath).';base64,'.base64_encode(Storage::disk('public')->get($logoDesaPath));
    }
@endphp
<div class="kop">
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:24%; text-align:center; vertical-align:middle;">
                @if ($logoPemdaSrc)
                    <img src="{{ $logoPemdaSrc }}" alt="Logo Pemda" style="height:68px; width:auto;">
                @endif
            </td>
            <td style="text-align:center; vertical-align:middle;">
                <div style="font-size:11pt; font-weight:bold; text-transform:uppercase; letter-spacing:0.5px;">Pemerintah Kabupaten {{ $namaKabKop }}</div>
                <h1>Pemerintah Desa {{ $namaDesaKop }}</h1>
                <p><strong>Kecamatan {{ $namaKecKop }}, Kabupaten {{ $namaKabKop }}</strong></p>
                <p class="alamat">{{ $alamatKop }} &mdash; Email: {{ $emailKop }}{{ $teleponKop ? ' &mdash; Telp: '.$teleponKop : '' }}</p>
            </td>
            <td style="width:24%; text-align:center; vertical-align:middle;">
                @if ($logoDesaSrc)
                    <img src="{{ $logoDesaSrc }}" alt="Logo Desa" style="height:68px; width:auto;">
                @endif
            </td>
        </tr>
    </table>
</div>
