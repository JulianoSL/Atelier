<!DOCTYPE html>
<?php
/** Souza Luz Juliano
 *  -------
 *  \file
 *  \brief     incription
 *  \details   Cette page permet à l'utilisateur de s'inscrire
 *  \author    Souza Luz Juliano
 *  \version   1.0
 *  \date      2021
 *  \pre       First initialize the system.
 *  \bug       
 *  \warning   
 *  \copyright JSL
 */
session_start();
include_once("./fonctions/func.php");
if ($_SESSION["connected"]) {
    header("Location:index.php");
}
$erreur = "";
/**< le message d'erreur */

$nom = "";
$prenom = "";
$naissance = "";
$genre = "";
$email = "";
if (isset($_POST["inscription"])) {

    $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING);
    /**< le nom de l'utilisateur */

    $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_STRING);
    /**< le prenom de l'utilisateur */

    $naissance = filter_input(INPUT_POST, "naissance", FILTER_SANITIZE_STRING);
    /**< la date de naissance de l'utilisateur */

    $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_STRING);
    /**< le genre de l'utilisateur */

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    /**< l'email de l'utilisateur */

    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    /**< le mot de passe de l'utilisateur */

    if ($nom && $prenom && $naissance && $email && $password) {

        $token = generateToken(255);
        /**< génération du token de l'utilisateur */
        $password = password_hash($password, PASSWORD_BCRYPT);
        /**< hachage du mot de passe */
        signIn($nom, $prenom, $naissance, $email, $genre, $password, $token);
        $_SESSION["idUtilisateur"] = connect($email, $password);
        $_SESSION["token"] = $token;
        $_SESSION["connected"] = true;
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Inscription</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Favicons -->
    <!-- <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico"> -->
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="css/signIn.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="" method="post">
            <img class="mb-4" src="img/logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Formulaire d'inscription</h1>

            <input type="text" class="form-control" placeholder="Nom" name="nom" value="<?= $nom; ?>" required autofocus>
            <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="<?= $prenom; ?>" required>
            <input type="email" class="form-control" placeholder="Adresse Email" name="email" value="<?= $email; ?>" required>
            <label for="naissance">Date de Naissance</label>
            <input type="date" id="naissance" class="form-control" name="naissance" value="<?= $naissance; ?>" required>
            <label for="Homme">Homme</label>
            <input type="radio" id="Homme" name="genre" value="Homme" checked><br>
            <label for="Femme">Femme</label>
            <input type="radio" id="Femme" name="genre" value="Femme">
            <input type="password" class="form-control" placeholder="Mot de passe" name="password" required id="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Doit contenir au moins 1 nombre, 1 majuscule, et au moins 8 charactères !" oninput="CheckPassword()">
            <input type="password" class="form-control" placeholder="Confirmer le mot de passe" name="confirmMdp" required oninput="CheckPassword()">
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="inscription">S'inscrire</button>
            <p><?= $erreur ?></p>
            <p class="mt-5 mb-3 text-muted">&copy;JSL 2021</p>
        </form>
    </main>
</body>
<script>
    function CheckPassword() {
        var decimal = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        if (document.getElementById("Password").value.match(decimal)) {
            document.getElementById("Password").classList.remove("is-invalid");
            document.getElementById("Password").classList.add("is-valid");

            document.getElementById("PasswordConfirm").classList.remove("is-invalid");
            document.getElementById("PasswordConfirm").classList.add("is-valid");
        } else {
            document.getElementById("Password").classList.remove("is-valid");
            document.getElementById("Password").classList.add("is-invalid");

            document.getElementById("PasswordConfirm").classList.remove("is-valid");
            document.getElementById("PasswordConfirm").classList.add("is-invalid");
        }
    }
</script>

</html>