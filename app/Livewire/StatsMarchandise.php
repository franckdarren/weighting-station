<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BonPesee;
use Carbon\Carbon;

class StatsMarchandise extends Component
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
            ->whereNotNull('produits_transportes')
            ->orderBy('created_at')
            ->get();

        if ($records->isEmpty()) {
            return ['noData' => true];
        }

        // Products Distribution
        $productsData = $records->groupBy('produits_transportes')
            ->map->count()
            ->sortDesc();

        // Weight by Product
        $weightByProduct = $records->groupBy('produits_transportes')
            ->map(function ($group) {
                return round($group->avg('poids'), 2);
            });

        // Daily Products Timeline
        $timeData = $records->groupBy(function ($item) {
            return [
                'date' => $item->created_at->format('Y-m-d'),
                'product' => $item->produits_transportes
            ];
        })->map->count();

        // Get top 5 products for timeline
        $topProducts = $productsData->take(5)->keys();
        
        $timelineData = collect();
        foreach ($topProducts as $product) {
            $productData = [];
            foreach ($records->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            }) as $date => $items) {
                $productData[$date] = $items->where('produits_transportes', $product)->count();
            }
            $timelineData[$product] = $productData;
        }

        return [
            'products' => [
                'labels' => $productsData->keys()->toArray(),
                'datasets' => [[
                    'data' => $productsData->values()->toArray(),
                    'backgroundColor' => [
                        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEEAD',
                        '#D4A5A5', '#9FA8DA', '#90CAF9', '#A5D6A7', '#FFCC80'
                    ],
                ]]
            ],
            'weights' => [
                'labels' => $weightByProduct->keys()->toArray(),
                'datasets' => [[
                    'label' => 'Poids moyen (kg)',
                    'data' => $weightByProduct->values()->toArray(),
                    'backgroundColor' => '#2E5BFF',
                    'borderColor' => '#2E5BFF',
                    'borderWidth' => 1,
                ]]
            ],
            'timeline' => [
                'labels' => collect($timelineData->first())->keys()->toArray(),
                'datasets' => $timelineData->map(function ($data, $product) {
                    $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    return [
                        'label' => $product,
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
        return view('livewire.stats-marchandise', [
            'chartData' => $this->getChartData()
        ]);
    }
}
