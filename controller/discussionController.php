<?php
function clean($field){
    $field = trim($field);
    $field = htmlspecialchars($field);

    return $field;
}
function getUser($id){
    require "../model/config.php";
    $id = clean($id);
    $q = $bdd->prepare("SELECT * FROM users WHERE id = ?");
    $q->execute(array($id));

    if($q->rowCount() > 0){
        return $q->fetch();
    }else{
        return false;
    }
}
function getContacts($user_id){
    require "../model/config.php";

    $q = $bdd->query("SELECT * FROM contact WHERE user_id = ".$user_id." or receiver_id = ".$user_id." order by last_talk desc");
    $arr1 = [];
    $arr2 = [];
    while($dt = $q->fetch()){
        $arr1 = [
            'id' => $dt['id'],
            'user_id' => $dt['user_id'],
            'receiver_id' => $dt['receiver_id'],
            'last_talk' => $dt['last_talk']
        ];
        $arr2[] = $arr1;
    }
    return $arr2;         
}
function addContact($id, $host){
    require "../model/config.php";

    $q = $bdd->prepare("SELECT * FROM contact WHERE receiver_id = ? and user_id = ?");
    $q->execute(array($id, $host));

    if($q->rowCount() == 0){
        $add = $bdd->prepare("INSERT INTO contact(user_id, receiver_id, last_talk) values(?, ?, NOW())");
        $add->execute(array($host, $id));
    }else{
        $add = $bdd->prepare("UPDate contact SET last_talk = NOW() WHERE user_id = ? and receiver_id = ?");
        $add->execute(array($host, $id));
    }
}
function getLastMsg($user_id, $receiver_id){
    require "../model/config.php";

    $query = "SELECT message FROM message WHERE date_env IN (SELECT MIN(date_env) FROM message) and ((user_id = ? and receiver_id = ?) or (user_id = ? and receiver_id = ?))";
    $q = $bdd->prepare($query);
    $q->execute(array($user_id, $receiver_id, $receiver_id, $user_id));

    if($q->rowCount() == 0){
        return "vide";
    }else {
        return $q->fetch()["message"];
    }
}
function getLastMsgTime($user_id, $receiver_id){
    require "../model/config.php";

    $query = "SELECT date_env FROM message WHERE date_env IN (SELECT MIN(date_env) FROM message) and ((user_id = ? and receiver_id = ?) or (user_id = ? and receiver_id = ?))";
    $q = $bdd->prepare($query);
    $q->execute(array($user_id, $receiver_id, $receiver_id, $user_id));

    if($q->rowCount() == 0){
        return "";
    }else {
        $dateTime = new DateTime($q->fetch()["date_env"]);
        $dateTime = $dateTime->format('H:i');
        return $dateTime;
    }
}
function getMsgs($user_id, $receiver_id){
    require "../model/config.php";

    $query = "SELECT * FROM message user_id = ? and receiver_id = ?";
    $q = $bdd->prepare($query);
    $q->execute(array($user_id, $receiver_id));
    $arr1 = [];
    $arr2 = [];

    if($q->rowCount() == 0){
        return "vide";
    }else {
        $arr1 = [];
        $arr2 = [];
        while($dt = $q->fetch()){
            $arr1 = [
                'id' => $dt['id'],
                'user_id' => $dt['user_id'],
                'receiver_id' => $dt['receiver_id'],
                'message' => $dt['message'],
                'date_env' => $dt['date_env']
            ];
            $arr2[] = $arr1;
        }
        return $arr2;      
    }    
}