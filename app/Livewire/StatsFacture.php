<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FacturePesage;
use Carbon\Carbon;

class StatsFacture extends Component
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
            ->orderBy('created_at')
            ->get();

        if ($records->isEmpty()) {
            return ['noData' => true];
        }

        // Payment Method Distribution
        $paymentData = [
            'Cash' => $records->where('cash_montant', '>', 0)->count(),
            'Airtel Money' => $records->where('airtelmoney_montant', '>', 0)->count(),
            'Chèque' => $records->where('cheque_montant', '>', 0)->count(),
        ];

        // Amount Ranges Distribution
        $amountRanges = [
            '0-50k' => $records->where('montant_total', '<=', 50000)->count(),
            '50k-100k' => $records->where('montant_total', '>', 50000)->where('montant_total', '<=', 100000)->count(),
            '100k-500k' => $records->where('montant_total', '>', 100000)->where('montant_total', '<=', 500000)->count(),
            '500k+' => $records->where('montant_total', '>', 500000)->count(),
        ];

        // Daily Revenue Timeline
        $timeData = $records->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function ($group) {
            return [
                'paid' => $group->where('statut', 'Payée')->sum('montant_total'),
                'pending' => $group->where('statut', '!=', 'Payée')->sum('montant_total')
            ];
        });

        return [
            'payments' => [
                'labels' => array_keys($paymentData),
                'datasets' => [[
                    'data' => array_values($paymentData),
                    'backgroundColor' => ['#4ECDC4', '#FF6B6B', '#45B7D1'],
                ]]
            ],
            'amounts' => [
                'labels' => array_keys($amountRanges),
                'datasets' => [[
                    'label' => 'Distribution des montants',
                    'data' => array_values($amountRanges),
                    'backgroundColor' => '#FF9F43',
                ]]
            ],
            'timeline' => [
                'labels' => $timeData->keys()->toArray(),
                'datasets' => [
                    [
                        'label' => 'Revenus encaissés (FCFA)',
                        'data' => $timeData->pluck('paid')->toArray(),
                        'borderColor' => '#2E5BFF',
                        'backgroundColor' => 'rgba(46, 91, 255, 0.1)',
                        'tension' => 0.4,
                        'fill' => true
                    ],
                    [
                        'label' => 'Revenus à recevoir (FCFA)',
                        'data' => $timeData->pluck('pending')->toArray(),
                        'borderColor' => '#FF9F43',
                        'backgroundColor' => 'rgba(255, 159, 67, 0.1)',
                        'tension' => 0.4,
                        'fill' => true
                    ]
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.stats-facture', [
            'chartData' => $this->getChartData()
        ]);
    }
}
