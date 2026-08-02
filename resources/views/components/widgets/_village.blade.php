@if (!empty($nama_desa))
<div class="widget-card h-full">
    <div class="widget-card-header">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Informasi Desa</h2>
                <p class="text-[10px] text-gray-400">{{ $nama_desa ?? '-' }}, {{ $nama_kecamatan ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="widget-card-body">
        <div class="space-y-0">
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-[13px] text-gray-500">Kepala Desa</span>
                <span class="text-[13px] font-semibold text-gray-800">{{ $nama_kades ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-[13px] text-gray-500">Sekretaris</span>
                <span class="text-[13px] font-semibold text-gray-800">{{ $nama_sekdes ?? '-' }}</span>
            </div>
        </div>

        {{-- Population Stats --}}
        <div class="grid grid-cols-2 gap-3 mt-4">
            <div class="bg-gradient-to-br from-brand-50 to-teal-50 rounded-xl p-3.5 text-center border border-brand-100/40">
                <p class="text-xl font-extrabold text-brand-900" x-data x-init="animateNumber($el, {{ $total_penduduk ?? 0 }})">0</p>
                <p class="text-[10px] text-brand-600 font-semibold uppercase tracking-wider mt-0.5">Penduduk</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-3.5 text-center border border-blue-100/40">
                <p class="text-xl font-extrabold text-blue-900" x-data x-init="animateNumber($el, {{ $total_kk ?? 0 }})">0</p>
                <p class="text-[10px] text-blue-600 font-semibold uppercase tracking-wider mt-0.5">Kartu Keluarga</p>
            </div>
        </div>

        @if(!empty($website_desa) || !empty($email_desa) || !empty($telepon_desa) || !empty($jumlah_dusun))
        <div class="mt-4 pt-3 border-t border-gray-100/60 space-y-2">
            @if(!empty($website_desa))
            <div class="flex justify-between items-center">
                <span class="text-[13px] text-gray-500">Website</span>
                <span class="text-[13px] font-medium text-brand-600 truncate max-w-[60%] text-right">{{ $website_desa }}</span>
            </div>
            @endif
            @if(!empty($email_desa))
            <div class="flex justify-between items-center">
                <span class="text-[13px] text-gray-500">Email</span>
                <span class="text-[13px] font-medium text-gray-800 truncate max-w-[60%] text-right">{{ $email_desa }}</span>
            </div>
            @endif
            @if(!empty($telepon_desa))
            <div class="flex justify-between items-center">
                <span class="text-[13px] text-gray-500">Telepon</span>
                <span class="text-[13px] font-medium text-gray-800">{{ $telepon_desa }}</span>
            </div>
            @endif
            @if(!empty($jumlah_dusun))
            <div class="flex justify-between items-center">
                <span class="text-[13px] text-gray-500">Dusun</span>
                <span class="text-[13px] font-bold text-gray-800">{{ $jumlah_dusun }}</span>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endif
