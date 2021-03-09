<?php

/** Freeder
 *  -------
 *  @file
 *  @copyright Copyright (c) 2014 Freeder, MIT License, See the LICENSE file for copying permissions.
 *  @brief Various functions, not specific and widely used.
 */
/*
Auteur   :  Juliano Souza Luz
Date     :  Fin 2020
Desc.    :  fonctions pour l'ensemble des pages de test de graphiques
Version  :  1.0
*/
require("constantes.inc.php");

/**
 * Connecteur de la base de données du .
 * Le script meurt (die) si la connexion n'est pas possible.
 * @static var PDO $dbc
 * @return \PDO
 */
function dbData()
{
    static $dbc = null;

    // Première visite de la fonction
    if ($dbc == null) {
        // Essaie le code ci-dessous
        try {
            $dbc = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPWD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::ATTR_PERSISTENT => true,
                PDO::ERRMODE_EXCEPTION => PDO::ATTR_ERRMODE
            ));
        }
        // Si une exception est arrivée
        catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br />';
            echo 'N° : ' . $e->getCode();
            // Quitte le script et meurt
            die('Could not connect to MySQL');
        }
    }
    // Pas d'erreur, retourne un connecteur
    return $dbc;
}

/**
 * select tout les éléments ordonné par la date
 *
 * @return array string
 */
function selectAllByDate($idUtilisateur)
{
    static $ps = null;
    $sql = "SELECT * FROM Data  WHERE idUtilisateur = :IDUTILISATEUR ORDER BY Date ASC";
    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbData()->prepare($sql);
        }
        $ps->bindParam(':IDUTILISATEUR', $idUtilisateur, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}
/**
 * cherche l'element dans la base de donnee afin de l'afficher et le modifier 
 *
 * @param int $row
 * @return array string
 */
function afficherModif($row)
{
    static $ps = null;
    $sql = "SELECT * FROM Data WHERE idImc=:ID";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbData()->prepare($sql);
        }
        $ps->bindParam(':ID', $row, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * fonction pour modifier un element
 *
 * @param int $imc
 * @param date $date
 * @param int $row
 * @return array string
 */
function Modifier($imc, $date, $row)
{
    static $ps = null;
    $sql = "UPDATE `imc` SET `imc` = :IMC, `date` = :DATE WHERE `idImc` = :ID";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbData()->prepare($sql);
        }
        $ps->bindParam(':IMC', $imc, PDO::PARAM_STR);
        $ps->bindParam(':DATE', $date, PDO::PARAM_STR);
        $ps->bindParam(':ID', $row, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * fonction pour supprimer un element
 *
 * @param int $row
 * @return array string
 */
function Supprimer($row)
{
    static $ps = null;
    $sql = "DELETE FROM Data WHERE idImc = :ID";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbData()->prepare($sql);
        }
        $ps->bindParam(':ID', $row, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * vérifie si l'utilisateur est sur la page sur laquelle il a cliqué ( retourne ensuite la classe qui permet de mieux voir la page actuelle)
 *
 * @param string $pageActuelle , page où se trouve actuellement l'utilisateur
 * @param string $pageCible , page où l'utilisateur a cliqué
 * @return string class css
 */
function isOnPage($pageActuelle, $pageCible)
{
    if ($pageActuelle == $pageCible) {
        return "navSelected";
    }
}

/**
 * fonction qui retourne une donnée php convertie en json
 *
 * @param array $data
 * @return json
 */
function dataToJson($data)
{
    return json_encode($data);
}

/**
 * enregistre un utilisateur dans la base de données
 *
 * @param [string] $nom
 * @param [string] $prenom
 * @param [date] $naissance
 * @param [string] $mail
 * @param [string] $mdp
 * @return void
 */
function signIn($nom, $prenom, $naissance, $mail, $mdp)
{
    static $ps = null;
    $sql = "INSERT INTO Utilisateurs (Nom,Prenom,DateNaissance,Mail,Mdp) VALUE(:NOM,:PRENOM,:NAISSANCE,:MAIL,:MDP)";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbData()->prepare($sql);
        }
        $ps->bindParam(':NOM', $nom, PDO::PARAM_STR);
        $ps->bindParam(':PRENOM', $prenom, PDO::PARAM_STR);
        $ps->bindParam(':NAISSANCE', $naissance, PDO::PARAM_STR);
        $ps->bindParam(':MAIL', $mail, PDO::PARAM_STR);
        $ps->bindParam(':MDP', $mdp, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}
/**
 * Se connecte à la base
 *
 * @param string $email email de l'utilisateur
 * @param string $password mot de passe
 * @return bool True si la connexion a réussi, sinon retourne false
 */
function connect($email, $password)
{
    static $ps = null;
    $sql = 'SELECT `Mdp`,`idUtilisateurs` FROM Utilisateurs WHERE `Mail` LIKE :EMAIL';

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbData()->prepare($sql);
        }
        $ps->bindParam(':EMAIL', $email, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
        if (count($answer) == 1) {

            if (password_verify($password, $answer[0]["Mdp"])) {
                return $answer[0]["idUtilisateurs"];
            } else {
                return false;
            }
        }
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}
/**
 * fonction qui calcule l'imc
 *
 * @param float $taille
 * @param float $poids
 * @return float
 */
function calculerImc($taille, $poids)
{
    //imc = kg/m2   
    return $poids / ($taille * $taille);
}
/**
 * ajoute une data dans la bd
 *
 * @param int $taille
 * @param int $poids
 * @param date $date
 * @param int $idUtilisateur
 * @return void
 */
function ajouterImcData($taille, $poids, $date, $idUtilisateur)
{
    static $ps = null;
    $sql = "INSERT INTO Data (idUtilisateur,Poids,Taille,Date) VALUE(:IDUTILISATEUR,:POIDS,:TAILLE,:DATE)";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbData()->prepare($sql);
        }
        $ps->bindParam(':IDUTILISATEUR', $idUtilisateur, PDO::PARAM_STR);
        $ps->bindParam(':POIDS', $poids, PDO::PARAM_STR);
        $ps->bindParam(':TAILLE', $taille, PDO::PARAM_STR);
        $ps->bindParam(':DATE', $date, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * verifie si la variable connected de la session est crée ou non, cela empeche un utilisateur d'acceder a la page par url brut
 *
 * @return void
 */
function verifierSession()
{
    if (!$_SESSION["connected"] || !isset($_SESSION["connected"])) {
        header('Location: index.php');
        exit();
    }
}
