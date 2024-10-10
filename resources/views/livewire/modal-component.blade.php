<div>
    <h2 class="mt-10">
        <span class="font-semibold">CEMAC:</span> Communauté Economique des Etats de l'Afrique Centrale
    </h2>

    <x-modal wire:model="showModal.article20">
        <x-slot name="title">
            <span class="font-semibold">Article 20 du code CEMAC :</span> LIMITATION DES POIDS DES VEHICULES
        </x-slot>

        <div class="mt-4 mx-10">
            1. Les normes suivantes sont retenues:<br />
            <div class="ms-5">
                <p class="pt-2">
                    a- Charches maximales par essieu pour un véhicule:<br />
                </p>
                <div class="ms-5">
                    - 13 tonnes pour un essieu simple;<br />
                    - 21 tonnes pour un essieu tandem;<br />
                    - 27 tonnes pour un essieu tridem.
                </div>
                <p class="pt-2">
                    b- Le poids total autorisé en charge ne peut dépasser 50 tonnes.
                </p>
            </div>
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article20')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <x-modal wire:model="showModal.article21">
        <x-slot name="title">
            <span class="font-semibold">Article 21 du code CEMAC :</span> CHARGEMENT DES VEHICULES
        </x-slot>

        <div class="mt-4 mx-10">
            Lorsqu'un poids maximal autorisé est fixé pour un véhicule, le poids en charge de ce véhicule ne doit jamais
            dépasser le poids
            maximal autorisé. Par ailleurs, le chargement doit être réparti de façon à ce que la charge par essieu ou
            groupe d'essieux ne
            dépasse pas les charges définies dans l'article 20.
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article21')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <x-modal wire:model="showModal.article22">
        <x-slot name="title">
            <span class="font-semibold">Article 22 du code CEMAC :</span> DIMENSIONS DES VEHICULES
        </x-slot>

        <div class="mt-4 ms-10">
            Sauf cas de transports exceptionnels, les dimensions de véhicules automobiles ou ensembles, autorisés à
            ceirculer, tout
            chargement compris, sont fixées comme suit:<br />
            <div class="ms-5">
                <p class="pt-2">
                    1. Longueurs maximales (toutes saillies comprises):<br />
                </p>
                <div class="ms-5">
                    a- véhicule isolé: 12 mètres;<br />
                    b- ensemble articulé: 15,50 mètres;<br />
                    c- train routier: 18 mètres;
                </div>
                <p class="pt-2">
                    2. largeur maximale : 2,50 mètres, Cette longueur maximale s'entend toutes saillies (sauf les
                    retroviseurs, feux de gabarit et indicateur de changement)</p>
                <p class="pt-2">
                    3. hauteur maximale: 4 mètres</p>
            </div>
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article22')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <x-modal wire:model="showModal.article71">
        <x-slot name="title">
            <span class="font-semibold">Article 71 du code CEMAC :</span> DISPOSITIONS GENERALES (Protection du domaine
            public routier)
        </x-slot>

        <div class="mt-4 mx-10">
            1. L'usage des axes routiers ouverts à la circulation est réservé aux véhicules déclarés conformes aux
            prescriptions du Code
            de la Route, notemment en ce qui concerne les caractéristiques techniquess relatives:<br />
            <div class="ms-5">
                <dl>
                    <li> au poids total autorisé en charge</li>
                    <li>au poids à vide;</li>
                    <li>à la charge à l'essieu;</li>
                    <li>à la distance entre les essieux;</li>
                    <li>au gabarit.</li>
                </dl>
            </div>
            <p class="pt-2">
                2. Les limitations de poids et les dimensions nen doivent pas excéder les limites fixées par les
                articles 20
                et 22 du présent
                Code.</p>
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article71')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <x-modal wire:model="showModal.article73">
        <x-slot name="title">
            <span class="font-semibold">Article 73 du code CEMAC :</span> PESAGE DES VEHICULES (Protection du domaine
            public routier)
        </x-slot>

        <div class="mt-4 mx-10">
            1. Le pesage routier est une opération technique destinée à contrôler la conformité des normes relatives ax
            poids total
            autorisé en charge et à l'essieu, pour tout véhicule dont le poids total en charge est superieur à 3,5
            tonnes.<br />
            <p class="pt-2">
                2. Il est effectué au niveau des stations depesage fixes ou mobiles.<br /></p>
            <p class="pt-2">
                3. Il est obligatoire sur toutes les routes comportant un dispositif de contrôle du poids et de la
                charge à
                l'essieu.<br /></p>
            <div class="pt-2">
                4. Tout conducteur d'un véhicule en surcharge est astreint au paiement d'une amende de la manière
                suivante:
                <p class="ms-5">
                    - surcharge inférieure à 5 tonnes: 25 000 (vingt cinq mille) Francs CFA par tonne
                    supplémentaire;<br />
                    - surcharge de 5 à 10 tonnes: 50 000 'cinquante mille Francs CFA par tonne supplémentaire; <br />
                    - au-delà de 10 tonnes: 75 000 (soixante quinze mille) Francs CFA par tonne supplémentaire.</br>
                </p>
            </div>
            <p class="pt-2">
                Les Transporteurs récidivistes s'exposent au retrait de leur licence de transport par l'Autorité
                compétente
                chargée des
                transports.
            </p>
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article73')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <ul class="flex w-full justify-around mt-5 text-red-600">
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article20')" class="ms-5">Article 20
                du code CEMAC</button></li>
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article21')" class="ms-5">Article 21
                du code CEMAC</button></li>
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article22')" class="ms-5">Article 22
                du code CEMAC</button></li>
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article71')" class="ms-5">Article 71
                du code CEMAC</button></li>
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article73')" class="ms-5">Article 73
                du code CEMAC</button></li>
    </ul>

    <h2 class="mt-7">
        <span class="font-semibold">Loi 13/2003 du 17/02/2005</span> Portant protection du patrimoine routier national
    </h2>

    <x-modal wire:model="showModal.article24">
        <x-slot name="title">
            <span class="font-semibold">Article 24 alinéa 2</span>
        </x-slot>

        <div class="mt-4 mx-10">
            Toute surcharge entraîne l'immobilisation du véhicule ou ensemblede véhicules jusqu'au déchargement de la
            charge exédentaire.
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article24')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <x-modal wire:model="showModal.article25">
        <x-slot name="title">
            <span class="font-semibold">Article 25</span>
        </x-slot>

        <div class="mt-4 mx-10">
            Sera puni d'une amende de 100 000 FCFA à 150 000 FCFA, assorti d'une immobilisation du véficule ou
            ensemblede véhicules, l'auteur du
            non respect de gabarit règlementaire.
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article25')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <x-modal wire:model="showModal.article26">
        <x-slot name="title">
            <span class="font-semibold">Article 26</span>
        </x-slot>

        <div class="mt-4 mx-10">
            Sera puni d'un emprisonnement de trois mois et d'une amende de 500 000 FCFA à 1 000 000 FCFA, ou de l'une de
            ces deux peines
            seulement, tout auteur de falsicifationdes documents de circulation relatifs au poids et au gabaritvéhicules
            ou ensemble de véhicules.
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article26')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <x-modal wire:model="showModal.article27">
        <x-slot name="title">
            <span class="font-semibold">Article 27</span>
        </x-slot>

        <div class="mt-4 mx-10">
            Sera puni d'un emprisonnement de dix jours à un mois et d'une amende de 300 000 FCFA à 500 000 FCFA,
            assortis d'une mesure de
            suspension du permis du permis de conduire, ou de l'une de ces deux peines seulement, le conducteur qui aura
            refusé de conduire un
            véhicule ou ensemble de véhicules à la balance d'une station de pesage fixe ou mobile.
        </div>

        <div class="sm:mt-6 m-5 flex justify-end">
            <x-button wire:click="closeModal('article27')">
                Fermer
            </x-button>
        </div>
    </x-modal>

    <ul class="flex w-full justify-around mt-5 text-red-600">
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article24')" class="ms-5">Article 24
                aliéna 2</button></li>
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article25')" class="ms-5">Article
                25</button></li>
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article26')" class="ms-5">Article
                26</button></li>
        <li class="underline hover:text-blue-500"><button wire:click="openModal('article27')" class="ms-5">Article
                27</button></li>
    </ul>

    <div class="mt-20">
        <div>
            <h3>
                <span class="font-semibold">DOCUMENTS EXIGES:</span>
            </h3>
            <dl class="ms-5">
                <li>Carte grise du véhicule ou License de transport</li>
                <li> Permis de conduire</li>
            </dl>
        </div>
        <div class="mt-5">
            <h3>
                <span class="font-semibold">
                    VITESSE DE PASSAGE:
                </span>
                Comprise entre 5km/h et 8km/h ( 5 km/h ≤ Vitesse de passage ≤ 8km/h )
            </h3>
        </div>
    </div>
</div>
