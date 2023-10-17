<?php
session_start();
require('../../../_app/Config.inc.php');
$site = HOME;
try{

$userlogin = $_SESSION['userlogin'];
$idcupom = $_POST['iddocupom'];
$res['msg'] = "";
$res['success'] = false;

 
 

$deletbanco->ExeDelete("cupom_desconto", "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$idcupom}");
    if($deletbanco->getResult()){
      $res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
     
      <b class=\"alert-link\">SUCESSO! </b> Cupom foi excluído!.
      </div>";     
      $res['success'] = true;
      $res['error'] = false;
      echo json_encode($res);
    }else{
      $res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			Ocorreu um erro no processamento
			</div>";
			$res['success'] = false;
			$res['error'] = true;
    }

    
}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }