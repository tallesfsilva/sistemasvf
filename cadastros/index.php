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
		<link href="<?= $site; ?>css/jquery.peekabar.min.css" rel="stylesheet">

 
<!-- BASE CSS -->

		
		<link href="<?=$site;?>css/icheck/icheck-material.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?= $site;?>css/bootstrap.min.css">
		 

		
		<link href="<?=$site;?>css/icheck/icheck-material.css" rel="stylesheet">
	
		 
<!-- 
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">



		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css'> -->



		<!-- Radio and check inputs -->
		 
		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/normalize.css" />
			
			<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/uploads/component.css" />
		<link href="<?= $site; ?>css/skins/square/grey.css" rel="stylesheet">
		
		<link href="<?= $site; ?>css/tailwind.min.css" rel="stylesheet">
		<link href="<?= $site; ?>css/flowbite.min.css" rel="stylesheet">
		<?php
		if(!empty($_SESSION['userlogin'])):
			?>
			<link href="<?= $site; ?>css/skins/square/green.css" rel="stylesheet">
			<link href="<?= $site; ?>css/admin.css" rel="stylesheet">
			<link href="<?= $site; ?>css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
			<link href="<?= $site; ?>css/dropzone.css" rel="stylesheet">


			<?php
		else:
		endif;
		?>

		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/modal/frappuccino-modal.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="<?= $site; ?>css/modal/popupmodal.css" />
	  
		<script src="<?= $site; ?>js/jquery-2.2.4.min.js"></script>
		
		<link href="<?=$site;?>css/style-configuracao.css" rel="stylesheet">


		<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script> -->


		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>


	

		

			<!--https://gao-sun.github.io/x0popup/-->
			<link href="<?= $site; ?>css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
			<script src="<?= $site; ?>css/x0popup-master/dist/x0popup.min.js"></script>

			<script src="<?= $site; ?>js/jquery.gotop.js"></script>
			

			<!-- <script src="<?= $site; ?>js/player.js"></script> -->
			<script src="<?= $site; ?>js/howler.js"></script>

 

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
			var options_cidades = '<option value="">Selecione uma cidade</option>';	
			$.each(data, function (key, val) {
				if(val.sigla == str) {	
					options_cidades = "";									
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



		 


			<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/JNKKKK/MoreToggles.css@0.2.1/output/moretoggles.min.css"> -->

			<!-- Select da pagina carrinho -->
			<link href="<?=$site?>css/selectcarrinho/dist/css/select2.min.css" rel="stylesheet" />
			<script src="<?=$site?>css/selectcarrinho/dist/js/select2.min.js"></script>
			<!-- Select da pagina carrinho -->


			<!-- Radio and check inputs -->
			<link href="<?= $site; ?>css/radio-check.css" rel="stylesheet">
			<link href="<?= $site; ?>css/modal.css" rel="stylesheet">
			<!-- <script type="text/javascript" src="<?= $site; ?>js/modalhorarios.js"></script>  -->
			<!-- https://www.cssscript.com/pure-css-checkbox-radio-button-replacement-bootstrap-icheck/ -->
			<link href="<?= $site; ?>notificacao/light-theme.min.css" rel="stylesheet">
			<link href="<?= $site; ?>css/chackbox/dist/css/checkboxes.css" rel="stylesheet">
			<link href="<?=$site;?>css/icheck/icheck-material.css" rel="stylesheet">
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

			 		 #btn-2:after,#btn-3:after,#btn-4:after,#btn-1:after {
						font-family: "Glyphicons Halflings";
						content: "\e080";
					 
						right: 0;
						position: absolute;
						margin-right:4px;
						}

						/* Icon when the collapsible content is hidden */
						#btn-2.collapsed:after,#btn-3.collapsed:after,#btn-4.collapsed:after,#btn-1.collapsed:after {
					
						content: "\e114";
					}

				ul > li > a > span{
					 left: 25px;
 					 position: relative
				}
				li > div > button > img{
					position: relative;
					left: 2px;
					width:24px;
					height:24px;
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

		 
		 



		



		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css'>



		<!-- Radio and check inputs -->
		<link href="<?= $site; ?>css/skins/square/grey.css" rel="stylesheet">
			



		 

		 
 
 
		 
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
					<aside style="width: 211.33px; background:#7233A1; box-shadow: 2px 2px 2px 2px gray;" id="default-sidebar" class="fixed top-0 left-0 z-40 w-90 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
				 
					<div style="margin-top:10px; background: #7233A1;box-shadow: 0px 1px 1px black" class="mx-auto flex-row justify-center flex lg:mx-0 text-white font-bold  py-4 px-10 shadow-lg focus:outline-none focus:shadow-outline">
					<div class="flex flex-row">			
						 		
								<div class="w-full self-center">
									<span style="font-size:23px;">Cadastros</span>
								</div>
							</div>
						</div>
 	
			<div  style="background: #7233A1" class="h-full overflow-y-auto bg-gray-50 dark:bg-gray-800">
				
			<ul id="side-bar-menu" class="space-y-2 font-medium text-white">
						 <div id="accordion" aria-multiselectable="true" role="tablist">
       				  <li style="border-color: #837979" class="w-full border-t">
			
					<div style="background-color: #7233A1;color: #ffffff;" class="head-panel">
						
						<button id="btn-1" href="#collapse-1" data-toggle="collapse" aria-controls="collapse-1" aria-expanded="false" class="mt-2 mb-2 flex btn-menu panel-title expand collapsed items-center p-2 rounded-lg text-white  group">
						<img src="<?=URL_IMAGE.'img/produto1.png'?>"/>
						 
				<span class="flex-1 ml-3  ">Produtos</span>
		
		</button>

			<div id="collapse-1" data-parent="#accordion" class="collapse">
						<div class="flex flex-col">
							 
									<ul style="background:#9C42DD" class="font-medium text-white">
          
         					 

							<li style="border-color: #837979" class="w-full border-t">
		 
		 <a href="<?=$site.'cadastros/'?>view-item" target="_parent" class="mt-2 mb-2 flex items-center p-2 rounded-lg text-white  group">
		 
 <span class="flex-1 ml-3  ">Meus Produtos</span>

			 </a>
	
 </li>
 
 <li style="border-color: #837979;" class="w-full border-t">
		 
		 <a href="<?=$site.'cadastros/'?>categorias" target="_parent" class="mt-2 mb-2 flex items-center p-2 rounded-lg text-white  group">
		 
 <span class="flex-1 ml-3  ">Cadastrar Categorias</span>

			 </a>

 </li>
		</ul>

					 
            
				</div>
					</div>
		</div>
 

			
		 
         </li>
		 
		 <li style="border-color: #837979" class="w-full border-t">
				 
					<div style="background-color: #7233A1;color: #ffffff;" class="head-panel">
						
			<button id="btn-2"  href="#collapse-2"   data-toggle="collapse" aria-controls="collapse-2" aria-expanded="false" class="mt-2 mb-2 flex btn-menu panel-title collapsed expand items-center p-2 rounded-lg text-white  group">
			<img src="<?=URL_IMAGE.'img/financeiro1.png'?>"/>
               <span class="flex-1 ml-3  ">Financeiro</span>
		
		</button>

			<div id="collapse-2" aria-expanded="false" data-parent="#accordion" class="collapse">
						<div class="flex flex-col">
							 
									<ul style="background:#9C42DD" class="space-y-2 font-medium text-white">
          
         						<li style="border-color: #837979" class="w-full border-t">
		 
           						 <a href="<?=$site.'cadastros/'?>cadastrar-formas-pagamento" target="_parent" class="mt-2 mb-2 flex items-center p-2 rounded-lg text-white  group">
              						 
							<span class="flex-1 ml-3  ">Formas de Pagamentos</span>
		
           							 </a>
		 
       					 </li>

						 
		</ul>

					 
            
				</div>
					</div>
		</div>
	 

			
		 
         </li>
	 
		 <li style="border-color: #837979" class="w-full border-t">
			 
					<div style="background-color: #7233A1;color: #ffffff;" class="head-panel">
						
					<button id="btn-3"  href="#collapse-3" data-toggle="collapse" aria-controls="collapse-3" aria-expanded="false" class="mt-2 mb-2 flex btn-menu panel-title collapsed expand items-center p-2 rounded-lg text-white  group">
					<img src="<?=URL_IMAGE.'img/delivery1.png'?>"/>
               <span class="flex-1 ml-3  ">Delivery</span>
		
		</button>

			<div id="collapse-3" class="collapse">
						<div class="flex flex-col">
							 
									<ul style="background:#9C42DD" class="space-y-2 font-medium text-white">
          
         						<li style="border-color: #837979" class="w-full border-t">
		 
           						 <a href="<?=$site.'cadastros/'?>enderecos-delivery" target="_parent" class="mt-2 mb-2 flex items-center p-2 rounded-lg text-white  group">
              						 
							<span class="flex-1 ml-3  ">Taxa de Entrega</span>
		
           							 </a>
		 
       					 </li>

						 
		</ul>

					 
            
				</div>
					</div>
		</div>
	

			
		 
         </li>

		 <li style="border-color: #837979" class="w-full border-t border-b">
				 <div  class="head-panel">
					<div style="background-color: #7233A1;color: #ffffff;" class="">
						
					<button id="btn-4"  href="#collapse-4"  id="btn_4" data-toggle="collapse" aria-controls="collapse-4" aria-expanded="false" class="mt-2 mb-2 flex btn-menu panel-title collapsed expand items-center p-2 rounded-lg text-white  group">
					<img src="<?=URL_IMAGE.'img/promocao1.png'?>"/>
              		 <span class="flex-1 ml-2  ">Promoções</span>
		
						</button>
 

			<div id="collapse-4"   class="collapse">
						<div class="flex flex-col">
							 
									<ul style="background:#9C42DD" class="space-y-2 font-medium text-white">
          
         						<li style="border-color: #837979" class="w-full border-t">
		 
           						 <a href="<?=$site.'cadastros/'?>cupom-desconto" target="_parent" class="mt-2 mb-2 flex items-center p-2 rounded-lg text-white  group">
              					 
							<span class="flex-1 ml-3  ">Cupons de Desconto</span>
		
           							 </a>
		 
       					 </li>

						 
		</ul>

					 
            
				</div>
					</div>
		</div>
		</div>

			
		 
         </li>
         
		</div>
         
      </ul>
	  <ul  class="fixed w-1/2 md:w-full bottom-0 pt-4 mt-4 dark:border-gray-700">
        
       
         <li class="md:w-full">

		 <a class="md:w-full" href="<?=$site;?>">
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
					<img id="img_container" style="width: 400px;height: 300px;" src="../../Imagens/INICIO.png"/>	

						</div>
				</div>
				

				<script>
	$( function() {


		
		$( "#datepicker" ).datepicker();
		
		$('.btn-menu').on('click', function(e){
			  
  			 
					jQuery('#accordion .collapse').collapse('hide');
 
		 
	})
	} );
</script>




 
<script src="<?= $site; ?>js/flowbite.min.js"></script>
<script src="<?= $site; ?>js/bootstrap.js"></script>
<!-- <script src="<?= $site; ?>js/functions.js"></script> -->
<script src="<?= $site; ?>assets/validate.js"></script>
<script src="<?= $site; ?>js/jquery.mask.js"></script>
<!-- <script src="<?= $site; ?>js/index-btn-file.js"></script> -->
<script src="<?= $site; ?>js/funcoesjs.js"></script>
<script src="<?= $site; ?>js/custom-file-input.js"></script>
<script src="<?= $site; ?>js/bootstrap-datepicker.js"></script>
<!-- <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script> -->
<script src="<?= $site; ?>js/parallax.js"></script>
<script src="<?= $site; ?>js/parallax.min.js"></script>
<script src="<?= $site; ?>js/printThis.js"></script>
<script src="<?=$site;?>js/suportewats.js"></script>
<script src="<?=$site;?>js/jquery.peekabar.min.js"></script>

		</body> 
</html>
<?php



ob_end_flush();
?>