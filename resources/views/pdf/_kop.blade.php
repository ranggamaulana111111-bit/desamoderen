@php
    use Illuminate\Support\Facades\Storage;

    $namaDesaKop = trim((string) config('village.nama_desa', 'Desa'));
    $namaDesaKop = preg_replace('/^(Desa|Kelurahan)\s+/i', '', $namaDesaKop) ?: $namaDesaKop;
    $namaKabKop = trim((string) config('village.nama_kabupaten', 'Kabupaten'));

    $kopMimeMap = fn (string $path) => strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'jpg'
        || strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'jpeg'
            ? 'jpeg'
            : 'png';

    $logoPemdaSrc = null;
    if (config('village.logo_pemda') && Storage::disk('public')->exists(config('village.logo_pemda'))) {
        $logoPemdaSrc = 'data:image/'.$kopMimeMap(config('village.logo_pemda')).';base64,'.base64_encode(Storage::disk('public')->get(config('village.logo_pemda')));
    }

    $logoDesaSrc = null;
    if (config('village.logo_desa') && Storage::disk('public')->exists(config('village.logo_desa'))) {
        $logoDesaSrc = 'data:image/'.$kopMimeMap(config('village.logo_desa')).';base64,'.base64_encode(Storage::disk('public')->get(config('village.logo_desa')));
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
                <p><strong>Kecamatan {{ config('village.nama_kecamatan', 'Kecamatan') }}, Kabupaten {{ $namaKabKop }}</strong></p>
                <p class="alamat">{{ config('village.alamat_kantor', 'Alamat Kantor') }} &mdash; Email: {{ config('village.email_desa', 'email@desa.id') }}</p>
            </td>
            <td style="width:24%; text-align:center; vertical-align:middle;">
                @if ($logoDesaSrc)
                    <img src="{{ $logoDesaSrc }}" alt="Logo Desa" style="height:68px; width:auto;">
                @endif
            </td>
        </tr>
    </table>
</div>
