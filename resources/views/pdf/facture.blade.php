<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Facture</title>
</head>

<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    span {
        font-weight: normal;
    }

    body {
        font-family: "Poppins", sans-serif;
        font-size: 0.7rem;
        font-weight: 400;
        line-height: 0.75rem;
        color: #212529;
        /* text-align: left;
        padding: 15px; */
    }

    section {
        /* max-width: 1473px; */
        width: calc(100% - 40px);
        margin: 0 auto;
        padding: 0 5px !important;
    }

    .container {
        /* max-width: 900px; */
        width: 100%;
        margin-inline: auto;

        position: relative;
    }

    h1 {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        font-size: 0.80rem;
        line-height: 1rem;
        font-weight: 500;
        color: #5a5230;
        /* height: 130px; */
        display: inline-block;
    }

    .informations-library-user {
        margin: 0;
    }

    .informations-library-user div {
        padding: 0 4px;
        display: inline-block;
    }

    .informations-library-user,
    .section-livraison {
        padding: 0.10rem 0;
        /* border-top: 1.5px solid #eeeeee; */
    }


    .uppercase {
        text-transform: uppercase;
    }

    .capitalize {
        text-transform: capitalize;
    }

    .sub-title {
        font-size: 0.64rem;
        line-height: 0.5rem;
        font-weight: 400;
        color: #212121;
    }

    p span {
        display: inline-block;
        color: #212121;
        text-transform: uppercase;
        font-weight: 600;
    }

    .sub-title span {
        color: #9e9e9e;
        font-weight: 300;
    }

    /* .section-table {
        margin-top: 1 rem;
        border-top: 1.5px solid #eeeeee;
    } */

    h4 {
        font-weight: 400;
        margin-bottom: 0.75rem;
        color: #616161;
    }

    .main-table {
        width: 100%;
        overflow: hidden;
    }

    table {
        border-collapse: collapse;

        width: 100%;
        table-layout: auto;
        margin-top: 10px;
        border-color: #000;
        font-size: 9px;
        text-align: center;
    }

    thead {
        background-color: rgb(236, 223, 185);
    }

    tfoot {
        border-top: 1.5px solid #eeeeee;
        padding-top: 1.5rem;
    }

    thead th {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        text-align: center;
    }

    thead th:first-child {
        padding-left: 0.25rem;
        text-align: center;
    }

    thead th:last-child {
        padding-right: 0.25rem;
        text-align: center;
    }

    tbody td {
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
        text-align: center;
    }

    tbody td:first-child {
        text-align: center;
    }

    tbody td:last-child {
        text-align: center;
    }

    tfoot td {
        padding-left: 2rem;
        padding-right: 2rem;
        font-size: 0.84rem;
        line-height: 1.05rem;
        padding-top: 1rem;
        padding-bottom: 0.75rem;
        font-weight: 700;
    }

    tfoot td:last-child {
        text-align: center;
    }

    .first-line {
        border-top: 1px solid #000;
    }
</style>

