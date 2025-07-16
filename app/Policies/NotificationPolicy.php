<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the notification.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return mixed
     */
    public function view(User $user, DatabaseNotification $notification)
    {
        return $user->id === $notification->notifiable_id && 
               $notification->notifiable_type === User::class;
    }

    /**
     * Determine whether the user can mark the notification as read.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return mixed
     */
    public function markAsRead(User $user, DatabaseNotification $notification)
    {
        return $user->id === $notification->notifiable_id && 
               $notification->notifiable_type === User::class;
    }

    /**
     * Determine whether the user can delete the notification.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return mixed
     */
    public function delete(User $user, DatabaseNotification $notification)
    {
        return $user->id === $notification->notifiable_id && 
               $notification->notifiable_type === User::class;
    }
}
