<?php

namespace App\Livewire;

use App\Models\Pv;
use Filament\Forms\Get;
use Filament\Forms\Set;
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

class ListCaisse extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;



    public function table(Table $table): Table
    {
        return $table
            ->query(
                FacturePesage::query()->where('statut', 'En attente de paiement')->orWhere('statut', 'Payée')->orWhere('statut', 'En attente') // Filtrer les factures en attente de paiement ou payée
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
                        'En attente de paiement' => 'warning',
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
                        ->visible(fn(FacturePesage $record) => auth()->user()->can('view factures') && $record->statut === 'Payée') // Masquer pour les utilisateurs sans cette permission
                        ->after(function () {
                            activity()
                                ->causedBy(auth()->user())
                                ->log('Facture exportée au format PDF.'); // Correction du message
                        }),

                    // Action de paiement
                    Action::make('edit')
                        ->label('Mode de paiement')
                        ->action(function (FacturePesage $record, array $data) {
                            // Mise à jour de la table `FacturePesage`
                            $record->update([
                                'montant_total' => $data['montant_total'],
                                'cash_montant' => $data['cash_montant'],
                                'airtelmoney_montant' => $data['airtelmoney_montant'],
                                'cheque_montant' => $data['cheque_montant'],
                                'total_paiement' => $data['total_paiement'],
                                'reste_a_payer' => $data['reste_a_payer'],
                                'trop_percu' => $data['trop_percu'],
                                'statut' => $data['statut'],
                            ]);
                        })
                        ->form([
                            TextInput::make('montant_total')
                                ->label('Montant total')
                                ->numeric()
                                ->required()
                                ->live(true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::calculateTotalPaiement($get, $set);
                                }),

                            Fieldset::make('Cash')
                                ->schema([
                                    TextInput::make('cash_montant')
                                        ->label('Montant')
                                        ->live(true)
                                        ->numeric()
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            Self::calculateTotalPaiement($get, $set);
                                        }),
                                    TextInput::make('cash_num_transaction')
                                        ->label('Numéro de transaction'),
                                ]),

                            Fieldset::make('Airtel Money')
                                ->schema([
                                    TextInput::make('airtelmoney_montant')
                                        ->label('Montant')
                                        ->live(true)
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            Self::calculateTotalPaiement($get, $set);
                                        })
                                        ->numeric(),
                                    TextInput::make('airtelmoney_num_transaction')
                                        ->label('Numéro de transaction'),
                                ]),

                            Fieldset::make('Chèque')
                                ->schema([
                                    TextInput::make('cheque_montant')
                                        ->label('Montant')
                                        ->live(true)
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            Self::calculateTotalPaiement($get, $set);
                                        })
                                        ->numeric(),
                                    TextInput::make('cheque_num_transaction')
                                        ->label('Numéro de transaction'),
                                ]),

                            TextInput::make('total_paiement')
                                ->label('Total paiement')
                                ->required()
                                ->live(true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    Self::calculateTotalPaiement($get, $set);
                                }),

                            TextInput::make('reste_a_payer')
                                ->label('Reste à payer')
                                ->required(),

                            TextInput::make('trop_percu')
                                ->label('Trop perçu')
                                ->required(),

                            Select::make('statut')
                                ->label('Statut')
                                ->options([
                                    'En attente' => 'En attente',
                                    'Payée' => 'Payée',
                                ])
                                ->required(),
                        ])
                        ->modalHeading('Éditer la facture')
                        ->modalWidth('lg')
                        ->mountUsing(fn(Component $livewire, FacturePesage $record, $form) => $form->fill([
                            'montant_total' => $record->montant_total,
                            'cash_montant' => $record->cash_montant,
                            'airtelmoney_montant' => $record->airtelmoney_montant,
                            'cheque_montant' => $record->cheque_montant,
                            'total_paiement' => $record->total_paiement,
                            'reste_a_payer' => $record->reste_a_payer,
                            'trop_percu' => $record->trop_percu,
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
                    ->visible(fn() => auth()->user()->can('edit factures')) // Masquer pour les utilisateurs sans cette permission
                    ->after(function () {
                        activity()
                            ->causedBy(auth()->user())
                            ->log('Export de factures effectuées au format Excel.');
                    })
            ]);
    }

    protected function getSurchargeWeightsCount(): int
    {
        return FacturePesage::where('type', 'Surcharge')->where('statut', 'En attente de paiement')->orWhere('statut', 'Payée')->count();
    }

    protected function getNoSurchargeWeightsCount(): int
    {
        return FacturePesage::where('type', 'Normal')->where('statut', 'En attente de paiement')->orWhere('statut', 'Payée')->count();
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

    public static function calculateTotalPaiement(Get $get, Set $set): void
    {
        $set('total_paiement', $get('cash_montant') + $get('airtelmoney_montant') + $get('cheque_montant'));

        // Calculer reste_a_payer avec une condition pour ne pas être négatif
        $resteAPayer = $get('montant_total') - $get('total_paiement');
        $set('reste_a_payer', max(0, $resteAPayer));

        // Calculer trop_percu avec une condition pour ne pas être négatif
        $tropPerçu = $get('total_paiement') - $get('montant_total');
        $set('trop_percu', max(0, $tropPerçu));
    }


    public function render()
    {
        return view('livewire.list-caisse');
    }
}
