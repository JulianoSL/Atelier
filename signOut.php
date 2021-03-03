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
$_SESSION["connected"] = false;
$_SESSION["idUtilisateur"] = "";
header('Location: index.php');
?>