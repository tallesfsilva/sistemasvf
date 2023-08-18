<?php
ob_start();
session_cache_expire(60);
session_start();
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
$detect = new Mobile_Detect;
$site = HOME; 

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>S.V.F - Recuperar Senha</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">

	<!--===============================================================================================-->
	<link href="<?=$site;?>css/suportewats.css" rel="stylesheet">
	<link href="<?=$site;?>css/flowbite.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
						<?php					

					 	$error = "";

					if (isset($_GET["key"]) && isset($_GET["action"]) 
						&& ($_GET["action"]=="reset") && !isset($_POST["action"])){
						 
						$curDate = date("Y-m-d H:i:s");
						$data = filter_input_array(INPUT_GET, FILTER_DEFAULT);
						
						$key = $data["key"];						 
					 
						$read = new Read;

						$read->ExeRead("password_reset_temp", "WHERE keyString = :e", "e={$key}");
						if(!$read->getResult()){
						?>
									<div class="limiter">
										<div class="container-login100">
											<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
														<img style="margin: 0 auto; max-width: 70%;" src="/Imagens/INICIO.png"/>
														<span class="login100-form-title p-b-32" style="margin-top: 15px;font-size: 20px;">
				 
														</span>
														<p style="text-align: center;margin-top: 20px; " class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
															Link inválido. <a class="text-lg text-bold font-bold text-gray-500 dark:text-gray-400" href="<?php echo $site.'/login'?>">Clique aqui</a> para gerar uma nova solicitação de redefinição de senha
															</p>		
													</div>	
											</div>	
									</div>			 						
						<?php			
						}else{

							$expDate = $read->getResult()[0]['expDate'];
							$email = $read->getResult()[0]['email'];
							 
							if($expDate >= $curDate && $email){
							?>
								<div class="limiter">
										<div class="container-login100">
								<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
								<img style="margin: 0 auto; max-width: 70%;" src="/Imagens/INICIO.png"/>
								
								<h3 id="msg_recover_1" style="display: none;text-align: center;margin-top: 20px;margin-bottom: 20px;" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"></h3>
									<form method="post" class="login100-form validate-form flex-sb flex-w">
									<span class="login100-form-title p-b-32" style="margin-top: 15px;font-size: 20px;">
									<center id="msg" >Redefinição de Senha</center>
								</span>
									
									<span class="txt1 p-b-11">
										Senha
									</span>
									<div class="wrap-input100 validate-input m-b-36" data-validate = "Senhas não conferem">
										<input hidden name="email" value="<?=$email?>"/>
										<input type="hidden" name="action" value="update" />
										<span class="btn-show-pass">
											<i class="fa fa-eye"></i>
										</span>
										<input class="input100" type="password" name="senha1" >
										<span class="focus-input100"></span>
									</div>

									<span class="txt1 p-b-11">
										Confirmar Senha
									</span>
									<div class="wrap-input100 validate-input m-b-12" data-validate = "Senhas não conferem">
										<span class="btn-show-pass">
											<i class="fa fa-eye"></i>
										</span>
										<input class="input100" type="password" name="senha2" >
										<span class="focus-input100"></span>
									</div>
					
								<div class="container-login100-form-btn">
										<button class="login100-form-btn" style="background-color: #7233a1;">
											Recuperar Senha
										</button>
									</div>

								</form>
			<?php
			}else{
			?>
							<div class="limiter">
										<div class="container-login100">
											<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">																	
												<img style="margin: 0 auto; max-width: 70%;" src="/Imagens/INICIO.png"/>									 
												<p style="text-align: center;margin-top: 20px; " class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
												O link enviado expirou. <a class="text-lg text-bold font-bold text-gray-500 dark:text-gray-400" href="<?php echo $site.'/login'?>">Clique aqui</a>
												para gerar uma nova solicitação de redefinição de senha</p>
										</div> 
									</div>
								</div>  
				
			<?php				
				}
			}						
			 
			}else{
				header("Location: {$site}/login");
			  }

			?>
	<style type="text/css">
				#social_footer{
	text-align:center;
	border-top:1px solid #ededed;
	padding-top:30px;
	margin-top:30px;
}
#social_footer p{
	font-size:12px;
	color:#8c8c8c;
}
#social_footer ul{
	margin:0;
	padding:0 0 10px 0;
	text-align:center;
}
#social_footer ul li{
	display:inline-block;
	margin:0 5px 10px 5px;
}
#social_footer ul li a{
	color:white;
	text-align:center;
	line-height:34px;
	display:block;
	font-size:16px;
	width:35px;
	height:35px;
	background-color:#7233a1;
	-webkit-border-radius: 50%;
	-moz-border-radius: 50%;
	border-radius: 50%;
}
#social_footer ul li a:hover{
	background:#fff;
	color:#111;
}
			</style>
			<div id="social_footer">
        <ul>
          <li><a target="_blank" href="<?=(!empty($texto['link_do_face']) ? $texto['link_do_face'] : "");?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
          <!--<li><a href="#0"><i class="icon-twitter"></i></a></li>-->
          <!--<li><a href="#0"><i class="icon-google"></i></a></li>-->
          <li><a target="_blank" href="<?=(!empty($texto['link_do_insta']) ? $texto['link_do_insta'] : "");?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
          <!--<li><a href="#0"><i class="icon-pinterest"></i></a></li>-->
          <!--<li><a href="#0"><i class="icon-vimeo"></i></a></li>-->
          <li><a target="_blank" href="<?=(!empty($texto['link_do_insta']) ? $texto['link_do_insta'] : "");?>"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
        </ul>    
      </div>
		</div>
	</div>

