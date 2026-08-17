<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransaksiBaruNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $judul;
    protected $pesan;
    protected $tipe_transaksi;
    protected $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($judul, $pesan, $tipe_transaksi, $url = null)
    {
        $this->judul = $judul;
        $this->pesan = $pesan;
        $this->tipe_transaksi = $tipe_transaksi;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'judul'          => $this->judul,
            'pesan'          => $this->pesan,
            'tipe_transaksi' => $this->tipe_transaksi,
            'url'            => $this->url,
        ];
    }
}
