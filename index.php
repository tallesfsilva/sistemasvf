<?php
ob_start();
session_cache_expire(60);
session_start();

require('_app/Config.inc.php');
 
if(empty($_SESSION['hasShowed'])){
	require('_app/status_plano.php');
}

require('_app/Mobile_Detect.php');
$detect = new Mobile_Detect;

$loginUrl = LOGIN;

$linkLoja = LINK_LOJA;
 



$Url[1] = (empty($Url[1]) ? null : $Url[1]);

$site = HOME;
$img_log_dir = 'configuracoes/uploads/';
 
if(empty($_SESSION['userlogin'])){
	header("Location: {$loginUrl}");
} 

if(empty($Url[0]) || $Url[0] == 'index'):
	require('landingpage.php');	 
 
else:
	 
	$nemprise = $Url[0];	 

	$lerbanco->FullRead("select * from ws_empresa WHERE binary nome_empresa_link = :lemprise", "lemprise={$nemprise}");
	if (!$lerbanco->getResult()):
		header("Location: {$site}");
	else:
		foreach ($lerbanco->getResult() as $i):
			extract($i);
		endforeach;

		$getu = $user_id;	
		 
		$lerbanco->FullRead("select * from ws_users WHERE user_id = :user", "user={$getu}");
		if (!$lerbanco->getResult()){
		 
		}else{
			foreach ($lerbanco->getResult() as $j):
				extract($j);
			endforeach;	
		}
		$linkLoja = $linkLoja.$nome_empresa_link;
	endif;


	$lerbanco->FullRead("select * from configuracoes_site");
	if (!$lerbanco->getResult()):		 
	else:
		foreach ($lerbanco->getResult() as $k):
			extract($k);
		endforeach;
	endif;

	$cart = new Cart([
	//Total de item que pode ser adicionado ao carrinho 0 = Ilimitado
		'cartMaxItem' => 0,

	// A quantidade máxima de um item que pode ser adicionada ao carrinho, 0 = Ilimitado
		'itemMaxQuantity' => 0,

	// Não usar cookies, os itens do carrinho desaparecerão depois que o navegador for fechado
		'useCookie' => false,
	]);

	// if(!empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] != $getu):
	// 	header("Location: {$site}Demo");
	// endif;

	$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
 
	
	if(!empty($logoff) && $logoff == true):
		 
	$updateacesso = new Update;
	$dataEhora    = date('d/m/Y H:i');
	$ip           = get_client_ip();
	$string_last = array("user_ultimoacesso" => " Último acesso em: {$dataEhora} IP: {$ip} ");
	$updateacesso->ExeUpdate("ws_users", $string_last, "WHERE user_id = :uselast", "uselast={$userlogin['user_id']}");
	unset($_SESSION['hasShowed']);	
	unset($_SESSION['userlogin']);
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

	


	<!DOCTYPE id="main"html>
	<!--[if IE 9]><html class="ie ie9"> <![endif]-->
	<html lang="pt-br" style="heigth:100%; scroll-behavior: smooth;">
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

		<!-- Favicons-->
		<link rel="shortcut icon" href="../../Imagens/LOGO.ico" type="image/x-icon">
		<!-- GOOGLE WEB FONT -->
		<link href="<?= $site; ?>css/fonts-google.css" rel="stylesheet">

		<!-- BASE CSS -->
		<link href="<?= $site; ?>css/base.css" rel="stylesheet">
		<link href="<?= $site; ?>css/custom.css" rel="stylesheet">
       
		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/normalize.css" />			
		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/component.css" /> 	
		<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">
		<link href="<?= $site; ?>css/style.css" rel="stylesheet">	 
		<link href="<?= $site; ?>css/tailwind.min.css" rel="stylesheet">

		<style type="text/css">
		 


			#img-head-loja{
				background-image:url(<?=(!empty($img_header) ? $site."uploads/".$img_header : '');?>);
				background-attachment:fixed;
				background-size:100%;
				background-repeat:no-repeat;
				background-color:#000;
			}
		</style>

		<style type="text/css">

			.switch {
				position: relative;
				margin: 5px auto;
				width: 95%;
				height: 40px;
				border: 3px solid #34AF23;
				color: #ffffff;
				font-size: 15px;
				border-radius: 10px;
			}

			.quality {
				position: relative;
				display: inline-block;
				width: 50%;
				height: 100%;
				line-height: 40px;
			}
			.quality:first-child label {
				border-radius: 5px 0 0 5px;
			}
			.quality:last-child label {
				border-radius: 0 5px 5px 0;
			}
			.quality label {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				cursor: pointer;
				font-style: italic;
				text-align: center;
				transition: transform 0.4s, color 0.4s, background-color 0.4s;
			},

					
    
			.quality input[type="radio"] {
				appearance: none;
				width: 0;
				height: 0;
				opacity: 0;
			}
			.quality input[type="radio"]:focus {
				outline: 0;
				outline-offset: 0;
			}
			.quality input[type="radio"]:checked ~ label {
				background-color: #34AF23;
				color: #ffffff;
			}
			.quality input[type="radio"]:active ~ label {
				transform: scale(1.05);
			}

		</style>


 
		



		 

		 
		<link rel="stylesheet" href="css/font-awesome.css">
		 
		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>
 

		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

	 
 
  
 
 
		<!-- MUDAR CORES DO TEMPLATE -->
		<!--<link href="css/color_scheme.css" rel="stylesheet">-->
	</head>

	<body class="leading-normal tracking-normal  overflow-auto text-white" style="background-image: url('<?=$site.'/img/bg_1.png'?>'); background-repeat:no-repeat;background-size: cover;">
			
 


