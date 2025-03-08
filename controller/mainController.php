<?php
require("../model/config.php");
function getSitePost(){
    require "../model/config.php";

    $q = $bdd->query("SELECT * FROM post order by id desc");
    $arr1 = [];
    $arr2 = [];
    while($dt = $q->fetch()){
        $arr1 = [];
        $arr1[] = $dt['id'];
        $arr1[] = $dt['user_id'];
        $arr1[] = $dt['msg'];
        $arr1[] = $dt['pic1'];
        $arr1[] = $dt['pic2'];
        $arr1[] = $dt['pic3'];
        $arr1[] = $dt['pic4'];
        $arr1[] = $dt['date_post'];
        $arr2[] = $arr1;
    }
    return $arr2;     
}
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
function getComments($post_id){
    require "../model/config.php";

    $q = $bdd->prepare("SELECT * FROM commentaire WHERE post_id = ?");
    $q->execute(array($post_id));

    $arr1 = [];
    $arr2 = [];
    while($dt = $q->fetch()){
        $arr1 = [];
        $arr1[] = $dt['id'];
        $arr1[] = $dt['user_id'];
        $arr1[] = $dt['guest_id'];
        $arr1[] = $dt['post_id'];
        $arr1[] = $dt['msg'];
        $arr2[] = $arr1;
    }
    return $arr2;  
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['post_btn'])){
        if(isset($_POST['post_text']) and !empty($_POST['post_text'])){
            if(isset($_POST['cimg1'], $_POST['cimg2'], $_POST['cimg3'], $_POST['cimg4'])){
                $q = $bdd->prepare("INSERT INTO post(user_id, msg, pic1, pic2, pic3, pic4, date_post) values(?,?,?,?,?,?,curdate())");
                $q->execute(array($_SESSION['id'], htmlspecialchars($_POST['post_text']), $_POST['cimg1'], $_POST['cimg2'], $_POST['cimg3'], $_POST['cimg4']));
                header("location: ../vues/main.php");
            }
        }else{
            header("location: ../vues/main.php?error=empty-post-text");
        }
    }
    if(isset($_POST['commentBtn'])){
        if(isset($_POST['comment']) and !empty($_POST['comment']) and isset($_POST['user_id']) and isset($_POST['post_id']) and !empty($_POST['user_id']) and !empty($_POST['post_id'])){
            $q = $bdd->prepare("INSERT INTO commentaire(user_id, guest_id, post_id, msg) values(?,?,?,?)");
            $q->execute(array($_POST['user_id'],$_SESSION['id'], $_POST['post_id'], $_POST['comment']));
            header("location: ../vues/main.php?comment=".$_POST['post_id']."#pos".$_POST['post_id']);          
        }
    }
}