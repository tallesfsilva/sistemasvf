<?php
require('../_app/Config.inc.php');
$site = HOME;


try{
	   
	$getId = $_POST['iditem'];
	$iduser = $_POST['iduser'];
	$action = !empty($_POST['action']) ? $_POST['action'] : false;
 
	
	if(is_array($getId) && count($getId)>1 && $action) {
	
		foreach($getId as $item){
		 
			$lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id = :f", "userid={$iduser}&f={$item}");
		
		if($lerbanco->getResult()){
			foreach($lerbanco->getResult() as $i){
				extract($i);
			}
		
			$novoStatus = array();
		
			 if($disponivel == 0){
				 $novoStatus['disponivel'] = 1;
			 }else{
				 $novoStatus['disponivel'] = 0;
			 };
		
			 $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id = :upp", "userid={$iduser}&upp={$item}");
			 
			
			};
		}
		if($updatebanco->getResult()){
			$res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
			<b class=\"alert-link\">Disponiblidade dos produtos atualizada!.
			</div>";
	
	
			$res['success'] = true;
			$res['error'] = false;
			echo json_encode($res);
		}else{
			$res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
			<b class=\"alert-link\">Ocorreu um erro ao atualizar o produto!.
			</div>";
	
	
			$res['success'] = false;
			$res['error'] = true;
			echo json_encode($res);
		}
			
	
	
	}else if (is_array($getId) && count($getId)==1 && $action){
		$idProduct = $getId[0];
		$lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id = :f", "userid={$iduser}&f={$idProduct}");
		if($lerbanco->getResult()){
			foreach($lerbanco->getResult() as $i){
				extract($i);
			}
		
			$novoStatus = array();
		
			 if($disponivel == 0){
				 $novoStatus['disponivel'] = 1;
			 }else{
				 $novoStatus['disponivel'] = 0;
			 };
		
			
			 $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id = :upp", "userid={$iduser}&upp={$idProduct}");
			 if($updatebanco->getResult()){
				$res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
				<b class=\"alert-link\">Disponiblidade do produto atualizada!.
				</div>";
		
		
				$res['success'] = true;
				$res['error'] = false;
				echo json_encode($res);
			}else{
				$res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
				<b class=\"alert-link\">Ocorreu um erro ao atualizar o produto!.
				</div>";
		
		
				$res['success'] = false;
				$res['error'] = true;
				echo json_encode($res);
			}
				
			
			};
		
	
	} else{
	 
			$idProduct = $getId;
			$lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id = :f", "userid={$iduser}&f={$idProduct}");
			if($lerbanco->getResult()){
				foreach($lerbanco->getResult() as $i){
					extract($i);
				}			
				$novoStatus = array();
			
				 if($disponivel == 0){
					 $novoStatus['disponivel'] = 1;
				 }else{
					 $novoStatus['disponivel'] = 0;
				 };		
				
				 $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id = :upp", "userid={$iduser}&upp={$idProduct}");
				 if($updatebanco->getResult()){
					$res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
					<b class=\"alert-link\">Disponiblidade do produto atualizada!.
					</div>";
			
			
					$res['success'] = true;
					$res['error'] = false;
					echo json_encode($res);
				}else{
					$res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
					<b class=\"alert-link\">Ocorreu um erro ao atualizar o produto!.
					</div>";
			
			
					$res['success'] = false;
					$res['error'] = true;
					echo json_encode($res);
				}
							
				};
	}
	
	

} catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
