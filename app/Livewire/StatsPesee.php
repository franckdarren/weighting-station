<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BonPesee;
use Carbon\Carbon;

class StatsPesee extends Component
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
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at')
            ->get();

        if ($records->isEmpty()) {
            return [
                'noData' => true
            ];
        }

        // Status distribution
        $validCount = $records->filter(fn($r) => $r->status === 'Valide')->count();
        $invalidCount = $records->filter(fn($r) => $r->status === 'A reprendre')->count();

        // Weight distribution
        $weightRanges = [
            '0-1000 kg' => $records->filter(fn($r) => $r->poids <= 1000)->count(),
            '1001-5000 kg' => $records->filter(fn($r) => $r->poids > 1000 && $r->poids <= 5000)->count(),
            '5001-10000 kg' => $records->filter(fn($r) => $r->poids > 5000 && $r->poids <= 10000)->count(),
            '10000+ kg' => $records->filter(fn($r) => $r->poids > 10000)->count(),
        ];

        // Daily distribution
        $timeData = $records->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })->map->count();

        return [
            'status' => [
                'labels' => ['Valide', 'A reprendre'],
                'datasets' => [[
                    'data' => [$validCount, $invalidCount],
                    'backgroundColor' => ['#10B981', '#EF4444'],
                ]]
            ],
            'weights' => [
                'labels' => array_keys($weightRanges),
                'datasets' => [[
                    'label' => 'Distribution des poids',
                    'data' => array_values($weightRanges),
                    'backgroundColor' => '#3B82F6',
                ]]
            ],
            'timeline' => [
                'labels' => $timeData->keys()->toArray(),
                'datasets' => [[
                    'label' => 'Nombre de pesées',
                    'data' => $timeData->values()->toArray(),
                    'borderColor' => '#8B5CF6',
                    'tension' => 0.4,
                    'fill' => true,
                ]]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.stats-pesee', [
            'chartData' => $this->getChartData()
        ]);
    }
}
