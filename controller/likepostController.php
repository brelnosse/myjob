<?php
require "../model/config.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['like'],$_GET['user_id'], $_GET['guest_id'], $_GET['pos'])){
        $getLikes = $bdd->prepare("SELECT * FROM likeposts WHERE user_id = ? and guest_id = ?");
        $getLikes->execute(array(htmlspecialchars($_GET['user_id']), htmlspecialchars($_GET['guest_id'])));

        if($getLikes->rowCount() == 1){
            $delLikes = $bdd->prepare("DELETE FROM likeposts WHERE user_id = ? and guest_id = ?");
            $delLikes->execute(array(htmlspecialchars($_GET['user_id']), htmlspecialchars($_GET['guest_id'])));
            header("location: ../vues/main.php#pos".$_GET['pos']);

        }else{
            $addLikes = $bdd->prepare("INSERT INTO likeposts(user_id, guest_id) Values(?, ?)");
            $addLikes->execute(array(htmlspecialchars($_GET['user_id']), htmlspecialchars($_GET['guest_id'])));

            header("location: ../vues/main.php#pos".$_GET['pos']);
        }
    }
}