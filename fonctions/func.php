<?php

/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     all functions
 *  \details   Fichier de fonctions
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       
 *  \warning   
 *  \copyright JSL
 */
session_start();
require("constantes.inc.php");

/**
 * Connecteur de la base de données du .
 * Le script meurt (die) si la connexion n'est pas possible.
 * @static var PDO $dbc
 * @return \PDO
 */
function dbImc()
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
            $ps = dbImc()->prepare($sql);
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
            $ps = dbImc()->prepare($sql);
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
 * @param double $taille
 * @param double $poids
 * @param string $date
 * @param int $idData
 * @return void
 */
function Modifier($taille, $poids, $date, $idData)
{
    static $ps = null;
    $sql = "UPDATE `Data` SET `Poids` = :POIDS, `Date` = :DATE,`Taille`=:TAILLE WHERE `idData` = :ID_DATA";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
        }
        $ps->bindParam(':POIDS', $poids, PDO::PARAM_STR);
        $ps->bindParam(':TAILLE', $taille, PDO::PARAM_STR);
        $ps->bindParam(':DATE', $date, PDO::PARAM_STR);
        $ps->bindParam(':ID_DATA', $idData, PDO::PARAM_INT);

        $answer = $ps->execute();
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * fonction pour supprimer un element
 *
 * @param int $idData
 * @return array string
 */
function Supprimer($idData)
{
    static $ps = null;
    $sql = "DELETE FROM Data WHERE idData = :ID_DATA";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
        }
        $ps->bindParam(':ID_DATA', $idData, PDO::PARAM_INT);

        $answer = $ps->execute();
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * vérifie si l'utilisateur est sur la page sur laquelle il a cliqué ( retourne ensuite la classe qui permet de mieux voir la page actuelle)
 *
 * @param string $pageActuelle
 * @param string $pageCible
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
 * @param string $nom
 * @param string $prenom
 * @param date $naissance
 * @param string $mail
 * @param string $mdp
 * @return void
 */
function signIn($nom, $prenom, $naissance, $mail, $genre, $mdp, $token)
{
    static $ps = null;
    $sql = "INSERT INTO Utilisateurs (Nom,Prenom,DateNaissance,Mail,Genre,Mdp,Token) VALUE(:NOM,:PRENOM,:NAISSANCE,:MAIL,:GENRE,:MDP,:TOKEN)";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
        }
        $ps->bindParam(':NOM', $nom, PDO::PARAM_STR);
        $ps->bindParam(':PRENOM', $prenom, PDO::PARAM_STR);
        $ps->bindParam(':NAISSANCE', $naissance, PDO::PARAM_STR);
        $ps->bindParam(':MAIL', $mail, PDO::PARAM_STR);
        $ps->bindParam(':GENRE', $genre, PDO::PARAM_STR);
        $ps->bindParam(':MDP', $mdp, PDO::PARAM_STR);
        $ps->bindParam(':TOKEN', $token, PDO::PARAM_STR);

        $answer = $ps->execute();
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
    $sql = 'SELECT `Mdp`,`idUtilisateur` FROM Utilisateurs WHERE `Mail` LIKE :EMAIL';

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
        }
        $ps->bindParam(':EMAIL', $email, PDO::PARAM_STR);
        $ps->execute();

        $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
        if (count($answer) == 1) {

            if (password_verify($password, $answer[0]["Mdp"])) {
                return $answer[0]["idUtilisateur"];
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
            $ps = dbImc()->prepare($sql);
        }
        $ps->bindParam(':IDUTILISATEUR', $idUtilisateur, PDO::PARAM_INT);
        $ps->bindParam(':POIDS', $poids, PDO::PARAM_STR);
        $ps->bindParam(':TAILLE', $taille, PDO::PARAM_STR);
        $ps->bindParam(':DATE', $date, PDO::PARAM_STR);

        $answer = $ps->execute();
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
        header('Location: connexion.php');
        exit();
    }
}
/**
 * Verifie que l'utilisateur possède bien des données dans la bd
 *
 * @param int $idUtilisateur
 * @return void
 */
function verifierData($idUtilisateur)
{
    static $ps = null;
    $sql = "SELECT * FROM Data WHERE idUtilisateur = :IDUTILISATEUR";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
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
 * génère un string aléatoire 
 * (fonction prise sur le site https://www.geeksforgeeks.org/generating-random-string-using-php/) 
 *
 * @param int $n -> la taille du string voulue
 * @return void
 */
function generateToken($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}
/**
 * récupère le token de l'utilisateur en fonction de son id
 *
 * @param int $idUtilisateur
 * @return void
 */
function GetTokenFromUserId($idUtilisateur)
{
    static $ps = null;
    $sql = "SELECT Token FROM Utilisateurs WHERE idUtilisateur = :IDUTILISATEUR";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
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
 * Ecrit l'imc dans de l'html
 *
 * @param float $imc , l'indice de masse corporelle
 * @param string $lvl , le niveau de titre (Ex.: h1,h2,...)
 * @return void
 */
function imcToHtml($imc, $lvl)
{
    echo "<$lvl>Vous avez un imc de : $imc</$lvl>";
}
/**
 * récupère la variable de session
 *
 * @param string $param , variable de session
 * @return void
 */
function GetSession($param)
{
    return $_SESSION[$param];
}
/**
 * défini la valeur d'une variable de session
 *
 * @param string $param , la variable de session
 * @param type $value , la valeur
 * @return void
 */
function SetSession($param, $value)
{
    $_SESSION[$param] = $value;
}
/**
 * retourne la dernière taille en date de l'utilisateur
 *
 * @param int $idUtilisateur
 * @return void
 */
function getLastTaille($idUtilisateur)
{
    static $ps = null;
    $sql = "SELECT Taille FROM Data WHERE idUtilisateur = :IDUTILISATEUR ORDER BY Date DESC LIMIT 1";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
        }
        $ps->bindParam(':IDUTILISATEUR', $idUtilisateur, PDO::PARAM_INT);
        $ps->execute();

        $answer = $ps->fetch();
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    if (!$answer) {
        return "";
    }
    return $answer["Taille"];
}
/**
 * retourne le dernier poids en date de l'utilisateur
 *
 * @param int $idUtilisateur
 * @return void
 */
function getLastPoids($idUtilisateur)
{
    static $ps = null;
    $sql = "SELECT Poids FROM Data WHERE idUtilisateur = :IDUTILISATEUR ORDER BY Date DESC LIMIT 1";

    $answer = false;
    try {
        if ($ps == null) {
            $ps = dbImc()->prepare($sql);
        }
        $ps->bindParam(':IDUTILISATEUR', $idUtilisateur, PDO::PARAM_INT);
        $ps->execute();

        $answer = $ps->fetch();
    } catch (Exception $e) {
        $answer = array();
        echo $e->getMessage();
    }
    if (!$answer) {
        return "";
    }
    return $answer["Poids"];
}
