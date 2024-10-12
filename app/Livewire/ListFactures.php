<?php

namespace App\Livewire;

use App\Models\Pv;
use Livewire\Component;
use App\Models\BonPesee;
use App\Models\Vehicule;
use App\Models\Conducteur;
use Filament\Tables\Table;
use App\Models\FacturePesage;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use PDF; // Utilisation du facade PDF
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\FacturePesageExporter;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Concerns\InteractsWithTable;


class ListFactures extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        return $table
            ->query(FacturePesage::query())
            ->columns([
                TextColumn::make('numero')
                    ->searchable(),
                TextColumn::make('bonPesee.vehicule.plaque_immatriculation')
                    ->label("Matricule")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('bonPesee.conducteur')
                    ->label("Chauffeur")
                    ->formatStateUsing(fn($state) => $state->nom . ' ' . $state->prenoms),
                TextColumn::make('bonPesee.vehicule.entreprise')
                    ->label("Société")
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'Surcharge' => 'warning',
                        'Normal' => 'success',
                    }),
                TextColumn::make('bonPesee.numero')
                    ->label("Bon pesée")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('pv.numero')
                    ->label("PV")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('pv.montant_amendes')
                    ->label("Montant amendes")
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, '', ' ');
                    }),
                TextColumn::make('montant_total')
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 0, '', ' ');
                    }),
                TextColumn::make('statut')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'En attente de paiement' => 'warning',
                        'Payée' => 'success',
                    }),
                TextColumn::make('bonPesee.provenance')
                    ->label("Provenance")
                    ->searchable(),
                TextColumn::make('bonPesee.destination')
                    ->label("Destination")
                    ->searchable(),
                TextColumn::make('bonPesee.produits_transportes')
                    ->label("Produits transporté"),
                TextColumn::make('created_at')
                    ->searchable()
                    ->since()
                    ->dateTimeTooltip()
                    ->label("Date création")

            ])
            ->filters([
                Filter::make('Avec surchage')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'Surcharge'))
                    ->toggle()
                    ->label('Avec surcharge (' . $this->getSurchargeWeightsCount() . ')'),

                Filter::make('Sans surchage')
                    ->query(fn(Builder $query): Builder => $query->where('type', 'Normal'))
                    ->toggle()
                    ->label('Sans surcharge (' . $this->getNoSurchargeWeightsCount() . ')'),

                Filter::make('Payées')
                    ->query(fn(Builder $query): Builder => $query->where('statut', 'Payée'))
                    ->toggle()
                    ->label('Payées (' . $this->getPaidFactureCount() . ')'),

                Filter::make('Non payées')
                    ->query(fn(Builder $query): Builder => $query->where('statut', 'En attente de paiement'))
                    ->toggle()
                    ->label('Non payées (' . $this->getNoPaidFactureCount() . ')'),

            ])
            ->actions([
                // Export en PDF
                Action::make('export_pdf')
                    ->label('Exporter en PDF')
                    ->action(function (FacturePesage $record) {
                        return $this->exportFactureToPDF($record);
                    })
                    ->after(function () {
                        activity()
                            ->causedBy(auth()->user())
                            ->log('Facture exportés au format Excel.');
                    }),
                // Changement de statut de la facture    
                Action::make('changer_statut')
                    ->label('Changer statut')
                    ->action(function (FacturePesage $record) {
                        $ancienStatut = $record->statut;  // Enregistrer l'ancien statut

                        // Changer le statut de la facture
                        if ($record->statut === 'En attente de paiement') {
                            $record->statut = 'Payée';
                        } else {
                            $record->statut = 'En attente de paiement';
                        }

                        $record->save();

                        // Enregistrer l'action dans le journal avec Spatie Activitylog
                        activity()
                            ->causedBy(auth()->user())
                            ->performedOn($record)
                            ->withProperties([
                                'ancien_statut' => $ancienStatut,
                                'nouveau_statut' => $record->statut,
                                'facture_code' => $record->numero,
                            ])
                            ->log("Le statut de la facture $record->numero a été changé de $ancienStatut à $record->statut"); // Description de l'action

                        // Rafraîchir la table après mise à jour
                        $this->dispatch('refreshTable');

                        // Utiliser un message flash
                        session()->flash('message', 'Le statut a été mis à jour avec succès !');
                    })
                    ->requiresConfirmation()
                    ->color('success')

            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->exporter(FacturePesageExporter::class)
                    ->label('Exporter')
                    ->formats([
                        ExportFormat::Xlsx
                    ])
                    ->after(function () {
                        activity()
                            ->causedBy(auth()->user())
                            ->log('Export de factures effectuées au format Excel.');
                    })
            ]);
    }

    protected function getSurchargeWeightsCount(): int
    {
        return FacturePesage::where('type', 'Surcharge')->count();
    }

    protected function getNoSurchargeWeightsCount(): int
    {
        return FacturePesage::where('type', 'Normal')->count();
    }

    protected function getPaidFactureCount(): int
    {
        return FacturePesage::where('statut', 'Payée')->count();
    }

    protected function getNoPaidFactureCount(): int
    {
        return FacturePesage::where('statut', 'En attente de paiement')->count();
    }

    // Méthode pour exporter une facture en PDF
    public function exportFactureToPDF(FacturePesage $facture)
    {
        $data = [
            'facture' => $facture,
        ];

        $numero_facture = $facture->bon_pesee_id;
        $typeFacture = $facture->type;
        $forfait_usage = $facture->forfait_usage;
        $montant_totalFacture = $facture->montant_total;
        $statutFacture = $facture->statut;

        $bon_pesee_id = $facture->bon_pesee_id;
        $pv_id = $facture->pv_id;

        // Recherchez le BonPesee correspondant
        $bp = BonPesee::find($bon_pesee_id);


        // Recherchez le PV correspondant
        $pv = Pv::find($pv_id);

        // Recherchez le Véhicule correspondant
        $vehicule = Vehicule::find($bp->vehicule_id);

        // Recherchez le Conducteur correspondant
        $conducteur = Conducteur::find($bp->conducteur_id);

        // Groupes essieux
        $ge1 = $bp->poids_E1;
        $ge2 = $bp->poids_E2 + $bp->poids_E3 + $bp->poids_E4;
        $ge3 = $bp->poids_E5 + $bp->poids_E6;



        // Générer le PDF avec le facade PDF
        $pdf = PDF::loadView('pdf.facture', [
            'bp' => $bp,
            'pv' => $pv,
            'vehicule' => $vehicule,
            'conducteur' => $conducteur,
            'ge1' => $ge1,
            'ge2' => $ge2,
            'ge3' => $ge3,




        ]);
        // dd($bp);
        // Télécharger le fichier PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'facture_' . $facture->numero . '.pdf');
    }

    public function render()
    {
        return view('livewire.list-factures');
    }
}