<!-- Header ================================================== -->
<header >
	
	</header>
<div class="container-login">
 
	
	<div  id="main-container" class="container-fuild  overflow-hidden">
		<!-- First Row -->
	<div class="container-menu">
		<div class="row ">				 
			<div class="col-md-4 col-xs-12">		
					<div  class="height-container new-menu-first-row hover:bg-sky-700">
						<div class="container">
							<div class="container-items" >
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="row">
											<div class="col-md-12">
											<a  class="text-values">
												<div class="object-fit img-container">	
													<?php
														$img_logo = empty($img_logo) ? 'default/LOGOPADRAO.png' : $img_logo;
													?>
												
													<img style="margin:10px" src="<?=URL_IMAGE.$img_logo?>"  height="200" width="200" alt="" data-retina="true" class="img-fluid">	 
												</div>
											</div>
											</a>	
										</div>
			 
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="flex text-info-menu flex-col w-full content-center justify-start ">
										
												<div style="font-size:20px;font-weight: bolder;" class='text-bold'>
													<span> INFORMAÇÕES</span>
												</div>	
												<div class="w-1/2 w-full flex flex-row content-center">	
												
														<div class="ellipse p-2"></div>						 
														<div class="p-2"><span>Nome da Loja: <a href="<?= $linkLoja ?>" target="_blank" class="text-values"><span class="text-values"> <?= $nome_empresa ?></span></a></div>
													</div>
									 
										<div class="w-1/2 w-full flex flex-row content-center">	
											
												<div class="ellipse p-2"></div>		
												<div class="p-2"><span>Plano: <span class="text-values"><?= $user_nome_plano ?></span><span></div>
												</div>
											<div class="w-1/2 w-full flex flex-row content-center">	
											
												<div class="ellipse p-2"></div>		
														<div class="p-2"><span>Email:   <span class="text-values" ><?= $user_email ?></span> </span></div>
												</div>
												<div class="w-1/2 w-full flex flex-row content-center">	
													<div class="ellipse p-2"></div>		
												
													<div class="p-2"><span>Data de Validade:  <span class="text-values" ><?= date('d/m/Y', strtotime($empresa_data_renovacao)) ?></span><span>
														
													</div>
												</div>
											</div>
										</div>
								</div>
								<div class="row">
									<div class="col-md-12 pb-1 col-xs-12">
										<div class="flex text-info-menu flex-col w-full justify-start ">
												
										<div style="font-size:20px;font-weight: bolder;">
													<span> ATENDIMENTO	</span>
												</div>	
										
												<div hidden class="w-full flex flex-row justify-center">	
												
														 					 
														<div class="text-center"><span>Horário de atendimento: </div>
											</div>
												<div class="w-full text-center flex flex-col">											
									 
												<div class=""><span>Segunda à Sexta:  <span class="text-values"><?= !empty(explode(",",$h_suporte)[0]) ? explode(",",$h_suporte)[0] : ""?></span><span></div>
												<div class=""><span>Final de semana:  <span class="text-values"><?=  !empty(explode(",",$h_suporte)[1]) ? explode(",",$h_suporte)[1] : ""?></span><span></div>
												<div class=""><span>E-Mail:  <span class="text-values"><?= $email_suporte?></span><span></div>
													</div>
													<div class="w-full flex flex-col content-center">											
													<?php 

														$today = getdate();
													 	$time = date('H:i:s');
													 
													
														 if((($today['wday']>='1' && $today['wday']<='5')  && (strtotime($time) >= strtotime('08:00:00')) && (strtotime($time) <= strtotime('18:00:00'))   )
														 || (($today['wday']=='6' || $today['wday']=='0') && (strtotime($time) >= strtotime('08:00:00')) && (strtotime($time) <= strtotime('18:00:00'))  )
														 ){
														 

															$status = "ONLINE";
															$class = "status-on";
															 
														}else{
																$status = "OFFLINE";
																$class = "status-off";
																 
														}														
														
														 
														?>
													
													<div><span style="font-size:25px;font-weight: bolder;" class="<?= $class ?>"><?= $status ?></div>
													</div>
										 
											</div>
										</div>
								</div>
								<div style="position: relative;padding: 10px;" class="row">
								  <div class="flex flex-row justify-center">
									 
									<div class="h-1/2" style="border-radius: 15px;padding: 5px;background:#7233A0">
									<a href="https://<?= $link_do_face?>" target="_blank">			
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0,0,256,256" width="20px" height="20px"><g fill="#fff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(8.53333,8.53333)"><path d="M15,3c-6.627,0 -12,5.373 -12,12c0,6.016 4.432,10.984 10.206,11.852v-8.672h-2.969v-3.154h2.969v-2.099c0,-3.475 1.693,-5 4.581,-5c1.383,0 2.115,0.103 2.461,0.149v2.753h-1.97c-1.226,0 -1.654,1.163 -1.654,2.473v1.724h3.593l-0.487,3.154h-3.106v8.697c5.857,-0.794 10.376,-5.802 10.376,-11.877c0,-6.627 -5.373,-12 -12,-12z"></path></g></g></svg>
													</a>
													</div>
													<div class="ml-3 h-1/2" style="border-radius: 15px;padding: 5px;background:#7233A0">
													<a href="https://<?= $link_do_insta?>" target="_blank">
									
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0,0,256,256" width="20px" height="20px"><g fill="#fff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M16,3c-7.16752,0 -13,5.83248 -13,13v18c0,7.16752 5.83248,13 13,13h18c7.16752,0 13,-5.83248 13,-13v-18c0,-7.16752 -5.83248,-13 -13,-13zM16,5h18c6.08648,0 11,4.91352 11,11v18c0,6.08648 -4.91352,11 -11,11h-18c-6.08648,0 -11,-4.91352 -11,-11v-18c0,-6.08648 4.91352,-11 11,-11zM37,11c-1.10457,0 -2,0.89543 -2,2c0,1.10457 0.89543,2 2,2c1.10457,0 2,-0.89543 2,-2c0,-1.10457 -0.89543,-2 -2,-2zM25,14c-6.06329,0 -11,4.93671 -11,11c0,6.06329 4.93671,11 11,11c6.06329,0 11,-4.93671 11,-11c0,-6.06329 -4.93671,-11 -11,-11zM25,16c4.98241,0 9,4.01759 9,9c0,4.98241 -4.01759,9 -9,9c-4.98241,0 -9,-4.01759 -9,-9c0,-4.98241 4.01759,-9 9,-9z"></path></g></g></svg>
													</a>
													</div>
													<div class="ml-3 h-1/2" style="border-radius: 15px;padding: 5px;background:#7233A0">
													<a href="https://<?= $link_do_youtube?>" target="_blank">
									
													<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="20px" fill="#fff" height="20px"><path d="M 44.898438 14.5 C 44.5 12.300781 42.601563 10.699219 40.398438 10.199219 C 37.101563 9.5 31 9 24.398438 9 C 17.800781 9 11.601563 9.5 8.300781 10.199219 C 6.101563 10.699219 4.199219 12.199219 3.800781 14.5 C 3.398438 17 3 20.5 3 25 C 3 29.5 3.398438 33 3.898438 35.5 C 4.300781 37.699219 6.199219 39.300781 8.398438 39.800781 C 11.898438 40.5 17.898438 41 24.5 41 C 31.101563 41 37.101563 40.5 40.601563 39.800781 C 42.800781 39.300781 44.699219 37.800781 45.101563 35.5 C 45.5 33 46 29.398438 46.101563 25 C 45.898438 20.5 45.398438 17 44.898438 14.5 Z M 19 32 L 19 18 L 31.199219 25 Z"/></svg>
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
			<!--End Row -->
	 
			<div class="col-md-8 col-xs-12" >	
				<div class="height-container container-buttons"> 	
				<div class="row">
					<div class="col-md-12 col-xs-12">	
					<a  href="<?=$site.'cadastros/'?>">	
					<div class="col-md-6">
							<div  class="new-menu mt-5 p-5">
			
								<div class="flex w-full flex-row p-4 justify-center">
									<div class="icon-new-menu">
										<img src="<?=$site ?>img/lista-de-controle_1.png">
									</div>

									<div class="p-4 text-menu font-medium leading-tight">
										<span>Cadastros</span>
									</div>
								</div>			
							</div>
						</div>
													</a>
						<div class="col-md-6">
						<a  href="<?=$linkLoja?>" target="_blank">
								<div  class="new-menu mt-5 p-5">
							
								<div class="flex w-full flex-row p-4 justify-center">
									<div class="icon-new-menu">
										<img src="<?=$site ?>img/pedido_1.png">
									</div>

									<div class="p-4 text-menu font-medium leading-tight">
										<span>Cardápio Fácil</span>
									</div>
							</div>
						</div>
						</div>
						</a>
					</div>		

					<div class="col-md-12 col-xs-12">	
		
						<div class="col-md-6">
							<a  href="<?=$site.'configuracoes/'?>">
									<div  class="new-menu mt-5 p-5">
						
										<div class="flex w-full flex-row p-4 justify-center">
												<div class="icon-new-menu">
														<img src="<?=$site ?>img/configuracao _1.png">
													</div>
													
												<div class="p-4 text-menu font-medium leading-tight">
													<span>Configurações</span>
												</div>
										</div>					
									</div>
								</a>
						</div>

						<div class="col-md-6">
							<div  disabled class="button-disabled new-menu mt-5 p-5 bg-gray-300">
						
									<div class="flex w-full flex-row p-4 justify-center">
										<div class="icon-new-menu">
											<img src="<?=$site ?>img/curso-online_1.png">
										</div>

										<div class="p-4 text-menu font-medium leading-tight">
											<span>Escola Fácil <br> <span style="font-size: 10px">(Em construção)</span></span>
										</div>
									</div>			
							</div>
						</div>			
			
					</div>

					<div class="col-md-12 col-xs-12">	
		
						<div class="col-md-6">
							<div  disabled class="button-disabled new-menu mt-5 p-5 bg-gray-300">						
								<div class="flex w-full flex-row p-4 justify-center">
										<div class="icon-new-menu">
											<img src="<?=$site ?>img/gestao _1.png">
										</div>
										<div class="p-4 text-menu font-medium leading-tight">
											<span>Gestão Fácil <br> <span style="font-size: 10px">(Em construção)</span></span>
										</div>
								</div>
							</div>
						</div>		
			
						<div class="col-md-6">
								<div  disabled class="button-disabled new-menu mt-5 p-5 bg-gray-300">
									<div class="flex w-full flex-row p-4 justify-center">
											<div class="icon-new-menu">
													<img src="<?=$site ?>img/salario_1.png">
											</div>
											<div class="p-4 text-menu font-medium leading-tight">
												<span>Mensalidades <br> <span style="font-size: 10px">(Em construção)</span></span>
											</div>
									</div>					
								</div>
						</div>
					</div>	

					<div class="col-md-12 col-xs-12">	
		
						<div class="col-md-6">
							<div  disabled class="button-disabled new-menu mt-5 p-5 bg-gray-300">			 
								<div class="flex w-full flex-row p-4  justify-center">
										<div class="icon-new-menu">
												<img src="<?=$site ?>img/caixa-eletronico_1.png">
										</div>
										<div class="p-4 text-menu font-medium leading-tight">					
												<span>PDV Fácil <br> <span style="font-size: 10px">(Em construção)</span></span>
												 								
										</div>
								</div>			
							</div>			 
						</div>	 
						<div class="col-md-6">
							
						<?php 

$today = getdate();
$time = date('H:i:s');

if((($today['wday']>='1' && $today['wday']<='5')  && (strtotime($time) >= strtotime('08:00:00')) && (strtotime($time) <= strtotime('18:00:00'))   )
|| (($today['wday']=='6' || $today['wday']=='0') && (strtotime($time) >= strtotime('08:00:00')) && (strtotime($time) <= strtotime('18:00:00'))  )
){

			$class = "suporte_btn new-menu mt-5 p-5";
														
}else{
		$class = "button-disabled new-menu mt-5 p-5 bg-gray-300";	 	 
	}  
?><a target="_blank" href="https://api.whatsapp.com/send?1=pt_BR&phone=55<?=$tel_adm?>">
							<div id="suporte_button" class="<?= $class ?>">				
								<div class="flex w-full flex-row p-4 justify-center">
									<div class="icon-new-menu">
											<img width="50" height="50" src="<?=$site?>img/aperto-de-mao.png">
									</div>
									<div  class="p-4 text-menu font-medium text-white leading-tight">
										<span>Suporte</span>
									</div>
								</div>
							</div>		 
						</div>
					</div>
</a>
					<!-- Third Row -->
		
					<div class="col-md-12 col-xs-12">	
		 
						<div class="col-md-6">

						</div>	
						<div class="col-md-6">
						<a href="<?=$site.$Url[0].'/';?>&logoff=true">
							<div id="sair_button" style="background-color: #A70000" class="new-menu mt-5 p-5">				
								<div class="flex w-full flex-row p-4 justify-center">
										<div class="icon-new-menu" style="left:30px">
										<img width="60" height="60" src="<?=$site?>img/icon _add_circled outline_.png">
										</div>		
										<div class="p-4 text-menu text-white font-bold leading-tight">
											
												<span>Sair</span>
											 
										</div>
								</div>				
							</div>
						</div>
						</a>
					</div>
			
		 
				</div>
 
		 
		<!-- End Fist Row -->
				</div>
		</div>


		</div>


		</div>
 
		</div><!-- End row -->
	</div><!-- End container -->

