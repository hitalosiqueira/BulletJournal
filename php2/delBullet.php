<?php
require_once 'DatabaseT.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
    $bullet = $_POST['id_bullet'];

    //conecta com o BD
    $inst = DatabaseT::getInstance();
    $con = $inst->getConnection();
    if($con){
        $sql = "DELETE FROM bullet WHERE codigo_bullet= $bullet";
        $result = pg_query($con,$sql);
        echo $result;

    }else{
        echo "nao conectou";    
    }
    
}
?>