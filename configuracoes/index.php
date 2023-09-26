<?php
ob_start();
session_cache_expire(60);
session_start();
require('../_app/Config.inc.php');
if(empty($_SESSION['hasShowed'])){
	require('../_app/status_plano.php');
}

$site = HOME;
$login = LOGIN; 
 
$Url[1] = (empty($Url[1]) ? null : $Url[1]);

$site = HOME;


if(empty($Url[0]) || $Url[0] == 'index'){

	 $Url[0] = 'configuracoes';

}
if(empty($_SESSION['userlogin'])){
	header("Location: {$login}");
} 
	$userId = $_SESSION['userlogin']['user_id'];	
	 

	$lerbanco->FullRead("select * from ws_empresa WHERE binary user_id = :userId", "userId={$userId}");
	if (!$lerbanco->getResult()){
		header("Location: {$site}");
	}else{
		foreach ($lerbanco->getResult() as $i):
			extract($i);
		endforeach;

		$getu = $user_id;	
		 
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
		<link href="<?=$site;?>css/style-configuracao.css" rel="stylesheet">


		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>




			<!--https://gao-sun.github.io/x0popup/-->
			<link href="<?= $site; ?>css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
			<script src="<?= $site; ?>css/x0popup-master/dist/x0popup.min.js"></script>

			<script src="<?= $site; ?>js/jquery.gotop.js"></script>

			<script src="<?= $site; ?>js/player.js"></script>
			<script src="<?= $site; ?>js/howler.js"></script>

 
			<script type="text/javascript">	

$(document).ready(function () {

	$.getJSON('<?=$site;?>estados_cidades.json', function (data) {

		var items = [];
		var options = '<option value="<?=(!empty($end_uf_empresa) ? $end_uf_empresa : "");?>"><?=(!empty($end_uf_empresa) ? $end_uf_empresa : "Escolha um estado");?></option>';	

		$.each(data, function (key, val) {
			options += '<option value="' + val.sigla + '">' + val.sigla + '</option>';
		});					
		$("#estados").html(options);				

		$("#estados").change(function () {				

			var options_cidades = '<option value="<?=(!empty($cidade_empresa) ? $cidade_empresa : "");?>"><?=(!empty($cidade_empresa) ? $cidade_empresa : "Escolha uma Cidade");?></option>';
			var str = "";					

			$("#estados option:selected").each(function () {
				str += $(this).text();
			});

			$.each(data, function (key, val) {
				if(val.sigla == str) {							
					$.each(val.cidades, function (key_city, val_city) {
						options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
					});							
				}
			});

			$("#cidades").html(options_cidades);

		}).change();		

	});

});

</script>

<script type="text/javascript">	

$(document).ready(function () {

	$.getJSON('<?=$site;?>estados_cidades.json', function (data) {

		var items = [];
		var options = '<option value="">Selecione o Estado</option>';	

		$.each(data, function (key, val) {
			options += '<option value="' + val.sigla + '">' + val.sigla + '</option>';
		});					
		$("#estados2").html(options);				

		$("#estados2").change(function () {				

			var options_cidades = '';
			var str = "";					

			$("#estados2 option:selected").each(function () {
				str += $(this).text();
			});

			$.each(data, function (key, val) {
				if(val.sigla == str) {							
					$.each(val.cidades, function (key_city, val_city) {
						options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
					});							
				}
			});

			$("#cidades2").html(options_cidades);

		}).change();		

	});

});

</script>



		 


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
				color: black;
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
			



		 

		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>
 
 
		 
	</head>

	<body class="bg-white leading-normal tracking-normal text-white"> 
		
		<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button"  class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
					<span class="sr-only">Open sidebar</span>
					<svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
					</svg>
		</button>
		<div class="flex flex-col">
			 	<div class="flex">
					<aside style="background:#7233A1; box-shadow: 2px 2px 2px 2px gray;" id="default-sidebar" class="fixed top-0 left-0 z-40 w-90 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
				 
					<div style="margin-top:10px; background: #7233A1;box-shadow: 0px 1px 1px black" class="mx-auto flex-row justify-center flex lg:mx-0 text-white font-bold  py-4 px-10 shadow-lg focus:outline-none focus:shadow-outline">
					<div class="flex flex-row">			
						 		
								<div class="w-full self-center">
									<span style="font-size:23px;">Configurações</span>
								</div>
							</div>
		</div>
 	
			<div  style="background: #7233A1" class="h-full overflow-y-auto bg-gray-50 dark:bg-gray-800">
						
			<ul id="side-bar-menu" class="space-y-2 font-medium text-white">
          
         <li style="border-color: #837979" class="w-full border-t">
		 
            <a href="<?=$site.'configuracoes/'?>admin-loja" target="_parent" class="flex items-center p-2 rounded-lg text-white  group">
               <svg width="23" height="27" viewBox="0 0 23 27" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.38581 13.5V13.9H9.78581H22.1536V26.6H0.609961V0.4H9.38581V13.5ZM3.40191 6.35H3.00191V6.75V10.125V10.525H3.40191H6.59386H6.99386V10.125V6.75V6.35H6.59386H3.40191ZM3.40191 13.1H3.00191V13.5V16.875V17.275H3.40191H6.59386H6.99386V16.875V13.5V13.1H6.59386H3.40191ZM3.40191 19.85H3.00191V20.25V23.625V24.025H3.40191H16.1697H16.5697V23.625V20.25V19.85H16.1697H3.40191ZM21.6247 9.725H13.3778V1.00507L21.6247 9.725Z" fill="white" stroke="black" stroke-width="0.8"/>
</svg>
               <span class="flex-1 ml-3  ">Pedido Fácil</span>
		
            </a>
		 
         </li>
         <li style="border-color: #837979" class="w-full  border-t">
		 <a href="<?=$site.'configuracoes/'?>painel" target="_parent" class="flex items-center p-2 rounded-lg text-white  group">
		 <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.0862 28C21.1376 28 26.854 21.9558 26.854 14.5C26.854 7.04415 21.1376 1 14.0862 1C7.03469 1 1.31836 7.04415 1.31836 14.5C1.31836 21.9558 7.03469 28 14.0862 28Z" fill="white" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M17.9165 9.77498C17.0419 8.85024 15.5018 8.20702 14.0862 8.16675L17.9165 9.77498ZM10.2559 18.55C11.0787 19.71 12.6087 20.3717 14.0862 20.4278L10.2559 18.55ZM14.0862 8.16675C12.402 8.11882 10.8942 8.92445 10.8942 11.125C10.8942 15.175 17.9165 13.15 17.9165 17.2C17.9165 19.5098 16.0476 20.5023 14.0862 20.4278M14.0862 8.16675V5.72498V8.16675ZM14.0862 20.4278V23.275V20.4278Z" fill="white"/>
<path d="M17.9165 9.77498C17.0419 8.85024 15.5018 8.20702 14.0862 8.16675M14.0862 8.16675C12.402 8.11882 10.8942 8.92445 10.8942 11.125C10.8942 15.175 17.9165 13.15 17.9165 17.2C17.9165 19.5098 16.0476 20.5023 14.0862 20.4278M14.0862 8.16675V5.72498M10.2559 18.55C11.0787 19.71 12.6087 20.3717 14.0862 20.4278M14.0862 20.4278V23.275" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Financeiro</span>
             
            </a>
         </li>
		 <li style="border-color: #837979" class="w-full   border-b border-t">
		 <a href="<?=$site.'configuracoes/'?>login-senha"  class="flex items-center p-2 rounded-lg text-white  group">
		 <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.9778 28C21.0292 28 26.7456 21.9558 26.7456 14.5C26.7456 7.04416 21.0292 1 13.9778 1C6.9263 1 1.20996 7.04416 1.20996 14.5C1.20996 21.9558 6.9263 28 13.9778 28Z" fill="white" stroke="black"/>
<path d="M7.59375 22.6V21.25C7.59375 17.5221 10.4519 14.5 13.9776 14.5C17.5033 14.5 20.3615 17.5221 20.3615 21.25V22.6" fill="white"/>
<path d="M7.59375 22.6V21.25C7.59375 17.5221 10.4519 14.5 13.9776 14.5C17.5033 14.5 20.3615 17.5221 20.3615 21.25V22.6" stroke="black" stroke-linecap="round"/>
<path d="M13.9778 14.5C16.0933 14.5 17.8081 12.6868 17.8081 10.45C17.8081 8.21328 16.0933 6.40002 13.9778 6.40002C11.8623 6.40002 10.1475 8.21328 10.1475 10.45C10.1475 12.6868 11.8623 14.5 13.9778 14.5Z" fill="white" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Conta</span>
            </a>
         </li>
         
         
      </ul>
	  <ul  class="fixed w-full bottom-0 pt-4 mt-4 dark:border-gray-700">
        
       
         <li class="w-full">

		 <a class="w-full" href="<?=$site;?>">
					<div style="background: #A70000; height:64px" id="voltar_button" class="items-center mx-auto cursor-pointer flex-row justify-center flex lg:mx-0 hover:underline w-full text-white font-bold  shadow-lg focus:outline-none focus:shadow-outline">
								<div class="w-40">
									<svg width="50" height="40" viewBox="0 0 37 39" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M14.8721 15.2735L18.4834 19.0918M18.4834 19.0918L22.0947 22.9102M18.4834 19.0918L22.0947 15.2735M18.4834 19.0918L14.8721 22.9102" stroke="white" stroke-width="2.98525" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9.4552 28.6378C14.4413 33.9099 22.5255 33.9099 27.5116 28.6378C32.4977 23.3657 32.4977 14.818 27.5116 9.54594C22.5255 4.27386 14.4413 4.27386 9.4552 9.54594C4.46911 14.818 4.46907 23.3657 9.4552 28.6378Z" stroke="white" stroke-width="2.98525" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>	
								</div>			
								<div class="w-full ml-2">
									<span style="font-size:23px;">Voltar</span>
								</div>
							</div>
		</a>	
            
         </li>
      </ul>
   </div>
   
</aside>
		</div>
 
		<?php				
 
 if(file_exists('includes/'.$Url[0] . '.php')):
 require 'includes/'.$Url[0] . '.php';					 
  
 endif;
 ?>
				<div  id="img-container" class="container-main-page flex bg-white h-screen justify-center items-center p-4">
				
				
				<div  class="flex h-full w-full items-center justify-center container-items" >
					<img style="width: 400px;height: 300px;" src="../../Imagens/INICIO.png"/>	

						</div>
				</div>
		 


 
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