<body>
    <section>
        <div class="container">
            <div class="head" style="display: flex; justify-content: center; align-items: center">
                <div style="display: inline-block">
                    <img src=" " alt="logo" />
                </div>
                <h1
                    style="
              align-items: center;
              display: flex;
              justify-content: center;
              background-color: #464040;
              color: #fff;
              width: 100%;
            ">
                    Station de pesage de Ndjole
                </h1>
            </div>
            <h1
                style="
            text-align: center;
            
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: #c4bebe;
            color: #000;
            width: 100%;
          ">
                Amende de constat d'infraction de surchage
            </h1>
            <div>
                <div class="head-invoice">

                    <div class="section-livraison">
                        <h4 class="sub-title">
                            N°Bon de pesée : <span style="margin-right: 30%;" class="capitalize">
                                {{ $bp->numero }}</span>
                            Matricule vehicule: <span>{{ $vehicule->plaque_immatriculation }}</span>
                        </h4>
                        <h4 class="sub-title">
                            N° de pv de constat de surcharge :
                            <span style="margin-right: 20%;"
                                class="capitalize">{{ $pv->numero ?? '                  ' }}</span>Société :
                            <span>{{ $vehicule->entreprise }}</span>
                        </h4>
                        <h4>
                            Nom et prénom du chauffeur : <span style="margin-right: 20%;">{{ $conducteur->nom }}
                                {{ $conducteur->prenoms }}</span>
                            Provenance : <span>{{ $bp->provenance }}</span>
                        </h4>
                        <h4>Destination : <span style="margin-right: 30%;">{{ $bp->destination }}</span>
                            Produit transporté : <span>{{ $bp->produits_transportes }}</span></h4>
                    </div>
                    <br>

                    <p>Opérateur : {{ Auth::user()->name }}</p>

                </div>
            </div>

            <div class="">
                <div class="main-table">
                    <table border="2">
                        <thead>
                            <tr>
                                <th colspan="4">
                                    Controle sur le poids total autorisé a chargé (PTAC)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PTAC</td>
                                <td>POIDS MAX</td>
                                <td>SURCHARGE RETENUE</td>
                                <td>AMENDES</td>
                            </tr>
                            <tr>
                                <td>68310</td>
                                <td>51000</td>
                                <td>17310</td>
                                <td>1,298,250</td>
                            </tr>
                        </tbody>
                    </table>

                    <table border="2">
                        <thead>
                            <th colspan="5">Contrôle sur le groupement d'essieux</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Groupes</td>
                                <td>Poids</td>
                                <td>Poids max</td>
                                <td>Surcharge retenue</td>
                                <td>Amendes</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>{{ $ge1 }}</td>
                                <td>22000</td>
                                <td>{{ max($ge1 - 22000, 0) }}</td>
                                <td>{{ number_format(max($ge1 - 22000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>{{ $ge2 }}</td>
                                <td>22000</td>
                                <td>{{ max($ge2 - 22000, 0) }}</td>
                                <td>{{ number_format(max($ge2 - 22000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>{{ $ge3 }}</td>
                                <td>22000</td>
                                <td>{{ max($ge3 - 22000, 0) }}</td>
                                <td>{{ number_format(max($ge3 - 22000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="2">
                        <thead>
                            <td style="background-color: #f5f1f1"></td>
                            <th colspan="5">Contrôle a l'essieu</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="background-color: #fff"></td>
                                <td>Essieux</td>
                                <td>Poids</td>
                                <td>Poids max</td>
                                <td>Surcharge retenue</td>
                                <td>Amendes</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>{{ $bp->poids_E1 }}</td>
                                <td>14000</td>
                                <td>{{ max($bp->poids_E1 - 14000, 0) }}</td>
                                <td>{{ number_format(max($bp->poids_E1 - 14000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>{{ $bp->poids_E2 }}</td>
                                <td>14000</td>
                                <td>{{ max($bp->poids_E2 - 14000, 0) }}</td>
                                <td>{{ number_format(max($bp->poids_E2 - 14000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>3</td>
                                <td>{{ $bp->poids_E3 }}</td>
                                <td>14000</td>
                                <td>{{ max($bp->poids_E3 - 14000, 0) }}</td>
                                <td>{{ number_format(max($bp->poids_E3 - 14000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>4</td>
                                <td>{{ $bp->poids_E4 }}</td>
                                <td>14000</td>
                                <td>{{ max($bp->poids_E4 - 14000, 0) }}</td>
                                <td>{{ number_format(max($bp->poids_E4 - 14000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>5</td>
                                <td>{{ $bp->poids_E5 }}</td>
                                <td>14000</td>
                                <td>{{ max($bp->poids_E5 - 14000, 0) }}</td>
                                <td>{{ number_format(max($bp->poids_E5 - 14000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>6</td>
                                <td>{{ $bp->poids_E6 }}</td>
                                <td>14000</td>
                                <td>{{ max($bp->poids_E6 - 14000, 0) }}</td>
                                <td>{{ number_format(max($bp->poids_E6 - 14000, 0) * 75, 0, ',', ' ') }}</td>
                            </tr>
                            <tr>
                                <td>0</td>
                                <td>7</td>
                                <td>0</td>
                                <td>14000</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td style="text-align: center">Type : 5</td>
                                <td colspan="2">Autres types : 0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table style="margin-left: 30%; width: 70%" border="2">
                        <thead>
                            <th colspan="5">Total Facture</th>
                        </thead>
                        <tbody>
                            <td>Forfait d'usage: 8500</td>
                            <tr>
                                <td>Amendes:
                                    {{ number_format(
                                        max($bp->poids_E6 - 14000, 0) * 75 +
                                            max($bp->poids_E5 - 14000, 0) * 75 +
                                            max($bp->poids_E4 - 14000, 0) * 75 +
                                            max($bp->poids_E3 - 14000, 0) * 75 +
                                            max($bp->poids_E2 - 14000, 0) * 75 +
                                            max($bp->poids_E1 - 14000, 0) * 75,
                                        0,
                                        ',',
                                        ' ',
                                    ) }}

                                </td>
                            </tr>
                            <tr>
                                <td>Net à payer:
                                    {{ number_format(
                                        max($bp->poids_E6 - 14000, 0) * 75 +
                                            max($bp->poids_E5 - 14000, 0) * 75 +
                                            max($bp->poids_E4 - 14000, 0) * 75 +
                                            max($bp->poids_E3 - 14000, 0) * 75 +
                                            max($bp->poids_E2 - 14000, 0) * 75 +
                                            max($bp->poids_E1 - 14000, 0) * 75 +
                                            8500,
                                        0,
                                        ',',
                                        ' ',
                                    ) }}

                                    XAF TTC</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h3 style="margin-left: 50%; margin-top: 20px">Etabli a Ndjole, le
                        {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h3>
                </div>
            </div>
        </div>
        <div style="height: 150px"></div>
    </section>
</body>

</html>