</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
<script src="<?=$site;?>js/suportewats.js"></script>






<div id='whatsapp-chat' class='hide'>
  <div class='header-chat'>
    <div class='head-home'>
      <h3 style="color: #ffffff;">    
        <?php
        $hr = date(" H ");
        if($hr >= 12 && $hr<18) {
          $resp = "Boa tarde!";}
          else if ($hr >= 0 && $hr <12 ){
            $resp = "Bom dia!";}
            else {
              $resp = "Boa noite!";}
              echo "$resp";
              ?>
            </h3>
            <p style="color:#ffffff;">Clique em um de nossos representantes abaixo para conversar no WhatsApp ou envie um email para <?=$texto['emailSuporteSite'];?></p></div>
            <div class='get-new hide'><div id='get-label'></div><div id='get-nama'></div></div></div>
            <div class='home-chat'>
              <!-- Info Contact Start -->
              <a class='informasi' href='javascript:void' title='Chat Whatsapp'>
                <div class='info-avatar'><img src='<?=$site?>img/supportmale.png'/></div>
                <div class='info-chat'>
                  <span class='chat-label'>Suporte Técnico</span>
                  <span class='chat-nama'>Atendimento ao Cliente 1</span>
                </div><span class='my-number'><?=$texto['telefoneAdministracaoTecnica'];?></span>
              </a>
              <!-- Info Contact End -->
              <!-- Info Contact Start -->
              <a class='informasi' href='javascript:void' title='Chat Whatsapp'>
                <div class='info-avatar'><img src='<?=$site?>img/supportfemale.png'/></div>
                <div class='info-chat'>
                  <span class='chat-label'>Suporte Vendas</span>
                  <span class='chat-nama'>Atendimento ao Cliente 2</span>
                </div><span class='my-number'><?=$texto['telefoneAdministracaoVendas'];?></span>
              </a>
              <!-- Info Contact End -->
              <div class='blanter-msg'><b>HORÁRIOS: </b> de <i><?=$texto['horariosSuporteSite']?></i></div></div>
              <div class='start-chat hide'>
                <div class='first-msg'><span>Olá, Como posso te ajudar?</span></div>
                <div class='blanter-msg'>
                  <input type="text" id='chat-input2' maxlength='120' class="form-control" placeholder='Escreva uma pergunta...' />
                  <a href='javascript:void;' id='send-it'><i class="fa fa-paper-plane" aria-hidden="true"></i></a></div></div>
                  <div id='get-number'></div><a class='close-chat' href='javascript:void'>×</a>
                </div>
                <a class='blantershow-chat' href='javascript:void' title='Show Chat'><i class='fab fa-whatsapp'></i>Precisa de ajuda?</a>
                <!-- partial -->
				<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.js"></script>

</body>
</html>

<?php
ob_end_flush();
?>