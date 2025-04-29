<?php

namespace App\Filament\Widgets;

use App\Models\PatientRecord;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class RespiratoryRatePieChart extends ChartWidget
{
    protected static ?string $heading = 'Respiratory Rate Overview';

    protected static ?string $pollingInterval = null;

    protected static ?string $maxHeight = '200px';

    protected static ?string $chartId = 'respiratoryRatePieChart';

    protected function getData(): array
    {
        $records = PatientRecord::all();

        $respiratory = $this->categorizeRespiratoryRate($records);

        return [
            'datasets' => [
                [
                    'label' => 'Respiratory Rate',
                    'data' => array_values($respiratory),
                    'backgroundColor' => ['#10b981', '#6366f1', '#ef4444'], // Normal, Low, Elevated
                ],
            ],
            'labels' => array_keys($respiratory),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    private function categorizeRespiratoryRate(Collection $records): array
    {
        $categories = ['Normal' => 0, 'Low' => 0, 'Elevated' => 0];

        foreach ($records as $record) {
            $rate = (int) $record->respiration_rate;

            // Categorizing based on the new ranges
            if ($rate > 20) {
                $categories['Elevated']++; // Elevated if greater than 20
            } elseif ($rate < 12) {
                $categories['Low']++; // Low if less than 12
            } else {
                $categories['Normal']++; // Normal if between 12 and 20
            }
        }

        return $categories;
    }
}
