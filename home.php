<?php

session_start();

if (!isset($_SESSION['IsAuthenticated'])) {
    
    Header("Location: index.php");

} else {

    # On va récuprer la somme d'argent que l'utilisateur à sur son compte 
    function get_money() {
        #$url = "http://127.0.0.1:8000/api/v1/users/" . $_SESSION['user_id'] . "/accounts/";
        $url = "http://devinstapay.pythonanywhere.com/api/v1/users/" . $_SESSION['user_id'] . "/accounts/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $productList = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($productList);
    
        #var_dump($response);
        $amount = $response->account_owner[0]->amount;
        #var_dump($amount);
        return $amount;
    }

    # On récupère toute les transactions
    function get_transaction() {
        #$url = "http://127.0.0.1:8000/api/v1/users/" . $_SESSION['user_id'] . "/transactions/";
        $url = "http://devinstapay.pythonanywhere.com/api/v1/users/" . $_SESSION['user_id'] . "/transactions/";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $productList = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($productList);
    
        #var_dump($response);
        $list_transactions = $response->user_sender;
        #$list_transactions = array_reverse($list_transactions);
        return $list_transactions;
        #var_dump($list_transactions);
    }

    function get_username($user_id) {
        #$url = "http://127.0.0.1:8000/api/v1/users/" . $user_id ."/";
        $url = "http://devinstapay.pythonanywhere.com/api/v1/users/" . $user_id . "/";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $productList = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($productList);
    
        #var_dump($response);
        $name_recipient = $response->last_name . " " . $response->first_name;
        return $name_recipient;
    }

    function getName($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = 'trans';
      
        for ($i = 0; $i < $n-4; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
      
        return $randomString;
    }
    
    $_SESSION['amount'] = get_money();
    $_SESSION['transactions'] = get_transaction();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instapay - Payez plus facilement </title>

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
                        <h1 style="color: #613de6; font-weight: bold;">Instapay</h1>
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
                                <li><a class="dropdown-item name fw-bold" href="home.php"> <?php echo $_SESSION['last_name']. " " . $_SESSION['last_name']; ?></a></li>
                                <li><a class="dropdown-item text-muted" href="#"><?php echo $_SESSION['contact']; ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fs-6" href="home.php"><i class="bi bi-person mx-2 fs-6"></i>Portefeuil</a></li>
                                <li><a class="dropdown-item fs-6" href="#"><i class="bi bi-wallet2 mx-2 fs-6"></i>Mes comptes</a></li>
                                <li><a class="dropdown-item fs-6" href="settings.php"><i class="bi bi-gear mx-2 fs-6"></i>Paramêtre</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fs-6 text-danger" href="logout.php"><i class="bi bi-box-arrow-left mx-2 fs-6 text-danger"></i>Deconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Header de la page -->>
    
    <div class="container">
        <div class="row">
            <div class="col-md-9 welcome_message">
                <br><br>
                <h6>Akwaba, <span id="username"><?php echo $_SESSION['last_name']. " " . $_SESSION['last_name']; ?> !</span></h6>
                <br>
            </div> <!-- Le message de bonne arrivé -->

            <div class="col-3">
                <br><br>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php" class="link_breadcrumb">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>  
                </ul>
            </div>

            <div class="col-12 col-md-7 my-sm-1 my_account rounded-2">
                <div class="row">
                    <div class="col-10">
                        <br>
                        <p class="text-white fw-bold">Hi, <?php echo $_SESSION['last_name']. " " . $_SESSION['last_name']; ?> </p>
                    </div>

                    <div class="col-2 mt-3"> <!-- Qr Code Icon, Button et Modals / Pour afficher le QR Code-->
                        <button class="btn btn-primary bg-white " data-bs-toggle="modal" data-bs-target="#qrcode_modal">
                            <i class="bi bi-qr-code qr_code_button"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="qrcode_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title h5 fw-bold" >Recevoir de l'argent</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h2 class="text-center"><i class="bi bi-qr-code qr_code"></i></h2>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="#" class="d-flex justify-content-center">
                                                <input class="form-control" type="text" value="<?php echo $_SESSION['receive_code'] ?>">
                                                <span type="text" class="input-group-text copy text-white fw-bold">Copy</span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div> <!-- Qr Code Icon, Button et Modals / Pour afficher le QR Code-->

                    <div class="col-md-12">
                        <p class="text-white text-center text-md-center mt-4">Fonds disponible</p>
                    </div>

                    <div class="col-md-12">
                        <p class="display-6 text-white text-center text-md-center fw-bold"><?php echo $_SESSION['amount']; ?></p>
                    </div>

                    <div class="col-12 d-md-flex justify-content-md-center flex-wrap mt-md-5">
                        <button type="submit" class="btn btn-primary btn-lg mx-md-1">Recharger</button>
                        <button type="submit" class="btn btn-success btn-lg mx-md-1">Recevoir</button>
                        <button type="submit" class="btn btn-warning btn-lg mx-md-1">Retirer</button>
                        <br><br>
                    </div>
                    
                </div>
            </div> <!-- Compte de l'utilisateur et son QR Code  -->

            <!-- Bloc pour transferer des fonds  -->
            <div class="col-12 col-md-4 my-2 my-md-0 my-sm-1 p-md-0 mx-md-3 bg-body rounded card">
                <div class="card-header bg-white">
                    <p class="bg-white fw-bold h5">Transférer</p>
                </div>
                <div class="card-body">
                    <form action="#", method="post">
                        <div class="mb-3">
                            <label for="recipient" class="form-label">Destinaire</label>
                            <input type="text" class="form-control" name="recipient" id="recipient" placeholder="addrUh5d5dsd4sd45sd" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient" class="form-label">Montant</label>
                            <input type="text" class="form-control" name="amount" placeholder="300000" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <label for="exampleFormControlInput1" class="form-label">Montant restant</label>
                            <label for="exampleFormControlInput1" class="form-label"><?php echo $_SESSION['amount']; ?></label>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary submit" type="submit">Button</button>
                          </div>
                    </form>
                </div>  
            </div> <!-- Bloc pour transferer des fonds  -->

            <!-- Tableau pour les transactions  -->
            <div class="col-12 my-2 card">
                <div class="card-header bg-white">
                    <p class="bg-white fw-bold h5">Mes Transactions</p>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-responsive">
                        <thead>
                          <tr>
                            <th scope="col">Id Transactions</th>
                            <th scope="col">Code Destinaire</th>
                            <th scope="col">Nom Complet</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Date et Heure</th>
                            <th scope="col">Type</th>
                            <th scope="col">status</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $list_transactions = $_SESSION['transactions'];

                            #var_dump($list_transactions);

                            foreach($list_transactions as $transaction) {
                            ?>  

                            <tr>
                                <td scope="row"><?php echo getName(10); ?></td>
                                <td><?php echo $transaction->recipient; ?></td>
                                <td><?php echo get_username($transaction->recipient); ?></td>
                                <td><?php echo $transaction->amount?></td>
                                <td><?php echo $transaction->datetime?></td>
                                <td>
                                    <?php
                                        if ($transaction->sender === $_SESSION['user_id']) {
                                        ?>
                                        <i class="bi bi-arrow-up-circle text-danger"></i>
                                        <?php
                                        
                                        } else {
                                        ?>
                                        <i class="bi bi-arrow-up-circle text-success"></i>
                                        <?php
                                        }
                                    ?>
                                    
                                </td>
                                <td><i class="bi bi-check-circle-fill text-success"></i></i></td>
                            </tr>

                            <?php
                            }
                            ?>
                        </tbody>
                      </table>
                </div>

                <nav aria-label="Page navigation example">
                    <br>
                    <ul class="pagination justify-content-center">
                      <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                      <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>

            </div> <!-- Tableau pour les transactions -->

        </div>
    </div> <!-- div princiaple -->

    <!-- Ajout de notre propre script JS -->
</body>
</html>
<?php
}
?>

