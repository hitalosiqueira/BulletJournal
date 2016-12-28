<?php
require_once 'Database.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
    $task = $_POST['id_task'];

    //conecta com o BD
    $inst = Database::getInstance();
    $con = $inst->getConnection();
    if($con){
        $sql = "DELETE FROM tasks WHERE codigo_task = $task";
        $result = pg_query($con,$sql);
        echo $result;

    }else{
        echo "nao conectou";    
    }
    
}
?>