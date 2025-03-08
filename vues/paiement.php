<?php
    require "../controller/loginController.php";
    require "../controller/servicesController.php";
    require "../model/config.php";
    if(!isset($_SESSION['id'])){
        header("location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/paiement.css">
    <title>Paiement - MyJob</title>
</head>
<body>
    <nav class="goToappMenu">
        <a href="messervices.php" class="arrowLeft"><i class="fas fa-arrow-left"></i></a>
    </nav>
    <form class="container" method="post" action="">
        <?php
            if (isset($_POST['pay'])) {
                if (isset($_POST['operator']) && !empty($_POST['operator']) && isset($_POST['num_tel']) && !empty($_POST['num_tel'])) {
                    
                    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                        $curl = curl_init();
                        
                        $url = 'https://mesomb.hachther.com/api/v1.0/payment/online/';
                        $appKey = '8a09e0daa19bc425b1cfb002f226c82097fa57e1';
                        $data = array(
                            'amount' => 10,
                            'payer' => '237'.htmlspecialchars($_POST['num_tel']),
                            'fees' => true,
                            'service' => strtoupper(trim(htmlspecialchars($_POST['operator']))),
                            'currency' => 'XAF',
                            'message' => "Message",
                            'country' => 'CM'
                        );
                        
                        curl_setopt_array($curl, [
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => json_encode($data),
                            CURLOPT_HTTPHEADER => [
                                "Accept: application/json",
                                "Content-Type: application/json",
                                "User-Agent: Mozilla",
                                "X-MeSomb-Application: {$appKey}"
                            ],
                        ]);
                        
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        
                        curl_close($curl);
                        
                        if ($err) { ?>
                        <div class="msg error">
                            <b>Erreur: </b><?= $err ?>
                        </div>
                        <?php
                        } else {
                            $responseData = json_decode($response, true);
                            if (isset($responseData['success']) && $responseData['success'] === true) { 
                                if(isSuscriber($_SESSION['id'])){
                                    $q = $bdd->prepare("update abonne SET user_id = ?, montant = 1000, num_tel=?, date_debut_abnmt = CURDATE(), date_fin_abnmt = DATE_ADD(CURDATE(), INTERVAL 1 MONTH)");
                                    $q->execute(array($_SESSION['id'], getUser($_SESSION['id'])['num_tel'])); ?>
                                    <div class="msg success">
                                        <b>Succes:</b> Souscription renouveller avec succes !!
                                    </div>    
                                <?php                          
                                }else{ 
                                    $q = $bdd->prepare("INSERT INTO abonne(user_id, montant, num_tel, date_debut_abnmt, date_fin_abnmt) VALUES(?, 1000,?, CURDATE(),DATE_ADD(CURDATE(), INTERVAL 1 MONTH))");
                                    $q->execute(array($_SESSION['id'], getUser($_SESSION['id'])['num_tel']));
                                    ?>
                                        <div class="msg success">
                                            <b>Succes:</b> transaction reussi !!
                                        </div>    
                                    <?php
                                }
                            } else { ?>
                                <div class="msg error">
                                    Une erreur inattendue est survenue.
                                </div>  
                            <?php
                            }
                        }            
                    }
                }
            }
        ?>
        <h2 style="text-align: center">abonnement mensuel a<br> MyJob</h2>
        <div class="pay_methods">
            <div class="meth">
                <img src="../resources/img/momo.png" alt="logo mtn momo">
                <span>
                    <input type="radio" id="mtn" value="mtn" name="operator" checked>
                    <label for="mtn">MTN Mobile Money(mtn momo)</label>                    
                </span>
            </div>
            <div class="meth">
                <img src="../resources/img/om.png" alt="logo orange money">
                <span>
                    <input type="radio" id="orange" value="orange" name="operator">
                    <label for="orange">orange money (om)</label>                
                </span>
            </div>
        </div>
        <div class="inputs">
            <div class="input-group">
                <label for="amount">Montant (FCFA):</label>
                <input type="text" name="amount" value="1000" disabled required pattern="1000">
            </div>
            <div class="input-group">
                <label for="amount">Numero de telephone (ex: 6xxxxxxxx):</label>
                <input type="text" value="<?= getUser($_SESSION['id'])['num_tel'] ?>" name="num_tel" pattern="6[0-9]{8}" required>
            </div>
            <div class="input-group">
                <input type="submit" value="Payer" name="pay">
            </div>
        </div>
    </form>
    <script src="../resources/all.js"></script>
    <script src="../resources/paiement.js"></script>
</body>
</html>