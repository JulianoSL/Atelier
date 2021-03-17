<!DOCTYPE html>
<?php
/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     deconnexion
 *  \details   Cette page déconnecte l'utilisateur et reset les variables de session
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       
 *  \warning   
 *  \copyright JSL
 */

include_once("./fonctions/func.php");
SetSession("connected", false);
/**< variable de session pour savoir si l'utilisateur est connecté*/
SetSession("idUtilisateur", "");
/**<variable de session qui contient l'id de l'utilisateur */
SetSession("token", "");
/**<variable de session qui contient le token de l'utilisateur */
header('Location: index.php');
?>