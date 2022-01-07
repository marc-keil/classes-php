<?php 
session_start();
include'./user.php';


echo "<pre>";
var_dump($bdd);
echo "</pre>";

echo "<br>";



if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail'] && !empty($_POST['nom']) && !empty($_POST['prenom']))) {

 
        $login = $_POST['login'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $password = $_POST['password'];
        $mail = $_POST['mail'];
        $user->Register($login, $password, $mail, $prenom, $nom);
   
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>



<body>

    <div class="login">
        <form class="form_login" method="POST" action="">
            <h4>Création de compte</h4>
            <div class="social-media">
                <p><i class="fab fa-google"></i></p>
                <p><i class="fab fa-youtube"></i></p>
                <p><i class="fab fa-facebook-f"></i></p>
                <p><i class="fab fa-twitter"></i></p>
            </div>
            <div class="inputs">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>
                <label for="mail">mail</label>
                <input type="mail" id="mail" name="mail" required>
                <label for="prenom">prenom</label>
                <input type="text" id="prenom" name="prenom" required>
                <label for="nom">nom</label>
                <input type="text" id="nom" name="nom" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
          
            </div>
            <div align="center">
                <button type="submit">Créer !</button>
            </div>

        </form>



    </div>
</body>

</html>