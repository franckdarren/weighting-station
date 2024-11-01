<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BonPesee;
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
        
        $records = BonPesee::query()
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->whereNotNull('entreprise')
            ->orderBy('created_at')
            ->get();

        if ($records->isEmpty()) {
            return ['noData' => true];
        }

        // Companies Distribution
        $companiesData = $records->groupBy('entreprise')
            ->map->count()
            ->sortDesc();

        // Average Weight by Company
        $weightByCompany = $records->groupBy('entreprise')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'avg_weight' => round($group->avg('poids'), 2),
                    'total_weight' => $group->sum('poids')
                ];
            })->sortByDesc('count');

        // Top 5 companies timeline
        $topCompanies = $companiesData->take(5)->keys();
        $timelineData = collect();
        
        foreach ($topCompanies as $company) {
            $companyData = [];
            foreach ($records->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            }) as $date => $items) {
                $companyData[$date] = $items->where('entreprise', $company)->count();
            }
            $timelineData[$company] = $companyData;
        }

        return [
            'companies' => [
                'labels' => $companiesData->keys()->toArray(),
                'datasets' => [[
                    'data' => $companiesData->values()->toArray(),
                    'backgroundColor' => [
                        '#6366F1', '#EC4899', '#8B5CF6', '#14B8A6', '#F59E0B',
                        '#3B82F6', '#EF4444', '#10B981', '#6366F1', '#F97316'
                    ],
                ]]
            ],
            'performance' => [
                'labels' => $weightByCompany->take(10)->keys()->toArray(),
                'datasets' => [
                    [
                        'label' => 'Nombre de pesées',
                        'data' => $weightByCompany->take(10)->pluck('count')->toArray(),
                        'backgroundColor' => '#6366F1',
                        'yAxisID' => 'y',
                    ],
                    [
                        'label' => 'Poids total (tonnes)',
                        'data' => $weightByCompany->take(10)->pluck('total_weight')->map(function($weight) {
                            return round($weight/1000, 2);
                        })->toArray(),
                        'backgroundColor' => '#F59E0B',
                        'yAxisID' => 'y1',
                    ]
                ]
            ],
            'timeline' => [
                'labels' => collect($timelineData->first())->keys()->toArray(),
                'datasets' => $timelineData->map(function ($data, $company) {
                    return [
                        'label' => $company,
                        'data' => array_values($data),
                        'borderColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
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
