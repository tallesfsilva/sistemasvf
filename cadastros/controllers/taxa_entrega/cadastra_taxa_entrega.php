<?php 
session_start();
require('../../../_app/Config.inc.php');
$site = HOME;


try{

$userlogin = $_SESSION['userlogin'];
$res['msg'] = "";
$res['success'] = false;
$inputTaxaEntrega= filter_input_array(INPUT_POST, FILTER_DEFAULT);
 
if(!empty($inputTaxaEntrega) && !empty($inputTaxaEntrega['cadastrataxa'])){
	unset($inputTaxaEntrega['cadastrataxa']);

	if (in_array('', $inputTaxaEntrega) || in_array('null', $inputTaxaEntrega)){
	$res['msg']  = "<div class=\"alert alert-info alert-dismissable\"> 
	Por favor preencha os campos!
	</div>";
	$res['success'] = false;
	$res['error'] = true;
	echo json_encode($res);	 

}else{
	$lerbanco->ExeRead('bairros_delivery', "WHERE user_id = :userid AND (uf = :u AND cidade = :c AND bairro = :v)", "userid={$userlogin['user_id']}&u={$inputTaxaEntrega['uf']}&c={$inputTaxaEntrega['cidade']}&v={$inputTaxaEntrega['bairro']}");
	 
	if ($lerbanco->getResult()){
		$res['msg'] = "<div class=\"alert alert-info alert-dismissable\">		
		Já existe um bairro cadastrado este nome!.
		</div>";
		$res['success'] = false;
		$res['error'] = true;
		echo json_encode($res);
	
	}else{	 
		 
		$inputTaxaEntrega['bairro'] = tratar_nome($inputTaxaEntrega['bairro']);
  		$inputTaxaEntrega['taxa'] = Check::Valor($inputTaxaEntrega['taxa']);

 		
		$inputTaxaEntrega['user_id']= $userlogin['user_id'];
		$inputTaxaEntrega['bairro']= strtoupper($inputTaxaEntrega['bairro']);
		$addbanco->ExeCreate("bairros_delivery", $inputTaxaEntrega);
		if ($addbanco->getResult()){                                            
			$res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
			
			 Forma de pagamento cadastrada com sucesso!.
			</div>";     
			$res['success'] = true;
			$res['error'] = false;
			echo json_encode($res);
		 
		 
		}else{
			$res['msg'] =  "<div class=\"alert alert-danger alert-dismissable\">			
			<b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
			</div>";  
			
			$res['success'] = true;
			$res['error'] = false;
			echo json_encode($res);
		};
	};

};



};

}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
 
  
  ?>