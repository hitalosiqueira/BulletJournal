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
    	$consulta = "SELECT * from bullet where id_owner ='$id' and shared = '1' order by nome_bullet asc";
    	$result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
        
    	if (pg_num_fields($result) > 0) {
    		while($row = pg_fetch_assoc($result)) {
    			$html .= "<div class=\"bullet\">";
                $html .= "<span class=\"bullet-title toggle\"><i class=\"fa fa-dot-circle-o\"></i> ". $row['nome_bullet']."</span>";
                $html .= "<span class=\"expand-collapse\"><i class=\"fa fa-chevron-down\"></i></span>";

                $html .= "<div class=\"toggle-container\">";
                $html .= "<ul class=\"bullet-items\">";

                $tasks = "SELECT * from tasks where id_bullet=".$row['codigo_bullet']." order by codigo_task";
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

                $cmts = "SELECT c.*,u.nome from comments c, usuario u where id_bullet=".$row['codigo_bullet']." and c.id_owner = u.id";
                $retorno2 = pg_query($con,$cmts);
                if(pg_num_fields($retorno2)>0){
                    while($linha2 = pg_fetch_assoc($retorno2)){
                        
                        $html .= "<p class=\"comments-mock\">".$linha2['comment']." - ".$linha2['nome']."</p>";
                    }
                }else{
                    $html .= "<p class=\"comments-mock\">Você não tem comentarios ainda :(</p>";
                }

                
                $html .= "<br></br>";

                $friends = "SELECT id,nome from usuario order by nome asc";
                $retorno3 = pg_query($con,$friends);
                $html .= "<span class=\"bullet-title secondary\">Compartilhado com:</span>";
                if(pg_num_fields($retorno3)>0){
                    while($linha3 = pg_fetch_assoc($retorno3)){
                        if ($linha3['id'] == $id) {
                            
                        }
                        else{
                            $friendsS = "SELECT count(id_user) as valor from sharedbullets where id_bullet = ".$row['codigo_bullet']." and id_user = '".$linha3['id']."'";
                            $retorno4 = pg_query($con,$friendsS);
                            $count = pg_fetch_assoc($retorno4);
                            if ($count['valor'] == 1){
                                $html .= "<p><i class=\"fa fa-user\" style=\"color:green;\">&nbsp;</i>".$linha3['nome']."<span class=\"inline-button\">&nbsp;</span></p>";
                        
                            }
                            else{            
                            
                            }
                        }
                    }
                }else{
                    $html .= "<p class=\"comments-mock\">Você não tem amigos no app :(</p>";
                }
                
                $html .= "</div>"; 
                $html .= "</div>"; 
                
    		}
    	}

    	echo $html;
    }
    else{
        echo "erro de conexao";
    }

}

?>