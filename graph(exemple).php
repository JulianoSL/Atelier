<?php

/**
 * Auteur       :   Souza Luz Juliano 
 * Date         :   Fin 2020
 * Description  :   test de différentes manières de créer des graphiques (ici googleChart)
 * Page         :   googleChart
 * Version      :   1.0, JSL
 */
require_once("func.php");
$record = selectAllByDate();
define("SURPOIDS", 25);
define("MAIGREUR", 18.5);
define("IDEAL", 21.75);
?>

<html>

<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    //variables
    var gChart;
    var data;
    var itemSelected;
    var row;
    var col;
    var value;
    var enabled = false;
    var dates = [];

    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    /**
     * dessine le graphique
     *
     * @return void
     */
    function drawChart() {
      data = google.visualization.arrayToDataTable([
        ['Year', 'Surpoids', 'Maigreur', "IMC idéal", "Votre IMC"],
        <?php
        if ($record) {
          foreach ($record as $key => $value) {
            $date = new DateTime($value["date"]);
            echo "['" . $date->format("d F Y") . "'," . SURPOIDS . "," . MAIGREUR . "," . IDEAL . "," . $value["imc"] . "],";
          }
        }
        ?>
      ]);

      /**
       * les options du graphique
       */
      var options = {
        title: 'Graphique IMC',
        curveType: 'function',
        legend: {
          position: 'right'
        },
        hAxis: {
          title: 'Year',
          titleTextStyle: {
            color: '#333'
          },
          minValue: 16
        },
        colors: ['#fc3819', "#0088ff", "#33FF58", "#000000"],
      };

      // var chart = new google.visualization.LineChart(document.getElementById('chart'));
      gChart = new google.visualization.AreaChart(document.getElementById('chart'));
      gChart.draw(data, options);

      google.visualization.events.addListener(gChart, 'select', function() {
        //recupère l'élement selectionné dans le graphique 
        itemSelected = gChart.getSelection()[0]

        row = itemSelected["row"];
        //
       // console.log(d);
        col = itemSelected["column"];
        if (col == 4) {
          enabled = true;
        } else {
          enabled = false;
        }
      });
      /**
       * rempli le tableau dates de toutes les dates liées a des points
       */
      for (let i = 0; i < data["cache"].length; i++) {
        dates[i] = data["cache"][i][0]["Ve"];
      }
    }

    /**
     * permet d'activer ou non le bouton modifier qui renvoie vers la page de modification
     *
     * @return void
     */
    function modifier() {
      if (enabled) {
        window.location = "modifier.php?row=" + (row);
      } 
    }

    /**
     * permet d'activer ou non le bouton supprimer qui renvoie vers la page de supression
     *
     * @return void
     */
    // function supprimer() {
    //   if (enabled) {
    //     window.location = "supprimer.php?row=" + (row);
    //   }
    // }
  </script>
</head>

<body>
  <div id="chart" style="width: 1000px; height: 800px"></div>
  <button onclick="modifier()">Modifier</button>
  <!-- <button onclick="supprimer()">Supprimer</button> -->
</body>

</html>