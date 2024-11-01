<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BonPesee;
use Carbon\Carbon;

class StatsVehicule extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function getChartData()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();
        
        $records = BonPesee::query()
            ->with('FacturePesage')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->whereNotNull('plaque_immatriculation')
            ->orderBy('created_at')
            ->get();

        if ($records->isEmpty()) {
            return ['noData' => true];
        }

        // Top Vehicles by Weighing Count
        $vehiclesData = $records->groupBy('plaque_immatriculation')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total_weight' => $group->sum('poids'),
                    'drivers' => $group->map(function ($record) {
                        return [
                            'name' => $record->facturePesage->identite_conducteur ?? 'N/A',
                            'date' => $record->created_at->format('d/m/Y'),
                            'weight' => $record->poids
                        ];
                    })->toArray()
                ];
            })
            ->sortByDesc('count')
            ->take(5);

        // Vehicle Activity Timeline
        $timelineData = collect();
        foreach ($vehiclesData->keys() as $plate) {
            $vehicleData = [];
            foreach ($records->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            }) as $date => $items) {
                $vehicleData[$date] = $items->where('plaque_immatriculation', $plate)->count();
            }
            $timelineData[$plate] = $vehicleData;
        }

        // Weight Distribution by Vehicle
        $weightData = $vehiclesData->map(function ($data) {
            return round($data['total_weight'] / 1000, 2); // Convert to tons
        });

        return [
            'topVehicles' => $vehiclesData->toArray(),
            'weights' => [
                'labels' => $weightData->keys()->toArray(),
                'datasets' => [[
                    'label' => 'Poids total transporté (tonnes)',
                    'data' => $weightData->values()->toArray(),
                    'backgroundColor' => [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'
                    ],
                ]]
            ],
            'timeline' => [
                'labels' => collect($timelineData->first())->keys()->toArray(),
                'datasets' => $timelineData->map(function ($data, $plate) {
                    $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    return [
                        'label' => $plate,
                        'data' => array_values($data),
                        'borderColor' => $color,
                        'backgroundColor' => 'transparent',
                        'tension' => 0.4,
                    ];
                })->values()->toArray()
            ]
        ];
    }

    public function render()
    {
        return view('livewire.stats-vehicule', [
            'chartData' => $this->getChartData()
        ]);
    }
}
