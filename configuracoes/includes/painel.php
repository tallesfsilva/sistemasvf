	<?php

	$user_id = $_SESSION['userlogin']['user_id'];
	$lerbanco->ExeRead("ws_empresa", 'where user_id = :user',   "user={$user_id}");
	if($lerbanco->getResult()):
		$getEmpresa = $lerbanco->getResult();
	endif;
	
	
	?>

<head>
	 <style>

#img-container{
      display:none;
    }

	 </style>
</head>
<html>
		
	<div  style="padding-right: 0px;"  class="container-main-page flex h-full justify-center items-center p-4">
		
	<div class="container p-0 m-0 text-black">
	<div  class="config-header w-full text-bold text-center text-white">
											<p>Configuração Financeiro</p>
									</div>	
				 

			 
			<div style="height:400px" class="section-config">
			<div class="row">
		
		<div class="col-md-12">
			<div class="m-5">	
				<form  data-url="<?=$site?>configuracoes" id="updateFinanceiro" method="post" autocomplete="off">
 
				
					<div class="form-group">
						<label>Public Key:
						</label>
						<input type="text" name="public_key_mp" value="<?=(!empty($getEmpresa[0]['public_key_mp']) ? $getEmpresa[0]['public_key_mp'] : "")?>" id="public_key_mp" class="form-control" placeholder="">
					</div>
					<div class="form-group">
					<label>Access Token:
					</label>
					<input type="text" name="access_token_mp" value="<?=(!empty($getEmpresa[0]['access_token_mp']) ? $getEmpresa[0]['access_token_mp'] : "")?>" id="access_token_mp" class="form-control" placeholder="">
					</div>
					 
					<button style="background-color: #00BB07;"class="btn_1 btn-success" type="submit">Salvar Alterações</button>
				</div>


			</form>

		</div>
	</div>
</div>
</div>
		</div>
		</div>