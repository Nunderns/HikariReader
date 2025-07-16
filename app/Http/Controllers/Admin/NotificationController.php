<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('admin.notifications.index', [
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark a notification as read.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Mark a notification as read.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notificação marcada como lida.',
                'unread_count' => Auth::user()->unreadNotifications->count()
            ]);
        }

        return back()->with('success', 'Notificação marcada como lida.');
    }

    /**
     * Mark a notification as read via AJAX.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsReadAjax($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notificação marcada como lida.',
            'unread_count' => Auth::user()->unreadNotifications->count()
        ]);
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Todas as notificações foram marcadas como lidas.',
                'unread_count' => 0
            ]);
        }

        return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    /**
     * Mark all notifications as read via AJAX.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsReadAjax()
    {
        $unreadCount = Auth::user()->unreadNotifications->count();
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Todas as notificações foram marcadas como lidas.',
            'unread_count' => 0,
            'marked_count' => $unreadCount
        ]);
    }

    /**
     * Delete a notification.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notificação removida com sucesso.');
    }

    /**
     * Delete all notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        Auth::user()->notifications()->delete();

        return back()->with('success', 'Todas as notificações foram removidas.');
    }
}
