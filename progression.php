<?php

/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     page de progression
 *  \details   Cette page affiche le suivi de l'imc de l'utilisateur sur un graphique
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       
 *  \warning   
 *  \copyright JSL
 */

include_once("./fonctions/func.php");
verifierSession();
$errorMsg = "";
if (!verifierData(GetSession("idUtilisateur"))) {
  $errorMsg = "Aucune donnée n'a été trouvée ! Veuillez inserer vos données grâce à la page <a href='imc.php'>IMC</a>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/style.css" rel="stylesheet">
  <title>Progression</title>
</head>

<body>
  <?php include_once("navbar.php"); ?>
  <main>
    <h1><?= $errorMsg; ?></h1>
    <div id="chart"></div>
    <div class="form-button">
      <button class="supprimer" name="supprimer" onclick="popUpsupprimer()" id="btnSupprimer">Supprimer</button>
      <button class="modifier" name="modifier" onclick="popUpmodifier()" id="btnModifier">Modifier</button>
    </div>

  </main>
  <div class="div-grise" onclick="fermerPopUp()" id="fenetre-grise"></div>
  <div class="popup" id="divModifier">
    <form action="" method="post">
      <h1>Modifier l'IMC :</h1>
      <p>
        <label for="Taille">Taille en M : </label><input type="number" id="Taille" name="Taille" placeholder="1.50 M" min="0" max="2.5" step=".01" value="<?= $taille; ?>" required>
      </p>
      <p>
        <label for="Poids">Poids en Kg : </label> <input type="number" id="Poids" name="Poids" placeholder="50 kg" min="0" step=".5" value="<?= $poids; ?>" required>
      </p>
      <p>
        <label for="Date">Date : </label> <input type="date" id="Date" name="Date" value="<?= $date; ?>" required>
      </p>
      <input type="submit" name="Modifier" value="Modifier">
      <button class="Annuler" name="annuler" onclick="fermerPopUp()">Annuler</button>
    </form>
  </div>
  <div class="popup" id="divSupprimer">
    <form action="" method="post">
      <h1>Supprimer l'imc ?</h1>
      <h2>
        Poids : <?= $poids; ?>
      </h2>
      <h2>
        Taille : <?= $taille; ?>
      </h2>
      <h2>
        Date : <?= $date; ?>
      </h2>
      <input type="submit" name="Supprimer" value="Supprimer">
      <button class="Annuler" name="annuler" onclick="fermerPopUp()">Annuler</button>
    </form>


  </div>
  <footer>&copy;JSL 2021</footer>
  <?php if (verifierData(GetSession("idUtilisateur"))) { ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="js/graph.js"></script>
  <?php }; ?>
</body>
<script>
  function popUpmodifier() {
    document.getElementById("fenetre-grise").style.visibility = "visible";
    document.getElementById("divModifier").style.visibility = "visible";
  }

  function popUpsupprimer() {
    document.getElementById("fenetre-grise").style.visibility = "visible";
    document.getElementById("divSupprimer").style.visibility = "visible";
  }

  function fermerPopUp() {
    document.getElementById("fenetre-grise").style.visibility = "hidden";
    document.getElementById("divModifier").style.visibility = "hidden";
    document.getElementById("divSupprimer").style.visibility = "hidden";
  }
</script>

</html>