<x-lembaga-layout title="Ubah Event">

    <div class="mb-6">
        <a href="{{ route('lembaga.events.index') }}" class="text-sm text-slate-500 hover:text-brand-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-slate-900 mt-2">Ubah Event</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui event "{{ $event->judul }}".</p>
    </div>

    <form action="{{ route('lembaga.events.update', $event) }}" method="POST">
        @csrf
        @method('PUT')
        @include('lembaga.events._form', ['event' => $event])
    </form>

</x-lembaga-layout>
