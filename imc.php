<!DOCTYPE html>
<?php
/** Freeder
 *  -------
 *  @file
 *  @copyright Copyright (c) 2014 Freeder, MIT License, See the LICENSE file for copying permissions.
 *  @brief Various functions, not specific and widely used.
 */
/**
 * Auteur       :   Souza Luz Juliano 
 * Date         :   
 * Description  :  
 * Page         :   
 * Version      :   1.0, JSL
 */
session_start();
include_once("./fonctions/func.php");
verifierSession();
/**
 * le message d'erreur, si erreur il y a
 */
$erreur = "";
/**
 * contient le résultat du calcul pour l'imc
 */
$calcul = "";

if (isset($_POST["Calculer"])) {
  /**
   * la taille de l'utilisateur
   */
  $taille = filter_input(INPUT_POST, "Taille", FILTER_SANITIZE_STRING);
  /**
   * le poids de l'utilisateur
   */
  $poids = filter_input(INPUT_POST, "Poids", FILTER_SANITIZE_STRING);
  /**
   * la date qui correspond au poids et la taille de l'utilisateur
   */
  $date = filter_input(INPUT_POST, "Date", FILTER_SANITIZE_STRING);
  /**
   * si on a coché le bouton pour enregister l'imc
   */
  $check = filter_input(INPUT_POST, "Data");
  if ($taille && $poids && $date) {
    $calcul = calculerImc($taille,$poids);
   // $calcul = round((calculerImc($taille, $poids)) * 10) / 10;
    if ($check) {
      ajouterImcData($taille, $poids, $date, $_SESSION["idUtilisateur"]);
    }
  }
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/imc.css" rel="stylesheet">
  <title>Calcul de l'IMC</title>
</head>

<body>
  <?php include_once("navbar.php"); ?>
  <main>
    <?php
    if ($calcul != "") {
    ?>
      <h2>Vous avez un imc de : <?= $calcul; ?></h2>
    <?php  } ?>
    <form action="" method="post">
      <div>
        <h1>Calcul de l'IMC :</h1>
        <p>
          <label>Taille en M : </label><input type="number" name="Taille" placeholder="1.50 M" min="0" step=".01" required>
        </p>
        <p>
          <label>Poids en Kg : </label> <input type="number" name="Poids" placeholder="50 kg" min="0" step=".5" required>
        </p>
        <p>
          <label>Date : </label> <input type="date" name="Date" required>
        </p>
        <p>
          Enregistrer l'imc ?
          <input type="checkbox" name="Data">
        </p>
        <input type="submit" name="Calculer" value="Calculer" />
        <p><?= $erreur; ?></p>
      </div>
    </form>
  </main>
  <footer>&copy;JSL 2021</footer>
</body>

</html>