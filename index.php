<?php
ob_start();
session_cache_expire(60);
session_start();
require('_app/Config.inc.php');
require('_app/Mobile_Detect.php');
$detect = new Mobile_Detect;

$loginUrl = LOGIN;
 


$Url[1] = (empty($Url[1]) ? null : $Url[1]);

$site = HOME;
 
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
 
	unset($_SESSION['userlogin']);


	header("Location: {$loginUrl}");
endif;

	?>

	


	<!DOCTYPE id="main"html>
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
		
		<link href="<?=$site;?>css/icheck/icheck-material.css" rel="stylesheet">
		<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">
		<link href="<?= $site; ?>css/style.css" rel="stylesheet">
		<link href="<?= $site; ?>css/style.css" rel="stylesheet">
		<link href="<?= $site; ?>css/tailwind.min.css" rel="stylesheet">

		<style type="text/css">
			@media (min-width: 768px) {
				.omb_row-sm-offset-3 div:first-child[class*="col-"] {
					margin-left: 25%;
				}
			}

			.omb_login .omb_authTitle {
				text-align: center;
				line-height: 300%;
			}

			.gradient {
       				 background: linear-gradient(90deg, #7233A1 0%, #8c52ff 100%);
      		}

			.omb_login .omb_socialButtons a {
				color: white; // In yourUse @body-bg 
				opacity:0.9;
			}
			.omb_login .omb_socialButtons a:hover {
				color: white;
				opacity:1;    	
			}

			.omb_login .omb_loginOr {
				position: relative;
				font-size: 1.5em;
				color: #aaa;
				margin-top: 1em;
				margin-bottom: 1em;
				padding-top: 0.5em;
				padding-bottom: 0.5em;
			}
			.omb_login .omb_loginOr .omb_hrOr {
				background-color: #cdcdcd;
				height: 1px;
				margin-top: 0px !important;
				margin-bottom: 0px !important;
			}
			.omb_login .omb_loginOr .omb_spanOr {
				display: block;
				position: absolute;
				left: 50%;
				top: -0.6em;
				margin-left: -1.5em;
				background-color: white;
				width: 3em;
				text-align: center;
			}			

			.omb_login .omb_loginForm .input-group.i {
				width: 2em;
			}
			.omb_login .omb_loginForm  .help-block {
				color: red;
			}


			@media (min-width: 768px) {
				.omb_login .omb_forgotPwd {
					text-align: right;
					margin-top:10px;
				}		
			}

			#whatsapp{
				position:fixed;
				width:60px;
				height:60px;
				right:10px;
				bottom:10px;
				display:block;
				z-index:1000000;
			}
			.cart-count{
				display: inline-block;
				position: absolute;
				top: 0;
				right: 0;
				background: #ff2646;
				color: #fff;
				padding: 4px 10px;
				border-radius: 100px;
				font-size: 10px;
				text-shadow: 0 1px 2px rgba(0,0,0,.1);
				box-shadow: 0 2px 4px rgba(0,0,0,.1);
				z-index: 10;
				text-align: center;
				opacity: 1;
				transition: .33s cubic-bezier(0.34, 0.13, 0.34, 1.43);
			}


			/*--thank you pop starts here--*/
			.thank-you-pop{
				width:100%;
				padding:20px;
				text-align:center;
			}
			.thank-you-pop img{
				width:76px;
				height:auto;
				margin:0 auto;
				display:block;
				margin-bottom:25px;
			}

			.thank-you-pop h1{
				font-size: 42px;
				margin-bottom: 25px;
				color:#5C5C5C;
			}
			.thank-you-pop p{
				font-size: 20px;
				margin-bottom: 27px;
				color:#5C5C5C;
			}
			.thank-you-pop h3.cupon-pop{
				font-size: 25px;
				margin-bottom: 40px;
				color:#222;
				display:inline-block;
				text-align:center;
				padding:10px 20px;
				border:2px dashed #222;
				clear:both;
				font-weight:normal;
			}
			.thank-you-pop h3.cupon-pop span{
				color:#03A9F4;
			}
			.thank-you-pop a{
				display: inline-block;
				margin: 0 auto;
				padding: 9px 20px;
				color: #fff;
				text-transform: uppercase;
				font-size: 14px;
				background-color: #8BC34A;
				border-radius: 17px;
			}
			.thank-you-pop a i{
				margin-right:5px;
				color:#fff;
			}
			#ignismyModal .modal-header{
				border:0px;
			}
			/*--thank you pop ends here--*/



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



		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">



		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css'>



		<!-- Radio and check inputs -->
		<link href="<?= $site; ?>css/skins/square/grey.css" rel="stylesheet">
		



		<?php
		if(!empty($_SESSION['userlogin'])):
			?>
			<link href="<?= $site; ?>css/skins/square/green.css" rel="stylesheet">
			<link href="<?= $site; ?>css/admin.css" rel="stylesheet">
			<link href="<?= $site; ?>css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
			<link href="<?= $site; ?>css/dropzone.css" rel="stylesheet">
			<link href="<?= $site; ?>css/tailwind.min.css" rel="stylesheet">


			<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/normalize.css" />
			 
			<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/component.css" />
			<?php
		else:
		endif;
		?>

		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/modal/frappuccino-modal.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/modal/popupmodal.css" />

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

		<link href="<?= $site; ?>notificacao/light-theme.min.css" rel="stylesheet">

		<script type="text/javascript" src="<?= $site; ?>notificacao/growl-notification.min.js"></script> 


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
		<script defer src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
		<link href="<?= $site; ?>css/chackbox/dist/css/checkboxes.css" rel="stylesheet">

		<script type="text/javascript">
			$(document).ready(function(){

			 


				$('.remove_item').click(function(){
					$('.remove_item').prop('disabled', true);

					var id_item = $(this).data('id_item');
					var rash_item = $(this).data('item_hash');

					$.ajax({
						url: '<?= $site; ?>includes/processaremovercart.php',
						method: 'post',
						data: {'iditem':id_item,'itemrash':rash_item, 'getpegaloja' : '<?=$Url[0];?>'},

						success: function(data){
							$('.remove_item').prop('disabled', false);
							$('#updatesidebar').html(data);
						}
					});
				});
			});
		</script>

		
		<script src="<?= $site; ?>css/multiselect/dist/bundle.min.js"></script>


		<!-- MUDAR CORES DO TEMPLATE -->
		<!--<link href="css/color_scheme.css" rel="stylesheet">-->
	</head>

	<body class="leading-normal tracking-normal text-white" style="background-color: #6303C3">
		<!-- inicio do loader 
		<div id="preloader">
			<div class="sk-spinner sk-spinner-wave" id="status">
				<div class="sk-rect1"></div>
				<div class="sk-rect2"></div>
				<div class="sk-rect3"></div>
				<div class="sk-rect4"></div>
				<div class="sk-rect5"></div>
			</div>
		</div> -->


