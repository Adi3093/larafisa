<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeNotifController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(15);

        $activeNotifId = $request->query('id');
        if ($activeNotifId) {
            $notification = $user->notifications()->find($activeNotifId);
            if ($notification && $notification->unread()) {
                $notification->markAsRead();
            }
        }

        return view('landing_page.hnotif', compact('notifications', 'activeNotifId'));
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        if ($notification->unread()) {
            $notification->markAsRead();
        }

        return response()->json([
            'id' => $notification->id,
            'title' => $notification->data['title'] ?? 'Pemberitahuan',
            'message' => $notification->data['message'] ?? '',
            'created_at' => $notification->created_at->translatedFormat('d F Y, H:i'),
            'type' => $notification->data['type'] ?? 'info'
        ]);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    // FUNGSI BARU: Hapus hanya notifikasi yang sudah dibaca
    public function deleteRead()
    {
        Auth::user()->readNotifications()->delete();
        return back()->with('success', 'Pesan yang sudah dibaca berhasil dibersihkan.');
    }

    public function deleteAll()
    {
        Auth::user()->notifications()->delete();
        return back()->with('success', 'Semua riwayat notifikasi berhasil dihapus.');
    }
}
