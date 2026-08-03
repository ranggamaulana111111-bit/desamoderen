<?php

namespace App\Services;

use App\Models\Apbdesa;
use App\Models\Berita;
use App\Models\Disposisi;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\Inventaris;
use App\Models\PengajuanSurat;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Carbon\Carbon;

class LaporanService
{
    const MODULES = [
        'profil_desa',
        'kependudukan',
        'pelayanan_surat',
        'ketatausahaan',
        'inventaris_aset',
        'anggaran',
        'kegiatan',
        'berita_informasi',
        'kesimpulan',
    ];

    const MODULE_LABELS = [
        'profil_desa' => 'Profil Desa',
        'kependudukan' => 'Kependudukan',
        'pelayanan_surat' => 'Pelayanan Surat',
        'ketatausahaan' => 'Ketatausahaan',
        'inventaris_aset' => 'Inventaris & Aset',
        'anggaran' => 'APBDesa',
        'kegiatan' => 'Kegiatan & Event',
        'berita_informasi' => 'Berita & Informasi',
        'kesimpulan' => 'Kesimpulan & Rekomendasi',
    ];

    const MODULE_ICONS = [
        'profil_desa' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z',
        'kependudukan' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        'pelayanan_surat' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
        'ketatausahaan' => 'M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51',
        'inventaris_aset' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
        'anggaran' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z',
        'kegiatan' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
        'berita_informasi' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z',
        'kesimpulan' => 'M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z',
    ];

    public function gatherAllData(array $modules, Carbon $start, Carbon $end): array
    {
        $data = [];
        foreach ($modules as $module) {
            $method = 'gather'.str_replace('_', '', ucwords($module, '_'));
            if (method_exists($this, $method)) {
                $data[$module] = $this->$method($start, $end);
            }
        }

        return $data;
    }

    public function generateAllNarratives(array $modules, Carbon $start, Carbon $end): array
    {
        $data = $this->gatherAllData($modules, $start, $end);
        $narratives = [];

        foreach ($data as $moduleKey => $moduleData) {
            $method = 'narrate'.str_replace('_', '', ucwords($moduleKey, '_'));
            $narratives[$moduleKey] = [
                'judul' => self::MODULE_LABELS[$moduleKey] ?? $moduleKey,
                'teks' => method_exists($this, $method)
                    ? $this->$method($moduleData, $start, $end)
                    : '',
                'data' => $moduleData,
            ];
        }

        return $narratives;
    }

    // ── Gather Methods ──

    private function gatherProfilDesa(Carbon $start, Carbon $end): array
    {
        return [
            'nama_desa' => config('village.nama_desa', '-'),
            'nama_kecamatan' => config('village.nama_kecamatan', '-'),
            'nama_kabupaten' => config('village.nama_kabupaten', '-'),
            'alamat_kantor' => config('village.alamat_kantor', '-'),
            'email_desa' => config('village.email_desa', '-'),
            'telepon_desa' => config('village.telepon_desa', '-'),
            'website_desa' => config('village.website_desa', '-'),
            'nama_kades' => config('village.nama_kades', '-'),
            'nip_kades' => config('village.nip_kades', '-'),
            'nama_sekdes' => config('village.nama_sekdes', '-'),
            'nip_sekdes' => config('village.nip_sekdes', '-'),
            'deskripsi_desa' => config('village.deskripsi_desa', '-'),
            'motto_desa' => config('village.motto_desa', '-'),
        ];
    }

    private function gatherKependudukan(Carbon $start, Carbon $end): array
    {
        $totalWarga = User::count();
        $newUsers = User::whereBetween('created_at', [$start, $end])->count();
        $totalWargaBefore = User::where('created_at', '<', $start)->count();

        $rtStats = User::whereNotNull('rt')
            ->selectRaw('rt, COUNT(*) as total')
            ->groupBy('rt')
            ->orderBy('rt')
            ->pluck('total', 'rt')
            ->toArray();

        $rwStats = User::whereNotNull('rw')
            ->selectRaw('rw, COUNT(*) as total')
            ->groupBy('rw')
            ->orderBy('rw')
            ->pluck('total', 'rw')
            ->toArray();

        $growth = $totalWargaBefore > 0
            ? round(($newUsers / $totalWargaBefore) * 100, 1)
            : ($newUsers > 0 ? 100 : 0);

        return [
            'total_warga' => $totalWarga,
            'warga_sebelum_periode' => $totalWargaBefore,
            'warga_baru_periode' => $newUsers,
            'pertumbuhan_persen' => $growth,
            'distribusi_rt' => $rtStats,
            'distribusi_rw' => $rwStats,
        ];
    }

    private function gatherPelayananSurat(Carbon $start, Carbon $end): array
    {
        $query = PengajuanSurat::whereBetween('created_at', [$start, $end]);

        $total = (clone $query)->count();
        $completed = (clone $query)->where('status', 'completed')->count();
        $rejected = (clone $query)->where('status', 'rejected')->count();
        $active = (clone $query)->whereIn('status', PengajuanSurat::ACTIVE_STATUSES)->count();
        $revision = (clone $query)->where('status', 'revision')->count();

        $approvalRate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

        $byType = (clone $query)
            ->selectRaw('jenis_surat, COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as selesai")
            ->groupBy('jenis_surat')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($item) => [
                'jenis' => str_replace('_', ' ', ucfirst($item->jenis_surat)),
                'total' => (int) $item->total,
                'selesai' => (int) $item->selesai,
            ])
            ->toArray();

        $avgProcessing = PengajuanSurat::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
            ->value('avg_hours');

        $topType = $byType[0] ?? null;

        return [
            'total' => $total,
            'selesai' => $completed,
            'ditolak' => $rejected,
            'aktif' => $active,
            'revisi' => $revision,
            'tingkat_persetujuan' => $approvalRate,
            'rata_rata_jam' => round((float) $avgProcessing, 1),
            'rata_rata_hari' => round((float) $avgProcessing / 24, 1),
            'per_jenis' => $byType,
            'jenis_terbanyak' => $topType,
        ];
    }

