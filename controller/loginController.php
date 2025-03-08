<?php
session_start();
function clean($field){
    $field = trim($field);
    $field = htmlspecialchars($field);

    return $field;
}

function getUser($id){
    require "../model/config.php";
    $id = clean($id);
    $q = $bdd->prepare("SELECT * FROM users WHERE id = ?");
    $q->execute(array($id));

    if($q->rowCount() > 0){
        return $q->fetch();
    }else{
        return false;
    }
}
function getAllUser(){
    require "../model/config.php";
    $users;
    $q = $q->query("SELECT * FROM users");

    if($q->rowCount() > 0){
        $users = $q->fetch();
    }else{
        return false;
    }
    return $users;
}
require "../model/config.php";
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connectionBtn'])){
    $_SESSION['error'] = '';
    $email = clean($_POST['email']);
    $mdp = clean($_POST['mdp']);

    $q = $bdd->prepare("SELECT id FROM users WHERE email = ? and mdp = ?");
    $q->execute(array($email, $mdp));

    if($q->rowCount() == 1){
        $user = $q->fetch();
        $_SESSION['id'] = $user['id'];
        $_SESSION['error'] = "";
        header("location: ../vues/main.php");
    }else{
        $_SESSION['error'] = "Email ou mot de passe incorrect .";
        header("location: ../index.php"); 
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscriptionBtn'])){
    $_SESSION['error'] = '';
    $nom = clean($_POST['nom']);
    $prenom = clean($_POST['prenom']);
    $email = clean($_POST['email']);
    $numTel = clean($_POST['num_tel']);
    $mdp = clean($_POST['mdp']);
    $cmdp = clean($_POST['cmdp']);

    $q = $bdd->prepare("SELECT * FROM users WHERE email = ? or num_tel = ?");
    $q->execute(array($email, $numTel));

    if($q->rowCount() > 0){
        $_SESSION['error'] = "Un utilisateur avec le meme numero de telephone ou adresse email existe deja";
        header("location: ../vues/inscription.php"); 
    }else{
        if($mdp == $cmdp){
            $addUser = $bdd->prepare("INSERT INTO users(nom, prenom, num_tel, email, mdp, isGuest) Values(?, ?, ?, ?, ?, 0)");
            $addUser->execute(array($nom, $prenom, $numTel, $email, $mdp));
            header("location: ../index.php?connexion_ok");
            $_SESSION['error'] = "";
            exit();
        }else{
            $_SESSION['error'] = "Les mots de passe ne correspondent pas.";    
            header("location: ../vues/inscription.php");        
        }
    }
}