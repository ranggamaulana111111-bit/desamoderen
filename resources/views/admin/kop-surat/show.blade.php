@php use Illuminate\Support\Facades\Storage; @endphp
<x-admin-layout title="Kop Surat" maxWidth="max-w-[1200px]">
    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-600 font-medium">Kop Surat</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Kop Surat (Letterhead)</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kustomisasi header surat yang berlaku untuk seluruh surat resmi desa</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.kop-surat.update') }}" enctype="multipart/form-data" x-data="kopSuratForm()">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- LEFT: Form --}}
            <div class="lg:col-span-7 space-y-6">
                {{-- Info --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-white">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900">Identitas Kop Surat</h2>
                                <p class="text-xs text-gray-500">Informasi header yang muncul di semua surat resmi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pemerintah Kabupaten</label>
                                <input type="text" name="kop_nama_kabupaten" x-model="namaKab"
                                       value="{{ old('kop_nama_kabupaten', $settings['nama_kabupaten'] ?? '') }}"
                                       placeholder="Kabupaten Contoh"
                                       class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pemerintah Desa</label>
                                <input type="text" name="kop_nama_desa" x-model="namaDesa"
                                       value="{{ old('kop_nama_desa', $settings['nama_desa'] ?? '') }}"
                                       placeholder="Nama Desa"
                                       class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                <input type="text" name="kop_nama_kecamatan" x-model="namaKec"
                                       value="{{ old('kop_nama_kecamatan', $settings['nama_kecamatan'] ?? '') }}"
                                       placeholder="Kecamatan Contoh"
                                       class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                                <input type="text" name="kop_telepon_desa" x-model="telepon"
                                       value="{{ old('kop_telepon_desa', $settings['telepon_desa'] ?? '') }}"
                                       placeholder="021-xxxxxxx"
                                       class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor</label>
                            <input type="text" name="kop_alamat_kantor" x-model="alamat"
                                   value="{{ old('kop_alamat_kantor', $settings['alamat_kantor'] ?? '') }}"
                                   placeholder="Jl. Raya Desa No. 1"
                                   class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Desa</label>
                            <input type="email" name="kop_email_desa" x-model="email"
                                   value="{{ old('kop_email_desa', $settings['email_desa'] ?? '') }}"
                                   placeholder="email@desa.id"
                                   class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Logo --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50/50 to-white">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900">Logo</h2>
                                <p class="text-xs text-gray-500">Logo Pemda (kiri) dan Logo Desa (kanan)</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Logo Pemerintah (Pemda)</label>
                                @if (!empty($settings['logo_pemda']) && Storage::disk('public')->exists($settings['logo_pemda']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$settings['logo_pemda']) }}" class="h-16 w-auto rounded border border-gray-200 bg-white p-1" id="logoPemdaPreview">
                                    </div>
                                @else
                                    <div class="mb-2 w-16 h-16 rounded border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50">
                                        <span class="text-[10px] text-gray-400">Kosong</span>
                                    </div>
                                @endif
                                <input type="file" name="kop_logo_pemda" accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       @change="previewLogo($el, 'logoPemdaPreview')">
                                <p class="text-[11px] text-gray-400 mt-1">Muncul di sisi kiri kop surat</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Logo Desa</label>
                                @if (!empty($settings['logo_desa']) && Storage::disk('public')->exists($settings['logo_desa']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$settings['logo_desa']) }}" class="h-16 w-auto rounded border border-gray-200 bg-white p-1" id="logoDesaPreview">
                                    </div>
                                @else
                                    <div class="mb-2 w-16 h-16 rounded border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50">
                                        <span class="text-[10px] text-gray-400">Kosong</span>
                                    </div>
                                @endif
                                <input type="file" name="kop_logo_desa" accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       @change="previewLogo($el, 'logoDesaPreview')">
                                <p class="text-[11px] text-gray-400 mt-1">Muncul di sisi kanan kop surat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Live Preview --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden sticky top-8">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50/50 to-white">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <h2 class="text-sm font-semibold text-gray-900">Live Preview</h2>
                            <span class="ml-auto text-[10px] text-purple-600 bg-purple-100 px-2 py-0.5 rounded-full font-medium">Real-time</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="bg-white rounded-xl border border-gray-200 p-5 text-center" style="font-family: 'Times New Roman', serif;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="width:24%; text-align:center; vertical-align:middle;">
                                        <div id="previewPemdaContainer">
                                            @if (!empty($settings['logo_pemda']) && Storage::disk('public')->exists($settings['logo_pemda']))
                                                <img src="{{ asset('storage/'.$settings['logo_pemda']) }}" style="height:60px; width:auto;" id="previewPemdaImg">
                                            @else
                                                <div class="w-14 h-14 mx-auto border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
                                                    <span class="text-[8px] text-gray-400">Logo</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <div style="font-size:11pt; font-weight:bold; text-transform:uppercase; letter-spacing:0.5px;" x-text="'Pemerintah Kabupaten ' + (namaKab || '{{ $settings['nama_kabupaten'] ?? '...' }}')"></div>
                                        <div style="font-size:14pt; font-weight:bold; text-transform:uppercase; margin:2px 0;" x-text="'Pemerintah Desa ' + (namaDesa || '{{ $settings['nama_desa'] ?? '...' }}')"></div>
                                        <div style="font-size:11pt;">
                                            <strong x-text="'Kecamatan ' + (namaKec || '{{ $settings['nama_kecamatan'] ?? '...' }}') + ', Kabupaten ' + (namaKab || '{{ $settings['nama_kabupaten'] ?? '...' }}')"></strong>
                                        </div>
                                        <div style="font-size:9pt; font-style:italic; margin-top:3px;">
                                            <span x-text="alamat || '{{ $settings['alamat_kantor'] ?? 'Alamat Kantor' }}'"></span>
                                            <br>
                                            Email: <span x-text="email || '{{ $settings['email_desa'] ?? 'email@desa.id' }}'"></span>
                                            <template x-if="telepon">
                                                <span x-text="' &mdash; Telp: ' + telepon"></span>
                                            </template>
                                        </div>
                                    </td>
                                    <td style="width:24%; text-align:center; vertical-align:middle;">
                                        <div id="previewDesaContainer">
                                            @if (!empty($settings['logo_desa']) && Storage::disk('public')->exists($settings['logo_desa']))
                                                <img src="{{ asset('storage/'.$settings['logo_desa']) }}" style="height:60px; width:auto;" id="previewDesaImg">
                                            @else
                                                <div class="w-14 h-14 mx-auto border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
                                                    <span class="text-[8px] text-gray-400">Logo</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div style="margin-top:8px; border-top:3px solid #000; border-bottom:1px solid #000; padding:2px 0;"></div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-3 text-center">Preview ini menampilkan kop surat secara real-time saat Anda mengedit.</p>
                    </div>

                    {{-- Actions --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.setting.index', ['tab' => 'profil-desa']) }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-6 py-2.5 rounded-xl transition shadow-sm hover:shadow">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Simpan Kop Surat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        function kopSuratForm() {
            return {
                namaKab: '{{ $settings['nama_kabupaten'] ?? '' }}',
                namaDesa: '{{ $settings['nama_desa'] ?? '' }}',
                namaKec: '{{ $settings['nama_kecamatan'] ?? '' }}',
                alamat: '{{ $settings['alamat_kantor'] ?? '' }}',
                email: '{{ $settings['email_desa'] ?? '' }}',
                telepon: '{{ $settings['telepon_desa'] ?? '' }}',

                previewLogo(input, previewId) {
                    const file = input.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        let img = document.getElementById(previewId);
                        if (img) {
                            img.src = e.target.result;
                        } else {
                            const container = document.getElementById(previewId.replace('Img', 'Container'));
                            if (container) {
                                container.innerHTML = '<img id="' + previewId + '" style="height:60px; width:auto;" src="' + e.target.result + '">';
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                },
            };
        }
    </script>
    @endpush
</x-admin-layout>
