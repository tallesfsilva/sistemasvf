<?php
ob_start();
 
session_cache_expire(60);
session_start();

require('../_app/Config.inc.php');
// require('../_app/status_pagamento.php');
 

$site = HOME;
$login = LOGIN; 
 
$Url[1] = (empty($Url[1]) ? null : $Url[1]);

$site = HOME;
$loginUrl = LOGIN;



require_once('../mercadopago/vendor/autoload.php');

 
$userId = $_SESSION['userlogin']['user_id'];	

try{
	$lerbanco->FullRead("select * from ws_mensalidades WHERE id_user = :user and status_pagamento='pending'", "user={$userId}");
    if (!$lerbanco->getResult()){ 
				 
    }else{    
        foreach ($lerbanco->getResult() as $j):
            extract($j);
        endforeach;	
        $date_now = date('Y-m-d-H:i.s');
        $dataPagamento = date('Y-m-d-H:i.s', strtotime($data_criacao));
        $url = $site.'notification?q='.$id_mercado_pago; 
      
        
		MercadoPago\SDK::setAccessToken($texto['accesstoken']);

    
        $payment = MercadoPago\Payment::find_by_id($id_mercado_pago);
        
        if($payment->status == "approved" && $payment->id == $id_mercado_pago){
          
            $_SESSION['statusPayment'] = $payment->status;
            $_SESSION['date_approved'] = $payment->date_approved;
			$_SESSION['plano'] = $plano_user;
			$_SESSION['id_payment'] = $payment->id;
            header("Location: {$site}sucesso?q=true");
        }  
                 
    }

}catch (PDOException $e) {
	echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
	header("Location: {$site}");
}
 

  
 
if(empty($Url[0]) || $Url[0] == 'index'){

	 $Url[0] = 'renovacao';

}
 
	$userId = $_SESSION['userlogin']['user_id'];	
	 
 
	$lerbanco->FullRead("select * from ws_empresa WHERE binary user_id = :userId", "userId={$userId}");
	

	if (!$lerbanco->getResult()){	
		 
		// header("Location: {$site}");
	}else{
		foreach ($lerbanco->getResult() as $i):
			extract($i);
		endforeach;

		 
		 
		$lerbanco->FullRead("select * from ws_users WHERE user_id = :user", "user={$userId}");
		if (!$lerbanco->getResult()){
		 
		}else{
			foreach ($lerbanco->getResult() as $j):
				extract($j);
			endforeach;	
		}
		

		if(empty($Url[0]) || $Url[0] == 'index'){
			$Url[0] = $nome_empresa_link;
	
			}
	 
	}
	 
	$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
	$hasShowed = filter_input(INPUT_GET, 'hasShowed', FILTER_VALIDATE_BOOLEAN);
 
	if(!empty($hasShowed) && $hasShowed == true){
			$_SESSION['hasShowed'] = true;			
			header("Location: {$site}"); 
	}
	
	if(!empty($logoff) && $logoff == true):
		 
	$updateacesso = new Update;
	$dataEhora    = date('d/m/Y H:i');
	$ip           = get_client_ip();
	$string_last = array("user_ultimoacesso" => " Último acesso em: {$dataEhora} IP: {$ip} ");
	$updateacesso->ExeUpdate("ws_users", $string_last, "WHERE user_id = :uselast", "uselast={$userlogin['user_id']}");
 
	unset($_SESSION['userlogin']);
	unset($_SESSION['hasShowed']);		 
	unset($_SESSION['qr_code_base64']);
	unset($_SESSION['qr_code']);
	unset($_SESSION['id_payment']);
	unset($_SESSION['status']);
	unset($_SESSION['paymentScreen']);
	unset($_SESSION['plano']);
	unset($_SESSION['amount']);

	header("Location: {$loginUrl}");
