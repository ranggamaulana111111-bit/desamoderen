<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Daftar IP atau CIDR proxy yang diperbolehkan menyisipkan header
    | X-Forwarded-*. Dipisahkan dengan koma. Biarkan kosong jika aplikasi
    | diakses langsung tanpa proxy (default: tidak ada proxy yang dipercaya).
    |
    | Contoh (Cloudflare):
    | TRUSTED_PROXIES=173.245.48.0/20,103.21.244.0/22,103.22.200.0/22,103.31.4.0/22,141.101.64.0/18,108.162.192.0/18,190.93.240.0/20,188.114.96.0/20,197.234.240.0/22,198.41.128.0/17,162.158.0.0/15,104.16.0.0/13,104.24.0.0/14,172.64.0.0/13,131.0.72.0/22
    |
    */

    'proxies' => env('TRUSTED_PROXIES', ''),

];
