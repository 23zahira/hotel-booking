<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->update(['status' => 'dibaca']);

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('id_user', auth()->id())
            ->where('status', 'belum_dibaca')
            ->update(['status' => 'dibaca']);

        return back();
    }
}