<?php
    session_start();
    require "../controller/discussionController.php";
    require("../model/config.php");
    if(isset($_GET['r_id']) and !empty($_GET['r_id'])){
        if($_GET['r_id'] == $_SESSION['id']){
            header("location: main.php");
        }
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['sendmsg'])){
                if(isset($_POST['msgText']) and !empty($_POST['msgText'])){
                    $qs = $bdd->prepare("INSERT INTO message(user_id, receiver_id, message, date_env) values(?,?,?,NOW())");
                    $qs->execute([$_SESSION['id'], $_GET['r_id'], $_POST['msgText']]);
                }else{
                    echo "no";
                }
            }else{
                echo "ok";
            }
        }
    }
    if(!isset($_SESSION['id'])){
        header("location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/menu.css">
    <link rel="stylesheet" href="../resources/discussion.css">
    <title>MyJob - discussion</title>
</head>
<body>
    <nav class="navbar-computer">
        <a href="" class="appName">MyJob</a>
        <div class="menu-items">
            <a href="main.php" class="menu-item">Explorer<i class="fas fa-search" style="margin-left:5px;font-size:1em"></i></a>
            <a href="discussion.php" class="menu-item active">Discussions<i class="fas fa-comments" style="margin-left:5px;font-size:1em"></i></a>
            <a href="workers.php" class="menu-item">Travailleurs <i class="fas fa-users" style="margin-left:5px;font-size:1em"></i></a>
        </div>
        <div class="dotsMenu">
            <span class="menu"><i class="fas fa-grip-vertical"></i></span>
            <div class="s-menu">
                <a href="messervices.php" class="s_menu-item"><i class="fab fa-servicestack" style="margin-right:10px;font-size:1em"></i>Mes services</a>
                <a href="" class="s_menu-item"><i class="fas fa-user" style="margin-right:10px;font-size:1em"></i> Mon compte</a>
                <a href="../model/deconnexion.php" class="s_menu-item"><i class="fas fa-sign-out-alt" style="margin-right:10px;font-size:1em"></i> Deconnexion</a>
            </div>
        </div>
    </nav>
    <h2 class="pageTitle" style="display: flex; justify-content: space-between">
        <?php
            if(isset($_GET['r_id'])){ ?>
                <a href='discussion.php' style="color: #333; padding: 10px"><i class="fas fa-arrow-left"></i></a>
        <?php
            }
        ?>
        <span>
            <i class="fas fa-comments" style="margin-right:5px;font-size:1em"></i> Discussion
        </span>
        
        <?php
            if(isset($_GET['r_id'])){ ?>
                <img src="<?= getUser($_GET['r_id'])['profil_pic'] ?>" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover">
        <?php
            }
        ?>
        
    </h2>
    <?php
    if(isset($_GET['r_id'])){ ?>
        <div class="messageZone">
            <?php
                $q = $bdd->prepare("SELECT * FROM message WHERE (user_id = ? and receiver_id = ?) or (user_id = ? and receiver_id = ?)");
                $q->execute(array($_SESSION['id'], $_GET['r_id'], $_GET['r_id'], $_SESSION['id']));

                if($q->rowCount() == 0){ ?>
                discussion vide.
            <?php
                }
                while($dt = $q->fetch()){ ?>
                <?php 
                if($dt["user_id"] == $_SESSION['id']){ ?>
                    <div class="message" style="background-color:rgba(0, 99, 0, 0.26);position: relative; left: 100%; transform: translateX(-100%)">
                        <img src="<?= getUser($_GET['r_id'])['profil_pic'] ?>">
                        <p><?= $dt["message"]; ?></p>
                        <b><?= getUser($_GET['r_id'])['nom']." ".getUser($_GET['r_id'])['prenom']?></b>
                    </div>
                <?php
                }else{ ?>
                    <div class="message">
                        <img src="<?= getUser($_GET['r_id'])['profil_pic'] ?>">
                        <p><?= $dt["message"]; ?></p>
                        <b><?= getUser($_GET['r_id'])['nom']." ".getUser($_GET['r_id'])['prenom']?></b>
                    </div>
            <?php
                }
                ?>
            <?php
                }
            ?>
        </div>
        <form class="writeMsgZone" method="post">
            <textarea name="msgText" id="msgText"></textarea>
            <input type="submit" value="Envoyer" name="sendmsg">
        </form>
    <?php
        }
    ?>

    <div class="contactContainer">
        <?php
            if(isset($_GET['r_id'])){
                addContact($_GET['r_id'], $_SESSION['id']);
            ?>
            <?php
            }else{
                if(count(getContacts($_SESSION['id'])) == 0){
                    echo "<div class='not-found'>aucun contacts</div>";
                }
                for($i = 0; $i < count(getContacts($_SESSION['id'])); $i++){ ?>
                    <a href="?r_id=<?= (getContacts($_SESSION['id'])[$i]["receiver_id"] == $_SESSION["id"]) ? getContacts($_SESSION['id'])[$i]["user_id"] : getContacts($_SESSION['id'])[$i]["receiver_id"]; ?>" class="contact">
                        <?php
                            if(empty(getUser(getContacts($_SESSION['id'])[$i]["user_id"])["profil_pic"])){ ?>
                            <span class="roundedRadius">
                            <?= (getContacts($_SESSION['id'])[$i]["receiver_id"] == $_SESSION["id"]) ? getUser(getContacts($_SESSION['id'])[$i]["user_id"])["nom"][0] : getUser(getContacts($_SESSION['id'])[$i]["receiver_id"])["nom"][0]; ?>
                            </span>
                        <?php
                            }else{ ?>
                            <img src="<?= (getContacts($_SESSION['id'])[$i]["receiver_id"] == $_SESSION["id"]) ? getUser(getContacts($_SESSION['id'])[$i]["user_id"])["profil_pic"] : getUser(getContacts($_SESSION['id'])[$i]["receiver_id"])["profil_pic"];?>" alt="" srcset="">
                        <?php
                            }
                        ?>
                        <span class="fullName">
                            <b><?= 
                                (getContacts($_SESSION['id'])[$i]["receiver_id"] == $_SESSION["id"]) ? 
                                getUser(getContacts($_SESSION['id'])[$i]["user_id"])["nom"]." ".getUser(getContacts($_SESSION['id'])[$i]["user_id"])["prenom"].'<i style="font-weight: 400;margin-left: 10px; font-size: 0.7em">+237'.getUser(getContacts($_SESSION['id'])[$i]["user_id"])["num_tel"] : 
                                getUser(getContacts($_SESSION['id'])[$i]["receiver_id"])["nom"]." ".getUser(getContacts($_SESSION['id'])[$i]["receiver_id"])["prenom"].'<i style="font-weight: 400;margin-left: 10px; font-size: 0.7em">+237'.getUser(getContacts($_SESSION["id"])[$i]["receiver_id"])["num_tel"]
                                ?>
                                </i>
                            </b>
                            <i>
                                <?=
                                (getContacts($_SESSION['id'])[$i]["receiver_id"] == $_SESSION["id"]) ? getLastMsg($_SESSION['id'], getContacts($_SESSION['id'])[$i]["user_id"]) : getLastMsg($_SESSION['id'], getContacts($_SESSION['id'])[$i]["receiver_id"]);
                                ?>
                            </i>
                        </span>
                        <span class="lastTime">
                            <?= 
                            (getContacts($_SESSION['id'])[$i]["receiver_id"] == $_SESSION["id"]) ? getLastMsgTime($_SESSION['id'], getContacts($_SESSION['id'])[$i]["user_id"]) : getLastMsgTime($_SESSION['id'], getContacts($_SESSION['id'])[$i]["receiver_id"]);
                            ?>
                        </span>
                    </a>
                    <?php
                }
            }
        ?>
    </div>
    <script src="../resources/all.js"></script>
</body>
</html>