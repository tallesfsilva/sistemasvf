	<?php

	$user_id = $_SESSION['userlogin']['user_id'];
	$lerbanco->ExeRead("ws_empresa", 'where user_id = :user',   "user={$user_id}");
	if($lerbanco->getResult()):
		$getEmpresa = $lerbanco->getResult();
	endif;
	
	
	?>

<head>
	<script>
		$(document).ready(function(){
			$('#img-container').hide();
		})
	
			 
	</script>
</head>
<html>
		
	<div  class="container-main-page flex h-full justify-center items-center p-4">
		
	<div class="container p-0 m-0 text-black">
	<div  class="config-header w-full text-bold text-center text-white">
											<p>Configuração Financeiro</p>
									</div>	
				 

				<?php
				$formupdateempresa = filter_input_array(INPUT_POST, FILTER_DEFAULT);
				if(!empty($formupdateempresa)):

					$formupdateempresa = array_map('strip_tags', $formupdateempresa);
					$formupdateempresa = array_map('trim', $formupdateempresa);

					if(in_array('', $formupdateempresa) || in_array('null', $formupdateempresa)):
						echo "<br /><div class=\"alert alert-info alert-dismissable\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
					Preencha todos os campos!
					</div>";
					else:				 

						$updatebanco->ExeUpdate("ws_empresa", $formupdateempresa, "WHERE user_id = :user", "user={$user_id}");
						if ($updatebanco->getResult()):
							echo "<div class=\"alert alert-success alert-dismissable\">
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
							<b class=\"alert-link\">SUCESSO!</b> Seus dados foram Inseridos no sistema.
							</div>";
							// header("Location: {$site}configuracoes/painel");
						else:
							echo "<br /><div class=\"alert alert-danger alert-dismissable\">
							<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
							<b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
							</div>";
						endif;

				endif;
			endif;
			?>
			<div class="h-screen" style="background:white; padding-bottom:20px;border:5px solid transparent; border-radius:8px; box-shadow: 2px 2px 2px 2px gray;">
			<div class="row">
		
		<div class="col-md-12">
			<div class="m-5">	
				<form method="post" autocomplete="off">
 
					<h2>DADOS DE PAGAMENTO</h2>
					<div class="form-group">
						<label>*****************************************************************<br />
							DEPOIS DE CRIAR SUA CONTA NO MERCADO PAGO VOCÊ DEVE <br />
							TERMINAR DE PREENCHER ALGUNS DADOS E PEGAR ESSAS 2 INFORMAÇÕES NO LINK E SUBISTITUIR ABAIXO:<br />
							https://www.mercadopago.com.br/developers/panel/credentials<br />
							Entre em " credenciais de produção ":<br />
						******************************************************************</label>
						<br />
						<br />
						<label>Public Key:
						</label>
						<input type="text" name="public_key_mp" value="<?=(!empty($getEmpresa[0]['public_key_mp']) ? $getEmpresa[0]['public_key_mp'] : "")?>" id="public_key_mp" class="form-control" placeholder="">
					</div>

					<label>Access Token:
					</label>
					<input type="text" name="access_token_mp" value="<?=(!empty($getEmpresa[0]['access_token_mp']) ? $getEmpresa[0]['access_token_mp'] : "")?>" id="access_token_mp" class="form-control" placeholder="">
					<br />
					<br />
					<button class="btn_1 btn-success" type="submit">Alterar dados</button>
				</div>


			</form>

		</div>
	</div>
</div>
</div>
		</div>
		</div>