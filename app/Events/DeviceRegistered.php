<?php

namespace App\Events;

use App\Models\Device;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeviceRegistered implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public Device $device
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('doctor.' . $this->device->doctor_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'device.registered';
    }

    public function broadcastWith(): array
    {
        return [
            'device_id' => $this->device->id,
            'device_uid' => $this->device->device_uid,
            'device_name' => $this->device->device_name,
            'status' => $this->device->status,
        ];
    }
}