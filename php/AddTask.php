<?php
require_once 'Database.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
    $id = $_POST['ID'];
    $nome = $_POST['nome'];

    //conecta com o BD
    $inst = Database::getInstance();
    $con = $inst->getConnection();
    if($con){
        $sql = "INSERT INTO tasks(codigo_task,nome_task,id_bullet,status) VALUES (DEFAULT,'$nome',$id,0)";
        $result = pg_query($con,$sql);
        echo $sql;
    }else{
        echo "nao conectou";    
    }
    
}
?>