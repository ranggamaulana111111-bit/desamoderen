{{-- Loading Skeleton --}}
<div x-show="loading" class="space-y-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl skeleton"></div>
                <div>
                    <div class="h-4 w-32 skeleton rounded"></div>
                    <div class="h-3 w-48 skeleton rounded mt-1.5"></div>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
                <div class="h-10 skeleton rounded-xl"></div>
            </div>
            <div class="h-20 skeleton rounded-xl"></div>
            <div class="flex justify-end">
                <div class="h-10 w-36 skeleton rounded-xl"></div>
            </div>
        </div>
    </div>
</div>