<!-- End Header =============================================== -->

<!-- SubHeader =============================================== -->

 
 
 
 
<script src="<?= $site; ?>js/jquery.mask.js"></script>
 

 
<script>
	 

	$('#tel_suporte').mask('(00) 0 0000-0000');
</script>
 

<?php				

if(file_exists('includes/'.$Url[1] . '.php')):
	require 'includes/'.$Url[1] . '.php';

endif;
?> 



 






<script language="JavaScript">
	/*
	window.onload = function() {
		document.addEventListener("contextmenu", function(e){
			e.preventDefault();
		}, false);
		document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
              // "I" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
              	disabledEvent(e);
              }
              // "J" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
              	disabledEvent(e);
              }
              // "S" key + macOS
              if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
              	disabledEvent(e);
              }
              // "U" key
              if (e.ctrlKey && e.keyCode == 85) {
              	disabledEvent(e);
              }
              // "F12" key
              if (event.keyCode == 123) {
              	disabledEvent(e);
              }
          }, false);
		function disabledEvent(e){
			if (e.stopPropagation){
				e.stopPropagation();
			} else if (window.event){
				window.event.cancelBubble = true;
			}
			e.preventDefault();
			return false;
		}
	}; */
</script>
 



</body>
</html>
<?php


endif;
ob_end_flush();
?>
