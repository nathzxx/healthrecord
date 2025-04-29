<?php

namespace App\Filament\Widgets;

use App\Models\PatientRecord;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class PbloodPressure extends ChartWidget
{
    protected static ?string $heading = 'Blood Pressure Overview';
    protected static ?string $pollingInterval = null;

    protected static ?string $maxHeight = '200px';
   
   
    protected static ?string $chartId = 'bloodPressurePieChart';

    protected function getData(): array
    {
        $records = PatientRecord::all();
        $bp = $this->categorizeBP($records);

        return [
            'datasets' => [
                [
                    'label' => 'Blood Pressure',
                    'data' => array_values($bp),
                    'backgroundColor' => ['#10b981', '#facc15', '#ef4444'], // Green for Normal, Yellow for Low, Red for High
                ],
            ],
            'labels' => array_keys($bp),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
   

    private function categorizeBP(Collection $records): array
    {
        $categories = [
            'Normal' => 0,
            'Low' => 0,
            'High' => 0,
        ];

        foreach ($records as $record) {
            if (!$record->blood_pressure || !str_contains($record->blood_pressure, '/')) {
                continue;
            }

            [$systolic, $diastolic] = explode('/', $record->blood_pressure);
            $systolic = (int) $systolic;
            $diastolic = (int) $diastolic;

            // Categorizing the blood pressure values as Normal, Low, and High
            if ($systolic < 90 && $diastolic < 60) {
                $categories['Low']++; // Low if systolic < 90 and diastolic < 60
            } elseif ($systolic < 120 && $diastolic < 80) {
                $categories['Normal']++; // Normal if systolic < 120 and diastolic < 80
            } else {
                $categories['High']++; // High if systolic >= 120 or diastolic >= 80
            }
        }

        return $categories;
    }
}
