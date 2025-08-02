<?php

namespace App\Events;

use App\Models\IndihomeDocument;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentUploaded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;
    public $user;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(IndihomeDocument $document, User $user)
    {
        $this->document = $document;
        $this->user = $user;
        $this->message = "{$user->name} telah mengupload dokumen '{$document->nama_dokumen}' untuk lokasi {$document->lokasi}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('document-uploads'),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->document->id,
            'document_name' => $this->document->nama_dokumen,
            'location' => $this->document->lokasi,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'uploaded_at' => $this->document->created_at->format('d/m/Y H:i'),
            'message' => $this->message,
            'project_type' => $this->document->project_type,
            'implementation_status' => $this->document->implementation_status,
            'site_code' => $this->document->site_code,
        ];
    }
}
