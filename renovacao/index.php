<?php
ob_start();
 
session_cache_expire(60);
session_start();

require('../_app/Config.inc.php');

$site = HOME;
$login = LOGIN; 
 
$Url[1] = (empty($Url[1]) ? null : $Url[1]);

$site = HOME;



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

	<body class="leading-normal tracking-normal  overflow-hidden text-white" style="background-image: url('<?=$site.'/img/bg_1.png'?>'); background-repeat:no-repeat;background-size: cover;">
 
	<div id="renovacao" class="container">
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
	<div class="container-fluid">
    <div class="flex h-screen justify-center w-full place-items-center" role="alert">
		 
			<div class="flex" style="border:2px solid black">
				<img src="<?=$site ?>img/pngwing_1.png">
	 
	</div>
	</div>
        
</div>

<?php
elseif(diasDatas(date('Y-m-d'), $empresa_data_renovacao) == 0 && !empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId):
 
?>

<div class="alert alert-danger alert-dismissible" role="alert">
<strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> OBSERVAÇÃO: </strong>Seu plano expira hoje.
<form action="<?=$site;?>mercadopago/processapagamentomp.php" method="POST">
    <script
    src="https://www.mercadopago.com.br/integrations/v1/web-tokenize-checkout.js"
    data-public-key="<?=$texto['publickey'];?>"				
    data-button-label="Pagar assinatura"
    data-transaction-amount="<?=$valorplano;?>"
    data-summary-product-label="<?=$nomeplano;?>">
</script>
</form>
</div>
<?php

elseif(diasDatas(date('Y-m-d'), $empresa_data_renovacao) > 1 && diasDatas(date('Y-m-d'), $empresa_data_renovacao) < 3 && !empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId):
 
?>

<div class="alert alert-danger alert-dismissible" role="alert">
<strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> OBSERVAÇÃO: </strong>Seu plano expira em <?=diasDatas(date('Y-m-d'), $empresa_data_renovacao)?> dias.
<form action="<?=$site;?>mercadopago/processapagamentomp.php" method="POST">
<script
src="https://www.mercadopago.com.br/integrations/v1/web-tokenize-checkout.js"
data-public-key="<?=$texto['publickey'];?>"				
data-button-label="Pagar assinatura"
data-transaction-amount="<?=$valorplano;?>"
data-summary-product-label="<?=$nomeplano;?>">
</script>
</form>
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