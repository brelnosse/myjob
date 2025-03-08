<?php
    function card($metier, $profile_pic, $prenom, $nom, $user_id, $guest_id){ ?>
        <div class="profil">
        <div class="header">
            <span class="badge"><?= $metier ?></span>
            <img src="<?= $profile_pic ?>" alt="profil picture">
        </div>
        <div class="body">
            <div class="card-name">
                <?= strtoupper($prenom).". ".$nom; ?>
             </div>
             <div class="btn-container">
                <a href="" class="link-btn" title="Voir le profil"><i class="fas fa-eye"></i></a>
                <a href="discussion.php?r_id=<?= $user_id ?>" class="link-btn">Envoyer un message <i class="fas fa-paper-plane" style="margin-left: 5px"></i></a>
                <?php
                    if(hasLiked($user_id, $guest_id)){ ?>
                        <a href="../controller/likeController.php?like&user_id=<?= $user_id; ?>&guest_id=<?= $guest_id; ?>" class="like-btn" style="background-color: #dc3545;color:#ffffff"><i class="fas fa-heart"></i></a>
                <?php
                    }else{ ?>
                        <a href="../controller/likeController.php?like&user_id=<?= $user_id; ?>&guest_id=<?= $guest_id; ?>" class="like-btn"><i class="fas fa-heart"></i></a>
                <?php       
                    }
                ?>
             </div>
        </div>
    </div>     
    <?php   
    }