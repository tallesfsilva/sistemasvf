<?php
ob_start();
 
session_cache_expire(60);
session_start();

require('../_app/Config.inc.php');

$site = HOME;
$login = LOGIN; 
 
$Url[1] = (empty($Url[1]) ? null : $Url[1]);

 
$site = HOME;
$loginUrl = LOGIN;
 

 
	$userId = $_SESSION['userlogin']['user_id'];	
	 
 
	$lerbanco->FullRead("select * from ws_empresa WHERE binary user_id = :userId", "userId={$userId}");
	

	if (!$lerbanco->getResult()){	
		 
		// header("Location: {$site}");
	}else{
		foreach ($lerbanco->getResult() as $i):
			extract($i);
		endforeach;

		 
	 	
 
	 
	}
	 
	 
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
		<meta name="og:title" content="<?=(!empty($nome_empresa) ? 'Pedido Fácil | '.$nome_empresa : 'Nome_do_seu_negócio');?>" />
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
		<!-- GOOGLE WEB FONT -->
		<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'>

		<!-- BASE CSS -->
		<link href="<?= $site; ?>css/base.css" rel="stylesheet">
	 
		<link href="<?= $site; ?>css/style-bt-file.css" rel="stylesheet">
		 

 <!-- GOOGLE WEB FONT -->
 <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'>

<!-- BASE CSS -->

		
	 
		<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">

		
	 
	
 

		<!-- Radio and check inputs -->
		<link rel="stylesheet" type="text/css" href="<?= $site;?>css/bootstrap.min.css">
	 
		
		<link href="<?= $site; ?>css/tailwind.min.css" rel="stylesheet">

		<?php
		if(!empty($_SESSION['userlogin'])):
			?>
			<link href="<?= $site; ?>css/skins/square/green.css" rel="stylesheet">
			<link href="<?= $site; ?>css/admin.css" rel="stylesheet">
			<link href="<?= $site; ?>css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
			<link href="<?= $site; ?>css/dropzone.css" rel="stylesheet">


			<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/normalize.css" />
			<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/demo.css" />
			<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/component.css" />
			<?php
		else:
		endif;
		?>

	 
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	 
		<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">
		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>
		 

 

		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>



 

		 


			

		  
		 


			<style type="text/css">
			 
		</style>

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
			 }
			 
			 #btn-renovar:hover{
				
				background-color: #7ccf7f  !important;
			 }
			 
			 	 
			 #btn-sair:hover{
				background-color: #c78a8a !important;
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



		



		



		<!-- Radio and check inputs -->
	 
			



		 
 
 
 
		 
	</head>

<body class="leading-normal tracking-normal  overflow-hidden text-white" style="background-image: url('<?=$site.'/img/bg_1.png'?>'); background-repeat:no-repeat;background-size: cover;">
 
   	 
	 

	<?php
    
		$status = $_GET['q'];
		$status = filter_var($status, FILTER_VALIDATE_BOOLEAN);


    if(!empty($_SESSION['userlogin']) && $status && !empty($_SESSION['plano']) && !empty($_SESSION['id_payment']) &&  $_SESSION['userlogin']['user_id'] == $userId){

    ?>
      
	   

		<div id="container_renova" class="flex items-center justify-center h-screen"> 
			
		<div class="container-menu ">
				 
						<div class="container-buttons-renova text-center" style=""> 
								 
								 
								<div class="row">
									<div class="flex justify-center">
										<div class="flex container-text flex-col justify-center">
										<div class="flex w-full justify-center">
										<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48">
                                            <path fill="#4caf50" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path fill="#ccff90" d="M34.602,14.602L21,28.199l-5.602-5.598l-2.797,2.797L21,33.801l16.398-16.402L34.602,14.602z"></path>
                                        </svg>
										</div>
										<div class="flex w-full">
												<p>Plano renovado </p>
											</div>
										</div>
									</div>
								</div>
								 
                                <?php

								try{

									$dias = "0";
									$arrayUser['user_nome_plano'] = "";
									$arrayUser['user_dias_plano'] = "";
									$diasExtras = diasDatas(date('Y-m-d'), $empresa_data_renovacao);
									$diasExtras = $diasExtras < 0 ? 0 : $diasExtras;
									if($_SESSION['plano'] == "PLANO MENSAL"):
										$arrayUser['user_nome_plano']  = $_SESSION['plano'];
									
									  $dias = (int) $texto['DiasPlanoDois'] + $diasExtras;
									  $arrayUser['user_dias_plano'] = $dias ;
									elseif($_SESSION['plano'] == "PLANO ANUAL"):
										$arrayUser['user_nome_plano']  = $_SESSION['plano'];
										$dias = (int) $texto['DiasPlanoTres'] + $diasExtras;     
										$arrayUser['user_dias_plano'] = $dias ;                                    
									endif;
								 
									$novadata = array();
							 
									
									$novadata['empresa_data_renovacao'] = date("Y-m-d", strtotime("+{$dias} days"));
								   
								 
									$updatebanco->ExeUpdate("ws_empresa", $novadata, "WHERE user_id = :userid", "userid={$_SESSION['userlogin']['user_id']}");
																	 

									$mensalidade['status_pagamento'] = $_SESSION['statusPayment'];
									$mensalidade['data_pagamento'] =  $_SESSION['date_approved'];
									$mensalidade['data_renovacao'] =  $novadata['empresa_data_renovacao'];
									$updatebanco->ExeUpdate("ws_mensalidades", $mensalidade, "WHERE id_user = :userid and id_mercado_pago= :idMercadoPago", "userid={$_SESSION['userlogin']['user_id']}&idMercadoPago={$_SESSION['id_payment']}");
									
									if($updatebanco->getResult()){

										$updatebanco->ExeUpdate("ws_users", $arrayUser, "WHERE user_id = :userid", "userid={$_SESSION['userlogin']['user_id']}");
												
										if($updatebanco->getResult()){
											unset($_SESSION['qr_code_base64']);
											unset($_SESSION['qr_code']);
											unset($_SESSION['id_payment']);
											unset($_SESSION['status']);
											unset($_SESSION['paymentScreen']);
											unset($_SESSION['plano']);
											unset($_SESSION['amount']);
											unset( $_SESSION['statusPayment']);
											header("Refresh:5; url=$site", true, 302);    
										}else{
											header("Location: {$site}");
										}
								    
									
									}else{
										header("Location: {$site}");
									}

								}catch (PDOException $e) {
									echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
									header("Location: {$site}");
								}                                     
										                               
                                     ?>
								 
    

								


								</div>
		
						</div>
				 
		</div>
	</div>
 
 
 
 
		</div>
 

		<?php }else{
			header("Location: {$site}");

		}

		?>
	 
				 
 
 
<script src="<?= $site; ?>js/flowbite.min.js"></script>
<script src="<?= $site; ?>js/common_scripts_min.js"></script>
<script src="<?= $site; ?>js/functions.js"></script>
 
 
<script src="<?= $site; ?>js/funcoesjs.js"></script>
<script src="<?= $site; ?>js/custom-file-input.js"></script>
 
 

		</body> 
</html>
<?php
ob_end_flush();
?>