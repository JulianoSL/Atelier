<?php

/**
 * Auteur       :   Souza Luz Juliano 
 * Date         :   
 * Description  :  
 * Page         :   
 * Version      :   1.0, JSL
 */
session_start();
require_once("fonctions/func.php");
//tableau associatif
echo dataToJson(selectAllByDate($_SESSION["idUtilisateur"]));
