<?php

namespace App\Http\Controllers\Lembaga;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $lembaga = $this->lembaga();

        $events = Event::where('lembaga_id', $lembaga->id)
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('lembaga.events.index', compact('events', 'lembaga'));
    }

    public function create()
    {
        $lembaga = $this->lembaga();

        return view('lembaga.events.create', compact('lembaga'));
    }

    public function store(Request $request)
    {
        $lembaga = $this->lembaga();

        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:musrenbangdes,rapat,kegiatan,sosialisasi',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:200',
            'status' => 'required|in:akan_datang,berlangsung,selesai',
        ]);

        $event = Event::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'jenis' => $validated['jenis'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'] ?? null,
            'tempat' => $validated['tempat'] ?? null,
            'user_id' => Auth::id(),
            'lembaga_id' => $lembaga->id,
            'status' => $validated['status'],
        ]);

        ActivityLog::catat(
            'create_event',
            "Lembaga {$lembaga->nama} ({$request->user()->name}) menambahkan event '{$event->judul}'",
            'event',
            $event->id
        );

        return redirect()->route('lembaga.events.index')
            ->with('success', 'Event berhasil ditambahkan dan langsung tampil di website desa.');
    }

    public function show(Event $event)
    {
        $lembaga = $this->lembaga();
        abort_if($event->lembaga_id !== $lembaga->id, 403, 'Event ini bukan milik lembaga Anda.');

        $event->load('user');

        return view('lembaga.events.show', compact('event', 'lembaga'));
    }

    public function edit(Event $event)
    {
        $lembaga = $this->lembaga();
        abort_if($event->lembaga_id !== $lembaga->id, 403, 'Event ini bukan milik lembaga Anda.');

        return view('lembaga.events.edit', compact('event', 'lembaga'));
    }

    public function update(Request $request, Event $event)
    {
        $lembaga = $this->lembaga();
        abort_if($event->lembaga_id !== $lembaga->id, 403, 'Event ini bukan milik lembaga Anda.');

        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:musrenbangdes,rapat,kegiatan,sosialisasi',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:200',
            'status' => 'required|in:akan_datang,berlangsung,selesai',
        ]);

        $event->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'jenis' => $validated['jenis'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'] ?? null,
            'tempat' => $validated['tempat'] ?? null,
            'status' => $validated['status'],
        ]);

        ActivityLog::catat(
            'update_event',
            "Lembaga {$lembaga->nama} ({$request->user()->name}) mengupdate event '{$event->judul}'",
            'event',
            $event->id
        );

        return redirect()->route('lembaga.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $lembaga = $this->lembaga();
        abort_if($event->lembaga_id !== $lembaga->id, 403, 'Event ini bukan milik lembaga Anda.');

        $judul = $event->judul;
        $event->delete();

        ActivityLog::catat(
            'delete_event',
            'Lembaga '.$lembaga->nama." menghapus event '{$judul}'",
            'event',
            $event->id
        );

        return redirect()->route('lembaga.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    private function lembaga(): Lembaga
    {
        $lembaga = auth()->user()->lembaga;

        abort_if(! $lembaga, 403, 'Akun ini tidak terhubung dengan lembaga mana pun.');

        return $lembaga;
    }
}
