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

    body {
      font-family: "Poppins", sans-serif;
      font-size: 0.7rem;
      font-weight: 400;
      line-height: 0.75rem;
      color: #212529;
      /* text-align: left;
        padding: 15px; */
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

    /* thead {
      background-color: rgb(236, 223, 185);
    } */

    tfoot {
      border-top: 1.5px solid #eeeeee;
      padding-top: 1.5rem;
    }

    thead th {
      padding-top: 0.25rem;
      padding-bottom: 0.25rem;
      text-align: left;
    }
    thead tr {
      display: flex;
      flex-direction: column;
    }

    thead th:first-child {
      padding-left: 0.25rem;
      text-align: left;
    }

    thead th:last-child {
      padding-right: 0.25rem;
      text-align: left;
    }

    tbody td {
      padding-left: 0.25rem;
      padding-right: 0.25rem;
      padding-top: 0.25rem;
      padding-bottom: 0.25rem;
      text-align: left;
    }
    

    tbody td:first-child {
      text-align: left;
    }

    tbody td:last-child {
      text-align: left;
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
    h1 {
      font-size: 15px;
    }
  </style>

  <body>
    <section style="padding-left: 20px; padding-right: 20px; padding-top: 10px;">
      <div class="container">
        <div
          class="head"
          style="display: flex; justify-content: start; align-items: center"
        >
          <div style="display: inline-block">
            <!-- <img src=" " alt="logo" /> -->
            <h1 class="logo-for-the-moment">TPL</h1>
            <p>Travaux publics & Logistique</p>
          </div>
        </div>
        <h1
          style="
            text-align: center;

            margin-top: 10px;
            margin-bottom: 10px;
            color: #000;
            width: 100%;
          "
        >
          Station de pesage de Ndjole
        </h1>
        

        <div style="display: flex; justify-content: space-between;">
          <div class="main-table">
            <table
              style="
                display: flex;
              "
            >
              <thead>
                <tr>
                  <th colspan="4">
                    Temps
                  </th>
                  <th colspan="4">
                    Plaque
                  </th>
                  <th colspan="4">
                    Plaque arrière
                  </th>
                  <th colspan="4">
                    Numéro de pesage
                  </th>
                  <th colspan="4">
                    Type de véhicule
                  </th>
                  <th colspan="4">
                    Nom de l'entreprise
                  </th>
                  <th colspan="4">
                    Nom de materiaux
                  </th>
                  <th colspan="4">
                    Poids
                  </th>
                  <th colspan="4">
                    Limite de poids
                  </th>
                  <th colspan="4">
                    Tolerance de Limite de poids
                  </th>
                  <th colspan="4">
                    Surcharge
                  </th>
                  <th colspan="4">
                    Amende de poids
                  </th>
                  <th colspan="4">
                   Largeur mesurée
                  </th>
                  <th colspan="4">
                    Limite de largeur
                  </th>
                  <th colspan="4">
                    Hauteur mesurée
                  </th>
                  <th colspan="4">
                    Limite de hauteur
                  </th>
                  <th colspan="4">
                    Longueur mesurée
                  </th>
                  <th colspan="4">
                    Limite de longueur
                  </th>
                  <th colspan="4">
                    Nombre d'essieux
                  </th>
                  <th colspan="4">
                    Nombre de groupes d'essieux
                  </th>
                  <th colspan="4">
                    Num d'essieux
                  </th>
                  <th colspan="4">
                    Poids essieux
                  </th>
                  <th colspan="4">
                    Groupe d'essieux Num
                  </th>
                  <th colspan="4">
                    Poids des groupes d'essieux
                  </th>
                  <th colspan="4">
                    Surcharge du groupe d'essieux
                  </th>
                  <th colspan="4">
                    amende de Groupe d'essieux
                  </th>
                  <th colspan="4">
                    CHARGE MAXIMUM DU GROUPE (kg)
                  </th>
                  <th colspan="4">
                    Resultat de pesage
                  </th>
                  <th colspan="4">
                    Tarif d'usage
                  </th>
                  <th colspan="4">
                    Resultat de poids
                  </th>
                  <th colspan="4">
                    Total d'amende
                  </th>
                  <th colspan="4">
                    Vitesse
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr style="display: flex;
      flex-direction: column;">
                  <td>26/09/2024 12:31:28</td>
                  <td>JX 691 AA</td>
                  <td>null</td>
                  <td>3330</td>
                  <td>6-VEHICULE A 6 ESSIEUX</td>
                  <td>EXPESS TRANSPORT</td>
                  <td>DEBITE OKOUME</td>
                  <td>43460</td>
                  <td>51000</td>
                  <td>51000</td>
                  <td>0</td>
                  <td>1,000.00</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>6</td>
                  <td>3</td>
                  <tr style="
                  display: flex;
                ">
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                  </tr>
                  <tr style="
                  display: flex;
                ">
                    <td>5670</td>
                    <td>7440</td>
                    <td>7980</td>
                    <td>5580</td>
                    <td>7180</td>
                    <td>9610</td>
                  </tr>
                  <tr style="
                  display: flex;
                ">
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    
                  </tr>
                  <tr style="
                  display: flex;
                ">
                    <td>5670</td>
                    <td>15420</td>
                    <td>22370</td>
                    
                  </tr>
                  <tr style="
                  display: flex;
                ">
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    
                  </tr>
                  <td>null</td>
                  <tr style="
                  display: flex;
                ">
                    <td>13000</td>
                    <td>21000</td>
                    <td>27000</td>
                    
                  </tr>
                  <tr style="display: flex;
      flex-direction: column;">
                    <td>1(1,000.00 FCFA)</td>
                  <td>8500 FCFA</td>
                  <td>D'ACCORD</td>
                  <td>1000.0000</td>
                  <td>5.33</td>
                  </tr>
                  
                </tr>
                
              </tbody>
            </table>
          </div>
          <div style="width: 100px; height: 100px; background-color: #d9d9d9;">
            <img src="" alt="">
            photo 1
          </div>
        </div>
      </div>
      <div style="display: flex; margin-top: 50px;">
        <p style="font-weight: 900; ">nom de l'opérateur</p>
        <p style="margin-left: 20px;">aicha</p>
      </div>
      <div style="display: flex; margin-top: 20px;"><p style="font-weight: bold;">BP.2418 NIF:740 438W TEL:062033141</p>
    <p style="font-weight: bold; margin-left: 20px;">admin@tpl-gabon.com</p></div>
    </section>
  </body>
</html>
