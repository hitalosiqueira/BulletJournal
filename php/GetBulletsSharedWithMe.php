<?php
require_once 'Database.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
if($post){
	$id = $_POST['ID'];
    
	//conecta com o BD
	$db = Database::getInstance();
    $con = $db->getConnection();


    if($con){
    	$consulta = "SELECT * from sharedbullets where id_user ='$id'";
    	$result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
        
    	if (pg_num_fields($result) > 0) {
    		while($row = pg_fetch_assoc($result)) {
                $select = "SELECT * from bullet where codigo_bullet = ". $row['id_bullet']."";
                $re = pg_query($con, $select);
                if (pg_num_fields($re) > 0){
                    while ($linha8 = pg_fetch_assoc($re)){

                        
                    

    			$html .= "<div class=\"bullet\">";
                $html .= "<span class=\"bullet-title toggle\"><i class=\"fa fa-dot-circle-o\"></i> ". $linha8['nome_bullet']."</span>";
                $html .= "<span class=\"expand-collapse\"><i class=\"fa fa-chevron-down\"></i></span>";

                $html .= "<div class=\"toggle-container\">";
                $html .= "<ul class=\"bullet-items\">";

                $tasks = "SELECT * from tasks where id_bullet=".$linha8['codigo_bullet']." order by codigo_task";
                $retorno = pg_query($con,$tasks);
                if(pg_num_fields($retorno)>0){
                    while($linha = pg_fetch_assoc($retorno)){
                        if ($linha['status'] == 1) {
                        $html .= "<li>".$linha['nome_task']." <span class=\"inline-button\"></span></li>";            
                        }
                        else                    
                        $html .= "<li>".$linha['nome_task']." <span class=\"inline-button\"></span></li>";         
                    }
                }else{
                    $html .= "<p class=\"comments-mock\">Você não tem tasks ainda :(</p>";
                }
                
                $html .= "</ul>";
                $html .= "<br></br>";
                
                
                $html .= "<span class=\"bullet-title secondary\">Comentários:</span>";

                $cmts = "SELECT c.*,u.nome from comments c, usuario u where id_bullet=".$linha8['codigo_bullet']." and c.id_owner = u.id";
                $retorno2 = pg_query($con,$cmts);
                if(pg_num_fields($retorno2)>0){
                    while($linha2 = pg_fetch_assoc($retorno2)){
                        
                        $html .= "<p class=\"comments-mock\">".$linha2['comment']." - ".$linha2['nome']."</p>";
                    }
                }else{
                    $html .= "<p class=\"comments-mock\">Você não tem comentarios ainda :(</p>";
                }

                $html .= "<br></br>";

                $html .= "<p class=\"comments-mock\"><b>Adicionar Comentários</b></p>";
                $html .= "<input type = \"text\" name = \"comments\" id=comment".$linha8['codigo_bullet']."><span><span class=\"inline-button\">&nbsp;<i class=\"fa fa-plus\" id=btncomment".$linha8['codigo_bullet']."></i></span>";

                $html .= "<br></br>";
                $html .= "<br></br>";

                $friends = "SELECT u.nome from usuario u, bullet b where b.id_owner = u.id and b.codigo_bullet = ". $row['id_bullet']." ";
                $retorno3 = pg_query($con,$friends);
                $html .= "<span class=\"bullet-title secondary\"<b>Dono do Bullet:</b></span>";
                if(pg_num_fields($retorno3)>0){
                    $linha3 = pg_fetch_assoc($retorno3);
                    $html .= "<p><i class=\"fa fa-user\" style=\"color:green;\">&nbsp;</i>".$linha3['nome']."<span class=\"inline-button\">&nbsp;</span></p>";
                }else{
                    $html .= "<p class=\"comments-mock\">Você não tem amigos no app :(</p>";
                }
                
                $html .= "</div>"; 
                $html .= "</div>"; 
                
    		
                }
               }     
            } //Fechando o 1o Wlihe
    	} // Fechando o 1o IF

    	echo $html;
    }
    else{
        echo "erro de conexao";
    }

}

?>