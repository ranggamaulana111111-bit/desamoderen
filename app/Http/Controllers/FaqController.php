<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private array $knowledge = [];

    private array $synonyms = [
        'daftar' => ['register', 'registrasi', 'mendaftar', 'pendaftaran', 'daftar'],
        'login' => ['masuk', 'log in', 'sign in', 'masuk'],
        'logout' => ['keluar', 'log out', 'sign out'],
        'biaya' => ['ongkos', 'tarif', 'harga', 'bayar', 'pembayaran', 'gratis', 'free', 'gratis'],
        'cetak' => ['print', 'download', 'unduh', 'pdf'],
        'surat' => ['dokumen', 'berkas', 'pengajuan'],
        'sktm' => ['surat keterangan tidak mampu', 'tidak mampu', 'miskin', 'kurang mampu'],
        'ktp' => ['kartu tanda penduduk', 'e-ktp', 'ktp sementara', 'ktp elektronik'],
        'kk' => ['kartu keluarga', 'family card', 'kartu keluarga'],
        'akta' => ['akta kelahiran', 'akta kematian', 'akta lahir', 'akte'],
        'admin' => ['petugas', 'operator', 'perangkat desa', 'pegawai'],
        'lama' => ['durasi', 'waktu', 'proses', 'hari', 'cepat'],
        'salah' => ['error', 'gagal', 'tidak bisa', 'masalah', 'error', 'bug'],
        'data' => ['informasi', 'detail', 'info'],
        'desa' => ['kampung', 'dusun', 'kumpay'],
        'nik' => ['no induk kependudukan', 'nomor induk', 'ktp'],
        'siapa' => ['siapakah', 'siapa itu', 'apakah itu'],
    ];

    public function ask(Request $request)
    {
        $question = trim($request->input('question', ''));

        if (empty($question)) {
            return response()->json([
                'answer' => 'Silakan ketik pertanyaan terlebih dahulu ya, saya siap membantu!',
            ]);
        }

        $this->buildKnowledge();

        $answer = $this->findBestMatch($question);

        return response()->json([
            'answer' => $answer,
        ]);
    }

    private function buildKnowledge(): void
    {
        $this->knowledge = [
            // ── Sapa & Obrolan Umum ──
            ['q' => 'halo', 'a' => 'Halo! Senang bertemu kamu. Ada yang bisa saya bantu seputar layanan desa? Coba tanya soal pendaftaran, SKTM, atau cara cetak surat ya!'],
            ['q' => 'selamat pagi', 'a' => 'Selamat pagi! Semoga hari Anda menyenangkan. Ada yang bisa saya bantu?'],
            ['q' => 'selamat siang', 'a' => 'Selamat siang! Ada keperluan layanan desa hari ini?'],
            ['q' => 'selamat malam', 'a' => 'Selamat malam! Walau sudah malam, saya tetap siap bantu informasi seputar desa.'],
            ['q' => 'terima kasih', 'a' => 'Sama-sama! Senang bisa membantu. Kalau ada pertanyaan lain, jangan ragu tanya lagi ya.'],
            ['q' => 'makasih', 'a' => 'Sama-sama! Semoga hari Anda menyenangkan.'],
            ['q' => 'siapa kamu', 'a' => 'Saya AI Assistant Prodesa — asisten virtual '.config('village.nama_desa', 'Desa').'! Saya bisa bantu menjawab pertanyaan seputar layanan surat, pendaftaran, berita desa, dan informasi desa lainnya.'],
            ['q' => 'siapa pembuatmu', 'a' => 'Saya dikembangkan oleh tim pengembang Prodesa untuk membantu warga '.config('village.nama_desa', 'Desa').' mengakses informasi layanan desa secara mudah dan cepat.'],
            ['q' => 'apa kabar', 'a' => 'Baik banget! Alhamdulillah selalu siap bantu warga. Gimana kabar kamu? Ada yang bisa saya bantu?'],
            ['q' => 'kamu pintar', 'a' => 'Terima kasih apresiasinya! Masih belajar terus nih biar makin bisa bantu warga dengan lebih baik :)'],
            ['q' => 'bisa bahasa inggris', 'a' => 'Yes, I can speak English a little! But I\'m best at Bahasa Indonesia. Feel free to ask in English or Indonesian.'],
            ['q' => 'selamat', 'a' => 'Terima kasih! Ada yang ingin ditanyakan?'],
            ['q' => 'hai', 'a' => 'Hai hai! Ada yang bisa saya bantu? Seru lho layanan desa sekarang udah online!'],
            ['q' => 'assalamualaikum', 'a' => 'Wa\'alaikumussalam warahmatullahi wabarakatuh! Ada yang bisa saya bantu?'],
            ['q' => 'p', 'a' => 'Ya, ada pertanyaan? Silakan tanya apa pun seputar desa ya.'],

            // ── Profil Desa ──
            ['q' => 'desa kumpay', 'a' => 'Desa Kumpay adalah desa di Kecamatan Banjarsari, Kabupaten Lebak, Banten. Desa ini memiliki potensi pertanian, perkebunan, dan UMKM yang berkembang. Dengan Prodesa, warga bisa mengurus surat menyurat secara online tanpa ribet.'],
            ['q' => 'kecamatan banjarsari', 'a' => 'Kecamatan Banjarsari adalah salah satu kecamatan di Kabupaten Lebak, Banten. Desa Kumpay berada di wilayah Kecamatan Banjarsari.'],
            ['q' => 'lebak', 'a' => 'Kabupaten Lebak adalah kabupaten di Provinsi Banten, dikenal dengan wisata alamnya. Desa Kumpay berada di Kecamatan Banjarsari, Kabupaten Lebak.'],
            ['q' => 'alamat kantor desa', 'a' => 'Kantor Desa Kumpay beralamat di '.config('village.alamat_kantor', 'Jl. Raya Kumpay No. 1, Kec. Banjarsari, Kab. Lebak, Banten').'.'],
            ['q' => 'visi misi desa', 'a' => 'Visi '.config('village.nama_desa', 'Desa').' adalah mewujudkan desa yang maju, mandiri, dan sejahtera melalui pelayanan prima dan pembangunan partisipatif. Misi-nya meliputi peningkatan kualitas pelayanan publik, pemberdayaan masyarakat, dan pembangunan infrastruktur berkelanjutan.'],
            ['q' => 'jumlah penduduk', 'a' => 'Informasi jumlah penduduk '.config('village.nama_desa', 'Desa').' bisa dicek langsung ke kantor desa atau melalui data kependudukan terbaru. Saat ini, pengguna terdaftar di Prodesa sudah mencapai ribuan warga.'],
            ['q' => 'batas desa', 'a' => 'Desa '.config('village.nama_desa', 'Desa').' berbatasan dengan desa-desa lain di Kecamatan Banjarsari. Untuk batas administrasi yang lebih detail, silakan hubungi kantor desa langsung ya.'],

            // ── Pendaftaran & Akun ──
            ['q' => 'bagaimana cara mendaftar', 'a' => 'Caranya gampang! Klik tombol "Daftar Warga" di halaman utama, lalu isi formulir pendaftaran dengan NIK, nama lengkap, dan password. Setelah itu kamu bisa langsung login menggunakan NIK dan password yang didaftarkan.'],
            ['q' => 'syarat pendaftaran', 'a' => 'Syarat mendaftar di Prodesa: 1) Warga '.config('village.nama_desa', 'Desa').', 2) Memiliki NIK yang terdaftar di data kependudukan desa, 3) Data diri lengkap (nama, tempat/tanggal lahir, alamat, RT/RW). Pastikan data yang dimasukkan sesuai dengan KTP ya!'],
            ['q' => 'lupa password', 'a' => 'Saat ini fitur reset password belum tersedia. Silakan hubungi admin desa atau perangkat desa setempat untuk bantuan reset password akun Anda.'],
            ['q' => 'lupa nik', 'a' => 'NIK bisa dicek di Kartu Tanda Penduduk (KTP) atau Kartu Keluarga (KK). Jika kehilangan, silakan hubungi kantor desa untuk informasi lebih lanjut.'],
            ['q' => 'ubah data diri', 'a' => 'Untuk mengubah data diri, silakan hubungi admin desa karena perubahan data kependudukan memerlukan verifikasi dari perangkat desa.'],
            ['q' => 'hapus akun', 'a' => 'Untuk penghapusan akun, silakan datang langsung ke kantor desa atau hubungi admin melalui halaman dashboard.'],
            ['q' => 'verifikasi akun', 'a' => 'Setelah mendaftar, akun Anda langsung aktif dan bisa digunakan untuk login serta mengajukan surat online. Pastikan data yang dimasukkan sudah benar ya!'],

            // ── SKTM ──
            ['q' => 'apa itu sktm', 'a' => 'SKTM adalah Surat Keterangan Tidak Mampu. Surat ini diterbitkan oleh '.config('village.nama_desa', 'Desa').' untuk warga yang termasuk golongan tidak mampu secara ekonomi. Biasanya digunakan untuk berobat gratis atau keringanan biaya di Puskesmas dan Rumah Sakit.'],
            ['q' => 'syarat sktm', 'a' => 'Syarat pengajuan SKTM: 1) Warga '.config('village.nama_desa', 'Desa').' terdaftar, 2) Memiliki KTP dan KK, 3) Data penghasilan per bulan, 4) Alasan pengajuan (misal: untuk berobat). Semua data diisi melalui form online.'],
            ['q' => 'cara buat sktm', 'a' => 'Cara buat SKTM online: 1) Login ke akun warga, 2) Kiri menu Surat Saya, 3) Pilih "Ajukan Surat Baru", 4) Pilih jenis "Surat Keterangan Tidak Mampu", 5) Isi data yang diminta (nama, NIK, penghasilan, alasan), 6) Klik Ajukan. Setelah itu tinggal tunggu verifikasi admin.'],
            ['q' => 'sktm untuk bpjs', 'a' => 'SKTM bisa digunakan untuk mengurus keringanan BPJS Kesehatan atau bantuan iuran. Dengan SKTM dari desa, Anda bisa mendapatkan faskes tingkat pertama secara gratis.'],
            ['q' => 'sktm untuk sekolah', 'a' => 'SKTM bisa digunakan untuk mendapatkan keringanan biaya sekolah, seperti beasiswa atau bantuan pendidikan lainnya. Surat ini menjadi bukti bahwa orang tua/wali termasuk golongan tidak mampu.'],
            ['q' => 'contoh sktm', 'a' => 'Setelah pengajuan SKTM Anda selesai (status "Selesai"), Anda bisa mencetak PDF langsung dari dashboard. PDF tersebut sudah siap pakai dengan kop surat resmi '.config('village.nama_desa', 'Desa').'.'],

            // ── Kartu Keluarga (KK) ──
            ['q' => 'kk hilang', 'a' => 'Jika Kartu Keluarga (KK) hilang, segera laporkan ke kantor desa setempat untuk mendapatkan surat keterangan kehilangan. Setelah itu, bawa surat tersebut ke Dinas Dukcapil untuk mengurus cetak ulang KK. Sementara menunggu, Anda bisa minta surat keterangan pengganti dari desa.'],
            ['q' => 'cara buat kk baru', 'a' => 'Untuk membuat KK baru (misal setelah nikah atau pisah kartu), Anda perlu datang ke kantor desa dengan membawa: 1) Surat pengantar dari RT/RW, 2) Fotokopi KTP suami/istri, 3) Akta nikah (jika baru menikah), 4) KK lama (jika ada). Setelah itu ke Dukcapil untuk proses penerbitan.'],
            ['q' => 'ubah kk', 'a' => 'Perubahan data KK (seperti pindah, tambah anggota, atau perubahan status) bisa diurus melalui kantor desa dengan membawa dokumen pendukung. Ajukan surat pengantar perubahan KK di dashboard Prodesa terlebih dahulu.'],

            // ── KTP Sementara ──
            ['q' => 'ktp sementara', 'a' => 'Surat Keterangan Pengganti KTP (KTP sementara) adalah surat yang diterbitkan desa untuk warga yang sedang dalam proses pembuatan KTP di Dinas Dukcapil. Surat ini berlaku selama 30 hari dan bisa digunakan sebagai identitas sementara.'],
            ['q' => 'cara buat ktp sementara', 'a' => 'Caranya: 1) Login, 2) Ajukan surat baru, pilih "Surat Keterangan Pengganti KTP", 3) Isi data diri dan alasan pembuatan KTP, 4) Tunggu verifikasi admin. Setelah selesai, bisa dicetak PDF.'],
            ['q' => 'ktp hilang', 'a' => 'Jika KTP hilang, Anda bisa mengurus surat keterangan pengganti KTP sementara dulu melalui Prodesa. Namun, tetap perlu lapor ke kantor desa/dukcapil untuk pembuatan KTP baru.'],
            ['q' => 'buat ktp baru', 'a' => 'Pembuatan KTP baru dilakukan di Dinas Dukcapil, bukan di desa. Desa hanya menerbitkan surat pengantar KTP. Caranya: 1) Datang ke kantor desa dengan membawa KK dan akta kelahiran, 2) Minta surat pengantar pembuatan KTP, 3) Bawa surat pengantar + dokumen ke Dukcapil untuk perekaman dan pencetakan KTP. Untuk KTP elektronik, biasanya ada jadwal perekaman dari desa.'],

            // ── Akta ──
            ['q' => 'akta kelahiran', 'a' => 'Surat pengantar akta kelahiran diterbitkan desa untuk mengurus akta kelahiran di Dinas Kependudukan dan Pencatatan Sipil. Ajukan melalui menu surat di dashboard warga.'],
            ['q' => 'akta kematian', 'a' => 'Surat pengantar akta kematian diterbitkan desa untuk mengurus akta kematian di Dinas Kependudukan dan Pencatatan Sipil. Sertakan surat keterangan kematian dari rumah sakit/kelurahan.'],
            ['q' => 'cara buat akta', 'a' => 'Cara mengurus akta: 1) Ajukan surat pengantar akta di Prodesa, 2) Pilih jenis akta (kelahiran/kematian), 3) Isi data yang diminta, 4) Setelah disetujui, download PDF dan bawa ke Dinas Kependudukan setempat.'],

            // ── Alur & Proses ──
            ['q' => 'berapa lama proses pengajuan', 'a' => 'Proses pengajuan biasanya selesai dalam 1-3 hari kerja setelah data diverifikasi oleh perangkat desa. Kalau lagi banyak pengajuan, bisa lebih lama sedikit. Pantau terus status di dashboard kamu ya!'],
            ['q' => 'cek status pengajuan', 'a' => 'Cara cek status pengajuan: 1) Login ke akun warga, 2) Buka menu "Surat Saya", di sana kamu bisa lihat status setiap pengajuan (Pending, Proses, Selesai, atau Ditolak) lengkap dengan tanggal pengajuannya.'],
            ['q' => 'status ditolak', 'a' => 'Jika pengajuan ditolak, jangan khawatir! Biasanya ada catatan dari admin kenapa ditolaknya. Cek catatan tersebut, perbaiki datanya, lalu ajukan ulang. Admin siap membantu jika ada yang kurang jelas.'],
            ['q' => 'proses verifikasi', 'a' => 'Setelah kamu ajukan surat, admin desa akan memverifikasi data kamu. Proses verifikasi meliputi pengecekan kelengkapan data dan validasi kependudukan. Status akan berubah dari "Pending" menjadi "Proses" lalu "Selesai".'],
            ['q' => 'surat ditolak terus', 'a' => 'Jika pengajuan ditolak berulang kali, sebaiknya hubungi admin desa langsung. Mungkin ada masalah dengan data kependudukan yang perlu diperbaiki. Admin bisa dihubungi melalui dashboard.'],

            // ── Teknis Cetak ──
            ['q' => 'cara cetak surat', 'a' => 'Cetak surat itu mudah! 1) Pastikan status pengajuan sudah "Selesai", 2) Buka halaman "Surat Saya" di dashboard warga, 3) Klik tombol "Cetak PDF" di baris pengajuan yang sudah selesai. Surat akan otomatis terdownload dalam format PDF siap pakai!'],
            ['q' => 'pdf tidak bisa dibuka', 'a' => 'Jika file PDF tidak bisa dibuka, coba: 1) Gunakan browser seperti Chrome atau Firefox, 2) Pastikan tidak ada pop-up blocker yang memblokir download, 3) Coba buka menggunakan aplikasi PDF reader seperti Adobe Acrobat.'],
            ['q' => 'cetak ulang surat', 'a' => 'Surat yang sudah selesai bisa dicetak ulang kapan saja selama akun kamu masih aktif. Tinggal buka "Surat Saya" dan klik "Cetak PDF" untuk surat yang ingin dicetak ulang.'],
            ['q' => 'surat hilang', 'a' => 'Tenang, surat di Prodesa tersimpan secara digital. Kamu bisa mencetak ulang kapan saja dari dashboard. Surat versi PDF yang sudah didownload juga bisa disimpan di device kamu.'],

            // ── Administrasi ──
            ['q' => 'jam kerja kantor desa', 'a' => 'Kantor '.config('village.nama_desa', 'Desa').' buka setiap hari Senin - Jumat, pukul 08.00 - 15.00 WIB. Istirahat pukul 12.00 - 13.00 WIB.'],
            ['q' => 'hubungi admin', 'a' => 'Kamu bisa menghubungi admin desa melalui: 1) Pesan di dashboard (jika ada fitur chat), 2) Datang langsung ke kantor desa jam kerja, 3) Melalui perangkat RT/RW setempat.'],
            ['q' => 'pengaduan', 'a' => 'Untuk pengaduan atau masukan, silakan sampaikan ke kantor desa langsung atau melalui perangkat RT/RW setempat. Kami terbuka terhadap kritik dan saran untuk pelayanan yang lebih baik.'],
            ['q' => 'surat menyurat online', 'a' => 'Prodesa adalah sistem pelayanan surat menyurat desa secara online. Warga bisa mengajukan SKTM, KTP sementara, dan pengantar akta tanpa perlu datang ke kantor desa. Cukup dari rumah saja!'],
            ['q' => 'data aman', 'a' => 'Keamanan data warga adalah prioritas kami. Data pribadi Anda disimpan secara aman dalam sistem dan hanya digunakan untuk keperluan administrasi desa sesuai ketentuan yang berlaku.'],

            // ── Berita & Informasi ──
            ['q' => 'berita terbaru desa', 'a' => 'Cek halaman berita desa di website ini! Di sana ada informasi terbaru seputar pembangunan, kegiatan, dan pengumuman dari Pemerintah '.config('village.nama_desa', 'Desa').'.'],
            ['q' => 'info lomba', 'a' => 'Informasi kegiatan lomba atau acara desa biasanya diumumkan melalui berita desa atau pemberitahuan dari RT/RW setempat. Cek berkala halaman berita untuk info terbaru.'],
            ['q' => 'pembangunan desa', 'a' => 'Informasi pembangunan desa bisa dilihat di halaman berita. Pemerintah desa selalu mengupdate progres pembangunan secara transparan melalui portal ini.'],
            ['q' => 'bantuan sosial', 'a' => 'Informasi bantuan sosial (bansos) biasanya diumumkan melalui pengumuman resmi desa dan berita desa. Untuk info lebih lanjut, hubungi RT/RW setempat.'],

            // ── Umum Lainnya ──
            ['q' => 'apa itu prodesa', 'a' => 'Prodesa adalah Portal Desa digital yang memudahkan warga '.config('village.nama_desa', 'Desa').' mengurus surat menyurat secara online. Dibuat untuk pelayanan yang lebih cepat, mudah, dan transparan.'],
            ['q' => 'beda prodesa dengan manual', 'a' => 'Dengan Prodesa, warga tidak perlu antre di kantor desa untuk mengurus surat. Cukup daftar online, isi data, submit, dan tunggu verifikasi. Jauh lebih hemat waktu dan tenaga!'],
            ['q' => 'prodesa gratis', 'a' => 'Ya, Prodesa gratis untuk seluruh warga '.config('village.nama_desa', 'Desa').'. Tidak ada biaya untuk pendaftaran maupun pengajuan surat. Kalau ada yang minta bayar, laporkan ke admin!'],
            ['q' => 'bisa dari hp', 'a' => 'Tentu! Prodesa bisa diakses dari HP, tablet, maupun laptop. Yang penting ada koneksi internet. Sangat praktis untuk warga yang sibuk atau tidak bisa datang ke kantor desa.'],
            ['q' => 'aplikasi mobile', 'a' => 'Saat ini Prodesa bisa diakses melalui website di HP kamu. Tampilannya sudah responsif dan nyaman dipakai dari browser HP. Untuk aplikasi mobile, masih dalam rencana pengembangan!'],
            ['q' => 'error system', 'a' => 'Kalau mengalami error atau masalah teknis, coba refresh halaman atau clear cache browser dulu. Jika masih bermasalah, silakan laporkan ke admin desa atau tim teknis.'],
            ['q' => 'ganti password', 'a' => 'Saat ini belum ada fitur ganti password mandiri. Hubungi admin desa untuk bantuan perubahan password akun Anda.'],
            ['q' => 'lupa email', 'a' => 'Pendaftaran Prodesa menggunakan NIK, bukan email. Jadi tidak perlu khawatir soal lupa email. Cukup ingat NIK dan password kamu.'],
            ['q' => 'rt rw', 'a' => 'Data RT dan RW untuk pengajuan surat akan diambil dari data kependudukan saat pendaftaran. Pastikan kamu memasukkan RT dan RW yang benar saat mendaftar ya!'],
        ];

        $beritaList = Berita::where('status', 'publish')->latest()->take(10)->get(['judul', 'konten']);
        foreach ($beritaList as $b) {
            $clean = strip_tags($b->konten);
            $this->knowledge[] = [
                'q' => $b->judul,
                'a' => substr($clean, 0, 500).(strlen($clean) > 500 ? '...' : ''),
            ];
            $this->knowledge[] = [
                'q' => 'berita '.$b->judul,
                'a' => 'Ini berita desa berjudul "'.$b->judul.'". '.substr($clean, 0, 300).(strlen($clean) > 300 ? '...' : ''),
            ];
        }
    }

    private function findBestMatch(string $question): string
    {
        $lower = strtolower(trim($question));
        $tokens = $this->tokenize($question);

        if (empty($tokens)) {
            return 'Halo! Silakan tanya apa saja seputar '.config('village.nama_desa', 'Desa').' dan layanan Prodesa ya. Contoh: "cara daftar", "apa itu SKTM", atau "cetak surat".';
        }

        $bestScore = 0;
        $bestAnswer = null;
        $bestQuestion = '';

        $query = implode(' ', $tokens);

        foreach ($this->knowledge as $item) {
            $itemTokens = $this->tokenize($item['q'].' '.$item['a']);
            $score = $this->computeSmartScore($query, $tokens, $itemTokens, $item['q']);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestAnswer = $item['a'];
                $bestQuestion = $item['q'];
            }
        }

        $threshold = 2.5;

        if ($bestAnswer && $bestScore >= $threshold) {
            $response = $bestAnswer;
            if (mb_strlen($response) < 80 && $bestQuestion !== $this->normalize($query)) {
                $response .= "\n\n💡 Ada pertanyaan lain seputar ".explode(' ', $bestQuestion)[0].'? Tanyakan saja!';
            }

            return $response;
        }

        return 'Maaf, saya belum paham pertanyaan "'.htmlspecialchars($question).'". Coba tanya dengan cara berbeda ya! Misalnya:\n- "Cara daftar"\n- "Apa itu SKTM"\n- "Cara cetak surat"\n- "Layanan apa saja"\nAtau hubungi admin desa langsung untuk bantuan lebih lanjut.';
    }

    private function computeSmartScore(string $query, array $qTokens, array $itemTokens, string $itemQ): float
    {
        $intersection = array_intersect($qTokens, $itemTokens);
        $union = array_unique(array_merge($qTokens, $itemTokens));

        if (empty($union)) {
            return 0;
        }

        $jaccard = count($intersection) / count($union);
        $overlap = count($intersection);

        $synonymBonus = 0;
        foreach ($qTokens as $qt) {
            foreach ($this->synonyms as $root => $forms) {
                if (in_array($qt, $forms)) {
                    foreach ($itemTokens as $it) {
                        if (in_array($it, $forms)) {
                            $synonymBonus += 0.5;
                        }
                    }
                }
            }
        }

        $questionNorm = $this->normalize($query);
        $itemNorm = $this->normalize(mb_strtolower($itemQ));
        $exactBonus = str_contains($itemNorm, $questionNorm) ? 3 : 0;

        $bigramScore = $this->bigramSimilarity($query, mb_strtolower($itemQ));

        $lengthPenalty = max(0, 1 - (abs(count($qTokens) - count($itemTokens)) * 0.1));

        return ($jaccard * 8) + ($overlap * 0.4) + $synonymBonus + $exactBonus + ($bigramScore * 5) + $lengthPenalty;
    }

    private function bigramSimilarity(string $a, string $b): float
    {
        $aBigrams = [];
        $len = mb_strlen($a);
        for ($i = 0; $i < $len - 1; $i++) {
            $aBigrams[] = mb_substr($a, $i, 2);
        }

        $bBigrams = [];
        $len = mb_strlen($b);
        for ($i = 0; $i < $len - 1; $i++) {
            $bBigrams[] = mb_substr($b, $i, 2);
        }

        if (empty($aBigrams) || empty($bBigrams)) {
            return 0;
        }

        $intersection = array_intersect($aBigrams, $bBigrams);
        $union = array_unique(array_merge($aBigrams, $bBigrams));

        return count($intersection) / count($union);
    }

    private function normalize(string $text): string
    {
        $text = preg_replace('/[^a-z0-9]/', '', $text);

        return $text;
    }

    private function tokenize(string $text): array
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);
        $words = array_filter(explode(' ', $text));

        $stopWords = [
            'yang', 'dengan', 'untuk', 'dari', 'pada', 'ini', 'itu', 'di', 'ke',
            'dan', 'atau', 'tidak', 'akan', 'bisa', 'apa', 'bagaimana', 'saja',
            'saya', 'kami', 'anda', 'mereka', 'ada', 'sudah', 'telah', 'juga',
            'dapat', 'oleh', 'sebagai', 'secara', 'seperti', 'karena', 'antar',
            'setelah', 'sebelum', 'antara', 'tentang', 'harus', 'lebih',
            'tolong', 'boleh', 'mohon', 'apakah', 'sih', 'kah', 'lah', 'pun',
            'ya', 'oh', 'si', 'kok', 'dong', 'deh',
        ];

        return array_diff($words, $stopWords);
    }
}
