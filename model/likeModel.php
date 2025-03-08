<?php
function hasLiked($user_id, $guest_id){
    require "../model/config.php";
    $getLikes = $bdd->prepare("SELECT * FROM likes WHERE user_id = ? and guest_id = ?");
    $getLikes->execute(array(htmlspecialchars($user_id), htmlspecialchars($guest_id)));   

    if($getLikes->rowCount() == 1){
        return true;
    }
    return false;
}

function hasLikedPost($user_id, $guest_id){
    require "../model/config.php";
    $getLikes = $bdd->prepare("SELECT * FROM likeposts WHERE user_id = ? and guest_id = ?");
    $getLikes->execute(array(htmlspecialchars($user_id), htmlspecialchars($guest_id)));   

    if($getLikes->rowCount() == 1){
        return true;
    }
    return false;
}