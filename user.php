<?php



class db
{
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = '';
    protected $dbname = 'classes';

    protected $bdh;
    protected $error;


    public function __construct()
    {
        // Set DSN
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
        // Set options
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        // Create a new PDO instanace
        try {
            $this->bdh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // Catch any errors
            $this->error = $e->getMessage();
        }
    }
}

class User extends db
{

    protected $_login;
    protected $_email;
    protected $_firstname;
    protected $_lastname;

    // Fonction inscription d'un utilisateur

    public function Register($login, $password, $email, $firstname, $lastname)
    {
        // Cryptage de MDP
        $password = password_hash($password, CRYPT_BLOWFISH);
        // Requete SQL : 
        $sqlNewUser = ('INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?,?,?,?,?)');
        $insertmbr = $this->bdh->prepare($sqlNewUser);
        $insertmbr->execute(array($login, $password, $email, $firstname, $lastname));

        if ($insertmbr == true) {
            $sqlUser = "SELECT * from UTILISATEURS WHERE login = '$login'";
            $req = $this->bdh->prepare($sqlUser);
            $req->execute();
            $infoUser = $req->Fetch();
            return $infoUser;
        } else {
            echo "Pas bon";
        }
    }
    public function connexion($login, $password)
    {
        $SqlVerifUtilisateur = "SELECT * FROM UTILISATEURS WHERE login = '$login'";
        $prepVerif = $this->bdh->prepare($SqlVerifUtilisateur);
        $prepVerif->execute(array($login));
        $infoLogin = $prepVerif->fetchAll();
        if (count($infoLogin) > 0) {
            $SqlPassword = $infoLogin[0]['password'];
            if (password_verify($password, $SqlPassword)) {
                $_SESSION['profil']['id'] = $infoLogin[0]['id'];
                $_SESSION['profil']['login'] = $infoLogin[0]['login'];
                $_SESSION['profil']['firstname'] = $infoLogin[0]['firstname'];
                $_SESSION['profil']['lastname'] = $infoLogin[0]['lastname'];


                header("location:./index.php");
                exit();
            } else {
                $erreur = "Mauvais mot de passe !";
            }
        } else
            $erreur = "Mauvais login !";
    }

    public function deconnexion()
    {
        unset($_SESSION['profil']);
        // header('location: index.php'); 
        exit();
    }

    public function delete($email)
    {
        $reqdeleteutilisateur = "DELETE * FROM utilisateurs where login = '$email'";
        $prepdeleteutilisateur = $this->bdh->prepare($reqdeleteutilisateur);
        $executerequetedelete = $prepdeleteutilisateur->execute();
        unset($_SESSION['profil']);
        // header('location: index.php'); 
        exit();
    }
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $requpdateutilisateur = "UPDATE utilisateurs SET login = ? , password = ? , email = ? , firstname = ? , lastname = ? WHERE email = '$this->_email'";;
        $prepupdatetilisateur = $this->bdh->prepare($requpdateutilisateur);
        $executerequeteupdate = $prepupdatetilisateur->execute($login, $password, $email, $firstname, $lastname);
    }
    public function isConnected()
    {
        $Suisjeconnecter = "";
        if (isset($_SESSION['profil'])) {
            $Suisjeconnecter = true;
        } else {
            $Suisjeconnecter = false;
        }
        return $Suisjeconnecter;
    }
    public function getAllInfos()
    {
        if ($this->isConnected() == true) {
            $requtilisateur = $this->bdh->prepare('SELECT * FROM utilisateurs WHERE id = ?');
            $requtilisateur->execute(array($_SESSION['id']));
            $infoutilisateur = $requtilisateur->fetch();
            return $infoutilisateur;
        } else {
            echo "C'est pas bon";
        }
    }
}
