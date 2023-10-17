<?php
session_start();
require('../../../_app/Config.inc.php');


try{

$site = HOME;


$userlogin = $_SESSION['userlogin'];
$idcupom = $_POST['iddocupom'];
 $res['msg'] = "";
$res['success'] = false;


$lerbanco->ExeRead("cupom_desconto", "WHERE user_id = :iduser AND mostrar_site = :mostrarcupom", "iduser={$userlogin['user_id']}&mostrarcupom=1");
if(!$lerbanco->getResult()){
////////////////////////////
	$updatemostrar['mostrar_site'] = 1;
	$updatebanco->ExeUpdate("cupom_desconto", $updatemostrar, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$idcupom}");
	if(!$updatebanco->getResult()){
			$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			Ocorreu um erro no processamento
			</div>";
			$res['success'] = false;
			$res['error'] = true;
	echo json_encode($res);
	}else{
		$res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
		<b class=\"alert-link\">SUCESSO! </b> Cupom foi atualizado e aparecerá no site!.
		</div>";     
		$res['success'] = true;
		$res['error'] = false;
		echo json_encode($res);
	};
//////////////////////////
}else{ // SE NÃO FAZ ISSO:

$getid = $lerbanco->getResult();
$idatualizazero = $getid[0]['id_cupom'];

if($idatualizazero == $idcupom){
	$updatezerom['mostrar_site'] = 0;
	$updatebanco->ExeUpdate("cupom_desconto", $updatezerom, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$idcupom}");
	if(!$updatebanco->getResult()){
		$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			Ocorreu um erro no processamento
			</div>";
			$res['success'] = false;
			$res['error'] = true;
	}else{
		$res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
		<b class=\"alert-link\">SUCESSO! </b> Cupom foi atualizado e aparecerá no site!.
		</div>";     
		$res['success'] = true;
		$res['error'] = false;
		echo json_encode($res);
	};
	
}else{

	$updatezero['mostrar_site'] = 0;
	$updatebanco->ExeUpdate("cupom_desconto", $updatezero, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$idatualizazero}");
	if(!$updatebanco->getResult()){
		$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
		Ocorreu um erro no processamento
		</div>";
		$res['success'] = false;
		$res['error'] = true;
	}else{
		$novonumeroum['mostrar_site'] = 1;
		$updatebanco->ExeUpdate("cupom_desconto", $novonumeroum, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$idcupom}");
		if(!$updatebanco->getResult()){
			$res['msg']  = "<div class=\"alert alert-info alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			Ocorreu um erro no processamento
			</div>";
			$res['success'] = false;
			$res['error'] = true;
		}else{
				$res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
				<b class=\"alert-link\">SUCESSO! </b> Cupom foi atualizado e aparecerá no site!.
				</div>";     
				$res['success'] = true;
				$res['error'] = false;
				echo json_encode($res);
		};

	};
	

};

}

}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }