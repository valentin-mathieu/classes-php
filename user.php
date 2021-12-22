<?php
class User {

    private $id;
    public $login, $email, $firstname, $lastname, $connexion;

    public function __construct() { 

        $connectbdd = mysqli_connect('localhost','root','','classes');
        $this->connexion = $connectbdd;
    
    }

    public function register($login,$password,$email,$firstname,$lastname){
        
        $query = mysqli_query($this->connexion, "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$login','$password','$email','$firstname','$lastname')");
        $query2 = mysqli_query($this->connexion,"SELECT * FROM utilisateurs Where login = '$login'");
        $result = mysqli_fetch_assoc($req);

        var_dump ($result);

    }
    
    public function connect($login, $password){

        $req = "SELECT login, password FROM utilisateurs WHERE login='$login'";
        $query = mysqli_query($this->connexion,$req); 
        $result = mysqli_fetch_assoc($query);

        if ($password == $result['password'] && $login == $result ['login']){
            
            $_SESSION['login'] = $result['login'];
            $this->login = $result['login'];
            $this->password = $result['password'];
            echo "Vous êtes connecté !";

        }

        else {

            echo "Login ou mot de passe incorrect";
        
        }
    }

    public function disconnect() {

        session_destroy();
        echo "Vous êtes déconnecté !";

    }

    public function delete() {

        $login = $_SESSION['login'];
        $query = mysqli_query($this->connexion,"DELETE FROM utilisateurs WHERE login='$login'");
        
        session_destroy();
        
        echo "Votre compte a été supprimé.";

    }

    public function update($login,$password,$email,$firstname,$lastname){
        
        $this->login = $_SESSION['login'];
        $req = "SELECT * FROM utilisateurs where login = '$this->login'";
        $query = mysqli_query($this->connexion, $req);
        $result = mysqli_fetch_assoc($query);
        $this->id = $result['id'];
       
        $req2 = "UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$email',`firstname`='$firstname',`lastname`='$lastname' WHERE id = '$this->id'";
        $query2 = mysqli_query($this->connexion, $req2);

        echo "Profil mis à jour.";

    }

    public function isConnected() {

        $result = null;

        if (isset($_SESSION['login'])){

            $result = true;
            echo "Vous êtes connecté.";

        }

        else {

            $result = false;
            echo "Vous n'êtes pas connecté.";
            
        }
        
        return $result;

    }

    public function getAllInfos() {

        $this->login = $_SESSION['login']; 
        $req = "SELECT * FROM utilisateurs WHERE login = '$this->login'";
        $query = mysqli_query($this->connexion, $req);
        $result = mysqli_fetch_assoc($query);
        
        var_dump ($result);

    }

    public function getLogin () {

        $this->login = $_SESSION['login'];
        $req = "SELECT login FROM utilisateurs WHERE login = '$this->login'";
        $query = mysqli_query($this->connexion, $req);
        $result = mysqli_fetch_assoc($query);
        
        $this->login = $result['login'];
        
        echo $this->login;
        
    }

    public function getEmail() {

        $this->login = $_SESSION['login'];
        $req = "SELECT email FROM utilisateurs WHERE login = '$this->login'";
        $query = mysqli_query($this->connexion, $req);
        $result = mysqli_fetch_assoc($query);

        $this->email = $result['email'];

        echo $this->email;

    }

    public function getFirstname() {

        $this->login = $_SESSION['login'];
        $req = "SELECT firstname FROM utilisateurs WHERE login = '$this->login'";
        $query = mysqli_query($this->connexion, $req);
        $result = mysqli_fetch_assoc($query);

        $this->firstname = $result['firstname'];

        echo $this->firstname;

    }

    public function getLastname() {

        $this->login = $_SESSION['login'];
        $req = "SELECT lastname FROM utilisateurs WHERE login = '$this->login'";
        $query = mysqli_query($this->connexion, $req);
        $result = mysqli_fetch_assoc($query);

        $this->lastname = $result['lastname'];

        echo $this->lastname;
    }

}


?>