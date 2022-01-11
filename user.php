<?php



class db
{
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = '';
    protected $dbname = 'classes';

    public $bdh;
    protected $error;


    public function __construct()
    {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $this->bdh = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
    }
}

class User extends db
{

    protected $_login;
    protected $_email;
    protected $_firstname;
    protected $_lastname;

    public function __construct($login, $email, $_firstname, $_lastname){
        parent::__construct();
        $this->_login = $login;
        $this->_email = $email;
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;
    }
    

    // Fonction inscription d'un utilisateur

    public function Register($login, $password, $email, $firstname, $lastname)
    {
        // Cryptage de MDP
        $password = password_hash($password, CRYPT_BLOWFISH);
        // Requete SQL : 
        $sqlNewUser = ('INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ($login,$password,$email,$firstname,$lastname)');
        $insertmbr = mysqli_query($this->bdh, $sqlNewUser);

        if ($insertmbr == true) {
            $sqlUser = "SELECT * FROM utilisateurs WHERE login = '$this->_login'";
            $req = $this->bdh->prepare($sqlUser);
            $infoUser = $req->fetch();
            return $infoUser;
        } else {
            echo "Pas bon";
        }
    }
    public function connexion($login, $password)
    {
        $SqlVerifUtilisateur = "SELECT * FROM UTILISATEURS WHERE login = '$login'";
        $prepVerif = mysqli_query($this->bdh, $SqlVerifUtilisateur);
        $infoLogin = mysqli_fetch_assoc($prepVerif);
        if (count($infoLogin) > 0) {
            $SqlPassword = $infoLogin[0]['password'];
            if (password_verify($password, $SqlPassword)) {
                $_SESSION['profil']['id'] = $infoLogin[0]['id'];
                $_SESSION['profil']['email'] = $infoLogin[0]['email'];
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

    public function delete()
    {
        $reqdeleteutilisateur = "DELETE * FROM utilisateurs where email = '$this->_email'";
        $prepDel = mysqli_query($this->bdh, $reqdeleteutilisateur);
        unset($_SESSION['profil']);
        // header('location: index.php'); 
        exit();
    }
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $requpdateutilisateur = "UPDATE utilisateurs SET login = $login , password = $password , email = $email , firstname = $firstname , lastname = $lastname WHERE email = '$this->_email'";;
        $update = mysqli_query($this->bdh,$requpdateutilisateur);
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
    public function getAllinfo()
    {
        if ($this->isConnected() === true) {

            $array = [

                'login' => $this->_login,
                'email' => $this->_email,
                'firstname' => $this->_firstname,
                'lastname' => $this->_lastname,
            ];
            return $array;
        } else {
            return false;
        }
    }
    // retourne le login de l'utilisateur connecté
    public function getLogin()
    {
        if ($this->isConnected() === true) {
            $login = $this->_login;
            return $login;
        } else {
            return false;
        }
    }
    //retourne l'adresse email de l'utilisateur 
    public function getEmail()
    {
        if ($this->isConnected() === true) {
            $email = $this->_email;
            return $email;
        } else {
            return false;
        }
    }
    // retourne le firstname de l'utilisateur
    public function getFirstName()
    {
        if ($this->isConnected() === true) {
            $firstname = $this->_firstname;
            return $firstname;
        } else {
            return false;
        }
    }
    // retourne la lastname de l'utilisateur
    public function getLastName()
    {
        if ($this->isConnected() === true) {
            $lastname = $this->_lastname;
            return $lastname;
        } else {
            return false;
        }
    }
}
