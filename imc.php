<!DOCTYPE html>
<?php
/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     indice masse corporelle
 *  \details   Cette page permet le calcul de l'imc et l'insertion de la taille,du poids et de la date dans la base de données
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

$erreur = "";
/**<le message d'erreur */

$calcul = false;
/**<contient le résultat du calcul pour l'imc */
$taille = "";
/**<la taille de l'utilisateur */
$poids = "";
/**<le poids de l'utilisateur */
$date = "";
/**<la date qui correspond au poids et la taille de l'utilisateur */

$taille = getLastTaille(GetSession("idUtilisateur"));
$poids = getLastPoids(GetSession("idUtilisateur"));

if (isset($_POST["Calculer"])) {

  $taille = filter_input(INPUT_POST, "Taille", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


  $poids = filter_input(INPUT_POST, "Poids", FILTER_SANITIZE_STRING);


  $date = filter_input(INPUT_POST, "Date", FILTER_SANITIZE_STRING);


  $check = filter_input(INPUT_POST, "Data");
  /**< si on a coché le bouton pour enregistrer l'imc */
  if ($taille && $poids && $date) {
    $calcul = calculerImc($taille, $poids);
    if ($check) {
      ajouterImcData($taille, $poids, $date, GetSession("idUtilisateur"));
      header("Location:progression.php");
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
    // imcTohtml($calcul,$lvl=h2)
    if (is_float($calcul)) {
      imcToHtml($calcul, "h1");
    ?>

    <?php  } ?>
    <form action="" method="post">
      <div>
        <h1>Calcul de l'IMC :</h1>
        <p>
          <label for="Taille">Taille en M : </label><input type="number" id="Taille" name="Taille" placeholder="1.50 M" min="0" max="2.5" step=".01" value="<?= $taille; ?>" required>
        </p>
        <p>
          <label for="Poids">Poids en Kg : </label> <input type="number" id="Poids" name="Poids" placeholder="50 kg" min="0" step=".1" value="<?= $poids; ?>" required>
        </p>
        <p>
          <label for="Date">Date : </label> <input type="date" id="Date" name="Date" value="<?= $date; ?>" required>
        </p>
        <p>
          <label for="Enregistrer">Enregistrer l'imc ?</label>
          <input type="checkbox" id="Enregistrer" name="Data">
        </p>
        <input type="submit" name="Calculer" value="Calculer" />
        <p><?= $erreur; ?></p>
      </div>
    </form>
  </main>
  <footer>&copy;JSL 2021</footer>
</body>

</html>