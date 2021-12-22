<?php

class User {

    private $id;
    public $login, $email, $firstname, $lastname, $connexion;

    public function __construct() { 

        try {
            
            $connectbdd = new PDO('mysql:host=localhost;dbname=classes',"root","");
            $this->connexion = $connectbdd;
        
        }

        catch(PDOException $e) {

            echo "Erreur :" . $e->getMessage(). "<br>";
            die();
        
        }

    }

    public function register($login,$password,$email,$firstname,$lastname) {

        $addquery = $this->connexion->prepare("INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$login','$password','$email','$firstname','$lastname')");
        $addquery->execute();

        $returnquery = $this->connexion->prepare("SELECT * FROM utilisateurs WHERE login='$login'");
        $returnquery->setFetchMode(PDO::FETCH_ASSOC);
        $returnquery->execute();

        $result= $returnquery->fetchAll();
        var_dump($result);
    
    }

    public function connect($login,$password) {

        $connectquery = $this->connexion->prepare("SELECT login, password FROM utilisateurs WHERE login='$login'");
        $connectquery->setFetchMode(PDO::FETCH_ASSOC);
        $connectquery->execute();

        $result = $connectquery->fetchAll();

        if ($login == $result['0']['login'] && $password == $result['0']['password']){

            $this->login = $result['0']['login'];
            $this->password = $result['0']['password'];
            $_SESSION['login'] = $this->login;

            echo "Vous êtes connecté !";

        }

        else {

            echo "Login ou mot de passe incorrect";
        
        }

    }

    public function disconnect() {

        session_destroy();
        echo "Vous êtes déconnecté.";

    }

    public function delete() {

        $login = $_SESSION['login'];
        $deletequery = $this->connexion->prepare("DELETE FROM utilisateurs WHERE login='$login'");
        $deletequery->execute();

        session_destroy();

        echo "Votre compte a bien été supprimé.";
        
    }

    public function update($login,$password,$email,$firstname,$lastname) {

        $this->login = $_SESSION['login'];
        $idquery = $this->connexion->prepare("SELECT id FROM utilisateurs where login = '$this->login'");
        $idquery->setFetchMode(PDO::FETCH_ASSOC);
        $idquery->execute();
        
        $resultid = $idquery->fetchAll();
        $this->id = $resultid['0']['id'];

        $updatequery = $this->connexion->prepare("UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$email',`firstname`='$firstname',`lastname`='$lastname' WHERE id = '$this->id'");
        $updatequery->execute();

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

    public function getAllInfos(){

        $this->login = $_SESSION['login']; 
        $infosquery = $this->connexion->prepare("SELECT * FROM utilisateurs WHERE login = '$this->login'");
        $infosquery->setFetchMode(PDO::FETCH_ASSOC); 
        $infosquery->execute();

        $result = $infosquery->fetchAll();
        
        var_dump ($result);

    }

    public function getLogin(){

        $this->login = $_SESSION['login'];
        $loginquery = $this->connexion->prepare("SELECT login FROM utilisateurs WHERE login = '$this->login'");
        $loginquery->setFetchMode(PDO::FETCH_ASSOC); 
        $loginquery->execute();

        $result = $loginquery->fetchAll();
        
        $this->login = $result['0']['login'];
        
        echo $this->login;

    }

    public function getEmail(){

        $this->login = $_SESSION['login'];
        $emailquery = $this->connexion->prepare("SELECT email FROM utilisateurs WHERE login = '$this->login'");
        $emailquery->setFetchMode(PDO::FETCH_ASSOC); 
        $emailquery->execute();

        $result = $emailquery->fetchAll();
        
        $this->email = $result['0']['email'];
        
        echo $this->email;

    }

    public function getFirstname(){
        
        $this->login = $_SESSION['login'];
        $fnamequery = $this->connexion->prepare("SELECT firstname FROM utilisateurs WHERE login = '$this->login'");
        $fnamequery->setFetchMode(PDO::FETCH_ASSOC); 
        $fnamequery->execute();

        $result = $fnamequery->fetchAll();
        
        $this->firstname = $result['0']['firstname'];
        
        echo $this->firstname;

    }

    public function getLastname(){

        $this->login = $_SESSION['login'];
        $lnamequery = $this->connexion->prepare("SELECT lastname FROM utilisateurs WHERE login = '$this->login'");
        $lnamequery->setFetchMode(PDO::FETCH_ASSOC); 
        $lnamequery->execute();

        $result = $lnamequery->fetchAll();
        
        $this->lastname = $result['0']['lastname'];
        
        echo $this->lastname;

    }
}