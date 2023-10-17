<?php
session_start();
require('../../../_app/Config.inc.php');
$site = HOME;
try{

$userlogin = $_SESSION['userlogin'];
$idfp = $_POST['idfp'];
$res['msg'] = "";
$res['success'] = false;

 
if(!empty($idfp) && (int) $idfp){
    $deletbanco->ExeDelete("ws_formas_pagamento", "WHERE user_id = :userid AND id_f_pagamento = :idfp", "userid={$userlogin['user_id']}&idfp={$idfp}");
    if($deletbanco->getResult()){
      $res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
     
      <b class=\"alert-link\"></b> A forma de pagamento foi excluída!.
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
  }else{
    $res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
    Ocorreu um erro no processamento. Por favor tente novamente!
    </div>";
    $res['success'] = false;
    $res['error'] = true;
  }
    
}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }