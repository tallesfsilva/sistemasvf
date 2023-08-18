<?php
ob_start();
session_cache_expire(60);
require('_app/Config.inc.php');
session_start();


$site = HOME;
$loginURL = LOGIN;

$login = new Login(3); 

if(!$login->CheckLogin()): 
	unset($_SESSION['userlogin']);
	header("Location: {$loginURL}");
else:
	$userlogin = $_SESSION['userlogin'];
endif;

  
if(empty($_SESSION['userlogin'])){
	header("Location: {$loginURL}");
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
			
	}



$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);

$dataFomatadarenovacao = explode('-', $empresa_data_renovacao);
$dataFomatadarenovacao = array_reverse($dataFomatadarenovacao);
$dataFomatadarenovacao = implode('/', $dataFomatadarenovacao);

if(!empty($_GET['statusmp'])):

	$statusMP = strip_tags(trim($_GET['statusmp']));

	if(!empty($statusMP) && $statusMP == "approved"):
		echo "<script>x0p('Sucesso!', 
		'Recebemos seu pagamento! Plano ativo até {$dataFomatadarenovacao}', 
		'ok', false);</script>";
	elseif(!empty($statusMP) && $statusMP == "rejected"):
		echo "<script>x0p('Ocorreu um Erro', 
		'Seu cartão foi recusado! Entre em contato conosco.',
		'error', false);</script>";
	endif;

endif;

if(!empty($logoff) && $logoff == true):
	$updateacesso = new Update;
	$dataEhora    = date('d/m/Y H:i');
	$ip           = get_client_ip();
	$string_last = array("user_ultimoacesso" => " Último acesso em: {$dataEhora} IP: {$ip} ");
	$updateacesso->ExeUpdate("ws_users", $string_last, "WHERE user_id = :uselast", "uselast={$userlogin['user_id']}");
 
	unset($_SESSION['userlogin']);

	 

	header("Location: {$loginURL}");
endif;

$updatebanco = new Update();
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

		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>

		

		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>



		<!--https://gao-sun.github.io/x0popup/-->
		<link href="<?= $site; ?>css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
		<script src="<?= $site; ?>css/x0popup-master/dist/x0popup.min.js"></script>

		<script src="<?= $site; ?>js/jquery.gotop.js"></script>
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
		<link href="<?=$site;?>css/style-configuracao.css" rel="stylesheet">
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

 
		 
	</head>

	<body class="leading-normal gradient tracking-normal text-white">
 
		
 
 
		
		<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button"  class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
					<span class="sr-only">Open sidebar</span>
					<svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
					</svg>
		</button>
		<div class="flex flex-col">
			 	<div class="flex">
					<aside style="box-shadow: 2px 2px 2px 2px gray;" id="default-sidebar" class="fixed p-5 top-0 left-0 z-40 w-80 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
						<div class="overflow-y-autol text-center">
							<div style="background: #8000FF" class="mx-auto lg:mx-0 hover:underline text-white font-bold rounded-full my-6 py-4 px-10 shadow-lg focus:outline-none focus:shadow-outline">
								Configuracões
							</div>
						</div>
			<div  style="background: #8000FF" class="h-full overflow-y-auto bg-gray-50 dark:bg-gray-800">
						
			<ul id="side-bar-menu" class="space-y-2 font-medium text-white">
          
         <li class="w-full   border-b border-gray-200">
            <a href="<?=$site?>admin-loja" target="_parent" class="flex items-center p-2 rounded-lg text-white  group">
               <svg class="flex-shrink-0 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                  <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
               </svg>
               <span class="flex-1 ml-3  ">Pedido Fácil</span>
		
            </a>
		 
         </li>
         <li class="w-full   border-b border-gray-200">
              <a href="#" class="flex items-center p-2 rounded-lg text-white  group">
               <svg class="flex-shrink-0 w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
               </svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Financeiro</span>
             
            </a>
         </li>
         <li class="w-full   border-b border-gray-200">
		 <a href="#" class="flex items-center p-2 rounded-lg text-white  group">
               <svg class="flex-shrink-0 w-5 h-5   text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                  <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
               </svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Conta</span>
            </a>
         </li>
         
         
      </ul>
	  <ul class="fixed bottom-0 pt-4 mt-4 dark:border-gray-700">
        
         
        
         <li>
		 <a href="<?=$site.$Url[0].'/';?>&logoff=true">
            <a href="<?=$site.$Url[0].'/';?>" class="flex items-center p-2 text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 21">
                  <path d="m5.4 2.736 3.429 3.429A5.046 5.046 0 0 1 10.134 6c.356.01.71.06 1.056.147l3.41-3.412c.136-.133.287-.248.45-.344A9.889 9.889 0 0 0 10.269 1c-1.87-.041-3.713.44-5.322 1.392a2.3 2.3 0 0 1 .454.344Zm11.45 1.54-.126-.127a.5.5 0 0 0-.706 0l-2.932 2.932c.029.023.049.054.078.077.236.194.454.41.65.645.034.038.078.067.11.107l2.927-2.927a.5.5 0 0 0 0-.707Zm-2.931 9.81c-.024.03-.057.052-.081.082a4.963 4.963 0 0 1-.633.639c-.041.036-.072.083-.115.117l2.927 2.927a.5.5 0 0 0 .707 0l.127-.127a.5.5 0 0 0 0-.707l-2.932-2.931Zm-1.442-4.763a3.036 3.036 0 0 0-1.383-1.1l-.012-.007a2.955 2.955 0 0 0-1-.213H10a2.964 2.964 0 0 0-2.122.893c-.285.29-.509.634-.657 1.013l-.01.016a2.96 2.96 0 0 0-.21 1 2.99 2.99 0 0 0 .489 1.716c.009.014.022.026.032.04a3.04 3.04 0 0 0 1.384 1.1l.012.007c.318.129.657.2 1 .213.392.015.784-.05 1.15-.192.012-.005.02-.013.033-.018a3.011 3.011 0 0 0 1.676-1.7v-.007a2.89 2.89 0 0 0 0-2.207 2.868 2.868 0 0 0-.27-.515c-.007-.012-.02-.025-.03-.039Zm6.137-3.373a2.53 2.53 0 0 1-.35.447L14.84 9.823c.112.428.166.869.16 1.311-.01.356-.06.709-.147 1.054l3.413 3.412c.132.134.249.283.347.444A9.88 9.88 0 0 0 20 11.269a9.912 9.912 0 0 0-1.386-5.319ZM14.6 19.264l-3.421-3.421c-.385.1-.781.152-1.18.157h-.134c-.356-.01-.71-.06-1.056-.147l-3.41 3.412a2.503 2.503 0 0 1-.443.347A9.884 9.884 0 0 0 9.732 21H10a9.9 9.9 0 0 0 5.044-1.388 2.519 2.519 0 0 1-.444-.348ZM1.735 15.6l3.426-3.426a4.608 4.608 0 0 1-.013-2.367L1.735 6.4a2.507 2.507 0 0 1-.35-.447 9.889 9.889 0 0 0 0 10.1c.1-.164.217-.316.35-.453Zm5.101-.758a4.957 4.957 0 0 1-.651-.645c-.033-.038-.077-.067-.11-.107L3.15 17.017a.5.5 0 0 0 0 .707l.127.127a.5.5 0 0 0 .706 0l2.932-2.933c-.03-.018-.05-.053-.078-.076ZM6.08 7.914c.03-.037.07-.063.1-.1.183-.22.384-.423.6-.609.047-.04.082-.092.129-.13L3.983 4.149a.5.5 0 0 0-.707 0l-.127.127a.5.5 0 0 0 0 .707L6.08 7.914Z"/>
               </svg>
               <span class="ml-3">Voltar</span>
            </a>
         </li>
      </ul>
   </div>
   