<!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->



<!-- Header ================================================== -->
<header >
	
	</header>
	<div  id="main-container" class="container-fuild  overflow-hidden">
		<!-- First Row -->
		<div class="container-menu gradient">
		<div class="row ">
				<div id="first_div_menu" class="col-md-4 hidden-custom">
					<div  class="new-menu-first-row">
					 <div class="container">
						<div class="object-fit img-container"	>
							<img src="../../Imagens/LOGO.png"  width="280"  alt="" data-retina="true" class="img-fluid">	 
						</div>
						</div>
					</div>
				</div>
    <div class="col-md-8 col-xs-12">		
        <div  class="new-menu-first-row hover:bg-sky-700">
			<div class="container">
			<div class="container-items" >
				<div class="row">
					<div class="col-md-4">
						<div class="object-fit img-container">
							<img src="../../Imagens/LOGO.png"     width="280" alt="" data-retina="true" class="img-fluid">	 
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="flex text-info-menu flex-col w-full content-center justify-start ">
							<div class="w-1/2 w-full flex flex-row content-center">	
								
								<div class="p-2">
										<svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.321888 25.6846C0.107296 25.6846 0 25.5594 0 25.403V0.966171C0 0.809725 0.143062 0.68457 0.321888 0.68457H24.6781C24.8569 0.68457 25 0.809725 25 0.966171V25.403C25 25.5907 24.8569 25.6846 24.6781 25.6846H0.321888ZM3.57654 22.5557H21.4592V16.2978H3.57654V22.5557ZM3.57654 13.1689H7.15308V10.04H3.57654V13.1689ZM10.7296 13.1689H14.3062V10.04H10.7296V13.1689ZM17.8827 13.1689H21.4592V3.78219H17.8827V13.1689ZM3.57654 6.9111H7.15308V3.78219H3.57654V6.9111ZM10.7296 6.9111H14.3062V3.78219H10.7296V6.9111Z" fill="black"/>
											</svg>
									</div>

								<div class="p-2"><span>Nome da Loja: <span class="text-values"> <?= $nome_empresa ?></span><span></div>
								</div>
							<div class="w-1/2 w-full flex flex-row content-center">	
								
								<div class="p-2">
										<svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.321888 25.6846C0.107296 25.6846 0 25.5594 0 25.403V0.966171C0 0.809725 0.143062 0.68457 0.321888 0.68457H24.6781C24.8569 0.68457 25 0.809725 25 0.966171V25.403C25 25.5907 24.8569 25.6846 24.6781 25.6846H0.321888ZM3.57654 22.5557H21.4592V16.2978H3.57654V22.5557ZM3.57654 13.1689H7.15308V10.04H3.57654V13.1689ZM10.7296 13.1689H14.3062V10.04H10.7296V13.1689ZM17.8827 13.1689H21.4592V3.78219H17.8827V13.1689ZM3.57654 6.9111H7.15308V3.78219H3.57654V6.9111ZM10.7296 6.9111H14.3062V3.78219H10.7296V6.9111Z" fill="black"/>
											</svg>
									</div>
									<div class="p-2"><span>Link da Loja:  <span class="text-values"><?= $nome_empresa_link ?></span><span></div>
							</div>
							<div class="w-1/2 w-full flex flex-row content-center">	
								
								<div class="p-2">
										<svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.321888 25.6846C0.107296 25.6846 0 25.5594 0 25.403V0.966171C0 0.809725 0.143062 0.68457 0.321888 0.68457H24.6781C24.8569 0.68457 25 0.809725 25 0.966171V25.403C25 25.5907 24.8569 25.6846 24.6781 25.6846H0.321888ZM3.57654 22.5557H21.4592V16.2978H3.57654V22.5557ZM3.57654 13.1689H7.15308V10.04H3.57654V13.1689ZM10.7296 13.1689H14.3062V10.04H10.7296V13.1689ZM17.8827 13.1689H21.4592V3.78219H17.8827V13.1689ZM3.57654 6.9111H7.15308V3.78219H3.57654V6.9111ZM10.7296 6.9111H14.3062V3.78219H10.7296V6.9111Z" fill="black"/>
											</svg>
									</div>
									<div class="p-2"><span>Plano: <span class="text-values"><?= $user_nome_plano ?></span><span></div>
							</div>
							<div class="w-1/2 w-full flex flex-row content-center">	
								
								<div class="p-2">
										<svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.321888 25.6846C0.107296 25.6846 0 25.5594 0 25.403V0.966171C0 0.809725 0.143062 0.68457 0.321888 0.68457H24.6781C24.8569 0.68457 25 0.809725 25 0.966171V25.403C25 25.5907 24.8569 25.6846 24.6781 25.6846H0.321888ZM3.57654 22.5557H21.4592V16.2978H3.57654V22.5557ZM3.57654 13.1689H7.15308V10.04H3.57654V13.1689ZM10.7296 13.1689H14.3062V10.04H10.7296V13.1689ZM17.8827 13.1689H21.4592V3.78219H17.8827V13.1689ZM3.57654 6.9111H7.15308V3.78219H3.57654V6.9111ZM10.7296 6.9111H14.3062V3.78219H10.7296V6.9111Z" fill="black"/>
											</svg>
									</div>
						 
									<div class="p-2"><span>Email:   <span class="text-values" ><?= $user_email ?></span> </span></div>
							</div>
							<div class="w-1/2 w-full flex flex-row content-center">	
								
								<div class="p-2">
										<svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.321888 25.6846C0.107296 25.6846 0 25.5594 0 25.403V0.966171C0 0.809725 0.143062 0.68457 0.321888 0.68457H24.6781C24.8569 0.68457 25 0.809725 25 0.966171V25.403C25 25.5907 24.8569 25.6846 24.6781 25.6846H0.321888ZM3.57654 22.5557H21.4592V16.2978H3.57654V22.5557ZM3.57654 13.1689H7.15308V10.04H3.57654V13.1689ZM10.7296 13.1689H14.3062V10.04H10.7296V13.1689ZM17.8827 13.1689H21.4592V3.78219H17.8827V13.1689ZM3.57654 6.9111H7.15308V3.78219H3.57654V6.9111ZM10.7296 6.9111H14.3062V3.78219H10.7296V6.9111Z" fill="black"/>
											</svg>
									</div>
							
									<div class="p-2"><span>Data de Validade:  <span class="text-values" ><?= date('d/m/Y', strtotime($empresa_data_renovacao)) ?></span><span></div>
							</div>
						</div>
					</div>
				</div>
		</div>
		</div>
        </div>
    </div>
   
