<?php 

session_start();

if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) { 

    $user_id = $_SESSION['user_id'];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"]; 

    # Les données que nous allons envoyer pour authentifier l'utilisateur
    #$url = "http://devinstapay.pythonanywhere.com/api/v1/login/";
    $url = "http://localhost:8000/api/v1/users/change_password/";
    $data = array(
        'user_id' => $user_id,
        'old_password' => $old_password,
        'new_password' => $new_password
    );

    $response = update_password($url, $data);
    header("Location: settings.php");

} else {
    header("Location: settings.php");
}

function update_password($url_api, $data_api) {

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

?>