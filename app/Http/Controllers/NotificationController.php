<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['unread_count' => 0, 'notifications' => []]);
        }

        $this->checkCalendarReminders($user);

        $notifications = AppNotification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'url' => $notif->url,
                    'type' => $notif->type,
                    'is_read' => $notif->is_read,
                    'time_ago' => $notif->created_at->diffForHumans(),
                ];
            });

        $unreadCount = AppNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = AppNotification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect($notification->url ?? back());
    }

    public function markAllAsRead()
    {
        AppNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    public function sendTestNotification(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $targetUrl = $user->role === 'guru' ? '/guru/counseling' : '/siswa/counseling';

        $notif = AppNotification::create([
            'user_id' => $user->id,
            'title' => '🔔 Uji Coba Notifikasi SIM-BK',
            'message' => 'Notifikasi HP berhasil aktif! Anda siap menerima peringatan temu konseling & pesan baru.',
            'url' => $targetUrl,
            'type' => 'test',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi uji coba berhasil dikirim!',
            'notification' => [
                'id' => $notif->id,
                'title' => $notif->title,
                'message' => $notif->message,
                'url' => $notif->url,
                'time_ago' => 'Baru saja',
            ]
        ]);
    }

    private function checkCalendarReminders($user)
    {
        $todayStr = date('Y-m-d');

        if ($user->role === 'guru') {
            // Periksa agenda kalender hari ini
            $events = \App\Models\CalendarEvent::whereDate('event_date', $todayStr)->get();
            foreach ($events as $event) {
                $alreadyNotified = AppNotification::where('user_id', $user->id)
                    ->where('type', 'calendar_reminder')
                    ->whereDate('created_at', $todayStr)
                    ->where('message', 'like', "%{$event->title}%")
                    ->exists();

                if (!$alreadyNotified) {
                    AppNotification::create([
                        'user_id' => $user->id,
                        'title' => '📅 Pengingat Kegiatan BK Hari Ini',
                        'message' => "Agenda: {$event->title}" . ($event->start_time ? " ({$event->start_time})" : "") . ($event->location ? " di {$event->location}" : ""),
                        'url' => '/guru/calendar',
                        'type' => 'calendar_reminder',
                        'is_read' => false,
                    ]);
                }
            }
        } elseif ($user->student) {
            $student = $user->student;
            // Periksa jadwal konseling siswa yang disetujui hari ini
            $counselings = \App\Models\CounselingSession::where('student_id', $student->id)
                ->where('status', 'disetujui')
                ->whereDate('preferred_date', $todayStr)
                ->get();

            foreach ($counselings as $c) {
                $alreadyNotified = AppNotification::where('user_id', $user->id)
                    ->where('type', 'counseling_reminder')
                    ->whereDate('created_at', $todayStr)
                    ->exists();

                if (!$alreadyNotified) {
                    AppNotification::create([
                        'user_id' => $user->id,
                        'title' => '🔔 Pengingat Jadwal Konseling Hari Ini',
                        'message' => "Anda memiliki temu bimbingan bersama Guru BK hari ini" . ($c->preferred_time ? " pukul {$c->preferred_time}" : "") . " di " . ($c->room_or_media ?? 'Ruang BK'),
                        'url' => '/siswa/counseling',
                        'type' => 'counseling_reminder',
                        'is_read' => false,
                    ]);
                }
            }
        }
    }
}
