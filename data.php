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
require_once("fonctions/func.php");
//tableau associatif
echo dataToJson(selectAllByDate($_SESSION["idUtilisateur"]));
