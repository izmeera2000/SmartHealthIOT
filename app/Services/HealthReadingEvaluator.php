<?php

namespace App\Services;

use App\Models\SensorReading;

class HealthReadingEvaluator
{
    public function evaluate(SensorReading $reading): array
    {
        $patient = $reading->device?->patient;

        if (!$patient) {
            return [];
        }

        $settings = $patient->healthSettings;

        if (!$settings) {
            return [];
        }

        $alerts = [];

        // Heart Rate
        if ($reading->heart_rate !== null) {

            if (
                $settings->heart_rate_min !== null &&
                $reading->heart_rate < $settings->heart_rate_min
            ) {
                $alerts[] = [
                    'type' => 'heart_rate',
                    'severity' => 'warning',
                    'value' => $reading->heart_rate,
                    'unit' => 'BPM',
                    'limit' => $settings->heart_rate_min,
                    'direction' => 'low',
                    'message' => "Heart rate is below the patient's configured minimum.",
                ];
            }

            elseif (
                $settings->heart_rate_max !== null &&
                $reading->heart_rate > $settings->heart_rate_max
            ) {
                $alerts[] = [
                    'type' => 'heart_rate',
                    'severity' => 'warning',
                    'value' => $reading->heart_rate,
                    'unit' => 'BPM',
                    'limit' => $settings->heart_rate_max,
                    'direction' => 'high',
                    'message' => "Heart rate is above the patient's configured maximum.",
                ];
            }
        }

        // SpO2
        if ($reading->spo2 !== null) {

            if (
                $settings->spo2_min !== null &&
                $reading->spo2 < $settings->spo2_min
            ) {
                $alerts[] = [
                    'type' => 'spo2',
                    'severity' => 'warning',
                    'value' => $reading->spo2,
                    'unit' => '%',
                    'limit' => $settings->spo2_min,
                    'direction' => 'low',
                    'message' => "SpO₂ is below the patient's configured minimum.",
                ];
            }

            elseif (
                $settings->spo2_max !== null &&
                $reading->spo2 > $settings->spo2_max
            ) {
                $alerts[] = [
                    'type' => 'spo2',
                    'severity' => 'warning',
                    'value' => $reading->spo2,
                    'unit' => '%',
                    'limit' => $settings->spo2_max,
                    'direction' => 'high',
                    'message' => "SpO₂ is above the patient's configured maximum.",
                ];
            }
        }

        // Body Temperature
        if ($reading->body_temperature !== null) {

            if (
                $settings->body_temperature_min !== null &&
                $reading->body_temperature < $settings->body_temperature_min
            ) {
                $alerts[] = [
                    'type' => 'body_temperature',
                    'severity' => 'warning',
                    'value' => $reading->body_temperature,
                    'unit' => '°C',
                    'limit' => $settings->body_temperature_min,
                    'direction' => 'low',
                    'message' => "Body temperature is below the patient's configured minimum.",
                ];
            }

            elseif (
                $settings->body_temperature_max !== null &&
                $reading->body_temperature > $settings->body_temperature_max
            ) {
                $alerts[] = [
                    'type' => 'body_temperature',
                    'severity' => 'warning',
                    'value' => $reading->body_temperature,
                    'unit' => '°C',
                    'limit' => $settings->body_temperature_max,
                    'direction' => 'high',
                    'message' => "Body temperature is above the patient's configured maximum.",
                ];
            }
        }

        // Ambient Temperature
        if ($reading->ambient_temperature !== null) {

            if (
                $settings->ambient_temperature_min !== null &&
                $reading->ambient_temperature < $settings->ambient_temperature_min
            ) {
                $alerts[] = [
                    'type' => 'ambient_temperature',
                    'severity' => 'warning',
                    'value' => $reading->ambient_temperature,
                    'unit' => '°C',
                    'limit' => $settings->ambient_temperature_min,
                    'direction' => 'low',
                    'message' => "Ambient temperature is below the configured minimum.",
                ];
            }

            elseif (
                $settings->ambient_temperature_max !== null &&
                $reading->ambient_temperature > $settings->ambient_temperature_max
            ) {
                $alerts[] = [
                    'type' => 'ambient_temperature',
                    'severity' => 'warning',
                    'value' => $reading->ambient_temperature,
                    'unit' => '°C',
                    'limit' => $settings->ambient_temperature_max,
                    'direction' => 'high',
                    'message' => "Ambient temperature is above the configured maximum.",
                ];
            }
        }

        return $alerts;
    }
}