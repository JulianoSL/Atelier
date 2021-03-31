/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     graphique
 *  \details   Ce fichier permet de dessiner le graphique
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       
 *  \warning   
 *  \copyright JSL
 */
// tout les seuils sont set à leurs valeurs max
const OBESITE = 35;/**<constante qui définit le seuil d'obésité */

const SURPOIDS = 30;/**<constante qui définit le seuil de surpoids */

const MAIGREUR = 18.5;/**< constante qui définit le seuil de maigreur*/

const NORMAL = 25;/**< constante qui définit le seuil normal*/


var gChart;/**<la variable du graphique */

var data;/**<contient le graphique avec les données (non dessiné) */

var itemSelected;/**<contient le point séléctionné sur le graphique */

var row;/**<la ligne du graphique */

var col;/**<la colonne du graphique */

var value;/**<utilisé pour stocker la valeur correspondante au point séléctionné */

var enabled = false;/**<utilisé pour définir la propriété enabled des boutons modifier et supprimer */

var imc;/**<l'indice de masse corporelle */

var date;/**<la date */

var tab = [];/**<le tableau contenant les données du graphiques */

var options;/**<les options du graphique */


fetch('http://127.0.0.1/Doc/Documentation/data.php')
    .then(response => response.text())
    .then((data) => {
        record = JSON.parse(data);
    })

google.charts.load('current', {
    'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawChart);
/**
 * chercher les points à afficher sur le graphique
 */
function recherchePoints() {
    if (record) {
        record.forEach(function (value) {
            //calculer l'imc
            imc = value.Poids / Math.pow(value.Taille, 2);
            //arrondir a 1 décimale
            imc = Math.round(imc * 10) / 10;
            tab.push([value.Date, OBESITE, SURPOIDS, NORMAL, imc, MAIGREUR]);
            if (record.length == 1) {
                tab.push([value.Date, OBESITE, SURPOIDS, NORMAL, imc, MAIGREUR]);
            }
        })
    }
}

/**
 * dessine le graphique (viens de googleChart)
 *
 * @return void
 */
function drawChart() {
    tab.push(['Year', 'Obésité', 'Surpoids', 'Normal', 'Votre IMC', "Maigreur"]);
    recherchePoints();
    data = google.visualization.arrayToDataTable(tab);

    options = {
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
        backgroundColor: "#FFFAFA",
        // obésité , surpoids, normal , imc,maigreur
        colors: ['#ffbaba', '#fefdb7', '#bdffbd', "#396937", "#fee5b9"],
        areaOpacity: 0.8,
    };

    // var chart = new google.visualization.LineChart(document.getElementById('chart'));
    gChart = new google.visualization.AreaChart(document.getElementById('chart'));
    gChart.draw(data, options);
    google.visualization.events.addListener(gChart, 'select', function () {
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
}
function resize() {
    gChart.draw(data, options)
}
window.onresize = resize;




/**
 * permet d'activer ou non le bouton modifier qui renvoie vers la page de modification
 *
 * @return void
 */
function modifier() {
    if (enabled) {
        document.getElementById("btnSupprimer").onclick = popUpmodifier();
        window.location = "modifier.php?row=" + (row);
    }
    else
    {
        document.getElementById("btnSupprimer").onclick = "";
    }
}

/**
 * permet d'activer ou non le bouton supprimer qui renvoie vers la page de supression
 *
 * @return void
 */
function supprimer() {
    if (enabled) {
        window.location = "supprimer.php?row=" + (row);
    }
}