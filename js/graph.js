/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     graphique
 *  \details   Ce fichier permet de dessiner le graphique
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       pas de bug
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

var record = [];/**<contient les données de la BD */



google.charts.load('current', {
    'packages': ['corechart']
});

google.charts.setOnLoadCallback(drawChart);

/**
 * chercher les points à afficher sur le graphique
 */
function searchPoints() {
    tab.push(['Year', 'Obésité', 'Surpoids', 'Normal', 'Votre IMC', "Maigreur"]);
    if (record) {
        record.forEach(function (value) {
            //calculer l'imc
            imc = value.Poids / Math.pow(value.Taille, 2);
            //arrondir a 1 décimale
            imc = Math.round(imc * 10) / 10;
            tab.push([value.Date, OBESITE, SURPOIDS, NORMAL, imc, MAIGREUR]);
            //ajout d'une 2ème ligne si il n'y a qu'un seul point, purement esthetique
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
    getChartData();
}

function resize() {
    gChart.draw(data, options)
}
window.onresize = resize;

/**
 * Récupère les données en ajax
 */
function getChartData() {
    fetch('http://127.0.0.1/Doc/Documentation/data.php')
        .then(response => response.text())
        .then((data) => {
            record = JSON.parse(data);
            searchPoints();
            initChart();
        })
}

/**
 * Initialisation du graphique google chart
 */
function initChart() {
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

    data = google.visualization.arrayToDataTable(tab);

    gChart.draw(data, options);
    google.visualization.events.addListener(gChart, 'select', function () {
        //recupère l'élement selectionné dans le graphique 
        itemSelected = gChart.getSelection()[0];
        row = itemSelected["row"];
        col = itemSelected["column"];
        // l'index 4 est celui qui correspond aux valeurs de l'utilisateur
        if (col == 4) {
            document.getElementById("btnSupprimer").style = "visibility:visible";
            document.getElementById("btnModifier").style = "visibility:visible";
            if (record.length > 1) {
                setPopupSuppr(record[row].idData, record[row].Poids, record[row].Taille, record[row].Date);
                setPopupModif(record[row].idData, record[row].Poids, record[row].Taille, record[row].Date);
            }
            else {
                setPopupSuppr(record[0].idData, record[0].Poids, record[0].Taille, record[0].Date);
                setPopupModif(record[0].idData, record[0].Poids, record[0].Taille, record[0].Date);
            }
        }
        else {
            document.getElementById("btnSupprimer").style = "visibility:hidden";
            document.getElementById("btnModifier").style = "visibility:hidden";
        }
    });
}
/**
 * Set les valeurs de la popup supprimer
 * @param int idData 
 * @param double Poids 
 * @param double Taille 
 * @param date Date 
 */
function setPopupSuppr(idData, Poids, Taille, Date) {
    document.getElementById("RecupIdSuppr").value = idData;
    document.getElementById("SupprPoids").innerHTML = "Poids : " + Poids;
    document.getElementById("SupprTaille").innerHTML = "Taille : " + Taille;
    document.getElementById("SupprDate").innerHTML = "Date : " + Date;
}
/**
 * Set les valeurs de la popup modifier
 * @param int idData 
 * @param double Poids 
 * @param double Taille 
 * @param date Date 
 */
function setPopupModif(idData, Poids, Taille, Date) {
    document.getElementById("RecupIdModif").value = idData;
    document.getElementById("Poids").value = Poids;
    document.getElementById("Taille").value = Taille;
    document.getElementById("Date").value = Date;
}
/**
 * permet d'activer ou non le bouton modifier qui renvoie vers la page de modification
 *
 * @return void
 */
// function modifier() {
//     if (enabled) {
//         document.getElementById("btnSupprimer").onclick = popUpmodifier();
//         window.location = "modifier.php?row=" + (row);
//     }
//     else {
//         document.getElementById("btnSupprimer").onclick = "";
//     }
// }

/**
 * permet d'activer ou non le bouton supprimer qui renvoie vers la page de supression
 *
 * @return void
 */
// function supprimer() {
//     if (enabled) {
//         window.location = "progression.php?row=" + (row);
//     }
// }


/**
 * retourne le point selectionné
 * @returns ligne selectionnée
 */
// function getPoint() {
//     if (col == 4) {
//         return row;
//     }
// }