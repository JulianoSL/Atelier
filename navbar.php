<?php
include_once("fonctions/func.php");
//récupère la page où se trouve l'utilisateur
$page = basename($_SERVER['PHP_SELF']);
?>
<nav>
    <h1 class="categorie">Pages :</h1>
    <h1>
        <a href="index.php" class='<?= isOnPage($page, "index.php"); ?>'>Menu</a>
    </h1>
    <?php if ($_SESSION["connected"]) {

    ?>
        <h1>
            <a href="imc.php" class='<?= isOnPage($page, "imc.php"); ?>'>IMC</a>
        </h1>
        <h1>
            <a href="progression.php" class='<?= isOnPage($page, "progression.php"); ?>'>Progression</a>
        </h1>
        <h1>
            <a href="signOut.php" class='<?= isOnPage($page, "signOut.php"); ?>'>Se déconnecter</a>
        </h1>
    <?php } else { ?>
        <h1>
            <a href="connexion.php" class='<?= isOnPage($page, "connexion.php"); ?>'>Se connecter</a>
        </h1>
    <?php } ?>
</nav>