</aside>
		</div>		 


				<?php

						 // REQUERIDOS
    // Definir horário de funcionamento diário
    // Deve estar no formato de 24 horas, separado por traço
    // Se fechado para o dia, deixe em branco (por exemplo, domingo) ou não adicione linha
    // Se aberto várias vezes em um dia, insira intervalos de tempo separados por vírgula
    


    $hours = array();      



         //CONFIGURAÇÃO DE SEGUNDA FEIRA
        if(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "false"):
            	 $hours['mon'] = array();
        elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "true"):
            $hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate, $segunda_tarde_de.'-'.$segunda_tarde_ate);
        
        elseif(!empty($config_segunda) && $config_segunda == "true" && !empty($config_segundaa) && $config_segundaa == "false"):
        	  $hours['mon'] = array($segunda_manha_de.'-'.$segunda_manha_ate);
       	elseif(!empty($config_segunda) && $config_segunda == "false" && !empty($config_segundaa) && $config_segundaa == "true"):
       		$hours['mon'] = array($segunda_tarde_de.'-'.$segunda_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE SEGUNDA FEIRA

        //CONFIGURAÇÃO DE TERÇA FEIRA
        if(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "false"):
            	 $hours['tue'] = array();
        elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "true"):
            $hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate, $terca_tarde_de.'-'.$terca_tarde_ate);
        
        elseif(!empty($config_terca) && $config_terca == "true" && !empty($config_tercaa) && $config_tercaa == "false"):
        	  $hours['tue'] = array($terca_manha_de.'-'.$terca_manha_ate);
       	elseif(!empty($config_terca) && $config_terca == "false" && !empty($config_tercaa) && $config_tercaa == "true"):
       		$hours['tue'] = array($terca_tarde_de.'-'.$terca_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE TERÇA FEIRA

         //CONFIGURAÇÃO DE QUARTA FEIRA
        if(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "false"):
            	 $hours['wed'] = array();
        elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "true"):
            $hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate, $quarta_tarde_de.'-'.$quarta_tarde_ate);
        
        elseif(!empty($config_quarta) && $config_quarta == "true" && !empty($config_quartaa) && $config_quartaa == "false"):
        	  $hours['wed'] = array($quarta_manha_de.'-'.$quarta_manha_ate);
       	elseif(!empty($config_quarta) && $config_quarta == "false" && !empty($config_quartaa) && $config_quartaa == "true"):
       		$hours['wed'] = array($quarta_tarde_de.'-'.$quarta_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE QUARTA FEIRA

         //CONFIGURAÇÃO DE QUINTA FEIRA
        if(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "false"):
            	 $hours['thu'] = array();
        elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "true"):
            $hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate, $quinta_tarde_de.'-'.$quinta_tarde_ate);
        
        elseif(!empty($config_quinta) && $config_quinta == "true" && !empty($config_quintaa) && $config_quintaa == "false"):
        	  $hours['thu'] = array($quinta_manha_de.'-'.$quinta_manha_ate);
       	elseif(!empty($config_quinta) && $config_quinta == "false" && !empty($config_quintaa) && $config_quintaa == "true"):
       		$hours['thu'] = array($quinta_tarde_de.'-'.$quinta_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE QUINTA FEIRA

        //CONFIGURAÇÃO DE SEXTA FEIRA
        if(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "false"):
            	 $hours['fri'] = array();
        elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "true"):
            $hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate, $sexta_tarde_de.'-'.$sexta_tarde_ate);
        
        elseif(!empty($config_sexta) && $config_sexta == "true" && !empty($config_sextaa) && $config_sextaa == "false"):
        	  $hours['fri'] = array($sexta_manha_de.'-'.$sexta_manha_ate);
       	elseif(!empty($config_sexta) && $config_sexta == "false" && !empty($config_sextaa) && $config_sextaa == "true"):
       		$hours['fri'] = array($sexta_tarde_de.'-'.$sexta_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE SEXTA FEIRA

         //CONFIGURAÇÃO DE SABADO
        if(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "false"):
            	 $hours['sat'] = array();
        elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "true"):
            $hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate, $sabado_tarde_de.'-'.$sabado_tarde_ate);
        
        elseif(!empty($config_sabado) && $config_sabado == "true" && !empty($config_sabadoo) && $config_sabadoo == "false"):
        	  $hours['sat'] = array($sabado_manha_de.'-'.$sabado_manha_ate);
       	elseif(!empty($config_sabado) && $config_sabado == "false" && !empty($config_sabadoo) && $config_sabadoo == "true"):
       		$hours['sat'] = array($sabado_tarde_de.'-'.$sabado_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE SABADO

        //CONFIGURAÇÃO DE DOMINGO
        if(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "false"):
            	 $hours['sun'] = array();
        elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "true"):
            $hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate, $domingo_tarde_de.'-'.$domingo_tarde_ate);
        
        elseif(!empty($config_domingo) && $config_domingo == "true" && !empty($config_domingoo) && $config_domingoo == "false"):
        	  $hours['sun'] = array($domingo_manha_de.'-'.$domingo_manha_ate);
       	elseif(!empty($config_domingo) && $config_domingo == "false" && !empty($config_domingoo) && $config_domingoo == "true"):
       		$hours['sun'] = array($domingo_tarde_de.'-'.$domingo_tarde_ate);
        endif;
        //CONFIGURAÇÃO DE DOMINGO
						
						$lerbanco->ExeRead("ws_datas_close", "WHERE user_id = :delivdata", "delivdata={$getu}");
						$exceptions = array();
						if($lerbanco->getResult()):
							foreach($lerbanco->getResult() as $dadosC):
								extract($dadosC);
								$i = explode('/', $data);
								$i = array_reverse($i);
								$i = implode("-", $i);							

								if(isDateExpired($i, 1)):
									$exceptions["{$i}"] = array();							
								endif;
							endforeach;
						endif;

					
					// Iniciando a classe
						$store_hours = new StoreHours($hours, $exceptions);

					
					 // Display open / closed menssagem
					 ?>
					<br />
					<br />
					 

				</div><!-- End sub_content -->
			</div><!-- End subheader -->
		</section><!-- End section -->


		<!-- End SubHeader ============================================ -->

		 
				<div  class="container-main-page flex h-full justify-center items-center p-4">
					 
							
							<div style="background-color:#ffffff;color:black" class="container margin_60">
								<div id="sendempresa"></div>


								<section id="section-1">
									<div class="indent_title_in">
										<i class="icon_house_alt"></i>
										<h3>Descrição geral do seu negócio</h3>
										<p>Insira no formulario abaixo detalhes do seu negócio e informações de contato.</p>
									</div>				

					<form method="post" action="#sendempresa" enctype="multipart/form-data">
						<div class="wrapper_indent">
							<?php

							$getdelldate = filter_input(INPUT_GET, 'dellDate', FILTER_VALIDATE_INT);

							if(!empty($getdelldate) && !isset($_POST['sendempresa'])):

								$lerbanco->ExeRead('ws_datas_close', "WHERE user_id = :userid AND id = :v", "userid={$userlogin['user_id']}&v={$getdelldate}");
							if ($lerbanco->getResult()):
								$deletbanco->ExeDelete("ws_datas_close", "WHERE user_id = :userid AND id = :k", "userid={$userlogin['user_id']}&k={$getdelldate}");
								if ($deletbanco->getResult()):
									echo "<div class=\"alert alert-success alert-dismissable\">
									<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
									<b class=\"alert-link\">SUCESSO!</b> A data de exceção foi deletada do sistema.
									</div>";
									header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
								else:
									echo "<div class=\"alert alert-danger alert-dismissable\">
									<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
									<b class=\"alert-link\">OCORREU UM ERRO DE CONEXÃO!</b> Tente novamente.
									</div>";
									header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
								endif;
							endif;
						endif;


						if(isset($_POST['sendempresa']) && $_POST['sendempresa'] == true):
							if(!empty($_POST['data_close'])):

								$dataClose1 = strip_tags(trim($_POST['data_close']));

								$data_c['data'] = $dataClose1;
								$data_c['user_id'] = $userlogin['user_id'];

								if(strlen($dataClose1) == 10):
									$lerbanco->ExeRead("ws_datas_close", "WHERE user_id = :userid AND data = :dat", "userid={$userlogin['user_id']}&dat={$dataClose1}");
									if($lerbanco->getResult()):
										//NÃO FAZ NADA
									else:
										$addbanco->ExeCreate("ws_datas_close", $data_c);
									endif;
								endif;						
							endif;
						endif;


						

						$inputdadosempresa = filter_input_array(INPUT_POST, FILTER_DEFAULT);

						if ($inputdadosempresa && !empty($inputdadosempresa['sendempresa'])):					

							unset($inputdadosempresa['sendempresa']);
							unset($inputdadosempresa['_wysihtml5_mode']);
							unset($inputdadosempresa['data_close']);
							$inputdadosempresa['end_bairro_empresa'] = tratar_nome($inputdadosempresa['end_bairro_empresa']);

							if(!empty($inputdadosempresa['minimo_delivery'])):					
								$inputdadosempresa['minimo_delivery'] = Check::Valor($inputdadosempresa['minimo_delivery']);
							else:
								$inputdadosempresa['minimo_delivery'] = '0.00';
							endif;



									// LIMPA OS CAMPOS RETIRANDO TAGS E ESPAÇOS DESNECESSÁRIOS
							$inputdadosempresa = array_map('strip_tags', $inputdadosempresa);
							$inputdadosempresa = array_map('trim', $inputdadosempresa);

							if(!empty($inputdadosempresa['confirm_delivery'])):
								$inputdadosempresa['confirm_delivery'] = "true";
							else:
								$inputdadosempresa['confirm_delivery'] = "false";
							endif;
							if(!empty($inputdadosempresa['confirm_balcao'])):
								$inputdadosempresa['confirm_balcao'] = "true";
							else:
								$inputdadosempresa['confirm_balcao'] = "false";
							endif;
							if(!empty($inputdadosempresa['confirm_mesa'])):
								$inputdadosempresa['confirm_mesa'] = "true";
							else:
								$inputdadosempresa['confirm_mesa'] = "false";
							endif;	


									// COMO NÃO EXISTE UM INPUT PARA IMAGEM TEMOS QUE FAZER VALIDAÇÃO VIA $_FILE MESMO

						// INICIO DA VALIDAÇÃO DA IMAGEM DE FUNDO
							if (isset($_FILES['img_header']['tmp_name']) && $_FILES['img_header']['tmp_name'] != ""):
								$inputdadosempresa['img_header'] = $_FILES['img_header'];
							else:
								unset($inputdadosempresa['img_header']);
							endif;


							if(!empty($inputdadosempresa['img_header'])):                        
								$upload = new Upload("uploads/");
								$upload->Image($inputdadosempresa['img_header']);

								if(isset($upload) && $upload->getResult()):
									$inputdadosempresa['img_header'] = $upload->getResult();
								if(!empty($inputdadosempresa['img_header']) && !empty($img_logo) && file_exists("uploads/{$img_header}") && !is_dir("uploads/{$img_header}")):
									unlink("uploads/{$img_header}");
							endif;
						elseif(is_array($inputdadosempresa['img_header'])):
							unset($inputdadosempresa['img_header']);
						endif;



					endif;
						// FIM DA VALIDAÇÃO DA IMAGEM DE FUNDO


									// INICIO DA VALIDAÇÃO DA IMAGEM PERFIL
					if (isset($_FILES['img_logo']['tmp_name']) && $_FILES['img_logo']['tmp_name'] != ""):
						$inputdadosempresa['img_logo'] = $_FILES['img_logo'];
					else:
						unset($inputdadosempresa['img_logo']);
					endif;


					if(!empty($inputdadosempresa['img_logo'])):                        
						$upload = new Upload("uploads/");
						$upload->Image($inputdadosempresa['img_logo']);

						if (isset($upload) && $upload->getResult()):	

							$inputdadosempresa['img_logo'] = $upload->getResult();

					elseif(is_array($inputdadosempresa['img_logo'])):
						unset($inputdadosempresa['img_logo']);
					endif;

					if(!empty($inputdadosempresa['img_logo']) && !empty($img_logo) && file_exists("uploads/{$img_logo}") && !is_dir("uploads/{$img_logo}")):
						unlink("uploads/{$img_logo}");
				endif;						

			endif;

			if(empty($inputdadosempresa['facebook_empresa'])):
				unset($inputdadosempresa['facebook_empresa']);
			endif;

			if(empty($inputdadosempresa['instagram_empresa'])):
				unset($inputdadosempresa['instagram_empresa']);
			endif;

			if(empty($inputdadosempresa['twitter_empresa'])):
				unset($inputdadosempresa['twitter_empresa']);
			endif;

									// FIM DA VALIDAÇÃO DA IMAGEM DE PERFIL 
									//---------------------------				

			if (in_array('', $inputdadosempresa) || in_array('null', $inputdadosempresa)):
				echo "<div class=\"alert alert-info alert-dismissable\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
			Preencha todos os campos!
			</div>";
			header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
			elseif (!Check::Email($inputdadosempresa['email_empresa'])):
				echo "<div class=\"alert alert-warning alert-dismissable\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
				O EMAIL informado não e valido!
				</div>";
				header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
			else:						
				$inputdadosempresa['telefone_empresa'] = preg_replace("/[^0-9]/", "", $inputdadosempresa['telefone_empresa']);
				$inputdadosempresa['user_id'] = $userlogin['user_id'];	

				$inputdadosempresa['config_delivery'] = Check::Valor($inputdadosempresa['config_delivery']);

				$inputdadosempresa['config_segunda'] = (!empty($inputdadosempresa['config_segunda']) && $inputdadosempresa['config_segunda'] == "true" ? $inputdadosempresa['config_segunda'] : "false");	

				$inputdadosempresa['config_terca'] = (!empty($inputdadosempresa['config_terca']) && $inputdadosempresa['config_terca'] == "true" ? $inputdadosempresa['config_terca'] : "false");		

				$inputdadosempresa['config_quarta'] = (!empty($inputdadosempresa['config_quarta']) && $inputdadosempresa['config_quarta'] == "true" ? $inputdadosempresa['config_quarta'] : "false");

				$inputdadosempresa['config_quinta'] = (!empty($inputdadosempresa['config_quinta']) && $inputdadosempresa['config_quinta'] == "true" ? $inputdadosempresa['config_quinta'] : "false");

				$inputdadosempresa['config_sexta'] = (!empty($inputdadosempresa['config_sexta']) && $inputdadosempresa['config_sexta'] == "true" ? $inputdadosempresa['config_sexta'] : "false");

				$inputdadosempresa['config_sabado'] = (!empty($inputdadosempresa['config_sabado']) && $inputdadosempresa['config_sabado'] == "true" ? $inputdadosempresa['config_sabado'] : "false");

				$inputdadosempresa['config_domingo'] = (!empty($inputdadosempresa['config_domingo']) && $inputdadosempresa['config_domingo'] == "true" ? $inputdadosempresa['config_domingo'] : "false");


				$inputdadosempresa['config_segundaa'] = (!empty($inputdadosempresa['config_segundaa']) && $inputdadosempresa['config_segundaa'] == "true" ? $inputdadosempresa['config_segundaa'] : "false");	

				$inputdadosempresa['config_tercaa'] = (!empty($inputdadosempresa['config_tercaa']) && $inputdadosempresa['config_tercaa'] == "true" ? $inputdadosempresa['config_tercaa'] : "false");		

				$inputdadosempresa['config_quartaa'] = (!empty($inputdadosempresa['config_quartaa']) && $inputdadosempresa['config_quartaa'] == "true" ? $inputdadosempresa['config_quartaa'] : "false");

				$inputdadosempresa['config_quintaa'] = (!empty($inputdadosempresa['config_quintaa']) && $inputdadosempresa['config_quintaa'] == "true" ? $inputdadosempresa['config_quintaa'] : "false");

				$inputdadosempresa['config_sextaa'] = (!empty($inputdadosempresa['config_sextaa']) && $inputdadosempresa['config_sextaa'] == "true" ? $inputdadosempresa['config_sextaa'] : "false");

				$inputdadosempresa['config_sabadoo'] = (!empty($inputdadosempresa['config_sabadoo']) && $inputdadosempresa['config_sabadoo'] == "true" ? $inputdadosempresa['config_sabadoo'] : "false");

				$inputdadosempresa['config_domingoo'] = (!empty($inputdadosempresa['config_domingoo']) && $inputdadosempresa['config_domingoo'] == "true" ? $inputdadosempresa['config_domingoo'] : "false");


										//COMEÇO A FAZER A GRAVAÇÃO DOS DADOS::::::::::::::::::::::::::::::::::::::::::::::::::
				$lerbanco->ExeRead('ws_empresa', "WHERE user_id = :v", "v={$userlogin['user_id']}");
				if (!$lerbanco->getResult()):		
					$addbanco->ExeCreate("ws_empresa", $inputdadosempresa);
					if ($addbanco->getResult()):												
						echo "<div class=\"alert alert-success alert-dismissable\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
						<b class=\"alert-link\">SUCESSO!</b> Seus dados foram Inseridos no sistema.
						</div>";
						header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
					else:
						echo "<div class=\"alert alert-danger alert-dismissable\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
						<b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
						</div>";
						header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
					endif;

				else:
					$updatebanco->ExeUpdate("ws_empresa", $inputdadosempresa, "WHERE user_id = :up", "up={$userlogin['user_id']}");
					if ($updatebanco->getResult()):
						echo "<div class=\"alert alert-success alert-dismissable\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
						<b class=\"alert-link\">SUCESSO!</b> Seus dados foram Atualizados no sistema.
						</div>";
						header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
					else:
						echo "<div class=\"alert alert-danger alert-dismissable\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
						<b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
						</div>";
						header("Refresh: 5; url={$site}{$Url[0]}/admin-loja");
					endif;
				endif;					

			endif;
			endif;
			?>
			<div class="form-group">
				<label for="nome_empresa">Nome do seu negócio:</label>
				<input class="form-control" required value="<?=(!empty($nome_empresa) ? $nome_empresa : '');?>" name="nome_empresa" id="nome_empresa" type="text">
			</div>
			<div class="form-group">
				<label for="descricao_empresa">Breve descrição do seu negócio:</label>
				<input type="text" required maxlength="297" name="descricao_empresa" class="form-control" placeholder="Digite uma descrição..." value="<?=(!empty($descricao_empresa) ? $descricao_empresa : '');?>" />
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="telefone_empresa">Suporte WhatsApp:</label>
						<input required type="tel" placeholder="(99) 99999-9999" data-mask="(00) 00000-0000" maxlength="15" id="telefone_empresa" name="telefone_empresa" value="<?=(!empty($telefone_empresa) ? $telefone_empresa : '');?>" class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="email_empresa">E-mail:</label>
						<input required type="email" id="email_empresa" value="<?=(!empty($email_empresa) ? $email_empresa : '');?>" name="email_empresa" class="form-control">
					</div>
				</div>
			</div>
			</div><!-- End wrapper_indent -->

			<hr />


			
			<div class="indent_title_in">
				<i class="icon_pin_alt"></i>
				<h3>Endereço</h3>
				<p>
					Defina o endereço do seu negócio!
				</p>
			</div>
			<div class="wrapper_indent">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="estados">ESTADO:</label>
							<select required class="form-control" name="end_uf_empresa" id="estados">
								
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="cidade_empresa">CIDADE:</label>
							<select required class="form-control" name="cidade_empresa" id="cidades">

							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label required for="end_rua_n_empresa">RUA / Nº:</label>
							<input type="text" id="end_rua_n_empresa" value="<?=(!empty($end_rua_n_empresa) ? $end_rua_n_empresa : '');?>" name="end_rua_n_empresa" class="form-control">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="end_bairro_empresa">BAIRRO:</label>
							<input required type="text" id="end_bairro_empresa" value="<?=(!empty($end_bairro_empresa) ? $end_bairro_empresa : '');?>" name="end_bairro_empresa" class="form-control">
						</div>
					</div>
				</div>
			</div><!-- End wrapper_indent -->

			<hr />

			<div class="indent_title_in">
				<i class="fa fa-motorcycle" aria-hidden="true"></i>
				<h3>Opções de entrega</h3>
				<div class="form-group">	

					<div class="icheck-material-green">
						<input <?=(!empty($confirm_delivery) && $confirm_delivery == "true" ? "checked" : "");?> type="checkbox" name="confirm_delivery" value="true" id="confirm_delivery" />
						<label for="confirm_delivery"><strong>Permitir delivery</strong></label>
					</div>
					<div class="icheck-material-green">
						<input <?=(!empty($confirm_balcao) && $confirm_balcao == "true" ? "checked" : "");?> type="checkbox" name="confirm_balcao" value="true" id="confirm_balcao" />
						<label for="confirm_balcao"><strong>Permitir retirada no balcão</strong></label>
					</div>
					<div class="icheck-material-green">
						<input <?=(!empty($confirm_mesa) && $confirm_mesa == "true" ? "checked" : "");?> type="checkbox" name="confirm_mesa" value="true" id="confirm_mesa" />
						<label for="confirm_mesa"><strong>Permitir pedido na mesa</strong></label>
					</div>
				</div>

				<p>
					<span style="color: red;">O valor inserido em "Custo padrão de entrega", será universal se não for adicionando nenhum bairro com taxas diferentes.</span>
					
				</p>
			</div>

			<div class="wrapper_indent">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label for="config_delivery">Custo padrão de entrega:</label>
							<input type="text" required maxlength="11" onkeypress="return formatar_moeda(this, '.', ',', event);" data-mask="#.##0,00" data-mask-reverse="true" class="form-control" id="config_delivery" name="config_delivery" value="<?=(!empty($config_delivery) ? Check::Real($config_delivery) : '0,00');?>" />
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label for="minimo_delivery">Valor Mínimo do Delivery: <small style="color: red;">Opcional</small></label>
							<input type="text" required maxlength="11" onkeypress="return formatar_moeda(this, '.', ',', event);" data-mask="#.##0,00" data-mask-reverse="true" class="form-control" id="minimo_delivery" name="minimo_delivery" value="<?=(!empty($minimo_delivery) ? Check::Real($minimo_delivery) : '0,00');?>" />
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Mensagem sobre tempo de Delivery:</label>
							<input type="text" required class="form-control" id="msg_tempo_delivery" name="msg_tempo_delivery" value="<?=(!empty($msg_tempo_delivery) ? $msg_tempo_delivery : "Entre 30 e 60 minutos.");?>" />
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Mensagem sobre retirar no local:</label>
							<input type="text" required class="form-control" id="msg_tempo_buscar" name="msg_tempo_buscar" value="<?=(!empty($msg_tempo_buscar) ? $msg_tempo_buscar : "Em 30 minutos.");?>" />
						</div>
					</div>
				</div>
			</div>

			<hr />

			<div class="indent_title_in">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
				<h3>Horários de funcionamento</h3>
				<p>
					Defina o seu horário de atendimento para que seus clientes saibam quando seus serviços estiverem disponíveis.
				</p>
			</div>

			<div class="panel panel-default">
				<div style="background-color: #85c99d;color: #ffffff;" class="panel-heading">
					<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">
						<div class="right-arrow pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
						<center><a style="color: #ffffff;" href="#">Cique aqui para Configurar Horários.</a></center>
					</h4>
				</div>
				<div id="collapse1" style="visibility:unset" class="panel-collapse collapse">
					<div class="panel-body">
						
						<div class="wrapper_indent">
							<label>SEGUNDA FEIRA</label>
							<br />
							<input id="config_segunda" name="config_segunda" type="checkbox" <?=(!empty($config_segunda) && $config_segunda == 'true' ? 'checked' : '');?> value="true" /> <label for="config_segunda"><strong style="color:#85c99d;"> PERIODO DA MANHÃ </strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_manha_de">de:</label>									
										<input required type="time" name="segunda_manha_de" id="segunda_manha_de" data-mask="00:00" value="<?=(!empty($segunda_manha_de) && $segunda_manha_de != "00:00" ? $segunda_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_manha_ate">até:</label>
										<input required type="time" name="segunda_manha_ate" id="segunda_manha_ate" data-mask="00:00" value="<?=(!empty($segunda_manha_ate) && $segunda_manha_ate != "00:00" ? $segunda_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<input id="config_segundaa" name="config_segundaa" type="checkbox" <?=(!empty($config_segundaa) && $config_segundaa == 'true' ? 'checked' : '');?> value="true" /> <label for="config_segundaa"><strong style="color:#85c99d;"> PERIODO DA TARDE</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_tarde_de">de:</label>									
										<input required type="time" name="segunda_tarde_de" id="segunda_tarde_de" data-mask="00:00" value="<?=(!empty($segunda_tarde_de) && $segunda_tarde_de != "00:00" ? $segunda_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_tarde_ate">até:</label>
										<input required type="time" name="segunda_tarde_ate" id="segunda_tarde_ate" data-mask="00:00" value="<?=(!empty($segunda_tarde_ate) && $segunda_tarde_ate != "00:00" ? $segunda_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->	
						<hr />
						
						<div class="wrapper_indent">
							<label>TERÇA FEIRA</label>
							<br />
							<input <?=(!empty($config_terca) && $config_terca == 'true' ? 'checked' : '');?> id="config_terca" name="config_terca" value="true" type="checkbox"> <label for="config_terca"><strong style="color:#85c99d;"> PERIODO DA MANHÃ</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_manha_de">de:</label>									
										<input required type="time" name="terca_manha_de" id="segunda_manha_de" data-mask="00:00" value="<?=(!empty($terca_manha_de) && $terca_manha_de != "00:00" ? $terca_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_manha_ate">até:</label>
										<input required type="time" name="terca_manha_ate" id="terca_manha_ate" data-mask="00:00" value="<?=(!empty($terca_manha_ate) && $terca_manha_ate != "00:00" ? $terca_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<input <?=(!empty($config_tercaa) && $config_tercaa == 'true' ? 'checked' : '');?> id="config_tercaa" name="config_tercaa" value="true" type="checkbox"><label for="config_tercaa"><strong style="color:#85c99d;"> PERIODO DA TARDE</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_tarde_de">de:</label>									
										<input required type="time" name="terca_tarde_de" id="terca_tarde_de" data-mask="00:00" value="<?=(!empty($terca_tarde_de) && $terca_tarde_de != "00:00" ? $terca_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_tarde_ate">até:</label>
										<input required type="time" name="terca_tarde_ate" id="terca_tarde_ate" data-mask="00:00" value="<?=(!empty($terca_tarde_ate) && $terca_tarde_ate != "00:00" ? $terca_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						<hr />
						
						<div class="wrapper_indent">
							<label>QUARTA FEIRA</label>
							<br />
							<input <?=(!empty($config_quarta) && $config_quarta == 'true' ? 'checked' : '');?> id="config_quarta" name="config_quarta" value="true" type="checkbox"> <label for="config_quarta"><strong style="color:#85c99d;"> PERIODO DA MANHÃ</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_manha_de">de:</label>									
										<input required type="time" name="quarta_manha_de" id="quarta_manha_de" data-mask="00:00" value="<?=(!empty($quarta_manha_de) && $quarta_manha_de != "00:00" ? $quarta_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_manha_ate">até:</label>
										<input required type="time" name="quarta_manha_ate" id="quarta_manha_ate" data-mask="00:00" value="<?=(!empty($quarta_manha_ate) && $quarta_manha_ate != "00:00" ? $quarta_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<input <?=(!empty($config_quartaa) && $config_quartaa == 'true' ? 'checked' : '');?> id="config_quartaa" name="config_quartaa" value="true" type="checkbox"><label for="config_quartaa"><strong style="color:#85c99d;"> PERIODO DA TARDE</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_tarde_de">de:</label>									
										<input required type="time" name="quarta_tarde_de" id="quarta_tarde_de" data-mask="00:00" value="<?=(!empty($quarta_tarde_de) && $quarta_tarde_de != "00:00" ? $quarta_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_tarde_ate">até:</label>
										<input required type="time" name="quarta_tarde_ate" id="quarta_tarde_ate" data-mask="00:00" value="<?=(!empty($quarta_tarde_ate) && $quarta_tarde_ate != "00:00" ? $quarta_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						<hr />
						<div class="wrapper_indent">
							<label>QUINTA FEIRA</label>
							<br />
							<input <?=(!empty($config_quinta) && $config_quinta == 'true' ? 'checked' : '');?> id="config_quinta" name="config_quinta" value="true" type="checkbox"> <label for="config_quinta"><strong style="color:#85c99d;"> PERIODO DA MANHÃ</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_manha_de">de:</label>									
										<input required type="time" name="quinta_manha_de" id="quinta_manha_de" data-mask="00:00" value="<?=(!empty($quinta_manha_de) && $quinta_manha_de != "00:00" ? $quinta_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_manha_ate">até:</label>
										<input required type="time" name="quinta_manha_ate" id="quinta_manha_ate" data-mask="00:00" value="<?=(!empty($quinta_manha_ate) && $quinta_manha_ate != "00:00" ? $quinta_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<input <?=(!empty($config_quintaa) && $config_quintaa == 'true' ? 'checked' : '');?> id="config_quintaa" name="config_quintaa" value="true" type="checkbox"><label for="config_quintaa"><strong style="color:#85c99d;"> PERIODO DA TARDE</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_tarde_de">de:</label>									
										<input required type="time" name="quinta_tarde_de" id="quinta_tarde_de" data-mask="00:00" value="<?=(!empty($quinta_tarde_de) && $quinta_tarde_de != "00:00" ? $quinta_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_tarde_ate">até:</label>
										<input required type="time" name="quinta_tarde_ate" id="quinta_tarde_ate" data-mask="00:00" value="<?=(!empty($quinta_tarde_ate) && $quinta_tarde_ate != "00:00" ? $quinta_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						<hr />

						<div class="wrapper_indent">
							<label>SEXTA FEIRA</label>
							<br />
							<input <?=(!empty($config_sexta) && $config_sexta == 'true' ? 'checked' : '');?> id="config_sexta" name="config_sexta" value="true" type="checkbox"> <label for="config_sexta"><strong style="color:#85c99d;"> PERIODO DA MANHÃ</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_manha_de">de:</label>									
										<input required type="time" name="sexta_manha_de" id="sexta_manha_de" data-mask="00:00" value="<?=(!empty($sexta_manha_de) && $sexta_manha_de != "00:00" ? $sexta_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_manha_ate">até:</label>
										<input required type="time" name="sexta_manha_ate" id="sexta_manha_ate" data-mask="00:00" value="<?=(!empty($sexta_manha_ate) && $sexta_manha_ate != "00:00" ? $sexta_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<input <?=(!empty($config_sextaa) && $config_sextaa == 'true' ? 'checked' : '');?> id="config_sextaa" name="config_sextaa" value="true" type="checkbox"> <label for="config_sextaa"><strong style="color:#85c99d;"> PERIODO DA TARDE</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_tarde_de">de:</label>									
										<input required type="time" name="sexta_tarde_de" id="sexta_tarde_de" data-mask="00:00" value="<?=(!empty($sexta_tarde_de) && $sexta_tarde_de != "00:00" ? $sexta_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_tarde_ate">até:</label>
										<input required type="time" name="sexta_tarde_ate" id="sexta_tarde_ate" data-mask="00:00" value="<?=(!empty($sexta_tarde_ate) && $sexta_tarde_ate != "00:00" ? $sexta_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						<hr />
						
						<div class="wrapper_indent">
							<label>SABADO</label>
							<br />
							<input <?=(!empty($config_sabado) && $config_sabado == 'true' ? 'checked' : '');?> id="config_sabado" name="config_sabado" value="true" type="checkbox"> <label for="config_sabado"><strong style="color:#85c99d;"> PERIODO DA MANHÃ</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_manha_de">de:</label>									
										<input required type="time" name="sabado_manha_de" id="sabado_manha_de" data-mask="00:00" value="<?=(!empty($sabado_manha_de) && $sabado_manha_de != "00:00" ? $sabado_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_manha_ate">até:</label>
										<input required type="time" name="sabado_manha_ate" id="sabado_manha_ate" data-mask="00:00" value="<?=(!empty($sabado_manha_ate) && $sabado_manha_ate != "00:00" ? $sabado_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<input <?=(!empty($config_sabadoo) && $config_sabadoo == 'true' ? 'checked' : '');?> id="config_sabadoo" name="config_sabadoo" value="true" type="checkbox"> <label for="config_sabadoo"><strong style="color:#85c99d;"> PERIODO DA TARDE</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_tarde_de">de:</label>									
										<input required type="time" name="sabado_tarde_de" id="sabado_tarde_de" data-mask="00:00" value="<?=(!empty($sabado_tarde_de) && $sabado_tarde_de != "00:00" ? $sabado_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_tarde_ate">até:</label>
										<input required type="time" name="sabado_tarde_ate" id="sabado_tarde_ate" data-mask="00:00" value="<?=(!empty($sabado_tarde_ate) && $sabado_tarde_ate != "00:00" ? $sabado_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						<hr />
						
						<div class="wrapper_indent">
							<label>DOMINGO</label>
							<br />
							<input <?=(!empty($config_domingo) && $config_domingo == 'true' ? 'checked' : '');?> id="config_domingo" name="config_domingo" value="true" type="checkbox"> <label for="config_domingo"><strong style="color:#85c99d;"> PERIODO DA MANHÃ</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_manha_de">de:</label>									
										<input required type="time" name="domingo_manha_de" id="domingo_manha_de" data-mask="00:00" value="<?=(!empty($domingo_manha_de) && $domingo_manha_de != "00:00" ? $domingo_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_manha_ate">até:</label>
										<input required type="time" name="domingo_manha_ate" id="domingo_manha_ate" data-mask="00:00" value="<?=(!empty($domingo_manha_ate) && $domingo_manha_ate != "00:00" ? $domingo_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<input <?=(!empty($config_domingoo) && $config_domingoo == 'true' ? 'checked' : '');?> id="config_domingoo" name="config_domingoo" value="true" type="checkbox"><label for="config_domingoo"><strong style="color:#85c99d;"> PERIODO DA TARDE</strong></label>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_tarde_de">de:</label>									
										<input required type="time" name="domingo_tarde_de" id="domingo_tarde_de" data-mask="00:00" value="<?=(!empty($domingo_tarde_de) && $domingo_tarde_de != "00:00" ? $domingo_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_tarde_ate">até:</label>
										<input required type="time" name="domingo_tarde_ate" id="domingo_tarde_ate" data-mask="00:00" value="<?=(!empty($domingo_tarde_ate) && $domingo_tarde_ate != "00:00" ? $domingo_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
					</div>
				</div>
			</div>

			<hr />

			<div class="indent_title_in">
				<i class="fa fa-calendar" aria-hidden="true"></i>
				<h3>Fechado na Data</h3>
				<p>
					Adicione exceções (ótimo para feriados etc.)
				</p>
			</div>

			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div style="background-color: #85c99d;color: #ffffff;" class="panel-heading">
						<h4 data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="panel-title expand">
							<div class="right-arrow pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
							<center><a style="color: #ffffff;" href="#">Clique aqui para adicionar uma data</a></center>
						</h4>
					</div>

					<div id="collapse2" style="visibility:unset" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="datepicker">Inserir Data:</label>
									<input type="text" class="form-control" name='data_close' id="datepicker" data-mask="00/00/0000" placeholder="00/00/0000" />
								</div>					
								<label for="datepicker">Fechado nas Datas:</label><br />
								<?php
								$lerbanco->ExeRead("ws_datas_close", "WHERE user_id = :userid ORDER BY id ASC", "userid={$userlogin['user_id']}");
								if($lerbanco->getResult()):						
									foreach ($lerbanco->getResult() as $dadosC):
										extract($dadosC);		

										$i = explode('/', $data);
										$i = array_reverse($i);
										$i = implode("-", $i);							

										if(isDateExpired($i, 1)):
											?>

											<a title="Deletar" href="<?=$site.$Url[0].'/admin-loja&dellDate='.$id.'#sendempresa';?>">
												<button type="button" class="btn btn-danger">
													<strong><?=$data;?> = </strong> <span class="glyphicon glyphicon-trash"></span>
												</button>
											</a>
											<?php
										endif;
									endforeach;
								else:								
								endif;
								?>				
							</div>
						</div>


					</div>
				</div>

				<hr />
				


				

				<div class="indent_title_in">
					<i class="fa fa-share-square-o" aria-hidden="true"></i>
					<h3>Redes Sociais</h3>
					<p>
						Insira as urls de suas redes sociais!
					</p>
				</div>

				<div class="wrapper_indent">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="facebook_status">Facebook Status:</label>
								<select required class="form-control" name="facebook_status">
									<?php 
									if(!empty($facebook_status) && $facebook_status == 2):
										echo "
										<option value=\"2\">Mostrar no Site</option>
										<option value=\"1\">Não Mostrar no Site</option>			
										";

									else:
										echo "
										<option value=\"1\">Não Mostrar no Site</option>
										<option value=\"2\">Mostrar no Site</option>	
										";
									endif;
									?>					
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="facebook_empresa">Facebook URL:</label>
								<input type="text" placeholder="https://www.facebook.com/Meu_Perfil" class="form-control" value="<?=(!empty($facebook_empresa) ? $facebook_empresa : "");?>" name="facebook_empresa" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="instagram_status">Instgram Status:</label>
								<select required class="form-control" name="instagram_status">
									<?php 
									if(!empty($instagram_status) && $instagram_status == 2):
										echo "
										<option value=\"2\">Mostrar no Site</option>
										<option value=\"1\">Não Mostrar no Site</option>			
										";

									else:
										echo "
										<option value=\"1\">Não Mostrar no Site</option>
										<option value=\"2\">Mostrar no Site</option>	
										";
									endif;
									?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="instagram_empresa">Instgram URL:</label>
								<input type="text" placeholder="https://www.instagram.com/Meu_Perfil" class="form-control" value="<?=(!empty($instagram_empresa) ? $instagram_empresa : "");?>" name="instagram_empresa" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="twitter_status">Twitter Status:</label>
								<select required class="form-control" name="twitter_status">
									<?php 
									if(!empty($twitter_status) && $twitter_status == 2):
										echo "
										<option value=\"2\">Mostrar no Site</option>
										<option value=\"1\">Não Mostrar no Site</option>			
										";

									else:
										echo "
										<option value=\"1\">Não Mostrar no Site</option>
										<option value=\"2\">Mostrar no Site</option>	
										";
									endif;
									?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="twitter_empresa">Twitter URL:</label>
								<input type="text" placeholder="https://twitter.com/Meu_Perfil" class="form-control" value="<?=(!empty($twitter_empresa) ? $twitter_empresa : "");?>" name="twitter_empresa" >
							</div>
						</div>
					</div>
				</div><!-- End wrapper_indent -->

				<div class="indent_title_in">
					<i class="icon_images"></i>
					<h3>Imagens de fundo e de Perfil</h3>
					<p>
						Imagens que serão usadas na página inicial do site!
					</p>
				</div>

				<div class="wrapper_indent add_bottom_45">

					<div class="form-group">
						<label>Imagem utilizada como banner de fundo no site:</label>
						<div class="input-file-container">  
							<input name="img_header" class="input-file" id="my-file" type="file" />
							<label tabindex="0" for="my-file" class="input-file-trigger">Enviar Imagem...</label>
						</div>
						<p class="file-return"></p>
						<br />
						<?=(!empty($img_header) ? "<spa style=\"color:#70bb0f;\">VOCÊ JÁ ENVIOU UMA IMAGEM!</span>" : "");?>
					</div>	

					<div class="form-group">
						<label>Imagem de perfil, será redimensionada em 240 X 240:</label>
						<div class="input-file-container">  
							<input name="img_logo" class="input-file" id="my-file" type="file" />
							<label tabindex="0" for="my-file" class="input-file-trigger">Enviar Imagem...</label>
						</div>
						<p class="file-return"></p>
						<br />
						<?=(!empty($img_logo) ? "<spa style=\"color:#70bb0f;\">VOCÊ JÁ ENVIOU UMA IMAGEM!</span>" : "");?>
					</div>
				</div><!-- End wrapper_indent -->
				<div class="wrapper_indent add_bottom_45">
				</div><!-- End wrapper_indent -->
				<hr />
				<div class="wrapper_indent">
					<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>" />
					<input type="hidden" name="sendempresa" value="true" />
					<button type="input" class="btn_1">SALVAR ALTERAÇOES</button>
					<b style="float: right;color: green;font-weight: bold;">Data de Renovação: 
						<?php
						echo $dataFomatadarenovacao;
						?></b>
					</div><!-- End wrapper_indent -->
					<div class="panel-group" id="accordion">

					</form>

				</section><!-- End section 1 -->

