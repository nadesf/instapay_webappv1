<?php 
session_start();
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet"/>
    <title>Instapay - Payez tout en un seule clique</title>
</head>
<body>
    
    <header>
        <h1> Instapay </h1>
    </header>

    <?php 
        if (!isset($_GET['signup'])) {
            # On affiche la pge de connexion
    ?>

    <div class="login_bloc">
        <div class="login_form">
            <h2> Se connecter </h2>

            <form action="login.php", method="POST">
                <label>
                    <span>Email ou Numéro de téléphone </span><br>
                    <input type="email" name="username"><br>
                </label>
                <label>
                    <span>Mot de passe</span><br>
                    <input type="password" name="password"><br>
                </label>
                <button class="submit" type="submit">Connexion</button>
            </form>

            <p class="forgot-pass">Mot de passe oublié ?</p>
            
            <?php
                if (isset($_SESSION['Error_login'])) {
                ?>
                <p class="error">Votre login/mot de passe est incorrecte </p>
                <?php
                $_SESSION['Error_login'] = NULL;
                }
            ?>

        </div>

        <div class="login_banner">
            <h2> Pas de compte ? </h2>
            <p> Inscrivez-vous en remplissant les différents champs </p>

            <div class="login_btn">
                <a href="index.php?signup=1">S'inscire</a>
            </div>
        </div>
    </div>

    <?php  
        } else {
    ?>
    <div class="login_bloc">

        <div class="login_banner">
            <h2>Aviez-vous déja un compte ?</h2>
            <p>Connectez-vous au plus vite car vous nous aviez manqué !</p>

            <div class="login_btn">
                <a href="index.php">Se connecter</a>
            </div>
        </div>

        <div class="login_form">
            <h2> S'inscrire </h2>

            <form action="login.php", method="POST">
                <label>
                    <span>Nom Complet </span><br>
                    <input type="text" name="name"><br>
                </label>
                <label>
                    <span>Email ou Numéro de téléphone </span><br>
                    <input type="text" name="username"><br>
                </label>
                <label>
                    <span>Mot de passe </span><br>
                    <input type="password" name="password"><br>
                </label>
                <label>
                    <span>Confirmation Mot de passe</span><br>
                    <input type="password" name="password_confirm"><br>
                </label>
                <button class="submit" type="submit">S'inscrire</button>

                <?php 
                    if (isset($_SESSION['Error_signup'])) {
                ?>
                    <p class="error">Cette adresse email est déja utilisé </p>
                <?php 
                    $_SESSION['Error_signup'] = NULL;
                    }
                ?>
            </form>
        </div>
    </div>
    <?php  
        }
    ?>

    


</body>
</html>