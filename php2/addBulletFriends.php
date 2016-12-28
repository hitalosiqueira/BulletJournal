<?php
require_once 'DatabaseT.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
    $id = $_POST['ID'];
    $bullet = $_POST['id_bullets'];

    //conecta com o BD
    $inst = DatabaseT::getInstance();
    $con = $inst->getConnection();
    if($con){
        $update = "UPDATE bullet SET shared = 1 WHERE codigo_bullet= $bullet";
        $result = pg_query($con,$update);

        $sql = "INSERT INTO sharedbullets(id_user,id_bullet) VALUES ('$id',$bullet)";

        $result = pg_query($con,$sql);



    }else{
        echo "nao conectou";    
    }
    
}
?>