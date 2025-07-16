<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Manga;

class MangaNotification extends Notification
{
    use Queueable;

    protected $manga;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param Manga $manga
     * @param string $type
     * @return void
     */
    public function __construct(Manga $manga, $type = 'created')
    {
        $this->manga = $manga;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $message = '';
        $title = '';
        
        switch ($this->type) {
            case 'created':
                $title = 'Novo Mangá Adicionado';
                $message = "O mangá {$this->manga->title} foi adicionado à biblioteca.";
                break;
            case 'updated':
                $title = 'Mangá Atualizado';
                $message = "O mangá {$this->manga->title} foi atualizado.";
                break;
            default:
                $title = 'Atualização de Mangá';
                $message = "O mangá {$this->manga->title} foi atualizado.";
        }

        return [
            'title' => $title,
            'message' => $message,
            'url' => route('manga.show', $this->manga->id),
            'type' => 'manga_' . $this->type,
            'data' => [
                'manga_id' => $this->manga->id,
                'title' => $this->manga->title,
                'cover_url' => $this->manga->cover_url,
                'created_at' => now()->toDateTimeString(),
                'read_at' => null,
            ]
        ];
    }
    
    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => get_class($this),
            'data' => $this->toArray($notifiable),
            'read_at' => null,
            'created_at' => now()->toDateTimeString(),
        ]);
    }
    
    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'manga.notification';
    }
}