    private function gatherKetatausahaan(Carbon $start, Carbon $end): array
    {
        $masukTotal = SuratMasuk::whereBetween('created_at', [$start, $end])->count();
        $keluarTotal = SuratKeluar::whereBetween('created_at', [$start, $end])->count();
        $disposisiTotal = Disposisi::whereBetween('created_at', [$start, $end])->count();

        $masukPerJenis = SuratMasuk::whereBetween('created_at', [$start, $end])
            ->selectRaw('jenis_surat, COUNT(*) as total')
            ->groupBy('jenis_surat')
            ->orderByDesc('total')
            ->pluck('total', 'jenis_surat')
            ->toArray();

        $masukPerSifat = SuratMasuk::whereBetween('created_at', [$start, $end])
            ->selectRaw('sifat_surat, COUNT(*) as total')
            ->groupBy('sifat_surat')
            ->pluck('total', 'sifat_surat')
            ->toArray();

        $disposisiPending = Disposisi::where('status', 'pending')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        return [
            'surat_masuk' => $masukTotal,
            'surat_keluar' => $keluarTotal,
            'total_disposisi' => $disposisiTotal,
            'disposisi_pending' => $disposisiPending,
            'per_jenis_masuk' => $masukPerJenis,
            'per_sifat_masuk' => $masukPerSifat,
        ];
    }

    private function gatherInventarisAset(Carbon $start, Carbon $end): array
    {
        $total = Inventaris::count();
        $totalNilai = Inventaris::sum('nilai_perolehan');

        $perKondisi = Inventaris::selectRaw('kondisi, COUNT(*) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi')
            ->toArray();

        $perKategori = Inventaris::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->pluck('total', 'kategori')
            ->toArray();

        $perStatus = Inventaris::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $baruDitambahkan = Inventaris::whereBetween('created_at', [$start, $end])->count();

        return [
            'total_barang' => $total,
            'total_nilai' => $totalNilai,
            'formatted_nilai' => 'Rp '.number_format($totalNilai, 0, ',', '.'),
            'per_kondisi' => $perKondisi,
            'per_kategori' => $perKategori,
            'per_status' => $perStatus,
            'baru_periode' => $baruDitambahkan,
        ];
    }

    private function gatherAnggaran(Carbon $start, Carbon $end): array
    {
        $year = $start->format('Y');

        $query = Apbdesa::where('tahun', $year);
        $totalAnggaran = (clone $query)->sum('anggaran');
        $totalRealisasi = (clone $query)->sum('realisasi');
        $persentase = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : 0;

        $perKategori = (clone $query)
            ->selectRaw('kategori, SUM(anggaran) as anggaran, SUM(realisasi) as realisasi')
            ->groupBy('kategori')
            ->get()
            ->map(fn ($item) => [
                'kategori' => $item->kategori,
                'anggaran' => (float) $item->anggaran,
                'realisasi' => (float) $item->realisasi,
                'persentase' => $item->anggaran > 0 ? round(($item->realisasi / $item->anggaran) * 100, 1) : 0,
            ])
            ->toArray();

        $perBidang = (clone $query)
            ->selectRaw('bidang, SUM(anggaran) as anggaran, SUM(realisasi) as realisasi')
            ->groupBy('bidang')
            ->orderByDesc('anggaran')
            ->get()
            ->map(fn ($item) => [
                'bidang' => $item->bidang,
                'anggaran' => (float) $item->anggaran,
                'realisasi' => (float) $item->realisasi,
            ])
            ->toArray();

        $totalItems = (clone $query)->count();

        return [
            'tahun' => $year,
            'total_anggaran' => $totalAnggaran,
            'total_realisasi' => $totalRealisasi,
            'persentase_realisasi' => $persentase,
            'formatted_anggaran' => 'Rp '.number_format($totalAnggaran, 0, ',', '.'),
            'formatted_realisasi' => 'Rp '.number_format($totalRealisasi, 0, ',', '.'),
            'per_kategori' => $perKategori,
            'per_bidang' => $perBidang,
            'jumlah_items' => $totalItems,
        ];
    }

    private function gatherKegiatan(Carbon $start, Carbon $end): array
    {
        $total = Event::whereBetween('created_at', [$start, $end])->count();
        $upcoming = Event::where('tanggal', '>=', now())
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $completed = Event::where('tanggal', '<', now())
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $perJenis = Event::whereBetween('created_at', [$start, $end])
            ->selectRaw('jenis, COUNT(*) as total')
            ->groupBy('jenis')
            ->pluck('total', 'jenis')
            ->toArray();

        $totalPeserta = EventPeserta::whereHas('event', function ($q) use ($start, $end) {
            $q->whereBetween('events.created_at', [$start, $end]);
        })->count();

        $konfirmasiHadir = EventPeserta::where('konfirmasi', 'hadir')
            ->whereHas('event', function ($q) use ($start, $end) {
                $q->whereBetween('events.created_at', [$start, $end]);
            })->count();

        return [
            'total' => $total,
            'mendatang' => $upcoming,
            'selesai' => $completed,
            'per_jenis' => $perJenis,
            'total_peserta' => $totalPeserta,
            'konfirmasi_hadir' => $konfirmasiHadir,
        ];
    }

