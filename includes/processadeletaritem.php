<?php 
require('../_app/Config.inc.php');

 
 
$site = HOME;


try{
	   
	
$idItem = $_POST['iditem'];
$idusuario   = $_POST['iduser'];
 

$action = !empty($_POST['action']) ? $_POST['action'] : false;
 
	 

if( is_array($idItem) && count($idItem)>1 && $action) {
	
		foreach($idItem as $item){
		 
            $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$idusuario}&iditem={$item}");
		
		if($lerbanco->getResult()){
			foreach($lerbanco->getResult() as $i){
				extract($i);
			}
            if(file_exists(URL_IMAGE.$img_item) && !is_dir(URL_IMAGE.$img_item)){
                unlink(URL_IMAGE.$img_item);
            }
			
            $deletbanco->ExeDelete("ws_itens", "WHERE user_id = :userid AND id = :iditem", "userid={$idusuario}&iditem={$item}");
          
		}
	 
        }
        if($deletbanco->getResult()){
            $deletbanco->ExeDelete("ws_relacao_tamanho", "WHERE 	id_user = :userid AND id_item = :iditem", "userid={$idusuario}&iditem={$item}");
         
            $res = array("s" => true);  
            echo json_encode($res); 
         }else{
             $res = array("s" => false);  
             echo json_encode($res);
         }
	
}else if (is_array($idItem) && count($idItem)==1 && $action){
		$idProduct = $idItem[0];
        $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$idusuario}&iditem={$idProduct}");
		
		if($lerbanco->getResult()){
			foreach($lerbanco->getResult() as $i){
				extract($i);
			}
            if(file_exists(URL_IMAGE.$img_item) && !is_dir(URL_IMAGE.$img_item)){
                unlink(URL_IMAGE.$img_item);
            }
			
            $deletbanco->ExeDelete("ws_itens", "WHERE user_id = :userid AND id = :iditem", "userid={$idusuario}&iditem={$idProduct}");
            if($deletbanco->getResult()){
               $deletbanco->ExeDelete("ws_relacao_tamanho", "WHERE 	id_user = :userid AND id_item = :iditem", "userid={$idusuario}&iditem={$idProduct}");
            
               $res = array("s" => true);  
               echo json_encode($res); 
            }else{
                $res = array("s" => false);  
                echo json_encode($res);
            }
		}
			
		 		
	
	} else{	 
         
        $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$idusuario}&iditem={$idItem}");
		
		if($lerbanco->getResult()){
			foreach($lerbanco->getResult() as $i){
				extract($i);
			}
            if(file_exists(URL_IMAGE.$img_item) && !is_dir(URL_IMAGE.$img_item)){
                unlink(URL_IMAGE.$img_item);
            }
			
            $deletbanco->ExeDelete("ws_itens", "WHERE user_id = :userid AND id = :iditem", "userid={$idusuario}&iditem={$idItem}");
            if($deletbanco->getResult()){
               $deletbanco->ExeDelete("ws_relacao_tamanho", "WHERE 	id_user = :userid AND id_item = :iditem", "userid={$idusuario}&iditem={$idItem}");
            
               $res = array("s" => true);  
               echo json_encode($res); 
            }else{
                $res = array("s" => false);  
                echo json_encode($res);
            }
		}
	}
	
	

} catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}






 