endif;

 
	?>	

	<!DOCTYPE html>
	<!--[if IE 9]><html class="ie ie9"> <![endif]-->
	<html lang="pt-br" style="scroll-behavior: smooth;">
	<head>
		 
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="pizza, delivery food, fast food, sushi, take away, chinese, italian food">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

		<meta name="robots" content="index, fallow" />
		<link rel="canonical" href="<?=$site.$Url[0];?>">
		<meta name="author" content="Alex Silva">
		<meta name="og:title" content="<?=(!empty($nome_empresa) ? 'Cardápio Fácil | '.$nome_empresa : 'Nome_do_seu_negócio');?>" />
		<meta name="og:type" content="website">
		<meta property="og:site_name" content="<?=$texto['nome_site_landing'];?>"/>
		<meta property="og:url" content="<?$site.$nome_empresa_link?>"/>
		<meta property="og:description" content="<?=(!empty($descricao_empresa) ? $descricao_empresa : '');?>" />
		<meta name="description" content="<?=(!empty($descricao_empresa) ? $descricao_empresa : '');?>">
		<meta property="og:image"content="<?=(!empty($img_logo) ? $site.'uploads/'.$img_logo : '')?>"/>

		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<title><?=(!empty($nome_empresa) ? 'Sistema Venda Fácil | '.$nome_empresa : 'Nome_do_seu_negócio');?></title>
		<link rel="shortcut icon" href="../../Imagens/LOGO.ico" type="image/x-icon">
		<!-- Favicons-->
		<link rel="shortcut icon" href="../../Imagens/LOGO.ico" type="image/x-icon">
 
		<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'>

 
		<link href="<?= $site; ?>css/base.css" rel="stylesheet"> 
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'>
 		<link rel="stylesheet" type="text/css" href="<?= $site;?>css/bootstrap.min.css">
 		<link href="<?= $site; ?>css/tailwind.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
		<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">
		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>
		 

 

		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>




		<style type="text/css">
			.container-text{
				font-size:20px;
			}

			.img-renova{
				width:80%; 
				height:50%;
			}
			 .container-buttons-renova{
				 
 
 
				border: 1px solid #A3A3A3;
				margin: 15px;
			 
				padding: 10px;
				border-radius: 20px;	
				height:100% !important; 
				width:350px	 
				 
			 }

			 .buttons-renova{
				
				height: 40px;
				width: 70%;
				border-radius: 20px;
				box-shadow: 0px 3px 15px 0px rgba(0,0,0,0.85);
			 }
			 #btn-continuar:hover{
				background-color: #ffdf80 !important;
				text-decoration:none;
			 }
			 
			 #btn-renovar:hover{
				
				background-color: #7ccf7f  !important;
				text-decoration:none;
			 }
			 .btn_mp_cancelar{
				background-color: white;
				color: black;
				justify-content: center;
				border-radius: 15px;
				margin-top: 6px;
				text-align: center;
				display: flex;
				flex-direction: column;
				align-items: center;
				-webkit-box-shadow: 0px 3px 15px 0px rgba(0,0,0,0.85);
				-moz-box-shadow: 0px 3px 15px 0px rgba(0,0,0,0.85);
				box-shadow: 0px 2px 12px 0px rgba(0,0,0,0.85);
				height: 20px;
				height: 15px;  
  				margin-top: 16px;
				width:180px;
			 }
			 
			 	 
			 #btn-sair:hover{
				background-color: #c78a8a !important;
				text-decoration:none;
			 }
			 @media screen and (orientation:landscape) and (max-width: 1000px ) {
				
				#container_renova{
						height:100%; 
				}	

				.container-buttons-renova{
					width:auto;	 
				}
			} 

			@media screen and (max-width: 1000px ) {
				
				#container_renova{
					 
				}	

				.container-buttons-renova{
					width:auto;	 
				}
			} 
		</style>



		 


		

 
			



		 

 
 
		 
	</head>

