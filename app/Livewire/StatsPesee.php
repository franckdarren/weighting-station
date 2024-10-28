<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BonPesee;
use Carbon\Carbon;

class StatsPesee extends Component
{
    public $timeFilter = 'year';
    public $statusFilter = 'all';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfYear();
        $this->endDate = Carbon::now();
    }

    public function getChartData()
    {
        $query = BonPesee::query();

        // Pour le débogage
        logger('Dates range:', [$this->startDate, $this->endDate]);

        // Get all records first
        $records = $query->whereBetween('created_at', [$this->startDate, $this->endDate])->get();

        // Pour le débogage
        logger('Records count:', [$records->count()]);

        // Then filter by status using the accessor
        if ($this->statusFilter === 'Valide') {
            $records = $records->filter(fn($record) => $record->status === 'Valide');
        } elseif ($this->statusFilter === 'A reprendre') {
            $records = $records->filter(fn($record) => $record->status === 'A reprendre');
        }

        // Pour le débogage
        logger('Filtered records count:', [$records->count()]);

        // Group the filtered records
        $groupFormat = match ($this->timeFilter) {
            'year' => 'Y',
            'month' => 'Y-m',
            'day' => 'Y-m-d',
        };

        $data = $records->groupBy(function ($item) use ($groupFormat) {
            return Carbon::parse($item->created_at)->format($groupFormat);
        })->map->count();

        // Pour le débogage
        logger('Grouped data:', $data->toArray());

        // Si aucune donnée, créer des données factices pour test
        if ($data->isEmpty()) {
            $data = collect([
                '2024-01' => 5,
                '2024-02' => 8,
                '2024-03' => 3,
            ]);
        }

        return [
            'labels' => $data->keys()->toArray(),
            'datasets' => [[
                'label' => 'Nombre de pesées',
                'data' => $data->values()->toArray(),
                'borderColor' => '#3d8cd6',
                'backgroundColor' => 'rgba(61, 140, 214, 0.2)',
                'borderWidth' => 2,
                'tension' => 0.4,
                'fill' => true
            ]]
        ];
    }

    public function render()
    {
        return view('livewire.stats-pesee');
    }
}
