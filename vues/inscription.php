<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/connexion.css">
    <title>MyJob - Inscription</title>
</head>
<body>
    <form method="post" action="../controller/loginController.php">
        <div class="from-header">
                <?php 
                    if(isset($_SESSION['error']) and !empty($_SESSION['error'])){ ?>
                     <div class="msg error">
                        <?= $_SESSION['error']?>
                     </div>
                    <?php
                    }
                ?>
            <h1>MyJob</h1>
        </div>
        <div class="form-body">
            <img src="../resources/img/1734511936729.jpg"/>
        </div>
        <div class="form-footer">
        <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Nom" class="form-input" required minlength="3">
            </div>
            <div class="form-group">
                <label for="prenom">Prenom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Prenom" class="form-input" required minlength="3">
            </div>            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="num">Numero de telephone (Exemple: 6xxxxxxxx)</label>
                <input type="text" id="num" name="num_tel" placeholder="Numero de telephone" class="form-input" required pattern="6[0-9]{8}">
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" class="form-input" required minlength="6">
            </div>
            <div class="form-group">
                <label for="cmdp">Confirmation du mot de passe</label>
                <input type="password" name="cmdp" placeholder="Retaper votre mot de passe" id="cmdp" class="form-input" required>
            </div>
            <div class="form-group">
                <input type="submit" value="S'inscrire" name="inscriptionBtn"/>
                <p>J'ai deja un compte ?<a href="../" class="link">Se connecter</a></p>
            </div>                        
        </div>
    </form>    
</body>
</html>