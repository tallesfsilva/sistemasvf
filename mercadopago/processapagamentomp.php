<?php 
ob_start();
session_start();
require('../_app/Config.inc.php');
$site = HOME;

require_once('vendor/autoload.php');

try{

//Criar tabela para credenciais
MercadoPago\SDK::setAccessToken($texto['accesstoken']);
 

  $userId = $_SESSION['userlogin']['user_id'];	
	 
 
	$lerbanco->FullRead("select * from ws_empresa WHERE binary user_id = :userId", "userId={$userId}");
	

	if (!$lerbanco->getResult()){	
		 
		// header("Location: {$site}");
	}else{
		foreach ($lerbanco->getResult() as $i):
			extract($i);
		endforeach;
  }


$lerbanco->FullRead("select * from ws_users WHERE user_id = :user", "user={$userId}");
		if (!$lerbanco->getResult()){
		 
		}else{
			foreach ($lerbanco->getResult() as $j):
				extract($j);
			endforeach;	
		}
			

 
$description = $_REQUEST["description"];
$totalAmount = $_REQUEST['transactionAmount'];

 
 
 
$new_datetime = date('Y-m-d\TH:i:s.vP', strtotime('30 minutes'));
 

$payment = new MercadoPago\Payment();
$payment->transaction_amount = $totalAmount;
$payment->date_of_expiration = $new_datetime; 
$payment->description = $texto['nome_site_landing'].' - '.$description;
$payment->payment_method_id = "pix";
 
$payment->payer = array(
     "email" => $user_email,
     "first_name" => $user_name,
     "last_name" => $user_lastname,
     "identification" => array(
         "type" => "CPF",
         "number" => $user_cpf
      ),
     "address"=>  array(
         "zip_code" => $cep_empresa,
         "street_name" => $end_rua_n_empresa,
        // "street_number" => "3003",
         "neighborhood" => $end_bairro_empresa,
         "city" => $cidade_empresa,
         "federal_unit" => $end_uf_empresa
      )
   );
 
    $payment->save();
   
   
   
   
    $date_of_expiration =  date("Y-m-d\TH:i:s.vP", strtotime($payment->date_of_expiration));
    $data_created = date("Y-m-d\TH:i:s.vP", strtotime($payment->date_created));
     
   
    if($payment->status == "pending" && $payment->id){


      $array_mensalidades['id_mercado_pago']=$payment->id;
      $array_mensalidades['plano_user']=$description;
      $array_mensalidades['valor_plano']=(string)$payment->transaction_amount;
      $array_mensalidades['id_user']=$userId;
      $array_mensalidades['status_pagamento']=$payment->status ;
      $array_mensalidades['data_expiracao_pix']=$date_of_expiration;
      $array_mensalidades['data_criacao']=$data_created;
      $array_mensalidades['qr_code_base64']=$payment->point_of_interaction->transaction_data->qr_code_base64;
      $array_mensalidades['qr_code']=$payment->point_of_interaction->transaction_data->qr_code;
      $addbanco->ExeCreate("ws_mensalidades", $array_mensalidades);

      if ($addbanco->getResult()){
        $_SESSION['qr_code_base64'] = $payment->point_of_interaction->transaction_data->qr_code_base64;
        $_SESSION['qr_code'] = $payment->point_of_interaction->transaction_data->qr_code;
        $_SESSION['id_payment'] = $payment->id;
        $_SESSION['status'] = $payment->status;
        $_SESSION['paymentScreen'] = true;
        $_SESSION['plano']  = $description;
        $_SESSION['amount'] = $totalAmount;
        $_SESSION['date_of_expiration'] = $payment->date_of_expiration;       
      
        header("Location: {$site}renovacao"); 
    

      }

    }
 

  
   
  }catch (Exception $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}


ob_end_flush();