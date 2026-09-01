<?php

namespace App\Events;

use App\Models\Patient;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientRegistered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Patient $patient
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('doctor.' . $this->patient->doctor_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'patient.registered';
    }

    public function broadcastWith(): array
    {
        return [
            'patient_id' => $this->patient->id,
            'patient_code' => $this->patient->patient_id,
            'name' => $this->patient->user?->name,
        ];
    }
}