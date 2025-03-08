<?php
    require "../controller/servicesController.php";
    require "../controller/loginController.php";
    if(isset($_SESSION['transaction_result'])){
        unset($_SESSION['transcation_result']);
    }
    if(isset($_SESSION['paiement_error'])){
        unset($_SESSION['paiement_error']);
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
    <link rel="stylesheet" href="../resources/messervices.css">
    <title>Document</title>
</head>
<body>
    <nav class="navbar-computer">
        <a href="" class="appName">MyJob</a>
        <div class="menu-items">
            <a href="main.php" class="menu-item">Explorer<i class="fas fa-search" style="margin-left:5px;font-size:1em"></i></a>
            <a href="discussion.php" class="menu-item">Discussions<i class="fas fa-comments" style="margin-left:5px;font-size:1em"></i></a>
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
    <h2 class="pageTitle">Mes services</h2>
    <?php
        if(isset($_SESSION['id']) and !empty($_SESSION['id'])){
            if(isSuscriber($_SESSION['id'])){ ?>
            <div class="serv-menu">
                <a href="messervices.php?vue=posts" class="serv-menu_item active">Mon profil</a>
                <a href="messervices.php#pub" class="serv-menu_item">Mes publications (<?= getPostNumber($_SESSION['id']) ?>)</a>
                <!-- <a href="messervices.php?vue=posts" class="serv-menu_item">Commentaires</a> -->
                <!-- <a href="messervices.php?vue=posts" class="serv-menu_item">Reponses</a> -->
            </div>
            <div class="container">
            <h3 class="stitle">Mon profil</h3>
            <form class="infos" method="post" action="../controller/servicesController.php">
                    <?php
                        if(isset($_GET['error'])){
                            if($_GET['error'] == "empty"){ ?>
                            <div class="msg error">
                                Champs incomplets
                            </div>
                            <?php
                            }else{
                                if($_GET['error'] == "mdps"){ ?>
                            <div class="msg error">
                                Les mots de passes ne correspondent pas
                            </div>
                            <?php
                                }else{ ?>
                            <div class="msg error">
                                Un utilisateur avec le meme numero de telephone ou adresse emal existe deja
                            </div>
                            <?php
                                }
                            }
                        }else{
                            if(isset($_GET['success'])){?>
                            <div class="msg success">
                                Modification reussi !!
                            </div>
                        <?php
                            }
                        }
                    ?>
                <div class="info-group" style="text-align: center">
                    <label for="pp"><i class="fas fa-camera"></i></label>
                    <input type="file" name="pp" id="pp" style="display: none">
                    <img src="<?= empty(getUser($_SESSION['id'])['profil_pic']) ? "" : getUser($_SESSION['id'])['profil_pic']; ?>" alt="" id="pre">
                    <input type="hidden" id="pph" name="pph" value="<?= empty(getUser($_SESSION['id'])['profil_pic']) ? "" : getUser($_SESSION['id'])['profil_pic']; ?>">
                    <input type="hidden" id="id" name="id" value="<?= $_SESSION['id'] ?>">
                </div>
                <div class="info-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom"name="nom" value="<?php echo getUser($_SESSION['id'])['nom']; ?>" require>
                </div>
                <div class="info-group">
                    <label for="prenom">Prenom</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo getUser($_SESSION['id'])['prenom']; ?>" require>
                </div>
                <div class="info-group">
                    <label for="num">Numero de telephone</label>
                    <input type="text" id="num" name="num_tel" value="<?php echo getUser($_SESSION['id'])['num_tel']; ?>" require pattern="6[0-9]{8}">
                </div>
                <div class="info-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo getUser($_SESSION['id'])['email']; ?>" require>
                </div>
                <div class="info-group">
                    <label for="job">Metier</label>
                    <input type="text" id="job" name="job" style="text-transform: uppercase"value="<?= empty(getUser($_SESSION['id'])['metier']) ? "pas de job" : getUser($_SESSION['id'])['metier']; ?>" require>
                </div>
                <div class="info-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" value="<?= getUser($_SESSION['id'])['mdp']; ?>" require>
                </div>
                <div class="info-group">
                    <label for="cmdp">Confirmaion du mot de passe</label>
                    <input type="password" id="cmdp" name="cmdp" value="<?= getUser($_SESSION['id'])['mdp']; ?>" require>
                </div>
                <div class="info-group">
                    <input type="submit" id="btn" name="saveBtn" value="Enregistrer les modifications">
                </div>
            </div>
         </form>
         <h3 class="stitle" id="pub">Mes publication</h3>
        <?php
            for($i = 0; $i < count(getMyPost($_SESSION['id'])); $i++){ ?>
            <div class="post" id="pos<?= getMyPost($_SESSION['id'])[$i][0]; ?>">
                <div class="postHeader">
                    <div class="leftSide">
                        <img src="<?= getUser(getMyPost($_SESSION['id'])[$i][1])['profil_pic'] ?>" alt="">
                        <span class="pseudo"><?= getUser(getMyPost($_SESSION['id'])[$i][1])['nom']; ?></span>
                        <span class="email"><?= getUser(getMyPost($_SESSION['id'])[$i][1])['email']; ?></span>
                    </div>
                    <div class="rightSide">
                        <span class="PostedDate"><?= getMyPost($_SESSION['id'])[$i][7]; ?></span>
                    </div>
                </div>
                <div class="postBody">
                    <div class="imgContainer">
                        <?php
                            if(!empty(getMyPost($_SESSION['id'])[$i][6])){
                                echo "<img src='".getMyPost($_SESSION['id'])[$i][6]."'>";
                            }
                            if(!empty(getMyPost($_SESSION['id'])[$i][5])){
                                echo "<img src='".getMyPost($_SESSION['id'])[$i][5]."'>";
                            }
                            if(!empty(getMyPost($_SESSION['id'])[$i][4])){
                                echo "<img src='".getMyPost($_SESSION['id'])[$i][4]."'>";
                            }
                            if(!empty(getMyPost($_SESSION['id'])[$i][3])){
                                echo "<img src='".getMyPost($_SESSION['id'])[$i][3]."'>";
                            }
                        ?>
                    </div>
                    <div class="textContainer">
                        <?= getMyPost($_SESSION['id'])[$i][2]?>
                    </div>
                </div>
                <div class="postFooter"></div>     
            </div> 
        <?php
            }
        ?>
        <?php        
            }else{ ?>
        <div class="scontainer">
            <h2 style="text-align:center">Vous devez vous abonnez pour acceder a<br> cette fonctionnalite.</h2>
            <span class="price">1 000 FCFA/mois</span>
            <h3>avantages:</h3>
            <ul>
                <li>Possibilite de vendre ses services</li>
                <li>Profil visible par tous les clients</li>
            </ul>
            <a href="paiement.php" class="link-btn">Souscrire</a>
        </div>
    <?php
            }
        }
    ?>
    <script src="../resources/all.js"></script>
    <script src="../resources/messervices.js"></script>
</body>
</html>