</div>

		<!-- End Fist Row -->



		<!-- Second Row -->
		<div class="row">	
			<div class="col-md-4">
        			<div  class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
									<svg width="30" height="30" viewBox="0 0 96 110" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M0 0V109.079H95.4444V54.5397H40.9048V0H0ZM54.5397 0V40.9048H95.4444L54.5397 0ZM13.6349 27.2698H27.2698V40.9048H13.6349V27.2698ZM13.6349 54.5397H27.2698V68.1746H13.6349V54.5397ZM13.6349 81.8095H68.1746V95.4444H13.6349V81.8095Z" fill="black"/>
									</svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
								<span>Pedido Fácil</span>
							</div>
            			</div>
           
        			</div>
    			</div>


				<div class="col-md-4">
        			<div  class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg width="48" height="32" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20.8135 0.443848C15.084 0.443848 9.94521 2.01603 6.22401 4.49222L23.7668 16.1657V0.561761C22.8218 0.483152 21.8176 0.443848 20.8135 0.443848ZM29.6735 4.61013V18.013L13.6073 28.7038C17.2104 30.6691 21.6995 31.8875 26.7202 31.8875C38.12 31.8875 47.3935 25.7167 47.3935 18.1309C47.3935 11.2133 39.6558 5.59275 29.6735 4.61013ZM5.51521 9.75903C2.20747 11.8815 0.140137 14.8293 0.140137 18.1309C0.140137 21.9041 2.85721 25.1664 6.99188 27.3282L19.5731 18.9563L5.51521 9.75903Z" fill="black"/>
</svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
							<span>Gestão Fácil</span>
							</div>
            			</div>
           
        			</div>
    			</div>

				
				<div class="col-md-4">
        			<div  class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg width="30" height="30" viewBox="0 0 115 115" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M86.25 0L71.875 14.375L100.625 43.125L115 28.75L86.25 0ZM57.5 28.75L0 86.25V115H28.75L86.25 57.5L57.5 28.75Z" fill="black"/>
                    </svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
							<span>Escola Fácil</span>
							</div>
            			</div>
           
        			</div>
    			</div>

		</div>

 
		<!-- End Second Row -->
 

	<!-- Third Row -->
		<div class="row">			
		<div class="col-md-4">
        			<div  class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-check" viewBox="0 0 16 16">
											<path d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
											<path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
									</svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
							<span>Cadastro</span>
							</div>
            			</div>
           
        			</div>
    			</div>

				<div class="col-md-4">
        			<div  class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg width="30" height="30" viewBox="0 0 47 48" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M0.60515 0.0913086C0.201717 0.0913086 0 0.331152 0 0.630956V47.4604C0 47.7602 0.268956 48 0.60515 48H46.3949C46.731 48 47 47.7602 47 47.4604V0.630956C47 0.271191 46.731 0.0913086 46.3949 0.0913086L0.60515 0.0913086ZM6.72389 6.08739H40.3433V18.0796H6.72389V6.08739ZM6.72389 24.0756H13.4478V30.0717H6.72389V24.0756ZM20.1717 24.0756H26.8956V30.0717H20.1717V24.0756ZM33.6195 24.0756H40.3433V42.0639H33.6195V24.0756ZM6.72389 36.0678H13.4478V42.0639H6.72389V36.0678ZM20.1717 36.0678H26.8956V42.0639H20.1717V36.0678Z" fill="black"/>
									</svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
							<span>PDV Fácil</span>
							</div>
            			</div>
           
        			</div>
    			</div>


				<div class="col-md-4">
        			<div  class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg width="30" height="30" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19.3659 0.75V4.59654H12.273C5.84199 4.59654 0.451323 6.78907 0.451323 9.40472V11.328C0.451323 13.9436 4.61254 16.0977 10.7598 16.7516L34.9705 19.2903C36.2945 19.4442 38.186 20.4058 38.186 20.9828V22.9061C38.186 23.4446 37.1457 23.8677 35.8216 23.8677H12.1784C11.0435 23.8677 10.1923 23.7139 9.81405 23.6369V20.0212H0.35675V23.8677C0.35675 25.1755 2.24821 26.291 4.51796 26.868C6.69314 27.4835 9.43576 27.7143 12.1784 27.7143H19.2714V31.5608H28.7287V27.7143H35.8216C42.3472 27.7143 47.6433 25.5602 47.6433 22.9061V20.9828C47.6433 18.3672 43.482 16.2131 37.3348 15.5592L13.1241 13.0205C11.8001 12.8666 9.90862 11.905 9.90862 11.328V9.40472C9.90862 8.86621 10.9489 8.44309 12.273 8.44309H35.9162C36.9565 8.44309 37.9022 8.59695 38.2805 8.67388V12.2896H47.7378V8.44309C47.7378 7.13526 45.8464 6.01976 43.5766 5.44278C41.4014 4.82734 38.6588 4.59654 35.9162 4.59654H28.8232V0.75L19.3659 0.75Z" fill="black"/>
</svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
							<span>Mensabilidades</span>
							</div>
            			</div>
           
        			</div>
    			</div>

			 
		 
	</div>

			<div class="row">

			<div class="col-md-4">
        			<div  class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg width="30" height="30" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M20.9474 0.326172L17.9935 4.92695C17.4027 5.04294 16.871 5.23625 16.3393 5.42956L9.30893 3.49646L5.05526 6.28012L8.0092 10.8809C7.7138 11.2675 7.47749 11.5768 7.24117 11.9634L0.210815 13.8965V17.7627L7.24117 19.6958C7.47749 20.0825 7.7138 20.3918 8.0092 20.7784L5.05526 25.3792L9.30893 28.1628L16.3393 26.2297C16.871 26.3844 17.4027 26.5777 17.9935 26.7323L20.9474 31.3331H26.8553L29.8092 26.7323C30.3409 26.5777 30.9317 26.423 31.4634 26.2297L38.4938 28.1628L42.7474 25.3792L39.7935 20.7784C40.0298 20.4304 40.3252 20.0438 40.5615 19.6958L47.5919 17.7627V13.8965L40.5615 11.9634C40.3843 11.6155 40.0889 11.2289 39.7935 10.8809L42.7474 6.28012L38.4938 3.49646L31.4634 5.42956C30.9317 5.27491 30.3409 5.0816 29.8092 4.92695L26.8553 0.326172L20.9474 0.326172ZM23.9014 9.99168C28.8049 9.99168 32.7632 12.582 32.7632 15.791C32.7632 18.9999 28.8049 21.5903 23.9014 21.5903C18.9978 21.5903 15.0396 18.9999 15.0396 15.791C15.0396 12.582 18.9978 9.99168 23.9014 9.99168Z" fill="black"/>
									</svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
						
							<a id="teste" href="<?=$site.'configuracoes/'?>">
							 
									<span>Configuracões</span>
							</a>
							</div>
            			</div>
           
        			</div>
    			</div>


				 

			
					<div class="col-md-4">
        			<div style="background-color: #46DC4C; color: white" class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg width="30" height="30" viewBox="0 0 54 47" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M26.8571 0C15.7786 0 6.71429 9.06429 6.71429 20.1429V26.8571H3.35714C2.46677 26.8571 1.61287 27.2108 0.983284 27.8404C0.353698 28.47 0 29.3239 0 30.2143L0 43.6429C0 44.5332 0.353698 45.3871 0.983284 46.0167C1.61287 46.6463 2.46677 47 3.35714 47H10.0714C10.9618 47 11.8157 46.6463 12.4453 46.0167C13.0749 45.3871 13.4286 44.5332 13.4286 43.6429V20.1429C13.4286 12.69 19.4043 6.71429 26.8571 6.71429C34.31 6.71429 40.2857 12.69 40.2857 20.1429V43.6429C40.2857 44.5332 40.6394 45.3871 41.269 46.0167C41.8986 46.6463 42.7525 47 43.6429 47H50.3571C51.2475 47 52.1014 46.6463 52.731 46.0167C53.3606 45.3871 53.7143 44.5332 53.7143 43.6429V30.2143C53.7143 29.3239 53.3606 28.47 52.731 27.8404C52.1014 27.2108 51.2475 26.8571 50.3571 26.8571H47V20.1429C47 9.06429 37.9357 0 26.8571 0Z" fill="black"/>
									</svg>
								</div>

							<div class="p-4 text-menu font-bold leading-tight">
							<span>Suporte</span>
							</div>
            			</div>
           
        			</div>
    			</div>


					 


					<div class="col-md-4">
        			<div  style="background-color: #E70D0D" class="new-menu mt-5 p-5">
           
           			 <div class="flex w-full flex-row p-4 justify-center">
								<div class="p-4 icon-new-menu">
								<svg width="30" height="30" viewBox="0 0 48 47" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.51049 0L0 8.44204L4.34578 12.7529L15.0895 23.5898L4.34578 34.2471L0 38.3783L8.51049 47L12.8563 42.6892L23.7811 31.8522L34.5248 42.6892L38.6895 47L47.3811 38.3783L43.0353 34.2471L32.1105 23.5898L43.0353 12.7529L47.3811 8.44204L38.6895 0L34.5248 4.31083L23.7811 14.9682L12.8563 4.31083L8.51049 0Z" fill="white"/>
