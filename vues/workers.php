<?php
    session_start();
    require ("../controller/servicesController.php");
    require ("../model/likeModel.php");
    require ("../controller/workersController.php");
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
    <link rel="stylesheet" href="../resources/workers.css">
    <title>MyJob - workers</title>
</head>
<body>
    <nav class="navbar-computer">
        <a href="" class="appName">MyJob</a>
        <div class="menu-items">
            <a href="main.php" class="menu-item">Explorer<i class="fas fa-search" style="margin-left:5px;font-size:1em"></i></a>
            <a href="discussion.php" class="menu-item">Discussions<i class="fas fa-comments" style="margin-left:5px;font-size:1em"></i></a>
            <a href="workers.php" class="menu-item active">Travailleurs <i class="fas fa-users" style="margin-left:5px;font-size:1em"></i></a>
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
    <h2 class="pageTitle"><i class="fas fa-users" style="margin-right:5px;font-size:1em"></i> Travailleurs</h2> 
    <form action="" method="post" class="searchbar-container">
        <input type="search" name="searchbar">
        <input type="submit" value="Lancer" name="searchbtn">
    </form>
    <h3 style="margin: 10px;margin-left: 10px;font-weight:400">Categories</h3>
    <div class="serv-menu" style="justify-content: flex-start;margin-left: 10px">
        <?php
            if(!isset($_GET['categorie'])){ ?>
                <a href="workers.php" class="serv-menu_item active">Tout</a>
                <?php
                    for($i = 0; $i < count(getFreelancersJobs()); $i++){ ?>
                        <a href="?categorie=<?= strtolower(getFreelancersJobs()[$i]); ?>" class="serv-menu_item"><?= getFreelancersJobs()[$i] ?></a>
                    <?php
                    }
            }else{ ?>
                <a href="workers.php" class="serv-menu_item <?= empty($_GET['categorie']) ? 'active' : '' ?>">Tout</a>
                <?php
                    for($i = 0; $i < count(getFreelancersJobs()); $i++){ ?>
                        <a href="?categorie=<?= strtolower(getFreelancersJobs()[$i]); ?>" class="serv-menu_item <?= (trim(strtolower($_GET['categorie'])) == trim(strtolower(getFreelancersJobs()[$i]))) ? "active" :  strtolower($_GET['categorie']); ?>"><?= getFreelancersJobs()[$i] ?></a>
                    <?php
                    }                
                ?>
        <?php
            }
        ?>
    </div>
    <div class="container">
        <?php
            if(isset($_GET['categorie']) && !empty($_GET['categorie'])){
                $freelancers = getFreelancerByMetier($_GET['categorie']);
                for($i = 0; $i < count($freelancers); $i++){ 
                    card($freelancers[$i][7], $freelancers[$i][6], $freelancers[$i][2][0], $freelancers[$i][1], $freelancers[$i][0], $_SESSION['id']);
                }               
            }elseif(isset($_POST['searchbtn'])){
                if(isset($_POST['searchbar']) and !empty($_POST['searchbar'])){
                    $freelancers = getFreelancerBySearch(trim($_POST['searchbar']));
                    for($i = 0; $i < count($freelancers); $i++){ 
                        card($freelancers[$i][7], $freelancers[$i][6], $freelancers[$i][2][0], $freelancers[$i][1], $freelancers[$i][0], $_SESSION['id']);
                    }
                    if(count($freelancers) == 0){
                        echo "rien";
                    }                    
                }else{
                    $freelancers = getFreelancers();
                    for($i = 0; $i < count($freelancers); $i++){ 
                        card($freelancers[$i][7], $freelancers[$i][6], $freelancers[$i][2][0], $freelancers[$i][1], $freelancers[$i][0], $_SESSION['id']);
                    }                   
                }
            }
            else{
                $freelancers = getFreelancers();
                for($i = 0; $i < count($freelancers); $i++){ 
                    card($freelancers[$i][7], $freelancers[$i][6], $freelancers[$i][2][0], $freelancers[$i][1], $freelancers[$i][0], $_SESSION['id']);
                }
            }
        ?>
    </div>
    <script src="../resources/all.js"></script>
</body>
</html> 