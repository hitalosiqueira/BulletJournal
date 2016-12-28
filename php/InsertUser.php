<?php
require_once 'Database.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
	$id = $_POST['ID'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$photoLink = $_POST['photo_link'];

	//conecta com o BD
    $inst = Database::getInstance();
    $con = $inst->getConnection();
    if($con){
            //query de busca no banco
            $consulta = "SELECT COUNT(id) as valor from usuario where id='$id'";
            //execucao da query
            $result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n");
            $count = pg_fetch_assoc($result);
            if ($count['valor'] == 0) {
            	$sql = "INSERT INTO usuario(id,nome,email,link_photo) VALUES ('$id','$nome','$email','$photoLink')";
            	$result = pg_query($con,$sql);
            	if(!$result){
            		echo "deu ruim";
            	}else{
            		echo "deu bom";
            	}
            }
            echo $sql;
	}else{
		echo "nao conectou";	
	}
	
}
?>