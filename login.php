<?php 
session_start();
include'./user.php';
$user = new User("test","test@gmail.com","test","test");
var_dump($user->bdh);


if (!empty($_POST['login']) && !empty($_POST['password']) ) {

 
        $login = $_POST['login'];
        $password = $_POST['password'];
        $user->connexion($login, $password);
   
   
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
            <h4>login</h4>

            <div class="inputs">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>
 
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
          
            </div>
            <div align="center">
                <button type="submit">login !</button>
            </div>

        </form>



    </div>
</body>

</html>