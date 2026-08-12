@php
    $namaDesaKop = trim((string) config('village.nama_desa', 'Desa'));
    $namaDesaKop = preg_replace('/^(Desa|Kelurahan)\s+/i', '', $namaDesaKop) ?: $namaDesaKop;
@endphp
<div class="kop">
    <h1>Pemerintah Desa {{ $namaDesaKop }}</h1>
    <p><strong>Kecamatan {{ config('village.nama_kecamatan', 'Kecamatan') }}, Kabupaten {{ config('village.nama_kabupaten', 'Kabupaten') }}</strong></p>
    <p class="alamat">{{ config('village.alamat_kantor', 'Alamat Kantor') }} &mdash; Email: {{ config('village.email_desa', 'email@desa.id') }}</p>
</div>
