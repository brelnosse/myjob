<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/connexion.css">
    <title>MyJob - Connexion</title>
</head>
<body>
    <form method="post" action="controller/loginController.php">
        <div class="from-header">
            <?php 
                if(isset($_SESSION['error']) and !empty($_SESSION['error'])){ ?>
                    <div class="msg error">
                        <?= $_SESSION['error']; ?>
                    </div>
                <?php
                }else{
                    if(isset($_GET['connexion_ok'])){ ?>
                        <div class="msg success">
                            <?= "Inscription reussi !!. Connectez-vous avant d'acceder a l'application." ?>
                        </div>
                <?php
                    }
                }
            ?>         
            <h1>
                <?php
                    if(isset($_GET['connexion_ok'])){
                        echo "Connectez-vous.";
                    }else{
                        echo "Bon retour";
                    }
                ?>
            </h1>
        </div>
        <div class="form-body">
            <img src="resources/img/1734511936729.jpg"/>
        </div>
        <div class="form-footer">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="email">Mot de passe</label>
                <input type="password" name="mdp" placeholder="Mot de passe" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Se connecter" name="connectionBtn"/>
                <p>Je n'ai pas de compte ?<a href="vues/inscription.php" class="link">S'inscrire</a></p>
            </div>                        
        </div>
    </form>
</body>
</html>