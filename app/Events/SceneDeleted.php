<?php declare(strict_types=1);

namespace App\Events;

use App\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SceneDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Event $event;
    private int $sceneId;

    public function __construct(Event $event, int $sceneId)
    {
        $this->event = $event;
        $this->sceneId = $sceneId;
    }

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('history.' . $this->event->period->history_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->sceneId,
            'event' => $this->event->id,
            'period' => $this->event->period->id,
        ];
    }
}
