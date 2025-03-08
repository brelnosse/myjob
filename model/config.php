<?php

try{
    $bdd = new PDO("mysql:host=localhost;dbname=myjob","root","");
}catch(PDOException $e){
    die("Erreur :".$e->getMessage());
}