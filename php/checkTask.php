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
        $update = "UPDATE tasks SET status = 1 WHERE codigo_task= $task";
        $result = pg_query($con,$update);
        echo $result;

    }else{
        echo "nao conectou";    
    }
    
}
?>