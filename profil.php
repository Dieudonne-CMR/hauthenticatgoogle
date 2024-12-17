<?php 
require('./config.php');
if(empty($_SESSION['user'])){
header('location:connexion.php');
exit();
}
$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <h1> Votre profil</h1>

    <p>
    <a href="deconnexion.php"> Deconnexion</a>
    </p>
     <?php print_r($user);?>
    <img src="<?=$user['picture']?>">
    <ul>
        <li> Nom : <?=$user['given_name']?> </li>
        <li> Email:<?=$user['email']?></li>
        <li> Email:<?=$user['password']?></li>
    </ul> 
</body>
</html>