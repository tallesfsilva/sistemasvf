<?php 
 session_start();
require('../../../_app/Config.inc.php');


try{
$atualizaTaxa = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$site = HOME;

$res['msg'] = "";
$res['success'] = false;
$userlogin = $_SESSION['userlogin'];
 

if(!empty($atualizaTaxa) && isset($atualizaTaxa['id']) && isset($atualizaTaxa['taxa']) && isset($atualizaTaxa['updatetaxa'])){
		
	 
 
		unset($atualizaTaxa ['updatetaxa']);
	  
		$atualizaTaxa['taxa'] = Check::Valor($atualizaTaxa['taxa']);

  
	if (in_array('', $atualizaTaxa ) || in_array('null', $atualizaTaxa )){
			$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			
			Por favor preencha o campo taxa de entrega!
			</div>";
			$res['success'] = false;
			$res['error'] = true;
			echo json_encode($res);

 
}else{
	
		$updatebanco->ExeUpdate("bairros_delivery",$atualizaTaxa, "WHERE user_id = :userid AND id = :idfp", "userid={$userlogin['user_id']}&idfp={$atualizaTaxa['id']}");
		if ($updatebanco->getResult()){                                            
			$res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">

			</b> Valor da taxa de entrega atualizo com sucesso!.
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

}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
 
  
  ?>