<?php
require_once 'Database.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
    $id = $_POST['ID'];
    $comment = $_POST['cmt'];
    $id_o = $_POST['idOwner'];

    //conecta com o BD
    $inst = Database::getInstance();
    $con = $inst->getConnection();
    if($con){
        $sql = "INSERT INTO comments(codigo_comment,comment,id_bullet,id_owner) VALUES (DEFAULT,'$comment',$id,'$id_o')";
        $result = pg_query($con,$sql);
        echo $sql;
    }else{
        echo "nao conectou";    
    }
    
}
?>