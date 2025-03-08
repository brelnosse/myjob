<?php
session_start();

// Vérifiez que le formulaire a été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    if (isset($_POST['operator']) && !empty($_POST['operator']) && isset($_POST['num_tel']) && !empty($_POST['num_tel'])) {
        
        if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
            $curl = curl_init();
            
            $url = 'https://mesomb.hachther.com/api/v1.0/payment/online/';
            $appKey = '8a09e0daa19bc425b1cfb002f226c82097fa57e1';
            $data = array(
                'amount' => 50,
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
            
            if ($err) {
                if (isset($_SESSION['transaction_result'])) {
                    unset($_SESSION['transaction_result']);
                }
                $_SESSION['paiement_error'] = "<b>Erreur:</b> ".$err;
                header("Location: ../vues/paiement.php");
                exit();
            } else {
                if (isset($_SESSION['paiement_error'])) {
                    unset($_SESSION['paiement_error']);
                }
                $responseData = json_decode($response, true);
                if (isset($responseData['success']) && $responseData['success'] === true) {
                    $_SESSION['transaction_result'] = "<b>Succès:</b> transaction réussie !!";   
                    header("Location: ../vues/paiement.php");
                    exit();
                } else {
                    $_SESSION['transaction_result'] = "Une erreur inattendue est survenue.";
                    header("Location: ../vues/paiement.php");
                    exit();
                }
            }            
        }
    }
}
?>