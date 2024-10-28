<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BonPesee;
use App\Models\FacturePesage;

class DashboardStats extends Component
{
    public function getWeighingData()
    {
        $totalWeighings = BonPesee::count();
        return [
            'datasets' => [[
                'data' => [$totalWeighings],
                'backgroundColor' => ['#3d8cd6'],
                'borderWidth' => 2,
                'borderColor' => '#00000019',
            ]]
        ];
    }

    public function getInvoiceData()
    {
        $totalInvoices = FacturePesage::count();
        return [
            'datasets' => [[
                'data' => [$totalInvoices],
                'backgroundColor' => ['#3d8cd6'],
                'borderWidth' => 2,
                'borderColor' => '#00000019',
            ]]
        ];
    }

    public function getChartData()
    {
        return [
            'datasets' => [[
                'label' => 'Statistics',
                'data' => [
                    // FacturePesage::count(),
                    FacturePesage::where('statut', 'Payée')->count(),
                    FacturePesage::count() - FacturePesage::where('statut', 'Payée')->count(),
                ],
                'backgroundColor' => ['#3ba94a', '#f28e2c'],
            ]],
            'labels' => ['Factures Payées', 'Factures Non-payées'],
        ];
    }

    public function render()
    {
        //Weightingh and Facture Counts
        $weighingCount = BonPesee::count();
        $invoiceCount = FacturePesage::count();

        return view('livewire.dashboard-stats', [
            'chartData' => $this->getChartData(),
            'weighingData' => $this->getWeighingData(),
            'invoiceData' => $this->getInvoiceData(),
            'weighingCount' => $weighingCount,
            'invoiceCount' => $invoiceCount,
        ]);
    }
}
