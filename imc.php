<!DOCTYPE html>
<?php
/**
 * Auteur       :   Souza Luz Juliano 
 * Date         :   
 * Description  :  
 * Page         :   
 * Version      :   1.0, JSL
 */
session_start();
include_once("./fonctions/func.php");

$erreur = "";
$calcul = "";

if (isset($_POST["Calculer"])) {
  $taille = filter_input(INPUT_POST, "Taille", FILTER_SANITIZE_STRING);
  $poids = filter_input(INPUT_POST, "Poids", FILTER_SANITIZE_STRING);
  $date = filter_input(INPUT_POST, "Date", FILTER_SANITIZE_STRING);
  $check = filter_input(INPUT_POST, "Data");
  if ($taille && $poids && $date) {
    $calcul = round((calculerImc($taille, $poids)) * 10) / 10;
    if ($check) {
      ajouterImcData($taille, $poids, $date);
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
          <label>Taille en Cm : </label><input type="number" name="Taille" placeholder="150 cm" min="0" step=".1" required>
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