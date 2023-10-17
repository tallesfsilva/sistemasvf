<?php 
 session_start();
require('../../../_app/Config.inc.php');


try{
$atualizaFormas = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$site = HOME;

$res['msg'] = "";
$res['success'] = false;
$userlogin = $_SESSION['userlogin'];
 

if(!empty($atualizaFormas) && isset($atualizaFormas['id_f_pagamento']) && isset($atualizaFormas['updateforma'])){
		
	
	
	$lerbanco->ExeRead('ws_formas_pagamento', "WHERE user_id = :userid AND f_pagamento = :nome", "userid={$userlogin['user_id']}&nome={$atualizaFormas['f_pagamento']}");
	if ($lerbanco->getResult()){
		$res['msg'] = "<div class=\"alert alert-info alert-dismissable\">		
		Já existe uma forma de pagamento com este nome!.
		</div>";
		$res['success'] = false;
		$res['error'] = true;
		echo json_encode($res);
	
	}else {	
		unset($atualizaFormas ['updateforma']);
	 
		$atualizaFormas  = array_map('strip_tags', $atualizaFormas );
		$atualizaFormas  = array_map('trim', $atualizaFormas ); 
		$atualizaFormas['f_pagamento'] = strtoupper($atualizaFormas['f_pagamento']);
  
	if (in_array('', $atualizaFormas ) || in_array('null', $atualizaFormas )){
			$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			
			Por favor preencha o campo forma de pagamento!
			</div>";
			$res['success'] = false;
			$res['error'] = true;
			echo json_encode($res);

 
}else{
	
	 
	 
		 
		
		$updatebanco->ExeUpdate("ws_formas_pagamento",$atualizaFormas, "WHERE user_id = :userid AND id_f_pagamento = :idfp", "userid={$userlogin['user_id']}&idfp={$atualizaFormas['id_f_pagamento']}");
		if ($updatebanco->getResult()){                                            
			$res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
			
			</b> Forma de pagamento atualizada!.
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
 

}
	
};



};

}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
 
  
  ?>