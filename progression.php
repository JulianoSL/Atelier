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
  </main>
  <footer>&copy;JSL 2021</footer>
  <?php if (verifierData(GetSession("idUtilisateur"))) {

  ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="js/graph.js"></script>
  <?php }; ?>
</body>

</html>