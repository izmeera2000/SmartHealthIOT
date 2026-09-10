<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PatientRegistered extends Notification
{
    use Queueable;

    public function __construct(
        public string $patientName,
        public string $patientId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'patient_registered',
            'title' => 'New Patient Registered',
            'message' => "{$this->patientName} has been registered.",
            'icon' => 'person-plus',
            'icon_type' => 'success',
            'url' => route('doctor.patients.index'),
        ];
    }
}