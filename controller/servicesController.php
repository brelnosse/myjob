<?php
function isSuscriber($id){
    require "../model/config.php";

    $q = $bdd->prepare("SELECT * FROM abonne WHERE (date_fin_abnmt >= curdate() and user_id = ?)");
    $q->execute(array($id));

    if($q->rowCount() > 0){
        return true;
    }else{
        return false;
    }
}
function getPost($id){
    require "../model/config.php";

    $q = $bdd->prepare("SELECT * FROM post WHERE user_id = ?");
    $q->execute(array($id));

    if($q->rowCount() > 0){
        return $q->fetch();
    }else{
        return "0";
    }   
}
function getPostNumber($id){
    require "../model/config.php";

    $q = $bdd->prepare("SELECT COUNT(*) as num FROM post WHERE user_id = ?");
    $q->execute(array($id));

    return $q->fetch()[0];
}
function getFreelancersJobs(){
    require "../model/config.php";

    $q = $bdd->query("SELECT DISTINCT(metier) FROM users WHERE metier !=''");
    $arr = [];
    while($dt = $q->fetch()){
        $arr[] = $dt['metier'];
    }
    return $arr;    
}
function getFreelancers(){
    require "../model/config.php";

    $q = $bdd->query("SELECT * FROM users WHERE metier !=''");
    $arr1 = [];
    $arr2 = [];
    while($dt = $q->fetch()){
        $arr1 = [];
        $arr1[] = $dt['id'];
        $arr1[] = $dt['nom'];
        $arr1[] = $dt['prenom'];
        $arr1[] = $dt['num_tel'];
        $arr1[] = $dt['email'];
        $arr1[] = $dt['mdp'];
        $arr1[] = $dt['profil_pic'];
        $arr1[] = $dt['metier'];
        $arr1[] = $dt['isGuest'];
        $arr2[] = $arr1;
    }
    return $arr2;   
}
function getFreelancerByMetier($metier){
    require "../model/config.php";

    $q = $bdd->prepare("SELECT * FROM users WHERE metier = ?");
    $q->execute(array($metier));
    $arr1 = [];
    $arr2 = [];
    while($dt = $q->fetch()){
        $arr1 = [];
        $arr1[] = $dt['id'];
        $arr1[] = $dt['nom'];
        $arr1[] = $dt['prenom'];
        $arr1[] = $dt['num_tel'];
        $arr1[] = $dt['email'];
        $arr1[] = $dt['mdp'];
        $arr1[] = $dt['profil_pic'];
        $arr1[] = $dt['metier'];
        $arr1[] = $dt['isGuest'];
        $arr2[] = $arr1;
    }
    return $arr2;   
}

function getFreelancerBySearch($mot){
    $mot = htmlspecialchars($mot);
    require "../model/config.php";
    $query = "SELECT * FROM users WHERE metier LIKE '%".$mot."' OR metier LIKE '".$mot."%' OR metier LIKE '%".$mot."%' OR nom LIKE '%".$mot."' OR nom LIKE '".$mot."%' OR nom LIKE '%".$mot."%' OR prenom LIKE '%".$mot."' OR prenom LIKE '".$mot."%' OR prenom LIKE '%".$mot."%'";
    $q = $bdd->query($query);
    $arr1 = [];
    $arr2 = [];

    while($dt = $q->fetch()){
        $arr1 = [];
        $arr1[] = $dt['id'];
        $arr1[] = $dt['nom'];
        $arr1[] = $dt['prenom'];
        $arr1[] = $dt['num_tel'];
        $arr1[] = $dt['email'];
        $arr1[] = $dt['mdp'];
        $arr1[] = $dt['profil_pic'];
        $arr1[] = $dt['metier'];
        $arr1[] = $dt['isGuest'];
        $arr2[] = $arr1;
    }
    return $arr2;   
}
function getComment($post_id, $user_id){
    require "../model/config.php";

    $q = $bdd->prepare("SELECT * FROM commentaire WHERE post_id in (SELECT post_id FROM commentaire WHERE user_id = ?)");
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
function getMyPost($user_id){
    require "../model/config.php";

    $q = $bdd->query("SELECT * FROM post WHERE user_id = ".$user_id." order by id desc");
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
require "../model/config.php";
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveBtn'])){
    if(isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['pph'], $_POST['num_tel'], $_POST['mdp'], $_POST['cmdp'], $_POST['job'], $_POST['id'])){
        if(empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['pph']) || empty($_POST['num_tel']) || empty($_POST['mdp']) || empty($_POST['cmdp']) || empty($_POST['job']) ||  empty($_POST['id'])){
            header("Location: ../vues/messervices.php?error=empty&p=".$_POST['pph']);
        }else{
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $email = htmlspecialchars($_POST['email']);
            $numTel = htmlspecialchars($_POST['num_tel']);
            $profilePic = htmlspecialchars($_POST['pph']);
            $mdp = trim(htmlspecialchars($_POST['mdp']));
            $cmdp = trim(htmlspecialchars($_POST['cmdp']));
            $job = (strtolower(htmlspecialchars($_POST['job'])) == "pas de job") ? "" : htmlspecialchars($_POST['job']);

            if($mdp == $cmdp){
                $q = $bdd->prepare("SELECT * FROM users WHERE (email = ? or num_tel = ?) and id != ?");
                $q->execute(array(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['num_tel']), $_POST['id']));
                
                if($q->rowCount() == 0){
                    $q = $bdd->prepare("update users SET nom = ?, prenom = ?, email = ?, num_tel = ?, mdp = ?, profil_pic = ?, metier = ? WHERE id = ?");
                    $q->execute(array($nom, $prenom, $email, $numTel, $mdp, $profilePic, $job, $_POST['id']));
                    header("location: ../vues/messervices.php?success");
                }else{
                    header("location: ../vues/messervices.php?error=exist");
                }
            }else{
                header("location: ../vues/messervices.php?error=mdps");
            }
        }
    }
}