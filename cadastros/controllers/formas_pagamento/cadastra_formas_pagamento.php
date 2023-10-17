<?php 
session_start();
require('../../../_app/Config.inc.php');
$site = HOME;


try{

$userlogin = $_SESSION['userlogin'];
$res['msg'] = "";
$res['success'] = false;
$inputFormasPagamento= filter_input_array(INPUT_POST, FILTER_DEFAULT);
 
if(!empty($inputFormasPagamento) && !empty($inputFormasPagamento['cadastraformas'])){
	unset($inputFormasPagamento['cadastraformas']);

	if (in_array('', $inputFormasPagamento) || in_array('null', $inputFormasPagamento)){
	$res['msg']  = "<div class=\"alert alert-info alert-dismissable\"> 
	Por favor preencha o campo forma de pagamento!!!!
	</div>";
	$res['success'] = false;
	$res['error'] = true;
	echo json_encode($res);	 

}else{
	
	$lerbanco->ExeRead('ws_formas_pagamento', "WHERE user_id = :userid AND f_pagamento = :nome", "userid={$userlogin['user_id']}&nome={$inputFormasPagamento['f_pagamento']}");
	if ($lerbanco->getResult()){
		$res['msg'] = "<div class=\"alert alert-info alert-dismissable\">		
		Já existe uma forma de pagamento com este nome!.
		</div>";
		$res['success'] = false;
		$res['error'] = true;
		echo json_encode($res);
	
	}else{	 
		$inputFormasPagamento['aceita_entrega']= 1;
		$inputFormasPagamento['user_id']= $userlogin['user_id'];
		$inputFormasPagamento['f_pagamento']= strtoupper($inputFormasPagamento['f_pagamento']);
		$addbanco->ExeCreate("ws_formas_pagamento", $inputFormasPagamento);
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