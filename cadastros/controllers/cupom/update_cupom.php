<?php 
 session_start();
require('../../../_app/Config.inc.php');


try{
$atualizaCupom = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$site = HOME;

$res['msg'] = "";
$res['success'] = false;
$userlogin = $_SESSION['userlogin'];
$flagName = $atualizaCupom['flagName'] == "true" ? true : false;

if(!empty($atualizaCupom) && isset($atualizaCupom['id_cupom']) && isset($atualizaCupom['updatecupom'])){
		
	$lerbanco->ExeRead('cupom_desconto', "WHERE user_id = :userid AND ativacao = :pativacao", "userid={$userlogin['user_id']}&pativacao={$atualizaCupom['ativacao']}");
	
	if ($lerbanco->getResult() && !empty($flagName) && $flagName  ){             

		$res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
		Já existe um cupom com essa ativação! exclua e crie outra com novas propriedades.
		</div>";
		$res['success'] = false;
		$res['error'] = true;  
	   
		echo json_encode($res);
	}else {
	
		unset($atualizaCupom ['updatecupom']);
		unset($atualizaCupom ['flagName']);
		$atualizaCupom  = array_map('strip_tags', $atualizaCupom );
		$atualizaCupom  = array_map('trim', $atualizaCupom ); 

		$atualizaCupom ['data_validade'] = explode("/", $atualizaCupom ['data_validade']);
		$atualizaCupom ['data_validade'] = array_reverse($atualizaCupom ['data_validade']);
		$atualizaCupom ['data_validade'] = implode("-",  $atualizaCupom ['data_validade']);


	if($atualizaCupom ['porcentagem'] == ''){
		(int) $atualizaCupom ['porcentagem'] = 1;
	}elseif((int) $atualizaCupom ['porcentagem'] < 1){
		$atualizaCupom ['porcentagem'] = 1;
	}elseif((int) $atualizaCupom ['porcentagem'] > 100){
		$atualizaCupom ['porcentagem'] = 100;
	}else{ 
		$atualizaCupom ['porcentagem'] = str_replace('.', '', $atualizaCupom ['porcentagem']);
		$atualizaCupom ['porcentagem'] = str_replace(',', '', $atualizaCupom ['porcentagem']);
		$atualizaCupom ['porcentagem'] = (int) $atualizaCupom ['porcentagem'];    
	};

	if($atualizaCupom ['total_vezes'] == ''){
		(int) $atualizaCupom ['total_vezes'] = 1;            
	}else{ 
		$atualizaCupom ['total_vezes'] = str_replace('.', '', $atualizaCupom ['total_vezes']);
		$atualizaCupom ['total_vezes'] = str_replace(',', '', $atualizaCupom ['total_vezes']);
		$atualizaCupom ['total_vezes'] = (int) $atualizaCupom ['total_vezes'];    
	};

	if (in_array('', $atualizaCupom ) || in_array('null', $atualizaCupom )){
			$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			Preencha todos os campos!
			</div>";
			$res['success'] = false;
			$res['error'] = true;
			echo json_encode($res);

	} elseif(!isDateExpired($atualizaCupom ['data_validade'], 1)){
			$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			A data informada já expirou!
			</div>";
			$res['success'] = false;
			$res['error'] = true;
			echo json_encode($res);

}else{
	
	 
	 
		 
		
		$updatebanco->ExeUpdate("cupom_desconto",$atualizaCupom, "WHERE user_id = :userid AND id_cupom = :idCupom", "userid={$userlogin['user_id']}&idCupom={$atualizaCupom['id_cupom']}");
		if ($updatebanco->getResult()){                                            
			$res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			<b class=\"alert-link\">SUCESSO! </b> Cupom atualizado!.
			</div>";     
			$res['success'] = true;
			$res['error'] = false;
			echo json_encode($res);
		 
		 
		}else{
			$res['msg'] =  "<div class=\"alert alert-danger alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			<b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
			</div>";  
			
			$res['success'] = true;
			$res['error'] = false;
			echo json_encode($res);
		};
 

}
	
};



};

}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
 
  
  ?>