</div>
		</div>
				</div>
		 
 

 
	<script src="js/flowbite.min.js"></script>


	 


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

<script>
	$( function() {
		$( "#datepicker" ).datepicker();
	} );
</script>



<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js'></script>


<!-- SPECIFIC SCRIPTS -->
<script  src="<?= $site; ?>js/cat_nav_mobile.js"></script>
<script>$('#cat_nav').mobileMenu();</script>
<script src="<?= $site; ?>js/theia-sticky-sidebar.js"></script>
<script>
	jQuery('#sidebar').theiaStickySidebar({
		additionalMarginTop: 80
	});
</script>
<script>
	$('#cat_nav a[href^="#"]').on('click', function (e) {
		e.preventDefault();
		var target = this.hash;
		var $target = $(target);
		$('html, body').stop().animate({
			'scrollTop': $target.offset().top - 70
		}, 900, 'swing', function () {
			window.location.hash = target;
		});
	});
</script>


<?php
if(!empty($_SESSION['userlogin'])):
	?>
	<!-- Specific scripts -->
	<script src="<?= $site; ?>js/tabs.js"></script>

	<script type="text/javascript">
		$('#delete').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var recipient = button.data('whatever') // Extract info from data-* attributes
			  var recipientnome = button.data('whatevernome') // Extract info from data-* attributes
			  var recipientimg = button.data('whateverimg') // Extract info from data-* attributes
			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			  var modal = $(this)
			  modal.find('.modal-title').text(recipientnome)
			  modal.find('#campo_id').val(recipient)
			  modal.find('#campo_img').val(recipientimg)
			})
		</script>

		<script>

			$('#dinheiro').mask('#.##0,00', {reverse: true});
			$('.telefone').mask('(00) 0 0000-0000');
			$('.estado').mask('AA');
			$('.cpf').mask('000-000.000-00');
			$('.cnpj').mask('00.000.000/0000-00');
			$('.rg').mask('00.000.000-0');
			$('.cep').mask('00000-000');
			$('.dataNascimento').mask('00/00/0000');
			$('.placaCarro').mask('AAA-0000');
			$('.horasMinutos').mask('00:00');
			$('.cartaoCredito').mask('0000 0000 0000 0000');
			$('.numero').mask('#########0');
			$('.descontoporcentagem').mask('##0');



		</script>
		<?php
	else:
	endif;
	?>


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
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
             (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
             return;
         }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        	e.preventDefault();
        }
    });






	//if ($("#soma-delivery").prop("checked", true)){
		
	//}
</script>
<script>
	$( function() {
		$( "#datepicker" ).datepicker();
	} );
</script>



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

<script type="text/javascript">
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



ob_end_flush();
?>

