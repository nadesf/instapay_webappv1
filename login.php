<?php
session_start();
# Début du programme 

if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm'])){ # Traitement pour l'inscription

    $name = htmlspecialchars($_POST['name']);
    $contact = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $name = get_name_user($name);
    $last_name = $name[0];
    $first_name = $name[1];


    $url = "http://devinstapay.pythonanywhere.com/api/v1/signup/";
    #$url = "http://localhost:8000/api/v1/signup/";

    $data = array(
        'first_name' => "$first_name",
        'last_name' => "$last_name",
        'contact' => "$contact",
        'password' => "$password"
    );


    $send_request = signup_user($url, $data);
    $response = $send_request[0];
    $httpcode = $send_request[1];

    if ($httpcode === 200) {

        $_SESSION['success'] = $response->success;
        $_SESSION['user_id'] = $response->data[0]->user_id;
        $_SESSION['first_name'] = $response->data[0]->first_name;
        $_SESSION['last_name'] = $response->data[0]->last_name;
        $_SESSION['contact'] = $response->data[0]->contact;
        $_SESSION['send_code'] = $response->data[0]->send_code;
        $_SESSION['receive_code'] = $response->data[0]->receive_code;
        $_SESSION['status_user'] = $response->data[0]->status_user;
        $_SESSION['name_pointofsale'] = $response->data[0]->name_pointofsale;
        $_SESSION['location'] = $response-$response->data[0]->location;

        header("Location: home.php");
    } else {
        $_SESSION["Error_signup"] = "Cette Adresse Email Existe déja";
        header("Location: index.php?signup=1");
    }

    #header("Location: home.html");
} else if (isset($_POST['username']) && isset($_POST['password'])) { # Traitement pour la connexion

    $contact = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    # Les données que nous allons envoyer pour authentifier l'utilisateur
    $url = "http://devinstapay.pythonanywhere.com/api/v1/login/";
    #$url = "http://localhost:8000/api/v1/login/";
    $data = array(
        'contact' => "$contact",
        'password' => "$password"
    );

    # Envoie des données
    $request = login_user($url, $data);
    $response = $request[0];
    $httpcode = $request[1];

    # Analyse de la reponse 
    if ($httpcode === 200) {

        # Nous allons gardé les données reçu dans les variables de session pour pouvoir les utilisés sur toutes les pages site
        $_SESSION['IsAuthenticated'] = true;
        $_SESSION['user_id'] = $response->user_id;
        $_SESSION['first_name'] = $response->first_name;
        $_SESSION['last_name'] = $response->last_name;
        $_SESSION['contact'] = $response->contact;
        $_SESSION['send_code'] = $response->send_code;
        $_SESSION['receive_code'] = $response->receive_code;
        $_SESSION['status_user'] = $response->status;
        $_SESSION['name_pointofsale'] = $response->name;
        $_SESSION['location'] = $response->location;
        $_SESSION['transactions'] = $response->transactions;

        # On rédirige l'utilisateur vers l'espace membres
        header('Location: home.php');

    } else { # En cas d'erreur, on retourne un méssage à l'utilisateur.
        $_SESSION['Error_login'] = "Votre Login/Mot de passe est incorrecte ! ";
        header('Location: index.php');
    }



} else { # Si aucune donnée n'a été envoyer on retourne l'utilisateur vers la page index.php
    header('Location: index.html');
}


# -------------------------------------------
#             LES FONCTIONS
# -------------------------------------------

function login_user($url_api, $data_api) {

    # Encodage des données a envoyés et Initialisation de cURL
    $data_json = json_encode($data_api);
    $ch = curl_init();

    # Définition des options pour l'envoie de la requête HTTP POST
    curl_setopt($ch, CURLOPT_URL, $url_api);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    # Récupération de la reponse et fermeture de la session
    $response  = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch); 

    $response = json_decode($response);
    $response = array($response, $httpcode);

    return $response;
}

function signup_user($url_api, $data_api) {

    # Encodage des données à envoyer et Initialisation de cURL
    $data_json = json_encode($data_api);
    $ch = curl_init();

    # Définition des options pour l'envoie de la requête HTTP
    curl_setopt($ch, CURLOPT_URL, $url_api);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    # Récupération de la reponse et fermeture de la session
    $response  = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch); 

    $response = json_decode($response);
    #var_dump($httpcode);
    $response = [$response, $httpcode];
    #var_dump($response);

    return $response;

}

function get_name_user($name) {

    $name_list = explode(" ", $name);
    $name_size = count($name_list);
    
    $first_name = "";
    
    for ($i = 1; $i < $name_size; $i++) {
        $first_name = "$first_name $name_list[$i]";
    }
    
    $last_name = $name_list[0];
    
    return [$last_name, $first_name];
}
    
?>
