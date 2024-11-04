<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FacturePesage;
use Carbon\Carbon;

class StatsConducteur extends Component
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
        
        $records = FacturePesage::query()
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->whereNotNull('identite_conducteur')
            ->orderBy('created_at')
            ->get();

        if ($records->isEmpty()) {
            return ['noData' => true];
        }

        // Top Drivers Distribution
        $driversData = $records->groupBy('identite_conducteur')
            ->map->count()
            ->sortDesc()
            ->take(10);

        // Driver Details (Top 5)
        $topDrivers = $records->groupBy('identite_conducteur')
            ->map(function ($group) {
                $lastRecord = $group->last();
                return [
                    'count' => $group->count(),
                    'permis' => $lastRecord->num_permis_conduire,
                    'documents' => $lastRecord->cte_grise_licence_autres,
                    'last_visit' => $lastRecord->created_at->format('d/m/Y')
                ];
            })
            ->sortByDesc('count')
            ->take(5);

        // Daily Activity Timeline for Top 5 Drivers
        $timelineData = collect();
        foreach ($driversData->take(5)->keys() as $driver) {
            $driverData = [];
            foreach ($records->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            }) as $date => $items) {
                $driverData[$date] = $items->where('identite_conducteur', $driver)->count();
            }
            $timelineData[$driver] = $driverData;
        }

        return [
            'drivers' => [
                'labels' => $driversData->keys()->toArray(),
                'datasets' => [[
                    'data' => $driversData->values()->toArray(),
                    'backgroundColor' => [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
                        '#EC4899', '#14B8A6', '#6366F1', '#84CC16', '#F97316'
                    ],
                ]]
            ],
            'details' => [
                'labels' => ['Pesées', 'Documents valides'],
                'drivers' => $topDrivers->map(function ($data, $driver) {
                    return [
                        'name' => $driver,
                        'permis' => $data['permis'],
                        'documents' => $data['documents'],
                        'count' => $data['count'],
                        'last_visit' => $data['last_visit']
                    ];
                })->values()->toArray()
            ],
            'timeline' => [
                'labels' => collect($timelineData->first())->keys()->toArray(),
                'datasets' => $timelineData->map(function ($data, $driver) {
                    $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    return [
                        'label' => $driver,
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
        return view('livewire.stats-conducteur', [
            'chartData' => $this->getChartData()
        ]);
    }
}
