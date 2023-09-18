<?php

session_start();
require('../_app/Config.inc.php');
require_once('../mercadopago/vendor/autoload.php');

$site = HOME;
 
try{
	MercadoPago\SDK::setAccessToken($texto['accesstoken']);
 
	$idPayment = $_GET['q'];
	$message = "";	 

	 
	$cancel =filter_input(INPUT_GET, 'pc', FILTER_VALIDATE_BOOLEAN);
	
	if(!empty($cancel) && $cancel && (int) $idPayment){
		$payment = MercadoPago\Payment::find_by_id($idPayment);	
		
		// $current_time = time();		 
		// $new_datetime = date('Y-m-d\TH:i:s.vP', time());
		
		 
		$payment->status = "cancelled";		
		$payment->status_detail = "expired";	
		 
		$payment->update(); 
		$userId = $_SESSION['userlogin']['user_id'];	
		$deletbanco->ExeDelete("ws_mensalidades", "WHERE id_user = :userid AND status_pagamento = 'pending'", "userid={$userId}");
		unset($_SESSION['hasShowed']);		 
		unset($_SESSION['qr_code_base64']);
		unset($_SESSION['qr_code']);
		unset($_SESSION['id_payment']);
		unset($_SESSION['status']);
		unset($_SESSION['paymentScreen']);
		unset($_SESSION['plano']);
		unset($_SESSION['amount']);
		 

		header("Location: $site");  

	}
	 
	if(!empty($idPayment)  && (int)$idPayment){ 
		$payment = MercadoPago\Payment::find_by_id($idPayment);		 
		if($payment->status == "approved" && $payment->id == $idPayment){
			$message = "O pagamento foi aprovado!";
			$_SESSION['statusPayment'] = $payment->status;
			$_SESSION['date_approved'] = $payment->date_approved;
			$response = array('error'=> false, 'message' =>$message, "paymentPaid"=> true, 'paymentStatus' => $payment->status);
			header("Content-Type: application/json");
			http_response_code(200);
			echo json_encode($response);
		}else if ($payment->status == "pending" && $payment->id == $idPayment){			 
			$message = "O pagamento não foi aprovado!";
			header("Content-Type: application/json");
			http_response_code(200);
			$response = array('error'=> true, 'message' =>$message, "paymentPaid"=> false, 'paymentStatus' => $payment->status);
			echo json_encode($response);
		}
	}else{
		$message = "Não foi possível encontrar os dados do pagamento";
		$response = array('error'=> true, 'message' =>$message);
		header("Content-Type: application/json");
		http_response_code(200);
		echo json_encode($response);
	}



}catch (Exception $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
ob_end_flush();

?>

 
