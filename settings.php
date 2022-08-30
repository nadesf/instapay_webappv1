<?php

session_start();

if (!isset($_SESSION['IsAuthenticated'])) {
    
    Header("Location: index.php");

}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instapay</title>

    <!-- Les Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    
    <!-- Liens vers le fichier de bootstrap CSS et JS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="main.css"/>
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
</head>
<body>

    <!-- Header de la page -->>
    <div class="header bg-light">
        <div class="container">
            <div class="row">
                <div class="header-content d-flex justify-content-between">
                    <div class="header-left">
                        <h1>Instapay</h1>
                    </div>
                    <div class="right d-flex">

                        <div class="dropdown align-self-center">
                            <span class="mx-2 mt-1 mt-3 fs-4 dropdown-toggle" id="notification" data-bs-toggle="dropdown" aria-expanded="False">
                                <i class="bi bi-bell"></i>
                            </span>
                            
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Aucun message</a></li>
                            </ul>
                        </div>

                        <div class="dropdown align-self-center">
                            <span class="rounded-circle dropdown-toggle account" id="notification" data-bs-toggle="dropdown" aria-expanded="False">
                                <i class="bi bi-person-fill text-white"></i>
                            </span>
                            <ul class="dropdown-menu" style="width: 270px;">
                                <li><a class="dropdown-item name fw-bold" href="home.php"><?php echo $_SESSION['last_name'] . " " . $_SESSION['first_name'] ?></a></li>
                                <li><a class="dropdown-item text-muted" href="#"><?php echo $_SESSION['contact'] ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fs-6" href="home.php"><i class="bi bi-person mx-2 fs-6"></i>Portefeuil</a></li>
                                <li><a class="dropdown-item fs-6" href="#"><i class="bi bi-wallet2 mx-2 fs-6"></i>Mes comptes</a></li>
                                <li><a class="dropdown-item fs-6" href="settings.php"><i class="bi bi-gear mx-2 fs-6"></i>Paramêtre</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fs-6 text-danger" href="#"><i class="bi bi-box-arrow-left mx-2 fs-6 text-danger"></i>Deconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Header de la page -->>
    
    <div class="container"> <!-- Div principale -->
        <div class="row">
            <div class="col-md-9 mt-md-5 mb-md-2 welcome_message">
                <h4>Mon Profil</h4>
            </div> <!-- Le message de bonne arrivé -->

            <div class="col-12 col-md-3 mt-md-5">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php" class="link_breadcrumb">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>  
                </ul>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <nav class="nav">
                            <ul class="list-unstyled d-flex">
                                <a class="nav-link fs-5 active">Profiles</a>
                                <a class="nav-link fs-5 ">Securité</a>
                                <a class="nav-link fs-5">Methode de paiment</a>
                            </ul>
                        </nav>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 my-2"> <!-- Modifier Son Email -->
                                <h4 class="mb-3 info_update">Informations de l'utilisateur</h4>
                                <hr>
                                <form action="">
                                    <div class="mb-3">
                                        <label for="Name" class="form-label">Votre nom</label>
                                        <input type="text" class="form-control" id="" placeholder='<?php echo $_SESSION['last_name'] . " " . $_SESSION['first_name'] ?>'>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Email" class="form-label">Email address</label>
                                        <input type="text" class="form-control" id="email_update" placeholder="<?php echo $_SESSION['contact']?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Phone Number" class="form-label">Numéro de téléphone </label>
                                        <input type="number" class="form-control" id="describe" placeholder="Ex : 0140779541">
                                    </div>
                                </form>

                                <button class="btn btn-success">Envoyer</button>
                            </div>

                            <div class="col-12 col-md-6 my-2"> <!-- Changement de mot de passe -->
                                <h4 class="mb-3 info_update">Changer de mot de passe</h4>
                                <hr>
                                <form action="update_password.php" method="post">
                                    <div class="mb-3">
                                        <label for="Old Password" class="form-label">Ancien mot de passe (*)</label>
                                        <input type="password" class="form-control" name="old_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="New Password" class="form-label">Nouveau mot de passe (*)</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Confirm Mot de passe" class="form-label">Confirmation mot de passe (*)</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>

                                    <button class="btn btn-success">Envoyer</button>
                                </form>
                            </div>

                            <div class="col-12 col-md-6">

                            </div>
                        </div>
                    </div>
                  </div>
            </div>

            
        </div>
    </div> <!-- div princiaple -->

    <!-- Ajout de notre propre script JS -->
</body>
</html>