<?php

namespace App\Filament\Widgets;

use App\Models\PatientRecord;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class TemperaturePieChart extends ChartWidget
{
    protected static ?string $heading = 'Temperature Overview';

    protected static ?string $pollingInterval = null;

    protected static ?string $maxHeight = '200px';

    protected static ?string $chartId = 'temperaturePieChart';

    protected function getData(): array
    {
        $records = PatientRecord::all();

        $temperature = $this->categorizeTemperature($records);

        return [
            'datasets' => [
                [
                    'label' => 'Temperature',
                    'data' => array_values($temperature),
                    'backgroundColor' => ['#10b981', '#f59e0b', '#ef4444'], // Colors for Normal, Hypothermia, Fever
                ],
            ],
            'labels' => array_keys($temperature), // Categories: Normal, Hypothermia, Fever
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Type of chart (pie chart)
    }

    // Updated categorization for temperature
    private function categorizeTemperature(Collection $records): array
    {
        $categories = ['Normal' => 0, 'Hypothermia' => 0, 'Fever' => 0];

        foreach ($records as $record) {
            $temp = (float) $record->temperature;

            if ($temp < 35.5) {
                $categories['Hypothermia']++;
            } elseif ($temp > 37.5) {
                $categories['Fever']++;
            } else {
                $categories['Normal']++;
            }
        }

        return $categories;
    }
}
