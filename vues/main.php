<?php
    session_start();
    $_SESSION['error'] = '';
    require "../controller/servicesController.php";
    require "../controller/mainController.php";
    require "../model/likeModel.php";
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
    <link rel="stylesheet" href="../resources/main.css">
    <title>MyJob - accueil</title>
</head>
<body>
    <nav class="navbar-computer">
        <a href="" class="appName">MyJob</a>
        <div class="menu-items">
            <a href="main.php" class="menu-item active">Explorer<i class="fas fa-search" style="margin-left:5px;font-size:1em"></i></a>
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
    <h2 class="pageTitle"><i class="fas fa-search" style="margin-right:5px;font-size:1em"></i> Explorer</h2>
    <?php
        if(isSuscriber($_SESSION['id'])){ ?>
        <form method="post" action="" class="newPostContainer">
            <h3>Post</h3>
            <textarea name="post_text" id="post-text" placeholder="Dites-nous en plus sur votre post..."></textarea>
            <p>4 images maximum</p>
            <div class="imageContainer">
                <div class="prev1 prev"><label for="img1"><i class="fas fa-camera"></i></label></div>
                <input type="file" name="img1" id="img1" class="imgs">
                <input type="hidden" name="cimg1" id="cimg1">
                <div class="prev2 prev"><label for="img2"><i class="fas fa-camera"></i></label></div>
                <input type="file" name="img2" id="img2" class="imgs">
                <input type="hidden" name="cimg2" id="cimg2">
                <div class="prev3 prev"><label for="img3"><i class="fas fa-camera"></i></label></div>
                <input type="file" name="img3" id="img3" class="imgs">
                <input type="hidden" name="cimg3" id="cimg3">
                <div class="prev4 prev"><label for="img4"><i class="fas fa-camera"></i></label></div>
                <input type="file" name="img4" id="img4" class="imgs">
                <input type="hidden" name="cimg4" id="cimg4">
            </div>
            <input type="submit" value="Poster votre travail" name="post_btn" class="post-btn">
        </form>
    <?php
        }
    ?>
    <h3 style="margin:auto" class="newZone">Tous les posts</h3>
    <div class="postsContainer">
        <?php
            for($i = 0; $i < count(getSitePost()); $i++){ ?>
            <div class="post" id="pos<?= getSitePost()[$i][0]; ?>">
                <div class="postHeader">
                    <div class="leftSide">
                        <img src="<?= getUser(getSitePost()[$i][1])['profil_pic'] ?>" alt="">
                        <span class="pseudo"><?= getUser(getSitePost()[$i][1])['nom']; ?></span>
                        <span class="email"><?= getUser(getSitePost()[$i][1])['email']; ?></span>
                    </div>
                    <div class="rightSide">
                        <span class="PostedDate"><?= getSitePost()[$i][7]; ?></span>
                    </div>
                </div>
                <div class="postBody">
                    <div class="imgContainer">
                        <?php
                            if(!empty(getSitePost()[$i][6])){
                                echo "<img src='".getSitePost()[$i][6]."'>";
                            }
                            if(!empty(getSitePost()[$i][5])){
                                echo "<img src='".getSitePost()[$i][5]."'>";
                            }
                            if(!empty(getSitePost()[$i][4])){
                                echo "<img src='".getSitePost()[$i][4]."'>";
                            }
                            if(!empty(getSitePost()[$i][3])){
                                echo "<img src='".getSitePost()[$i][3]."'>";
                            }
                        ?>
                    </div>
                    <div class="textContainer">
                        <?= getSitePost()[$i][2]?>
                    </div>
                    <a href="?comment_view=<?= getSitePost()[$i][0]; ?>" class="commentNumber"><?= count(getComments(getSitePost()[$i][0])); ?> commentainers</a>
                </div>
                <div class="postFooter">
                    <?php
                        if(hasLikedPost(getSitePost()[$i][0], $_SESSION['id'])){ ?>
                            <a href="../controller/likepostController.php?like&user_id=<?= getSitePost()[$i][0] ?>&guest_id=<?= $_SESSION["id"]; ?>&pos=<?= getSitePost()[$i][0]; ?>" class="like-btn link-btn" style="background-color: #e74c3c; color: white"><i class="fas fa-heart"></i></a>
                    <?php
                        }else{ ?>
                            <a href="../controller/likepostController.php?like&user_id=<?= getSitePost()[$i][0] ?>&guest_id=<?= $_SESSION["id"]; ?>&pos=<?= getSitePost()[$i][0]; ?>" class="like-btn link-btn"><i class="fas fa-heart"></i></a>        
                    <?php
                        }
                        $id = getSitePost()[$i][0];
                    ?>
                    <a href="?comment=<?= getSitePost()[$i][0]; ?>#pos<?= getSitePost()[$i][0]; ?>" class="comment-btn link-btn"><i class="fas fa-comment"></i></a>
                    <a href="discussion.php?r_id=<?= getUser(getSitePost()[$i][1])['id']; ?>" class="link-btn"><i class="fas fa-paper-plane"></i> Contacter</a>
                </div>
                <?php
                    if(isset($_GET['comment']) && $_GET['comment'] == getSitePost()[$i][0]){ ?>
                    <form method="post" method="" class="commentSection">
                        <input type="hidden" name="user_id" value="<?= getUser(getSitePost()[$i][1])['id'] ?>">
                        <input type="hidden" name="post_id" value="<?= getSitePost()[$i][0] ?>">
                        <input type="text" name="comment" id="comment">
                        <button type="submit" name="commentBtn">commenter</button>
                    </form>
                <?php
                    }
                    if(isset($_GET['comment_view']) && $_GET['comment_view'] == getSitePost()[$i][0]){ ?>
                    <div class="comments">
                        <?php
                            for($j = 0; $j < count(getComments(getSitePost()[$i][0])); $j++){ ?>
                            <div class="commentaire">
                                <div class="cmtheader">
                                    <i class="fas fa-user"></i>
                                    <span class="cmtpseudo"><?= getUser(getComments($id)[$j][2])['nom'] ?></span>
                                </div>
                                <div class="cmtbody">
                                    <?= getComments($id)[$j][4]; ?>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                <?php
                    }
                ?>
            </div>                
            <?php
            }
            ?>
    </div>
    <script src="../resources/all.js"></script>
    <script src="../resources/main.js"></script>
</body>
</html>