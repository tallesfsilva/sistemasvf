<?php

$login = new Login(3);
$site = HOME;
 

if(!$login->CheckLogin()):
	unset($_SESSION['userlogin']);
	header("Location: {$site}");
else:
	$userlogin = $_SESSION['userlogin'];
endif;

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);

if(!empty($logoff) && $logoff == true):
	$updateacesso = new Update;
	$dataEhora    = date('d/m/Y H:i');
	$ip           = get_client_ip();
	$string_last = array("user_ultimoacesso" => " Último acesso em: {$dataEhora} IP: {$ip} ");
	$updateacesso->ExeUpdate("ws_users", $string_last, "WHERE user_id = :uselast", "uselast={$userlogin['user_id']}");
	
	unset($_SESSION['userlogin']);
	header("Location: {$site}");
endif;

$updatebanco = new Update();

?>
<html>

<head>
 
<style>
	#img-container{
      display:none;
    }

</style>
</head>

<div   style="padding-right: 0px;" class="container-main-page overflow-hidden flex h-screen justify-center items-center p-4">
	<div style="background-color:#ffffff;"   class="container h-full p-0 m-0">	 		
	<div  class="config-header w-full text-bold text-center text-white">
											<p>Configuração da Conta</p>
									</div>
		<section class="container section-config m-0 p-0 h-screen" style="" id="section-1">
		<div  class="row">	
			<div class="col-md-12">	

				 
				<?php
				$lerbanco->ExeRead("ws_users", "WHERE user_id = :a", "a={$userlogin['user_id']}");
				if ($lerbanco->getResult()):
					foreach ($lerbanco->getResult() as $d):
						extract($d);
					endforeach;
				endif;

		
				$inputnewsenha = filter_input_array(INPUT_POST, FILTER_DEFAULT);


			

				 

				if($inputnewsenha && !empty($inputnewsenha['sendnewpass'])):

					$lerbanco->ExeRead("ws_users", "WHERE user_email = :a", "a={$inputnewsenha['user_email']}");
					if ($lerbanco->getResult()):
						foreach ($lerbanco->getResult() as $j):
							extract($j);
						endforeach;
					endif;
	
					 
					unset($inputnewsenha['sendnewpass']);
						// LIMPA OS CAMPOS RETIRANDO TAGS E ESPAÇOS DESNECESSÁRIOS
					$inputnewsenha = array_map('strip_tags', $inputnewsenha);
					$inputnewsenha = array_map('trim', $inputnewsenha);

					if(in_array('', $inputnewsenha) || in_array('null', $inputnewsenha)):
						echo "<div class=\"alert alert-info alert-dismissable\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
					Preencha todos os campos!
					</div>";
				elseif (!empty($user_email) && $user_email == $inputnewsenha['user_email']):
						echo "<div class=\"alert alert-info alert-dismissable\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
						O e-mail informado já existe!
						</div>";
				elseif (!Check::Email($inputnewsenha['user_email'])):
					echo "<div class=\"alert alert-info alert-dismissable\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
					O e-mail informado e inválido!
					</div>";
				elseif ($inputnewsenha['user_password'] != $inputnewsenha['confirmpass']):
					echo "<div class=\"alert alert-info alert-dismissable\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
					Senhas não coincidem!
					</div>";
				elseif(md5($inputnewsenha['passatual']) != $userlogin['user_password']):
					echo "<div class=\"alert alert-info alert-dismissable\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
					A senha atual informada esta errada!
					</div>";
				elseif(strlen($inputnewsenha['user_password']) <= 7):
					echo "<div class=\"alert alert-info alert-dismissable\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
					A senha informada deve ter no mínimo 8 caracteres!
					</div>";
				else:

					unset($inputnewsenha['passatual']);
					unset($inputnewsenha['confirmpass']);

					$inputnewsenha['user_password'] = md5($inputnewsenha['user_password']);
					$updatebanco->ExeUpdate("ws_users", $inputnewsenha, "WHERE user_id = :newuserpass", "newuserpass={$userlogin['user_id']}");
					if ($updatebanco->getResult()):
						echo "<div class=\"alert alert-success alert-dismissable\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
						<b class=\"alert-link\">SUCESSO!</b> Seus dados foram alterados. saindo...
						</div>";
						header("Refresh: 5; url={$site}{$Url[0]}/login-senha&logoff=true");							
						else:
							echo "<div class=\"alert alert-danger alert-dismissable\">
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
							<b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
							</div>";
						endif;
					endif;			
				endif;

				?>
	
				<div class="widget ">
				
					<div style="height: 380px" class="widget-content padding">        
						<form class="flex flex-col" role="form" method="post" action="#sendnewpass">
							<div class="form-group">
								<label class="col-sm-2 control-label text-black">E-mail:</label>
								<div class="col-sm-12">
									<div class="w-full input-group">
										 
										<input type="text" name="user_email" value="<?=$user_email?>" class="form-control text-input" placeholder="e-mail">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-black">Senha atual:</label>
								<div class="col-sm-12">
									<div class="w-full input-group">
										 
										<input type="password" name="passatual" class="form-control text-input" placeholder="********">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-black">Nova senha:</label>
								<div class="col-sm-12">
									<div class="w-full input-group">
										 
										<input type="password" name="user_password" class="form-control text-input" placeholder="********">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label text-black">Confirme a senha:</label>
								<div class="col-sm-12">
									<div class="w-full input-group">
										 
										<input type="password" name="confirmpass" class="form-control text-input" placeholder="********">
									</div>
								</div>
							</div>

							<div class="form-group">							 
								<div class="col-sm-10">
									<div class="input-group">
									<button style="background-color: #00BB07;"class="btn_1 btn-success"  name="sendnewpass" value="Salvar" type="submit">Salvar Alterações</button>
									<!-- <input style="background-color: #00BB07;" class='btn_1 btn-success'  name="sendnewpass" type='submit' value='Salvar Alterações'/> 							 -->
									</div>
								</div>
							</div>
						 
							
						</form>       
					</div>
				</div>
			</div><!-- End col  -->			
		</div><!-- End row  -->
			</section>
	</div>
</div><!-- End container  -->
</html>