</svg>
								</div>
 
							<div class="p-4 text-menu font-bold leading-tight">
								<a href="<?=$site.$Url[0].'/';?>&logoff=true">
							<span>Sair</span>
							</a>
							</div>
            			</div>
           
        			</div>
    			</div>
				<?php				

if(file_exists('includes/'.$Url[1] . '.php')):
	require 'includes/'.$Url[1] . '.php';
 
endif;
?>

					</div>




		</div>
 

			<nav hidden class="col--md-8 col-sm-8 col-xs-8">
				<a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
				<div class="main-menu">
					<div id="header_menu">
						<img src="<?= $site; ?>img/home.png" height="40" alt="" data-retina="true">

					</div>
					<a class="open_close" id="close_in"><i class="icon_close"></i></a>
					<ul>
						<li><a href="<?=$site.$Url[0];?>"><?=$texto['home'];?></a></li>
						<li><a href="<?=$site.$Url[0].'/';?>contato"><?=$texto['contato'];?></a></li>
						

						<?php if(!empty($_SESSION['userlogin'])):?>
							<li><a href="<?=$site.$Url[0].'/';?>admin-loja"><?=$texto['Conf_loja'];?></a></li>
							<li><a href="<?=$site.$Url[0].'/';?>view-item"><?=$texto['itens'];?></a></li>
							<li class="submenu">
								<a class="show-submenu"><?=$texto['cadastros-menu'];?><i class="icon-down-open-mini"></i></a>
								<ul>
									<li><a href="<?=$site.$Url[0].'/';?>cadastrar-formas-pagamento"><?=$texto['cadastro-pagamentos'];?></a></li>
									<li><a href="<?=$site.$Url[0].'/';?>categoria"><?=$texto['cadastros-cat'];?></a></li>
									<li><a href="<?=$site.$Url[0].'/';?>itens"><?=$texto['cadastros-iten'];?></a></li>
									<li><a href="<?=$site.$Url[0].'/';?>add-adicionais"><?=$texto['cadastros-complementos'];?></a></li>
									<li><a href="<?=$site.$Url[0].'/';?>add-options"><?=$texto['cadastros-tipostamanhos'];?></a></li>
									<li><a href="<?=$site.$Url[0].'/';?>enderecos-delivery"><?=$texto['cadastros-enderecos'];?></a></li>
									<li><a href="<?=$site.$Url[0].'/';?>cupom-desconto"><?=$texto['cadastros-cupons'];?></a></li>	
								</ul>
							</li>
							<li><a href="<?=$site.$Url[0].'/';?>pedidos"><?=$texto['msg_pedidos']?></a></li>
							<li><a href="<?=$site.$Url[0].'/';?>estatisticas"><?=$texto['estatisticas'];?></a></li>
							<li><a href="<?=$site.$Url[0].'/';?>login-senha"><?=$texto['login-senha'];?></a></li>
							<li><a href="<?=$site.$Url[0].'/';?>admin-loja&logoff=true"><?=$texto['sair'];?></a></li>
						<?php endif;?>


					</ul>
				</div><!-- End main-menu -->
			</nav>
		</div><!-- End row -->
	</div><!-- End container -->

