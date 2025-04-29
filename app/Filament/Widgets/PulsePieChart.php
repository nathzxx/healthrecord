<?php

namespace App\Filament\Widgets;

use App\Models\PatientRecord;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class PulsePieChart extends ChartWidget
{
    protected static ?string $heading = 'Pulse Rate Overview';

    protected static ?string $pollingInterval = null;

    protected static ?string $maxHeight = '200px';

    

    protected static ?string $chartId = 'pulsePieChart';

    protected function getData(): array
    {
        $records = PatientRecord::all();

        $pulse = $this->categorizePulse($records);

        return [
            'datasets' => [
                [
                    'label' => 'Pulse Rate',
                    'data' => array_values($pulse),
                    'backgroundColor' => ['#10b981', '#3b82f6', '#ef4444'], // Normal, Bradycardia, Tachycardia
                ],
            ],
            'labels' => array_keys($pulse),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    private function categorizePulse(Collection $records): array
    {
        $categories = ['Normal' => 0, 'Bradycardia' => 0, 'Tachycardia' => 0];

        foreach ($records as $record) {
            $pulse = (int) $record->pulse;

            if ($pulse < 60) {
                $categories['Bradycardia']++;
            } elseif ($pulse > 100) {
                $categories['Tachycardia']++;
            } else {
                $categories['Normal']++;
            }
        }

        return $categories;
    }
}
