<?php 
require('./config.php');
include "includes/class.db.php";
include "includes/fontion.php";
if(!empty($_POST['credential'])){
  if(
     empty($_COOKIE['g_csrf_token']) || empty($_POST['g_csrf_token']) || $_COOKIE['g_csrf_token'] != $_POST['g_csrf_token']
  ){
     echo "Erreur verification jeton CSRF";
     exit();
  }
   
   $clientId="830191704068-f50jbsgu84ga27f919ndjhfp90fbsj9u.apps.googleusercontent.com";
   $client = new Google_Client(['client_id' => $clientId]);  // Specify the CLIENT_ID of the app that accesses the backend
   
   $idToken = $_POST['credential'];
   $user = $client->verifyIdToken($idToken);
   print_r( $user );
   if ($user) {
      $name = strip_tags(trim($user['given_name']));
	   $name = str_replace(array("\r","\n"),array(" "," "),$name);
      $email = filter_var(trim($user['email']), FILTER_SANITIZE_EMAIL);
      $profil = trim($user['picture']);
      $sub = trim($user['sub']);
      $_SESSION['sub']=$sub;
      $recup=select_table_where('user', 'SubUser', $sub);
    if(empty($recup)){
      $DB->query("INSERT INTO user (NomUser,EmailUser,ProfilUser,SubUser) VALUES (:NomUser, :EmailUser, :ProfilUser, :SubUser)",
      [
     'NomUser'=>$name,
     'EmailUser'=>$email,
     'ProfilUser'=>$profil,
     'SubUser'=>$sub
      ]
      );
      $_SESSION['user'] = $user;
      header('Location: profil.php?sub=' . $sub);
      exit();
     }else{
      $_SESSION['user'] = $user;
      $sub1=$recup[0]->SubUser;
      header('Location: profil.php?sub=' . $sub1);
      exit();
     }

    } else {
    echo "Erreur lors de l'authentification";
   }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
<div id="g_id_onload"
     data-client_id="830191704068-f50jbsgu84ga27f919ndjhfp90fbsj9u.apps.googleusercontent.com"
     data-context="signin"
     data-ux_mode="popup"
     data-login_uri="TestGoogle/connexion.php"
     data-auto_prompt="false">
</div>

<div class="g_id_signin"
     data-type="standard"
     data-shape="pill"
     data-theme="filled_blue"
     data-text="signin_with"
     data-size="large"
     data-logo_alignment="left">
</div>
<script src="https://accounts.google.com/gsi/client" async></script>
</body>
</html>