<!-- End Header =============================================== -->

<!-- SubHeader =============================================== -->



<!-- COMMON SCRIPTS -->

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



<script>
	jQuery(document).ready(function($){
		$('a').not('[href*="'+document.domain+'"]').attr('target', '_blank');
		$('a').not('[href*="'+document.domain+'"]').attr('rel', 'external nofollow');
	});
</script>
 

<?php				

if(file_exists('includes/'.$Url[1] . '.php')):
	require 'includes/'.$Url[1] . '.php';

endif;
?> 



 





<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js'></script>


<!-- SPECIFIC SCRIPTS -->
 




	<script type="text/javascript">
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
	e.preventDefault();

	fieldName = $(this).attr('data-field');
	type      = $(this).attr('data-type');
	var input = $("input[name='"+fieldName+"']");
	var currentVal = parseInt(input.val());
	if (!isNaN(currentVal)) {
		if(type == 'minus') {

			if(currentVal > input.attr('min')) {
				input.val(currentVal - 1).change();
			} 
			if(parseInt(input.val()) == input.attr('min')) {
				$(this).attr('disabled', true);
			}

		} else if(type == 'plus') {

			if(currentVal < input.attr('max')) {
				input.val(currentVal + 1).change();
			}
			if(parseInt(input.val()) == input.attr('max')) {
				$(this).attr('disabled', true);
			}

		}
	} else {
		input.val(0);
	}
});
$('.input-number').focusin(function(){
	$(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

	minValue =  parseInt($(this).attr('min'));
	maxValue =  parseInt($(this).attr('max'));
	valueCurrent = parseInt($(this).val());

	name = $(this).attr('name');
	if(valueCurrent >= minValue) {
		$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
	} else {
		alert('Desculpe, o valor mínimo foi atingido');
		$(this).val($(this).data('oldValue'));
	}
	if(valueCurrent <= maxValue) {
		$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
	} else {
		alert('Desculpe, o valor máximo foi atingido');
		$(this).val($(this).data('oldValue'));
	}


});



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

<!-- <script type="text/javascript">
	const selected = document.querySelector(".selected");
	const optionsContainer = document.querySelector(".options-container");
	const searchBox = document.querySelector(".search-box input");

	const optionsList = document.querySelectorAll(".option");

	selected.addEventListener("click", () => {
		optionsContainer.classList.toggle("active");

		searchBox.value = "";
		filterList("");

		if (optionsContainer.classList.contains("active")) {
			searchBox.focus();
		}
	});

	optionsList.forEach(o => {
		o.addEventListener("click", () => {
			selected.innerHTML = o.querySelector("label").innerHTML;
			optionsContainer.classList.remove("active");
		});
	});

	searchBox.addEventListener("keyup", function(e) {
		filterList(e.target.value);
	});

	const filterList = searchTerm => {
		searchTerm = searchTerm.toLowerCase();
		optionsList.forEach(option => {
			let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
			if (label.indexOf(searchTerm) != -1) {
				option.style.display = "block";
			} else {
				option.style.display = "none";
			}
		});
	};

</script>



</body>
</html>
<?php


endif;
ob_end_flush();
?>
