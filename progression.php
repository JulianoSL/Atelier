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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/style.css" rel="stylesheet">
  <title>Progression</title>
</head>

<body>
  <?php include_once("navbar.php"); ?>
  <main>
    <div id="chart"></div>
  </main>
  <footer>&copy;JSL 2021</footer>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="js/graph.js"></script>
</body>

</html>