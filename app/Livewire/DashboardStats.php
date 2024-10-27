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
                'data' => [$totalWeighings, 100 - $totalWeighings],
                'backgroundColor' => ['#3d8cd6', 'transparent'],
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
                'data' => [$totalInvoices, 100 - $totalInvoices],
                'backgroundColor' => ['#3d8cd6', 'transparent'],
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
                    BonPesee::count(),
                    FacturePesage::count(),
                    FacturePesage::where('statut', 'payé')->count(),
                    FacturePesage::where('statut', 'non payé')->count(),
                ],
                'backgroundColor' => ['#3d8cd6', '#e15759', '#3ba94a', '#f28e2c'],
            ]],
            'labels' => ['Total Pesages', 'Total Factures', 'Factures Payées', 'Factures Non-payées'],
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