<body class="leading-normal tracking-normal  overflow-hidden text-white" style="background-image: url('<?=$site.'/img/bg_1.png'?>'); background-repeat:no-repeat;background-size: cover;">
 

   	 <?php

		
		$lerbanco->FullRead("select * from ws_mensalidades WHERE id_user = :user and status_pagamento='pending'", "user={$userId}");
		if (!$lerbanco->getResult()){
		 
		}else{
			foreach ($lerbanco->getResult() as $j):
				extract($j);
			endforeach;	
			$date_now = date('Y-m-d-H:i.s');
		$dataPagamento = date('Y-m-d-H:i.s', strtotime($data_criacao));
		}
		
		
 
		 

	if(!empty($_SESSION['paymentScreen']) && $_SESSION['paymentScreen'] && !empty($status_pagamento) && $status_pagamento == 'pending' && !empty($id_mercado_pago) && !empty( $qr_code_base64) && 	!empty($qr_code)) {

	?>
	

	 <script src="https://sdk.mercadopago.com/js/v2"></script>
 
 	
	<div id="container_renova"  class="flex items-center justify-center h-screen"> 
	
			<div class="container-menu " style="background-color: white !important; color:black">
						
							<div class="container-buttons-renova text-center" style="margin:7px !important"> 
							<div style="font-size:20px;" class="flex mt-2 flex-row justify-center text-center">
									<div class="flex flex-col">
										<p>Acabamos de enviar os dados<br>de seu pedido para o e-mail</p>
										<span style="color:#7232A0" ><?= $user_email ?></span>

									</div>

										</div>
										<div style="font-size:15px"  class="flex mt-2 flex-row justify-center text-center">
					 
									<div class="flex m-1 self-center">
										<span>Finalize o pagamento usando o Pix!</span>

									</div>
										</div>

							<div style="font-size:12px"  class="flex mt-2 flex-row justify-center text-center">
							<div class="flex m-1 self-center">
									 <p>Você pode utilizar a câmera do seu celular para ler o QR Code ou copiar o código e pagar no aplicativo de seu banco:</p>
								</div>
							</div>
										<div style="font-size:12px"  class="flex mt-2 flex-row justify-center text-center">
												<div class="flex m-1 self-center">
														<img  width="170" height="170" src="data:image/jpeg;base64,<?=$qr_code_base64?>"/>
												</div>
									</div>
									<div style="font-size:20px;line-break:anywhere"  class="flex flex-row justify-center text-center">
									<div class="flex self-center">															 
    											<div style="color:#72329F">
													<h2 >VALOR:  R$ <?= $valor_plano?></h2>
												</div>											 
										</div>										
									</div>
									<div style="font-size:12px;line-break:anywhere"  class="flex mt-2 flex-row justify-center text-center">
									<div style="border: 1px solid #A3A3A3;font-size: 9px;padding: 5px;border-radius: 20px" class="flex m-1 self-center">
															 
    											<div style="color:#72329F">
													<p id="pix_qr" ><?= $qr_code?></p>
												</div>
											 
										</div>
										
									</div>
									<div style="font-size:10px;line-break:anywhere"  class="flex flex-row justify-center text-center">
									<div class="flex self-center">															 
    											<div>
													<p id="pix_qr" >O pagamento pode demorar até 05 minutos para ser processador, por favor não fechar a página</p>
												</div>											 
										</div>										
									</div>
									
								

									 
									<div style="font-size:12px;line-break:anywhere"  class="flex mt-2 flex-row justify-between text-center">
									 
											<div class="flex flex-row">					 
    											<div style="font-size:18px" class="flex mr-1 " style="color:black">
													 <span>Pix Válido:</span>
												
												</div>
												<?php
												$dateNow =  date('Y-m-d H:i:s');
											 
												$to_time = strtotime($data_expiracao_pix);
												$from_time = strtotime($dateNow);
												$expiration = round(abs($to_time - $from_time) / 60)*60;
											 
											 

												?>

												<script src=" https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js "></script>
												  
											 

												<div style="font-size:18px;color:#72329F" class="flex" style="color:black">
													 <span  data-id="<?= $_SESSION['id_payment']?>" data-url="<?=$site ?>"  id="minutes"><?= $expiration/60?>:00</span></span>
													 
												</div>
												</div>

												<div  id="msg_pix" style="padding:5px; background:#00BB07;color:white;border-radius:10px;display:none"  type="button" class="rounded-md cursor-pointer flex-row text-white shadow-lg focus:outline-none focus:shadow-outline flex" >
													

													
												<span>Pix Copiado!</span>	
													 
													</div>
												
												<div style="padding:5px; background:#72329F;color:white;border-radius:10px"  type="button" class="rounded-md cursor-pointer flex-row text-white shadow-lg focus:outline-none focus:shadow-outline flex" >
													

													
													<div id="pix_copy" class="items-center">
															Copiar Código
														</div>
													 
													</div>

													<script></script>
											 
										</div>
										<div class="flex flex-row justify-center">
 										<div id="sair_button" style="background-color: #A70000" class="btn_mp_cancelar  mt-5 p-8">				
											<a href="<?=$site.'notification'?>?q=<?=$id_mercado_pago?>&pc=true">	
											<div class="justify-center">														
														<div class="p-4 text-white leading-tight">															
																<span>Cancelar</span>															
														</div>
												</div>	
												</a>			
											</div>
												</div>
												


										</div>
									</div>
		 			 
		 
			  			</div>
			
							</div>
					 
			</div>
		</div>

  
		</div>
		<script id="noti" data-expiration="<?= $expiration?>" data-id="<?=  $id_mercado_pago?>" data-url="<?=$site ?>" src="js/main.js"></script>
	  
	 
			</div>
	 
<?php }else {
		 
?>
	<?php
    
    if(!empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId):
        $planoUser = $_SESSION['userlogin']['user_plano'];
        $nomeplano = "";
        $valorplano = "";

		$valorplanoMensal = "{$texto['valorPlanoDois']}.00";
		$valorplanoAnual = "{$texto['valorPlanoTres']}.00";

        if($planoUser == 1):
            $nomeplano = $texto['nomePlanoUm'];
            $valorplano = "{$texto['valorPlanoUm']}.00";
        elseif($planoUser == 2):
            $nomeplano = $texto['nomePlanoDois'];
            $valorplano = "{$texto['valorPlanoDois']}.00";
        elseif($planoUser == 3):
            $nomeplano = $texto['nomePlanoTres'];
            $valorplano = "{$texto['valorPlanoTres']}.00";
        endif;

    endif;

    if(diasDatas(date('Y-m-d'), $empresa_data_renovacao) < 0 && !empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId):
      
	   ?>
	    <script src="https://sdk.mercadopago.com/js/v2"></script>
		<script>
  			const mp = new MercadoPago("YOUR_PUBLIC_KEY");
		</script>



		<div id="container_renova" class="flex items-center justify-center h-screen"> 
			
		<div class="container-menu ">
				 
						<div class="container-buttons-renova text-center" style=""> 
								<div class="row">
									<div class="col-md-12">
										<img src="<?=$site ?>img/pngwing_1.png">
									</div>
								</div>
								<form id="form-checkout" action="<?=$site;?>mercadopago/processapagamentomp.php" method="post">
								<div class="row">
									<div class="col-md-12">
										<div class="container-text">
												<p>Que pena, sua assinatura expirou: </p>
												<span class="font-extrabold" ><?=date('d/m/Y', strtotime($empresa_data_renovacao))?></span>
												<p>Escolha um plano para renovar: </p>
										</div>
									</div>
								</div>
								<div class="row">
										<div class="col-md-12">										 
										<select id="amount" required style="background-color: #dddbdb;" name="transactionAmount" class="form-control" >
													<option  value="">Escolha seu Plano</option>													 
													<option data-plano="<?=$texto['nomePlanoDois'];?>"value="<?=$valorplanoMensal;?>"><?=$texto['nomePlanoDois']. " (R$ ".$valorplanoMensal.")";?></option>
													<option data-plano="<?=$texto['nomePlanoTres'];?>"value="<?=$valorplanoAnual;?>"><?=$texto['nomePlanoTres']." (R$ ".$valorplanoAnual.")"?><option>

											</select>
											<input type="hidden" name="description" id="description" value="">
										</div>
								</div>
								<div class="row">
										<div class="col-md-12">
											<div id="btn-renovar"  style="background:#00BB07"id="voltar_button" class="buttons-renova items-center mt-3 mb-2 mx-auto rounded-md cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
												 			
											<div class="w-full ml-2">
															<input class="w-full" id="btn_submit" type="submit" style="font-size:23px;" value="Renovar">
												</div>
											</div>
										</div>
								</div>
							</form>

								<div class="row">
								<a href="<?=$site.$Url[0].'/';?>&logoff=true">
										<div class="col-md-12">
											<div id="btn-sair" style="background:#E20A0A" id="voltar_button" class="buttons-renova items-center m-2 mx-auto cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
												 			
												<div class="w-full ml-2">
													<span style="font-size:23px;">Sair</span>
												</div>
											</div>
										</div>
								</a>
								</div>

								


								</div>
		
						</div>
				 
		</div>
	</div>

	
 

<?php
elseif(diasDatas(date('Y-m-d'), $empresa_data_renovacao) == 0 && !$_SESSION['hasShowed'] &&!empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId):
 
?>
<script src="https://sdk.mercadopago.com/js/v2"></script>
          
<script>
  const mp = new MercadoPago("TEST-1803e629-b6ab-435f-8200-252a7c016cd4");
</script>
		<div id="container_renova" class="flex items-center justify-center h-screen"> 
			
			<div class="container-menu ">
					 
							<div class="container-buttons-renova text-center" style=""> 
									<div class="row">
										<div class="col-md-12">
											<div class="flex w-full justify-center">
												<img  class="img-renova"  src="<?=$site ?>img/aviso_1.png">
											</div>
										</div>
									</div>
									<form id="form-checkout" action="<?=$site;?>mercadopago/processapagamentomp.php" method="post">
										<div class="row">
											<div class="col-md-12">									
												<div class="container-text">
													<p>Sua assinatura expira em breve: </p>
													<span class="font-extrabold"   ><?=date('d/m/Y', strtotime($empresa_data_renovacao))?></span>
													<p>Escolha um plano para renovar: </p>
												</div>										 
											</div>
										</div>
									 
										<div class="row">
												<div class="col-md-12">											 
													<select id="amount" required style="background-color: #dddbdb;" name="transactionAmount" class="form-control" >
															<option  value="">Escolha seu Plano</option>															
															<option data-plano="<?=$texto['nomePlanoDois'];?>"value="<?=$valorplanoMensal;?>"><?=$texto['nomePlanoDois']. " (R$ ".$valorplanoMensal.")";?></option>
															<option data-plano="<?=$texto['nomePlanoTres'];?>"value="<?=$valorplanoAnual;?>"><?=$texto['nomePlanoTres']." (R$ ".$valorplanoAnual.")"?><option>

													</select>
													<input type="hidden" name="description" id="description" value="">
												</div>
										</div>	
										<div class="row">
												<div class="col-md-12">
													<div id="btn-renovar"  style="background:#00BB07"  class="buttons-renova items-center mt-3 mb-2 mx-auto rounded-md cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
																	
														<div class="w-full ml-2">
															<input class="w-full" type="submit" style="font-size:23px;" value="Renovar">
														</div>
													</div>
												</div>
										</div>
								</form>
									<div class="row">
										<a href="<?= $site.$Url[0].'/';?>&hasShowed=true">
											<div class="col-md-12">
												<div id="btn-continuar" style="background:#FFC000"  class="buttons-renova items-center m-2 mx-auto cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
																 
													<div class="w-full ml-2">
														<span style="font-size:23px;">Continuar</span>
													</div>
												</div>
											</div>
											</a>
									</div>
	
								
	
	
									</div>
			
							</div>
					 
			</div>
		</div>
<?php

elseif(diasDatas(date('Y-m-d'), $empresa_data_renovacao) >= 1 && diasDatas(date('Y-m-d'), $empresa_data_renovacao) < 4 && !$_SESSION['hasShowed'] && !empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId):
 
?>
		<div id="container_renova" class="flex items-center justify-center h-screen"> 
			
			<div class="container-menu ">
					 
							<div class="container-buttons-renova text-center" style=""> 
									<div class="row">
										<div class="col-md-12">
										<div class="flex w-full justify-center">
										<img  class="img-renova" src="<?=$site ?>img/aviso_1.png">
											</div>
										<div>
									</div>
									<form id="form-checkout" action="<?=$site;?>mercadopago/processapagamentomp.php" method="post">
										<div class="row">
											<div class="col-md-12">
										 
											<div class="container-text">
													<p>Sua assinatura expira em breve: </p>
													<span class="font-extrabold"   ><?=date('d/m/Y', strtotime($empresa_data_renovacao))?></span>
													<p>Escolha um plano para renovar: </p>
											</div>
								 
										</div>
									</div>
									<div class="row">
											<div class="col-md-12">
											<select id="amount" required style="background-color: #dddbdb;" name="transactionAmount" class="form-control" >
														<option  value="">Escolha seu Plano</option>														 
														<option data-plano="<?=$texto['nomePlanoDois'];?>"value="<?=$valorplanoMensal;?>"><?=$texto['nomePlanoDois']. " (R$ ".$valorplanoMensal.")";?></option>
														<option data-plano="<?=$texto['nomePlanoTres'];?>"value="<?=$valorplanoAnual;?>"><?=$texto['nomePlanoTres']." (R$ ".$valorplanoAnual.")"?><option>

												</select>
												<input type="hidden" name="description" id="description" value="">
											</div>
									</div>
	
									
	
									<div class="row">
											<div class="col-md-12">
												<div   style="background:#00BB07"id="btn-renovar" class="buttons-renova items-center mt-3 mb-2 mx-auto rounded-md cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
																 
													<div class="w-full ml-2">
															<input class="w-full" type="submit" style="font-size:23px;" value="Renovar">
														</div>
												</div>
											</div>
									</div>
									</form>
									<div class="row">
									<a href="<?= $site.$Url[0].'/';?>&hasShowed=true">
											<div class="col-md-12">
												<div style="background:#FFC000" id="btn-continuar" class="buttons-renova items-center m-2 mx-auto cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
																 
													<div class="w-full ml-2">
														<span style="font-size:23px;">Continuar</span>
													</div>
												</div>
											</div>
</a>
									</div>
	
	
									</div>
			
							</div>
					 
			</div>
		</div>
<?php
else:
	 
	 header("Location: {$site}{$nome_empresa_link}/new-home"); 
?>	
<?php 
endif;
?>	
<?php
}
?>

 			
 














 
		</div>
 
		<?php				
 
 if(file_exists('includes/'.$Url[0] . '.php')):
 require 'includes/'.$Url[0] . '.php';					 
  
 endif;
 ?>
				 
<script type="text/javascript">


$(document).ready(function () {     
	$('#amount').change(function(e){

 

		$('#description').val($("#amount option:selected").data('plano'));
	})
})

</script>

 
			<script src="<?= $site; ?>js/flowbite.min.js"></script>

 
		</body> 
</html>
<?php



ob_end_flush();
?>
