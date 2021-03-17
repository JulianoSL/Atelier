<?php

/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     navbar
 *  \details   Ce fichier contient la barre de naviguation du site
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       
 *  \warning   
 *  \copyright JSL
 */
include_once("fonctions/func.php");

$page = basename($_SERVER['PHP_SELF']);
/**<récupère la page où se trouve l'utilisateur */
?>
<nav>
    <h1 class="categorie">Pages :</h1>
    <h1>
        <a href="index.php" class='<?= isOnPage($page, "index.php"); ?>'>Menu</a>
    </h1>
    <?php if (GetSession("connected")) {

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