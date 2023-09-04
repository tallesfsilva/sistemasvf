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
		<link href="<?= $site; ?>css/custom.css" rel="stylesheet">
		<link href="<?= $site; ?>css/reset.css" rel="stylesheet">
		<link href="<?= $site; ?>css/datepicker.css" rel="stylesheet">
		<link href="<?= $site; ?>css/style-bt-file.css" rel="stylesheet">
		<link href="<?=$site;?>css/suportewats.css" rel="stylesheet">

 <!-- GOOGLE WEB FONT -->
 <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'>

<!-- BASE CSS -->

		
		<link href="<?=$site;?>css/icheck/icheck-material.css" rel="stylesheet">
		<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">

		
		<link href="<?=$site;?>css/icheck/icheck-material.css" rel="stylesheet">
	
		 

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">



		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css'>



		<!-- Radio and check inputs -->
		<link rel="stylesheet" type="text/css" href="<?= $site;?>css/bootstrap.min.css">
		<link href="<?= $site; ?>css/skins/square/grey.css" rel="stylesheet">
		
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

		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/modal/frappuccino-modal.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/modal/popupmodal.css" />
		<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">
		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>
		 


		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>




			<!--https://gao-sun.github.io/x0popup/-->
			<link href="<?= $site; ?>css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
			<script src="<?= $site; ?>css/x0popup-master/dist/x0popup.min.js"></script>

			<script src="<?= $site; ?>js/jquery.gotop.js"></script>

			<script src="<?= $site; ?>js/player.js"></script>
			<script src="<?= $site; ?>js/howler.js"></script>

 
 
 



		 


			<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/JNKKKK/MoreToggles.css@0.2.1/output/moretoggles.min.css">

			<!-- Select da pagina carrinho -->
			<link href="<?=$site?>css/selectcarrinho/dist/css/select2.min.css" rel="stylesheet" />
			<script src="<?=$site?>css/selectcarrinho/dist/js/select2.min.js"></script>
			<!-- Select da pagina carrinho -->


			<!-- Radio and check inputs -->
			<link href="<?= $site; ?>css/radio-check.css" rel="stylesheet">
			<link href="<?= $site; ?>css/modal.css" rel="stylesheet">
			<script type="text/javascript" src="<?= $site; ?>js/modalhorarios.js"></script> 
			<!-- https://www.cssscript.com/pure-css-checkbox-radio-button-replacement-bootstrap-icheck/ -->
			<link href="<?= $site; ?>notificacao/light-theme.min.css" rel="stylesheet">
			<link href="<?= $site; ?>css/chackbox/dist/css/checkboxes.css" rel="stylesheet">

			<script type="text/javascript" src="<?= $site; ?>notificacao/growl-notification.min.js"></script> 


		 
		
		<script src="<?= $site; ?>css/multiselect/dist/bundle.min.js"></script>


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



		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">



		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css'>



		<!-- Radio and check inputs -->
		<link href="<?= $site; ?>css/skins/square/grey.css" rel="stylesheet">
			



		 

		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>
 
 
		 
	</head>

<body class="leading-normal tracking-normal  overflow-hidden text-white" style="background-image: url('<?=$site.'/img/bg_1.png'?>'); background-repeat:no-repeat;background-size: cover;">
 
   	 <?php

       
    if(!empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId):
        $planoUser = $_SESSION['userlogin']['user_plano'];
        $nomeplano = "";
        $valorplano = "";

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
										<form id="form-checkout" action="/process_payment" method="post">
											<select style="background-color: #dddbdb;" name="user_plano" class="text-center form-control" >
													<option  value="">Escolha seu Plano</option>
													 
													<option value="2"><?=$texto['nomePlanoDois'];?></option>
													<option value="3"><?=$texto['nomePlanoTres'];?></option>
											</select>
										</form>
										</div>
								</div>
								<div class="row">
										<div class="col-md-12">
											<div id="btn-renovar"  style="background:#00BB07"id="voltar_button" class="buttons-renova items-center mt-3 mb-2 mx-auto rounded-md cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
												 			
												<div class="w-full ml-2">
													<span style="font-size:23px;">Renovar</span>
												</div>
											</div>
										</div>
								</div>


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
  const mp = new MercadoPago("YOUR_PUBLIC_KEY");
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
									<form id="form-checkout" action="/process_payment" method="post">
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
												
													<select style="background-color: #dddbdb;" name="user_plano" class="text-center form-control" >
															<option  value="">Escolha seu Plano</option>
															
															<option value="2"><?=$texto['nomePlanoDois'];?></option>
															<option value="3"><?=$texto['nomePlanoTres'];?></option>
													</select>
												</div>
										</div>
	
										<div class="row">
												<div class="col-md-12">
													<div id="btn-renovar"  style="background:#00BB07"  class="buttons-renova items-center mt-3 mb-2 mx-auto rounded-md cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
																	
														<div class="w-full ml-2">
															<input type="submit" style="font-size:23px;" value="Renovar">
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
									<div class="row">
										<div class="col-md-12">
										<form id="form-checkout" action="/process_payment" method="post">
											<div class="container-text">
													<p>Sua assinatura expira em breve: </p>
													<span class="font-extrabold"   ><?=date('d/m/Y', strtotime($empresa_data_renovacao))?></span>
													<p>Escolha um plano para renovar: </p>
											</div>
										</form>
										</div>
									</div>
									<div class="row">
											<div class="col-md-12">
												<select style="background-color: #dddbdb;" name="user_plano" class="text-center form-control" >
														<option  value="">Escolha seu Plano</option>														 
														<option value="2"><?=$texto['nomePlanoDois'];?></option>
														<option value="3"><?=$texto['nomePlanoTres'];?></option>
												</select>
											</div>
									</div>
	
									
	
									<div class="row">
											<div class="col-md-12">
												<div   style="background:#00BB07"id="btn-renovar" class="buttons-renova items-center mt-3 mb-2 mx-auto rounded-md cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white shadow-lg focus:outline-none focus:shadow-outline">
																 
													<div class="w-full ml-2">
														<span style="font-size:23px;">Renovar</span>
													</div>
												</div>
											</div>
									</div>

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

 			
















 
		</div>
 
		<?php				
 
 if(file_exists('includes/'.$Url[0] . '.php')):
 require 'includes/'.$Url[0] . '.php';					 
  
 endif;
 ?>
				 


 
			<script src="<?= $site; ?>js/flowbite.min.js"></script>

<script src="<?= $site; ?>js/common_scripts_min.js"></script>
<script src="<?= $site; ?>js/functions.js"></script>
<script src="<?= $site; ?>assets/validate.js"></script>
<script src="<?= $site; ?>js/jquery.mask.js"></script>
<script src="<?= $site; ?>js/index-btn-file.js"></script>
<script src="<?= $site; ?>js/funcoesjs.js"></script>
<script src="<?= $site; ?>js/custom-file-input.js"></script>
<script src="<?= $site; ?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<script src="<?= $site; ?>js/parallax.js"></script>
<script src="<?= $site; ?>js/parallax.min.js"></script>
<script src="<?= $site; ?>js/printThis.js"></script>
<script src="<?=$site;?>js/suportewats.js"></script>
 

		</body> 
</html>
<?php



ob_end_flush();
?>