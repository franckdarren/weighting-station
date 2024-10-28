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
use Filament\Forms\Components\Select;
use PDF; // Utilisation du facade PDF
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
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
            ->query(
                FacturePesage::query()->where('statut', 'En attente de paiement')->orWhere('statut', 'En attente de traitement') // Filtrer les factures en attente de paiement ou payée
            )
            ->columns([
                TextColumn::make('numero')
                    ->searchable(),
                TextColumn::make('bonPesee.vitesse')
                    ->label('Vitesse (km/h)')
                    ->badge()
                    ->color(fn($state) => $state > 8 ? 'danger' : 'success'),
                TextColumn::make('bonPesee.plaque_immatriculation')
                    ->label("Immatriculation")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('bonPesee.numero')
                    ->label("Bon pesée")
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('bonPesee.produits_transportes')
                    ->label("Produits transporté"),
                TextColumn::make('identite_conducteur')
                    ->label("Chauffeur"),
                TextColumn::make('num_permis_conduire')
                    ->label("Permis de conduire"),
                TextColumn::make('cte_grise_licence_autres')
                    ->label("Carte grise/Licence/Autres"),
                TextColumn::make('bonPesee.entreprise')
                    ->label("Société")
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'Surcharge' => 'warning',
                        'Normal' => 'success',
                    }),

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

                TextColumn::make('provenance')
                    ->label("Provenance")
                    ->searchable(),
                TextColumn::make('destination')
                    ->label("Destination")
                    ->searchable(),

                TextColumn::make('observations')
                    ->searchable(),
                TextColumn::make('statut')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'En attente de traitement' => 'warning',
                        'En attente de paiement' => 'success',
                        'En attente' => 'warning',
                        'Payée' => 'success',
                    }),

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
                ActionGroup::make([
                    // Export en PDF
                    Action::make('export_pdf')
                        ->label('Exporter facture')
                        ->action(function (FacturePesage $record) {
                            return $this->exportFactureToPDF($record);
                        })
                        ->visible(fn(FacturePesage $record) => auth()->user()->can('view factures') && $record->statut === 'En attente de paiement') // Masquer pour les utilisateurs sans cette permission
                        ->after(function () {
                            activity()
                                ->causedBy(auth()->user())
                                ->log('Facture exportée au format PDF.'); // Correction du message
                        }),

                    // Action d'édition
                    Action::make('edit')
                        ->label('Éditer')
                        ->action(function (FacturePesage $record, array $data) {
                            // Mise à jour de la table `FacturePesage`
                            $record->update([
                                'identite_conducteur' => $data['identite_conducteur'],
                                'num_permis_conduire' => $data['num_permis_conduire'],
                                'cte_grise_licence_autres' => $data['cte_grise_licence_autres'],
                                'provenance' => $data['provenance'],
                                'destination' => $data['destination'],
                                'observations' => $data['observations'],
                                'statut' => $data['statut'],
                            ]);

                            // Mise à jour de la table `BonPesee` à partir de la relation
                            $record->bonPesee->update([
                                'entreprise' => $data['entreprise'],
                                'produits_transportes' => $data['produits_transportes'],
                            ]);
                        })
                        ->form([
                            Fieldset::make('Infos bon de pesée')
                                ->schema([
                                    TextInput::make('entreprise')
                                        ->label('Entreprise')
                                        ->required(),

                                    TextInput::make('produits_transportes')
                                        ->label('Produits transportés')
                                        ->required(),

                                ]),

                            Fieldset::make('Infos conducteur')
                                ->schema([
                                    TextInput::make('identite_conducteur')
                                        ->label('Identité du conducteur')
                                        ->required(),

                                    TextInput::make('num_permis_conduire')
                                        ->label('Permis de conduire')
                                        ->required(),

                                    TextInput::make('cte_grise_licence_autres')
                                        ->label('Carte grise/Licence/Autres')
                                        ->required(),

                                ]),

                            Fieldset::make('Infos parcours')
                                ->schema([
                                    TextInput::make('provenance')
                                        ->label('Provenance')
                                        ->required(),

                                    TextInput::make('destination')
                                        ->label('Destination')
                                        ->required(),

                                ]),

                            Textarea::make('observations')
                                ->label('Observations'),

                            Select::make('statut')
                                ->label('Statut')
                                ->options([
                                    'En attente de paiement' => 'En attente de paiement',
                                ])
                                ->required(),
                        ])
                        ->modalHeading('Éditer la facture')
                        ->modalWidth('lg')
                        ->mountUsing(fn(Component $livewire, FacturePesage $record, $form) => $form->fill([
                            'entreprise' => $record->bonPesee->entreprise,
                            'produits_transportes' => $record->bonPesee->produits_transportes,
                            'identite_conducteur' => $record->identite_conducteur,
                            'num_permis_conduire' => $record->num_permis_conduire,
                            'cte_grise_licence_autres' => $record->cte_grise_licence_autres,
                            'provenance' => $record->provenance,
                            'destination' => $record->destination,
                            'observations' => $record->observations,
                            'statut' => $record->statut,
                        ]))
                        ->visible(fn() => auth()->user()->can('edit factures'))
                        ->after(function () {
                            activity()
                                ->causedBy(auth()->user())
                                ->log('Facture modifiée.');
                        })
                ])
                    ->link()
                    ->color('success')
                    ->label('Actions')


            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->exporter(FacturePesageExporter::class)
                    ->label('Exporter')
                    ->formats([
                        ExportFormat::Xlsx
                    ])
                    ->visible(auth()->user()->can('edit factures'))  // Masquer si l'utilisateur n'a pas la permission
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
