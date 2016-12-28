<?php
require_once 'DatabaseT.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
    $id = $_POST['ID'];
    $nome = $_POST['nome'];

    //conecta com o BD
    $inst = DatabaseT::getInstance();
    $con = $inst->getConnection();
    if($con){
        $sql = "INSERT INTO bullet(codigo_bullet,nome_bullet,id_owner,shared) VALUES (DEFAULT,'$nome','121282945026474',0)";
        $result = pg_query($con,$sql);

    }else{
        echo "nao conectou";    
    }
    
}
?>