    private function gatherBeritaInformasi(Carbon $start, Carbon $end): array
    {
        $total = Berita::whereBetween('created_at', [$start, $end])->count();
        $published = Berita::where('status', 'published')
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $draft = Berita::where('status', 'draft')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $terbaru = Berita::whereBetween('created_at', [$start, $end])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn ($b) => [
                'judul' => $b->judul,
                'status' => $b->status,
                'tanggal' => $b->created_at->format('d M Y'),
            ])
            ->toArray();

        return [
            'total' => $total,
            'published' => $published,
            'draft' => $draft,
            'terbaru' => $terbaru,
        ];
    }

    // ── Narrative Generators (Academic Style) ──

    private function narrateProfilDesa(array $data, Carbon $start, Carbon $end): string
    {
        $kd = $data['nama_desa'];
        $lines = [];

        $lines[] = '**Pendahuluan**';
        $lines[] = "Laporan ini merupakan dokumen pertanggungjawaban penyelenggaraan pemerintahan desa yang disusun berdasarkan data kuantitatif terkini untuk wilayah **{$kd}**. Desa {$kd} merupakan wilayah pemerintahan desa yang secara administratif terletak di Kecamatan {$data['nama_kecamatan']}, Kabupaten {$data['nama_kabupaten']}. Secara geografis, kantor pemerintahan desa berlokasi di {$data['alamat_kantor']}, yang menjadi pusat kegiatan pelayanan publik dan administrasi pemerintahan desa.";

        $lines[] = '**Struktur Kepemerintahan**';
        $lines[] = "Penyelenggaraan pemerintahan desa {$kd} dipimpin oleh Kepala Desa **{$data['nama_kades']}** (NIP. {$data['nip_kades']}) yang bertanggung jawab langsung atas seluruh aspek penyelenggaraan pemerintahan, pembangunan, dan kemasyarakatan. Dalam menjalankan tugas administrasi dan ketatausahaan, Kepala Desa dibantu oleh Sekretaris Desa **{$data['nama_sekdes']}** (NIP. {$data['nip_sekdes']}) selaku pejabat pelaksana teknis kegiatan pemerintahan desa.";

        if (! empty($data['deskripsi_desa']) && $data['deskripsi_desa'] !== '-') {
            $lines[] = '**Profil Desa**';
            $lines[] = "{$data['deskripsi_desa']}";
        }
        if (! empty($data['motto_desa']) && $data['motto_desa'] !== '-') {
            $lines[] = "Motto desa \"{$data['motto_desa']}\" mencerminkan cita-cita dan semangat masyarakat {$kd} dalam menjalani kehidupan bermasyarakat dan bernegara.";
        }
        if (! empty($data['email_desa']) && $data['email_desa'] !== '-') {
            $kontakParts = ["Email: {$data['email_desa']}"];
            if (! empty($data['telepon_desa']) && $data['telepon_desa'] !== '-') {
                $kontakParts[] = "Telp: {$data['telepon_desa']}";
            }
            if (! empty($data['website_desa']) && $data['website_desa'] !== '-') {
                $kontakParts[] = "Website: {$data['website_desa']}";
            }
            $lines[] = 'Kontak desa: '.implode(' | ', $kontakParts).'.';
        }

        $lines[] = '**Ruang Lingkup Laporan**';
        $lines[] = "Laporan ini mencakup data dan analisis kuantitatif selama periode **{$start->format('d F Y')}** sampai dengan **{$end->format('d F Y')}**, yang meliputi aspek kependudukan, pelayanan publik, ketatausahaan, pengelolaan aset, pelaksanaan anggaran, kegiatan kemasyarakatan, serta informasi dan komunikasi desa. Seluruh data yang disajikan bersumber dari sistem informasi desa dan diverifikasi oleh aparat pemerintahan desa.";

        return implode("\n\n", $lines);
    }

    private function narrateKependudukan(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];
        $lines[] = '**Gambaran Umum Kependudukan**';
        $lines[] = "Data kependudukan merupakan salah satu indikator fundamental dalam perencanaan dan evaluasi penyelenggaraan pemerintahan desa. Pada periode pelaporan ini, jumlah penduduk tercatat di Desa sebanyak **{$data['total_warga']} jiwa** yang terdaftar dalam sistem informasi penduduk desa.";

        if ($data['warga_baru_periode'] > 0) {
            $lines[] = '**Dinamika Pertumbuhan Penduduk**';
            $lines[] = "Selama periode {$start->format('d F Y')} hingga {$end->format('d F Y')}, tercatat penambahan **{$data['warga_baru_periode']} warga baru** yang melakukan pendaftaran dalam sistem kependudukan desa. Angka ini menunjukkan laju pertumbuhan penduduk sebesar **{$data['pertumbuhan_persen']}%** dari jumlah penduduk sebelumnya ({$data['warga_sebelum_periode']} jiwa). Pertumbuhan ini dapat diasosiasikan dengan beberapa faktor, antara lain migrasi masuk, kelahiran, atau optimalisasi pendataan penduduk oleh aparat desa.";
        } else {
            $lines[] = '**Stabilitas Jumlah Penduduk**';
            $lines[] = 'Selama periode ini, tidak tercatat penambahan warga baru dalam sistem kependudukan desa, yang mengindikasikan stabilitas jumlah penduduk atau belum optimalnya pendaftaran penduduk baru oleh masyarakat.';
        }

        if (! empty($data['distribusi_rt'])) {
            $rtCount = count($data['distribusi_rt']);
            $totalRt = array_sum($data['distribusi_rt']);
            $rataRt = $rtCount > 0 ? round($totalRt / $rtCount, 1) : 0;

            $lines[] = '**Distribusi Spasial Penduduk**';
            $lines[] = "Secara spasial, penduduk tersebar di **{$rtCount} Rukun Tetangga (RT)** dengan rata-rata **".number_format($rataRt, 0, ',', '.').' jiwa per RT**. Distribusi yang tidak merata ini mencerminkan karakteristik pemukiman desa yang memiliki densitas populasi berbeda di tiap wilayah administratif.';

            $topRt = array_search(max($data['distribusi_rt']), $data['distribusi_rt']);
            if ($topRt) {
                $pctTop = round(($data['distribusi_rt'][$topRt] / $totalRt) * 100, 1);
                $lines[] = "RT dengan konsentrasi penduduk tertinggi adalah **RT {$topRt}** dengan **{$data['distribusi_rt'][$topRt]} jiwa** ({$pctTop}% dari total).";
            }
            $botRt = array_search(min($data['distribusi_rt']), $data['distribusi_rt']);
            if ($botRt && $botRt !== $topRt) {
                $pctBot = round(($data['distribusi_rt'][$botRt] / $totalRt) * 100, 1);
                $lines[] = "Sebaliknya, RT dengan populasi paling rendah adalah RT {$botRt} dengan {$data['distribusi_rt'][$botRt]} jiwa ({$pctBot}% dari total). Ketimpangan distribusi ini perlu menjadi pertimbangan dalam alokasi sumber daya dan program pemberdayaan masyarakat.";
            }
        }

        if (! empty($data['distribusi_rw'])) {
            $rwCount = count($data['distribusi_rw']);
            $lines[] = "Secara hierarkis administratif, penduduk tersebar dalam **{$rwCount} Rukun Warga (RW)**, yang membentuk struktur pemerintahan desa dari tingkat atas hingga tingkat akar rumput.";
        }

        $lines[] = '**Implikasi**';
        $lines[] = 'Data kependudukan ini menjadi dasar penting dalam perencanaan pembangunan desa, penentuan alokasi anggaran, serta perumusan kebijakan pelayanan publik. Pemahaman terhadap dinamika dan distribusi penduduk memungkinkan pemerintah desa untuk merancang program yang tepat sasaran dan responsif terhadap kebutuhan masyarakat di tiap wilayah.';

        return implode("\n\n", $lines);
    }

    private function narratePelayananSurat(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];
        $periode = $start->format('d F Y').' hingga '.$end->format('d F Y');

        $lines[] = '**Gambaran Umum Pelayanan Surat**';
        $lines[] = "Pelayanan surat-menyurat merupakan salah satu bentuk layanan publik utama yang diselenggarakan oleh pemerintahan desa. Pada periode **{$periode}**, sistem pencatatan digital mencatatkan total **{$data['total']} pengajuan surat** dari warga yang masuk ke meja pelayanan desa.";

        if ($data['total'] > 0) {
            $lines[] = '**Tingkat Penyelesaian dan Alur Proses**';
            $lines[] = "Dari total {$data['total']} pengajuan yang diterima, sebanyak **{$data['selesai']} pengajuan ({$data['tingkat_persetujuan']}%)** telah berhasil diselesaikan dan mendapat tanda tangan elektronik dari pejabat berwenang. Sementara itu, {$data['ditolak']} pengajuan mengalami penolakan karena tidak memenuhi persyaratan administratif, {$data['revisi']} pengajuan dikembalikan kepada pemohon untuk perbaikan dokumen, dan {$data['aktif']} pengajuan masih dalam proses penyelesaian alur kerja pemerintahan desa.";

            if (! empty($data['jenis_terbanyak'])) {
                $jt = $data['jenis_terbanyak'];
                $pctJt = round(($jt['total'] / $data['total']) * 100, 1);
                $lines[] = '**Analisis Jenis Surat**';
                $lines[] = "Jenis surat yang paling banyak diajukan adalah **{$jt['jenis']}** dengan **{$jt['total']} pengajuan** ({$pctJt}% dari total). Dominasi jenis surat ini mengindikasikan kebutuhan primer masyarakat terhadap pelayanan dokumen tertentu, yang dapat menjadi acuan dalam perencanaan peningkatan kapasitas pelayanan.";
            }

            if ($data['rata_rata_hari'] > 0) {
                $lines[] = '**Efisiensi Waktu Pemrosesan**';
                $lines[] = "Rata-rata waktu pemrosesan dari tahap pengajuan hingga penyelesaian tercatat sebesar **{$data['rata_rata_hari']} hari** (setara dengan {$data['rata_rata_jam']} jam kerja). Indikator ini mencerminkan tingkat efisiensi dan responsivitas aparat desa dalam memberikan pelayanan kepada warga. Semakin rendah angka ini, semakin baik kualitas layanan yang diberikan.";
            }

            if (! empty($data['per_jenis'])) {
                $lines[] = '**Rincian per Jenis Surat**';
                $rincianLines = [];
                foreach ($data['per_jenis'] as $jenis) {
                    $rincianLines[] = "{$jenis['jenis']}: {$jenis['total']} pengajuan ({$jenis['selesai']} selesai)";
                }
                $lines[] = implode('; ', $rincianLines).'.';
            }
        } else {
            $lines[] = '**Catatan**';
            $lines[] = 'Tidak tercatat adanya pengajuan surat dari warga selama periode ini. Fenomena ini dapat mengindikasikan beberapa kemungkinan, antara lain belum optimalnya sosialisasi layanan digital, minimnya kebutuhan administratif warga pada periode ini, atau adanya hambatan akses terhadap layanan pengajuan surat.';
        }

        $lines[] = '**Penilaian**';
        $lines[] = "Tingkat penyelesaian sebesar {$data['tingkat_persetujuan']}% menunjukkan ".($data['tingkat_persetujuan'] >= 90 ? 'kinerja pelayanan yang sangat baik dan dapat diandalkan' : ($data['tingkat_persetujuan'] >= 70 ? 'kinerja pelayanan yang cukup baik namun masih memiliki ruang untuk peningkatan' : 'perlunya evaluasi menyeluruh terhadap prosedur dan kapasitas pelayanan surat-menyurat')).'.';

        return implode("\n\n", $lines);
    }

    private function narrateKetatausahaan(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];
        $total = $data['surat_masuk'] + $data['surat_keluar'];

        $lines[] = '**Gambaran Umum Ketatausahaan**';
        $lines[] = "Ketatausahaan desa merupakan tulang punggung operasional pemerintahan desa yang mengelola arus informasi dan komunikasi resmi antar-stakeholder. Selama periode pelaporan ini, unit ketatausahaan menangani total **{$total} surat** yang terdiri dari **{$data['surat_masuk']} surat masuk** dan **{$data['surat_keluar']} surat keluar**.";

        if ($data['surat_masuk'] > 0 && ! empty($data['per_jenis_masuk'])) {
            $lines[] = '**Klasifikasi Surat Masuk**';
            $rincian = [];
            foreach ($data['per_jenis_masuk'] as $jenis => $jml) {
                $pct = round(($jml / $data['surat_masuk']) * 100, 1);
                $rincian[] = ucfirst(str_replace('_', ' ', $jenis))." sebanyak {$jml} surat ({$pct}%)";
            }
            $lines[] = 'Surat masuk yang dikelola diklasifikasikan berdasarkan jenisnya, yaitu: '.implode('; ', $rincian).'. Klasifikasi ini membantu identifikasi pola komunikasi dan kebutuhan informasi yang paling dominan.';
        }

        if ($data['surat_masuk'] > 0 && ! empty($data['per_sifat_masuk'])) {
            $lines[] = '**Sifat dan Prioritas Surat**';
            $rincian = [];
            foreach ($data['per_sifat_masuk'] as $sifat => $jml) {
                $rincian[] = ucfirst(str_replace('_', ' ', $sifat))." sebanyak {$jml} surat";
            }
            $lines[] = 'Berdasarkan sifat surat, komposisinya adalah: '.implode('; ', $rincian).'. Surat ber sifat penting dan segera memerlukan prioritas penanganan yang lebih tinggi dibandingkan surat biasa, sehingga proporsi sifat surat menjadi indikator penting untuk penjadwalan kerja.';
        }

        if ($data['total_disposisi'] > 0) {
            $selesaiDisposisi = $data['total_disposisi'] - $data['disposisi_pending'];
            $pctSelesai = round(($selesaiDisposisi / $data['total_disposisi']) * 100, 1);
            $lines[] = '**Manajemen Disposisi**';
            $lines[] = "Sebanyak **{$data['total_disposisi']} disposisi** telah diproses, di mana **{$selesaiDisposisi} disposisi ({$pctSelesai}%)** telah ditindaklanjuti sesuai perintah atasan dan **{$data['disposisi_pending']} disposisi** masih dalam proses penyelesaian. Kemampuan menyelesaikan disposisi secara tepat waktu merupakan indikator kunci efektivitas alur kerja internal pemerintahan desa.";
        } else {
            $lines[] = '**Manajemen Disposisi**';
            $lines[] = 'Tidak tercatat adanya disposisi surat selama periode ini, yang dapat mengindikasikan bahwa arus surat masuk belum memerlukan penanganan khusus atau mekanisme disposisi belum diterapkan secara optimal.';
        }

        return implode("\n\n", $lines);
    }

    private function narrateInventarisAset(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];

        $lines[] = '**Gambaran Umum Inventaris dan Aset**';
        $lines[] = "Pengelolaan inventaris dan aset desa merupakan bagian integral dari tata kelola pemerintahan desa yang baik (good governance). Pada periode pelaporan ini, Desa mengelola sejumlah **{$data['total_barang']} item inventaris/aset** dengan total nilai perolehan tercatat sebesar **{$data['formatted_nilai']}**.";

        if ($data['baru_periode'] > 0) {
            $lines[] = '**Dinamika Penambahan Aset**';
            $lines[] = "Selama periode {$start->format('d F Y')} hingga {$end->format('d F Y')}, sebanyak **{$data['baru_periode']} item baru** telah ditambahkan ke dalam inventaris desa. Penambahan ini mencerminkan upaya pemerintahan desa dalam pemenuhan kebutuhan sarana dan prasarana pendukung operasional pelayanan publik.";
        } else {
            $lines[] = '**Stabilitas Aset**';
            $lines[] = 'Tidak tercatat adanya penambahan item inventaris baru selama periode ini, yang mengindikasikan bahwa kondisi inventaris yang ada sudah memadai untuk mendukung operasional pemerintahan desa, atau bahwa proses pengadaan barang dan jasa belum dilaksanakan pada periode ini.';
        }

        if (! empty($data['per_kondisi'])) {
            $lines[] = '**Kondisi Fisik Aset**';
            $kondisiParts = [];
            foreach ($data['per_kondisi'] as $kondisi => $jml) {
                $pct = round(($jml / $data['total_barang']) * 100, 1);
                $kondisiParts[] = "**{$jml} {$kondisi}** ({$pct}%)";
            }
            $lines[] = 'Evaluasi kondisi fisik inventaris menunjukkan komposisi sebagai berikut: '.implode(', ', $kondisiParts).'. Kondisi fisik aset ini menjadi indikator penting untuk perencanaan pemeliharaan, penggantian, dan pengadaan barang inventaris di periode mendatang.';
        }

        if (! empty($data['per_kategori'])) {
            $lines[] = '**Distribusi Berdasarkan Kategori**';
            $rincian = [];
            foreach ($data['per_kategori'] as $kategori => $jml) {
                $pct = round(($jml / $data['total_barang']) * 100, 1);
                $rincian[] = ucfirst(str_replace('_', ' ', $kategori)).": {$jml} item ({$pct}%)";
            }
            $lines[] = 'Inventaris diklasifikasikan ke dalam beberapa kategori: '.implode('; ', $rincian).'.';
        }

        if (! empty($data['per_status'])) {
            $lines[] = '**Status Penggunaan**';
            $rincian = [];
            foreach ($data['per_status'] as $status => $jml) {
                $pct = round(($jml / $data['total_barang']) * 100, 1);
                $rincian[] = ucfirst($status).": {$jml} item ({$pct}%)";
            }
            $lines[] = 'Status penggunaan inventaris: '.implode('; ', $rincian).'. Analisis status penggunaan membantu identifikasi aset yang belum optimal dimanfaatkan atau yang memerlukan reposisi.';
        }

        $lines[] = '**Catatan Penilaian**';
        $lines[] = 'Pengelolaan inventaris desa memerlukan komitmen berkelanjutan dalam pemeliharaan, pencatatan, dan audit aset secara berkala untuk memastikan kepatuhan terhadap regulasi pengelolaan barang milik desa.';

        return implode("\n\n", $lines);
    }

    private function narrateAnggaran(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];

        $lines[] = '**Gambaran Umum APBDesa**';
        $lines[] = "Anggaran Pendapatan dan Belanja Desa (APBDesa) tahun **{$data['tahun']}** merupakan dokumen perencanaan keuangan desa yang menjadi dasar pelaksanaan seluruh kegiatan pemerintahan, pembangunan, dan kemasyarakatan. Total alokasi anggaran sebesar **{$data['formatted_anggaran']}** dengan realisasi sebesar **{$data['formatted_realisasi']}** menghasilkan tingkat realisasi sebesar **{$data['persentase_realisasi']}%**.";

        $lines[] = '**Analisis Realisasi Anggaran**';
        if ($data['persentase_realisasi'] >= 90) {
            $lines[] = "Tingkat realisasi yang mencapai **{$data['persentase_realisasi']}%** menunjukkan bahwa pelaksanaan anggaran berjalan dengan sangat baik dan sesuai perencanaan. Capaian ini merupakan indikator positif bahwa program kerja dan kegiatan pembangunan desa dapat terlaksana secara efektif dan efisien.";
        } elseif ($data['persentase_realisasi'] >= 70) {
            $lines[] = "Tingkat realisasi sebesar **{$data['persentase_realisasi']}%** tergolong cukup baik namun masih menyisakan ruang peningkatan sebesar ".(100 - $data['persentase_realisasi']).'%. Perlu dilakukan identifikasi kendala terhadap program yang belum terlaksana agar realisasi dapat dioptimalkan di sisa periode atau periode berikutnya.';
        } else {
            $lines[] = "Tingkat realisasi sebesar **{$data['persentase_realisasi']}%** berada di bawah ambang batas ideal (70%). Hal ini perlu mendapat perhatian serius karena mengindikasikan adanya keterlambatan atau hambatan dalam pelaksanaan program kerja. Evaluasi menyeluruh terhadap faktor penyebab perlu dilakukan secara komprehensif.";
        }

        if (! empty($data['per_kategori'])) {
            $lines[] = '**Komposisi Anggaran Berdasarkan Kategori**';
            $rincian = [];
            foreach ($data['per_kategori'] as $kat) {
                $anggaranKat = $kat['anggaran'] > 0 ? 'Rp '.number_format($kat['anggaran'], 0, ',', '.') : '-';
                $rincian[] = "{$kat['kategori']}: anggaran {$anggaranKat}, realisasi Rp ".number_format($kat['realisasi'], 0, ',', '.')." (**{$kat['persentase']}%**)";
            }
            $lines[] = implode('. ', $rincian).'.';
        }

        if (! empty($data['per_bidang'])) {
            $lines[] = '**Realisasi Berdasarkan Bidang Kegiatan**';
            $rincian = [];
            foreach ($data['per_bidang'] as $bidang) {
                $pct = $bidang['anggaran'] > 0 ? round(($bidang['realisasi'] / $bidang['anggaran']) * 100, 1) : 0;
                $rincian[] = "{$bidang['bidang']}: anggaran Rp ".number_format($bidang['anggaran'], 0, ',', '.').', realisasi Rp '.number_format($bidang['realisasi'], 0, ',', '.')." ({$pct}%)";
            }
            $lines[] = 'Distribusi anggaran dan realisasi berdasarkan bidang kegiatan: '.implode('. ', $rincian).'.';
        }

        $lines[] = '**Catatan**';
        $lines[] = "Terdapat **{$data['jumlah_items']} item** anggaran yang tercatat dalam APBDesa tahun {$data['tahun']}. Evaluasi berkala terhadap realisasi anggaran perlu dilakukan untuk memastikan seluruh program dan kegiatan dapat terlaksana sesuai rencana dan memberikan manfaat optimal bagi masyarakat desa.";

        return implode("\n\n", $lines);
    }

    private function narrateKegiatan(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];

        $lines[] = '**Gambaran Umum Kegiatan Desa**';
        $lines[] = "Penyelenggaraan kegiatan dan event desa merupakan wujud nyata partisipasi pemerintahan desa dalam pemenuhan kebutuhan sosial, budaya, dan kemasyarakatan warga. Pada periode pelaporan ini, tercatat sebanyak **{$data['total']} kegiatan** yang telah dilaksanakan atau direncanakan oleh pemerintahan desa.";

        if ($data['selesai'] > 0 && $data['mendatang'] > 0) {
            $pctSelesai = round(($data['selesai'] / $data['total']) * 100, 1);
            $lines[] = '**Status Pelaksanaan**';
            $lines[] = "Dari {$data['total']} kegiatan tersebut, sebanyak **{$data['selesai']} kegiatan ({$pctSelesai}%)** telah berhasil terlaksana sesuai rencana, sementara **{$data['mendatang']} kegiatan** masih dalam tahap pelaksanaan atau menunggu waktu pelaksanaan di masa mendatang.";
        } elseif ($data['selesai'] > 0) {
            $lines[] = '**Status Pelaksanaan**';
            $lines[] = "Seluruh **{$data['selesai']} kegiatan** yang direncanakan telah berhasil terlaksana, yang menunjukkan kemampuan pemerintahan desa dalam mengelola dan mengeksekusi program kerja secara konsisten.";
        } elseif ($data['mendatang'] > 0) {
            $lines[] = '**Status Pelaksanaan**';
            $lines[] = "Sebanyak **{$data['mendatang']} kegiatan** masih dalam tahap rencana dan pelaksanaan, yang menunjukkan adanya pipeline program kerja yang perlu dipantau dan dikelola agar dapat terlaksana sesuai jadwal.";
        }

        if ($data['total_peserta'] > 0) {
            $tingkatPartisipasi = round(($data['konfirmasi_hadir'] / $data['total_peserta']) * 100, 1);
            $lines[] = '**Partisipasi Masyarakat**';
            $lines[] = "Total partisipasi warga dalam kegiatan desa mencapai **{$data['total_peserta']} orang**, dengan **{$data['konfirmasi_hadir']} orang ({$tingkatPartisipasi}%)** dikonfirmasi hadir. Tingkat partisipasi ini merupakan indikator kunci keberhasilan program pemberdayaan masyarakat dan efektivitas komunikasi pemerintah desa dalam menghimpun partisipasi warga.";
        }

        if (! empty($data['per_jenis'])) {
            $lines[] = '**Klasifikasi Berdasarkan Jenis**';
            $rincian = [];
            foreach ($data['per_jenis'] as $jenis => $jml) {
                $pct = round(($jml / $data['total']) * 100, 1);
                $rincian[] = ucfirst(str_replace('_', ' ', $jenis)).": {$jml} kegiatan ({$pct}%)";
            }
            $lines[] = 'Kegiatan desa terbagi menjadi beberapa kategori: '.implode('; ', $rincian).'.';
        }

        $lines[] = '**Penilaian**';
        $lines[] = 'Penyelenggaraan kegiatan desa perlu terus dievaluasi dari aspek partisipasi, efektivitas, dan dampak terhadap masyarakat. Kegiatan dengan tingkat partisipasi tinggi menunjukkan keberhasilan mobilisasi masyarakat, sementara kegiatan dengan partisipasi rendah perlu dievaluasi dari aspek sosialisasi dan relevansi terhadap kebutuhan warga.';

        return implode("\n\n", $lines);
    }

    private function narrateBeritaInformasi(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];

        $lines[] = '**Gambaran Umum Informasi Desa**';
        $lines[] = "Pemerintahan desa berperan aktif dalam menyampaikan informasi kepada masyarakat melalui publikasi berita dan pengelolaan portal informasi desa. Pada periode pelaporan ini, tercatat **{$data['total']} artikel/berita** yang dikelola oleh unit terkait.";

        if ($data['published'] > 0) {
            $lines[] = '**Publikasi dan Diseminasi**';
            $lines[] = "Sebanyak **{$data['published']} berita** telah berhasil dipublikasikan dan dapat diakses oleh seluruh warga melalui portal informasi desa. Publikasi informasi secara berkala dan transparan merupakan wujud komitmen pemerintahan desa terhadap keterbukaan informasi publik (public disclosure) sebagaimana diamanatkan oleh peraturan perundang-undangan.";
        }
        if ($data['draft'] > 0) {
            $lines[] = '**Pipeline Konten**';
            $lines[] = "Selain itu, terdapat **{$data['draft']} berita** yang masih dalam tahap draf dan belum dipublikasikan. Draf-draf ini perlu dievaluasi dan diselesaikan agar informasi yang relevan dapat segera disampaikan kepada masyarakat.";
        }

        if (! empty($data['terbaru'])) {
            $lines[] = '**Daftar Publikasi Terbaru**';
            $daftarItems = [];
            foreach ($data['terbaru'] as $berita) {
                $statusLabel = $berita['status'] === 'published' ? 'Diterbitkan' : 'Draf';
                $daftarItems[] = "\"{$berita['judul']}\" ({$statusLabel}, {$berita['tanggal']})";
            }
            $lines[] = 'Berita terbaru yang dikelola: '.implode('. ', $daftarItems).'.';
        }

        $lines[] = '**Penilaian**';
        $lines[] = 'Kecepatan dan akurasi diseminasi informasi merupakan kunci dalam membangun kepercayaan masyarakat terhadap pemerintahan desa. Rasio publikasi terhadap draf menunjukkan efisiensi alur kerja pengelolaan konten informasi desa.';

        return implode("\n\n", $lines);
    }

    private function gatherKesimpulan(Carbon $start, Carbon $end): array
    {
        $allData = $this->gatherAllData(
            array_filter(self::MODULES, fn ($m) => $m !== 'kesimpulan'),
            $start,
            $end
        );

        $temuan = [];
        $rekomendasi = [];

        if (isset($allData['kependudukan'])) {
            $k = $allData['kependudukan'];
            $temuan[] = "Penduduk tercatat sebanyak {$k['total_warga']} jiwa dengan pertumbuhan {$k['pertumbuhan_persen']}%.";
        }

        if (isset($allData['pelayanan_surat'])) {
            $ps = $allData['pelayanan_surat'];
            $temuan[] = "Pelayanan surat mencatat {$ps['total']} pengajuan dengan tingkat penyelesaian {$ps['tingkat_persetujuan']}% dan rata-rata waktu pemrosesan {$ps['rata_rata_hari']} hari.";
            if ($ps['tingkat_persetujuan'] < 80) {
                $rekomendasi[] = 'Tingkatkan efisiensi pemrosesan surat agar mencapai tingkat penyelesaian minimal 80%. Evaluasi alur kerja dan kapasitas SDM pelayanan.';
            }
            if ($ps['rata_rata_hari'] > 3) {
                $rekomendasi[] = 'Percepat waktu pemrosesan surat agar tidak melebihi 3 hari kerja melalui optimalisasi prosedur operasional standar (SOP).';
            }
        }

        if (isset($allData['ketatausahaan'])) {
            $kt = $allData['ketatausahaan'];
            $totalSurat = $kt['surat_masuk'] + $kt['surat_keluar'];
            $temuan[] = "Ketatausahaan menangani {$totalSurat} surat dengan {$kt['total_disposisi']} disposisi.";
            if ($kt['disposisi_pending'] > 0) {
                $rekomendasi[] = "Tyelesaikan {$kt['disposisi_pending']} disposisi yang masih pending agar alur kerja internal tetap lancar.";
            }
        }

        if (isset($allData['inventaris_aset'])) {
            $inv = $allData['inventaris_aset'];
            $temuan[] = "Inventaris desa mencakup {$inv['total_barang']} item dengan total nilai {$inv['formatted_nilai']}.";
            if (! empty($inv['per_kondisi']) && isset($inv['per_kondisi']['rusak'])) {
                $rekomendasi[] = 'Segera lakukan penggantian atau perbaikan inventaris dalam kondisi rusak untuk menjaga kualitas aset desa.';
            }
        }

        if (isset($allData['anggaran'])) {
            $ang = $allData['anggaran'];
            $temuan[] = "APBDesa tahun {$ang['tahun']} terealisasi sebesar {$ang['persentase_realisasi']}% dari total anggaran {$ang['formatted_anggaran']}.";
            if ($ang['persentase_realisasi'] < 70) {
                $rekomendasi[] = 'Evaluasi realisasi anggaran yang masih di bawah 70%. Identifikasi kendala teknis dan administratif pada program yang belum terlaksana.';
            }
        }

        if (isset($allData['kegiatan'])) {
            $kg = $allData['kegiatan'];
            $temuan[] = "Tercatat {$kg['total']} kegiatan dengan {$kg['total_peserta']} partisipan.";
            if ($kg['total'] === 0) {
                $rekomendasi[] = 'Tingkatkan penyelenggaraan kegiatan desa untuk mempererat keterlibatan warga dan memperkuat modal sosial masyarakat.';
            }
        }

        if (isset($allData['berita_informasi'])) {
            $bi = $allData['berita_informasi'];
            $temuan[] = "Portal informasi desa menerbitkan {$bi['published']} berita dari {$bi['total']} yang dikelola.";
        }

        if (empty($rekomendasi)) {
            $rekomendasi[] = 'Secara umum, penyelenggaraan pemerintahan desa berjalan dengan baik dan sesuai perencanaan.';
            $rekomendasi[] = 'Pertahankan capaian kinerja dan lakukan evaluasi berkala untuk identifikasi area peningkatan.';
            $rekomendasi[] = 'Optimalkan pemanfaatan data kuantitatif dalam perencanaan program di periode mendatang.';
        }

        return [
            'total_data_modul' => count($allData),
            'temuan' => $temuan,
            'rekomendasi' => $rekomendasi,
            'data' => $allData,
        ];
    }

    private function narrateKesimpulan(array $data, Carbon $start, Carbon $end): string
    {
        $lines = [];
        $periode = $start->format('d F Y').' hingga '.$end->format('d F Y');

        $lines[] = '**Rangkuman Temuan**';
        $lines[] = "Berdasarkan analisis kuantitatif terhadap **{$data['total_data_modul']} modul** data selama periode **{$periode}**, berikut merupakan rangkuman temuan utama:";

        if (! empty($data['temuan'])) {
            $temuanLines = [];
            foreach ($data['temuan'] as $idx => $temuan) {
                $temuanLines[] = ($idx + 1).". {$temuan}";
            }
            $lines[] = implode("\n", $temuanLines);
        }

        $lines[] = '**Rekomendasi**';
        $lines[] = 'Berdasarkan temuan di atas, disusun rekomendasi kebijakan sebagai berikut:';

        if (! empty($data['rekomendasi'])) {
            $rekLines = [];
            foreach ($data['rekomendasi'] as $idx => $rek) {
                $rekLines[] = ($idx + 1).". {$rek}";
            }
            $lines[] = implode("\n", $rekLines);
        }

        $lines[] = '**Penutup**';
        $lines[] = 'Rekomendasi di atas merupakan masukan konstruktif bagi pemerintahan desa dalam menyusun perencanaan strategis periode berikutnya. Pelaksanaannya memerlukan koordinasi lintas sektoral dan partisipasi aktif seluruh pemangku kepentingan (stakeholder) desa.';

        return implode("\n\n", $lines);
    }
}
