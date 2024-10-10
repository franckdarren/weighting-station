<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html" />
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
        font-size: 0.8rem;
        font-weight: 400;
        line-height: 0.85rem;
        color: #212529;
        /* text-align: left;
        padding: 15px; */
    }

    section {
        /* max-width: 1473px; */
        width: calc(100% - 40px);
        margin: 0 auto;
        padding: 0 20px !important;
    }

    .container {
        /* max-width: 900px; */
        width: 100%;
        margin-inline: auto;
        padding: 1.25rem 0;
        position: relative;
    }

    h1 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        font-size: 1rem;
        line-height: 1.5rem;
        font-weight: 500;
        color: #5a5230;
        /* height: 130px; */
        display: inline-block;
    }

    .informations-library-user {
        margin: 0;
    }

    .informations-library-user div {
        padding: 0 8px;
        display: inline-block;
    }

    .informations-library-user,
    .section-livraison {
        padding: 0.5rem 0;
        /* border-top: 1.5px solid #eeeeee; */
    }

    .head-invoice {
        padding-bottom: 0.5rem;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .capitalize {
        text-transform: capitalize;
    }

    .sub-title {
        font-size: 0.94rem;
        line-height: 1.25rem;
        font-weight: 500;
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
        font-weight: 400;
    }

    .section-table {
        margin-top: 1 rem;
        border-top: 1.5px solid #eeeeee;
    }

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
        text-align: left;
    }

    thead th:last-child {
        padding-right: 0.25rem;
        text-align: right;
    }

    tbody td {
        padding-left: 2rem;
        padding-right: 2rem;
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
        text-align: center;
    }

    tbody td:first-child {
        text-align: left;
    }

    tbody td:last-child {
        text-align: right;
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
        text-align: right;
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
                    Station de pesage de ndjole
                </h1>
            </div>
            <h1
                style="
            align-items: center;
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 30px;
            background-color: #c4bebe;
            color: #000;
            width: 100%;
          ">
                Amende de constat d'infraction de surchage
            </h1>
            <div
                style="
            display: flex;
            justify-content: space-between;
            align-items: center;
          ">
                <div class="head-invoice">
                    <!-- <h4>Date : <span>9 août 2024</span></h4>
            <h4 class="sub-title">
              Amende de constat d'infraction de surcharge
            </h4> -->
                    <div class="section-livraison">
                        <h4 class="sub-title">
                            N°Bon de pesée : <span class="capitalize"> {{ $bp->numero }}</span>
                        </h4>
                        <h4 class="sub-title">
                            N° de pv de constat de surcharge :
                            <span class="capitalize"> 2903</span>
                        </h4>
                    </div>
                </div>

                <div
                    style="
              display: flex;
              justify-content: space-between;
              align-items: center;
            ">
                    <div class="library-details">
                        <h4>Matricule vehicule: <span>libraryName</span></h4>
                        <h4>Société : <span>libraryName</span></h4>
                        <h4>
                            Nom et prénom du chauffeur : <span>libraryName</span>
                        </h4>
                        <h4>Provenance : <span>libraryName</span></h4>
                        <h4>Destination : <span>libraryName</span></h4>
                        <h4>Produit transporté : <span>libraryName</span></h4>
                    </div>
                </div>
            </div>

            <div class="section-table">
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
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="2">
                        <thead>
                            <td style="background-color: #fff"></td>
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
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>27720</td>
                                <td>22000</td>
                                <td>5720</td>
                                <td>429,000</td>
                                <td>429,000</td>
                            </tr>
                            <tr>
                                <td style="text-align: center">Type : 5</td>
                                <td colspan="2">Autres types : 0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    style="display: flex; flex-direction: column; justify-content: end; width: 100%; align-items: end;">
                    <table style="width: 50%" border="2">
                        <thead>
                            <th colspan="5">Total Facture</th>
                        </thead>
                        <tbody>
                            <td>Forfait d'usage: 8500</td>
                            <tr>
                                <td>Amendes: 1,298,250</td>
                            </tr>
                            <tr>
                                <td>Net à payer1,306,750 xaf ttc</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 style="margin-top: 20px">Etabli a ndjole, le 23/09/2024</h3>
                </div>
            </div>
        </div>
        <div style="height: 150px"></div>
    </section>
</body>

</html>
