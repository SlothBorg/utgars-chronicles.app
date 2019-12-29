<?php declare(strict_types=1);

namespace App\Events;

use App\Scene;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SceneMoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Scene $scene;
    private int $newPosition;

    public function __construct(Scene $scene, int $newPosition)
    {
        $this->scene = $scene;
        $this->newPosition = $newPosition;
    }

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('history.' . $this->scene->event->period->history_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->scene->id,
            'position' => $this->newPosition,
            'event' => $this->scene->event->id,
            'period' => $this->scene->event->period->id,
        ];
    }
}
