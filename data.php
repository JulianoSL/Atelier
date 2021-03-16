<?php

/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     données json
 *  \details   affiche les données sur la page pour les récuperer dans une autre page
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       
 *  \warning   
 *  \copyright JSL
 */
session_start();
require_once("./fonctions/func.php");
verifierSession();
$tokenUser = GetTokenFromUserId($_SESSION["idUtilisateur"]);
if ($tokenUser == $_SESSION["token"]) {

    echo dataToJson(selectAllByDate($_SESSION["idUtilisateur"]));
} else {
    echo "Vous n'êtes pas autorisé à visionner ces données !";
}

// require_once("fonctions/constantes.inc.php");
// $token = filter_input(INPUT_GET, "token", FILTER_SANITIZE_STRING);
// if ($token == TOKEN) {
//     echo dataToJson(selectAllByDate($_SESSION["idUtilisateur"]));
// } else {
//     header("Location:index.php");
// }
