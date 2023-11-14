<?php

namespace Mobiverse\LaravelMixpanel\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Mobiverse\LaravelMixpanel\Models\Account;

/**
 * Class MixpanelEvent
 */
class MixpanelEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $charge;

    public $profileData;

    public $trackingData;

    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct($user, array $trackingData, int $charge = 0, array $profileData = [])
    {
        $this->charge = $charge;
        $this->trackingData = $trackingData;
        $this->profileData = $profileData;
        $this->user = $user;
    }

    public function names(): Collection
    {
        return collect($this->trackingData)
            ->keys();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
