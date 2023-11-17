<?php
 

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

<html>

<head>
	 
	<style>
		#img-container{
      display:none;
    }
	 
	#remove-img:hover, #remove-img-2:hover{

opacity:0.40 !important;

}

.container-hover:hover{
opacity:0.40 !important;
}

#file-5, #file-6{
    width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1
  }
.remove-icon,.remove-icon-2{
  position: absolute;
  right: 10px;
  margin: 10px;
  font-size: 25px;
 
  z-index: 1999;
  color: white;
  background: #00000024;
  border-radius: 10px;
  border: 2px solid;
    border-top-color: currentcolor;
    border-right-color: currentcolor;
    border-bottom-color: currentcolor;
    border-left-color: currentcolor;
  border-color: transparent;
  display: flex;
  align-items: center;
  width: 60px;
  height: 50px;
  justify-content: center;
}
  :focus-visible {
  outline: none !important;
}

			.img_temp > img {
				height: 240px !important;
  				width: 240px !important;
			}


					#icon-set:after,#icon-set2:after {
						font-family: "Glyphicons Halflings";
						content: "\e080";
					 
						right: 0;
						position: absolute;
						margin-right:32px;
						}

						/* Icon when the collapsible content is hidden */
						#icon-set.collapsed:after,#icon-set2.collapsed:after {
					
						content: "\e114";
					}


	</style>

</head>
<html>
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
			 

		<!-- End SubHeader ============================================ -->

		 
				<div   style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
					 
					
							
							<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
							<div  class="config-header w-full text-bold text-center text-white">
											<p>Configuração Cardápio Fácil</p>
									</div>	
							<div id="sendempresa"></div>


								<section class="m-5 section-config" id="section-1">
								    <br>
									<div class="indent_title_in">
										 
										<h3>Descrição geral do seu negócio</h3>
										<p>Insira no formulario abaixo detalhes do seu negócio e informações de contato.</p>
									</div>				
									<br />
					<form id="updatePedido" data-url="<?=$site?>configuracoes"method="post" action="#sendempresa" enctype="multipart/form-data">
						<div class="wrapper_indent">
							<?php
 

 
			?>
			<div class="form-group">
				<label for="nome_empresa">Nome do seu negócio:</label>
				<input class="form-control" value="<?=(!empty($nome_empresa) ? $nome_empresa : '');?>" name="nome_empresa" id="nome_empresa" type="text">
			</div>
			<div class="form-group">
				<label for="descricao_empresa">Breve descrição do seu negócio:</label>
				<input type="text" maxlength="297" name="descricao_empresa" class="form-control" placeholder="Digite uma descrição..." value="<?=(!empty($descricao_empresa) ? $descricao_empresa : '');?>" />
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="telefone_empresa">Suporte WhatsApp:</label>
						<input type="tel" placeholder="(99) 99999-9999" data-mask="(00) 00000-0000" maxlength="15" id="telefone_empresa" name="telefone_empresa" value="<?=(!empty($telefone_empresa) ? $telefone_empresa : '');?>" class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="email_empresa">E-mail:</label>
						<input type="text" id="email_empresa" value="<?=(!empty($email_empresa) ? $email_empresa : '');?>" name="email_empresa" class="form-control">
					</div>
				</div>
			</div>
			</div><!-- End wrapper_indent -->

			  <hr class="line-hr"/>


			<br>
			<div class="indent_title_in">
			 
				<h3>Endereço</h3>
				<p>
					Defina o endereço do seu negócio!
				</p>
			</div>
			<br />
			<div class="wrapper_indent">
				<div class="row">

				<div class="col-sm-2">
						<div class="form-group">
							<label for="cep_empresa">CEP</label>
							<input data-mask="00-000.000" type="text" id="cep_empresa" value="<?=(!empty($cep_empresa) ? $cep_empresa : '');?>" name="cep_empresa" class="form-control">
						</div>
					</div>
					<div class="col-sm-5">
						<div class="form-group">
							<label for="estados">ESTADO:</label>
							<select class="form-control" name="end_uf_empresa" id="estados">
								
							</select>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label for="cidade_empresa">CIDADE:</label>
							<select class="form-control" name="cidade_empresa" id="cidades">

							</select>
						</div>
					</div>
					
				</div>
			 
					
		 
				<div class="row">
				
					<div class="col-sm-6">
						<div class="form-group">
							<label for="end_rua_n_empresa">RUA / Nº:</label>
							<input type="text" id="end_rua_n_empresa" value="<?=(!empty($end_rua_n_empresa) ? $end_rua_n_empresa : '');?>" name="end_rua_n_empresa" class="form-control">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="end_bairro_empresa">BAIRRO:</label>
							<input  type="text" id="end_bairro_empresa" value="<?=(!empty($end_bairro_empresa) ? $end_bairro_empresa : '');?>" name="end_bairro_empresa" class="form-control">
						</div>
					</div>
				</div>
			</div><!-- End wrapper_indent -->

			  <hr class="line-hr"/>
<br>
			<div class="indent_title_in">
		 
				<h3>Opções de entrega</h3>
				<br />
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
					
					
				</p>
			</div>

			<div class="wrapper_indent">
				<div class="row">				 

					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label for="minimo_delivery">Valor Mínimo do Delivery:</label>
							<input type="text"  maxlength="11" onkeypress="return formatar_moeda(this, '.', ',', event);" data-mask="#.##0,00" data-mask-reverse="true" class="form-control" id="minimo_delivery" name="minimo_delivery" value="<?=(!empty($minimo_delivery) ? Check::Real($minimo_delivery) : '0,00');?>" />
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Mensagem sobre tempo de Delivery:</label>
							<input type="text"  class="form-control" id="msg_tempo_delivery" name="msg_tempo_delivery" value="<?=(!empty($msg_tempo_delivery) ? $msg_tempo_delivery : "Entre 30 e 60 minutos.");?>" />
						</div>
					</div>
				</div>	
				<div class="row">
					
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Mensagem sobre retirar no local:</label>
							<input type="text"  class="form-control" id="msg_tempo_buscar" name="msg_tempo_buscar" value="<?=(!empty($msg_tempo_buscar) ? $msg_tempo_buscar : "Em 30 minutos.");?>" />
						</div>
					</div>
				</div>
			</div>

			  <hr class="line-hr"/>
<br>
			<div class="indent_title_in">
		 
				<h3>Horários de funcionamento</h3>
				<p>
					Defina o seu horário de atendimento para que seus clientes saibam quando seus serviços estiverem disponíveis.
				</p>
			</div>
			<br />
			<div class="panel panel-default">
				<div style="background-color: #7233A1;color: #ffffff;" class="panel-heading">
					<h4 id="icon-set" class="collapsed" data-toggle="collapse"  aria-controls="collapse1" data-parent="#accordion" aria-expanded="false" href="#collapse1" class="panel-title expand">
						<div class="right-arrow pull-right"></div>
					<a style="color: #ffffff;" href="#">Cique aqui para Configurar Horários.</a>
					</h4>
				</div>
				<div id="collapse1"  class="panel-collapse collapse">
					<div class="panel-body">
						
						<div class="wrapper_indent">
							<label>SEGUNDA FEIRA</label>
							<br />
							<div class="icheck-material-green">
								<input id="config_segunda" name="config_segunda" type="checkbox" <?=(!empty($config_segunda) && $config_segunda == 'true' ? 'checked' : '');?> value="true" />
								<label for="config_segunda"><strong style="color:#7233A1;"> PERIODO DA MANHÃ </strong></label>
							</div>
							 
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_manha_de">de:</label>									
										<input  type="time" name="segunda_manha_de" id="segunda_manha_de" data-mask="00:00" value="<?=(!empty($segunda_manha_de) && $segunda_manha_de != "00:00" ? $segunda_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_manha_ate">até:</label>
										<input  type="time" name="segunda_manha_ate" id="segunda_manha_ate" data-mask="00:00" value="<?=(!empty($segunda_manha_ate) && $segunda_manha_ate != "00:00" ? $segunda_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<div class="icheck-material-green">
							<input id="config_segundaa" name="config_segundaa" type="checkbox" <?=(!empty($config_segundaa) && $config_segundaa == 'true' ? 'checked' : '');?> value="true" /> <label for="config_segundaa"><strong style="color:#7233A1;"> PERIODO DA TARDE</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_tarde_de">de:</label>									
										<input  type="time" name="segunda_tarde_de" id="segunda_tarde_de" data-mask="00:00" value="<?=(!empty($segunda_tarde_de) && $segunda_tarde_de != "00:00" ? $segunda_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="segunda_tarde_ate">até:</label>
										<input  type="time" name="segunda_tarde_ate" id="segunda_tarde_ate" data-mask="00:00" value="<?=(!empty($segunda_tarde_ate) && $segunda_tarde_ate != "00:00" ? $segunda_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->	
						  <hr class="line-hr"/>
						
						<div class="wrapper_indent">
							<label>TERÇA FEIRA</label>
							<br />
							<div class="icheck-material-green">
								<input <?=(!empty($config_terca) && $config_terca == 'true' ? 'checked' : '');?> id="config_terca" name="config_terca" value="true" type="checkbox"> <label for="config_terca"><strong style="color:#7233A1;"> PERIODO DA MANHÃ</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_manha_de">de:</label>									
										<input  type="time" name="terca_manha_de" id="segunda_manha_de" data-mask="00:00" value="<?=(!empty($terca_manha_de) && $terca_manha_de != "00:00" ? $terca_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_manha_ate">até:</label>
										<input  type="time" name="terca_manha_ate" id="terca_manha_ate" data-mask="00:00" value="<?=(!empty($terca_manha_ate) && $terca_manha_ate != "00:00" ? $terca_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<div class="icheck-material-green">
									<input <?=(!empty($config_tercaa) && $config_tercaa == 'true' ? 'checked' : '');?> id="config_tercaa" name="config_tercaa" value="true" type="checkbox"><label for="config_tercaa"><strong style="color:#7233A1;"> PERIODO DA TARDE</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_tarde_de">de:</label>									
										<input  type="time" name="terca_tarde_de" id="terca_tarde_de" data-mask="00:00" value="<?=(!empty($terca_tarde_de) && $terca_tarde_de != "00:00" ? $terca_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="terca_tarde_ate">até:</label>
										<input  type="time" name="terca_tarde_ate" id="terca_tarde_ate" data-mask="00:00" value="<?=(!empty($terca_tarde_ate) && $terca_tarde_ate != "00:00" ? $terca_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						  <hr class="line-hr"/>
						
						<div class="wrapper_indent">
							<label>QUARTA FEIRA</label>
							<br />
							<div class="icheck-material-green">
								<input <?=(!empty($config_quarta) && $config_quarta == 'true' ? 'checked' : '');?> id="config_quarta" name="config_quarta" value="true" type="checkbox"> <label for="config_quarta"><strong style="color:#7233A1;"> PERIODO DA MANHÃ</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_manha_de">de:</label>									
										<input  type="time" name="quarta_manha_de" id="quarta_manha_de" data-mask="00:00" value="<?=(!empty($quarta_manha_de) && $quarta_manha_de != "00:00" ? $quarta_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_manha_ate">até:</label>
										<input  type="time" name="quarta_manha_ate" id="quarta_manha_ate" data-mask="00:00" value="<?=(!empty($quarta_manha_ate) && $quarta_manha_ate != "00:00" ? $quarta_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<div class="icheck-material-green">
								<input <?=(!empty($config_quartaa) && $config_quartaa == 'true' ? 'checked' : '');?> id="config_quartaa" name="config_quartaa" value="true" type="checkbox"><label for="config_quartaa"><strong style="color:#7233A1;"> PERIODO DA TARDE</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_tarde_de">de:</label>									
										<input  type="time" name="quarta_tarde_de" id="quarta_tarde_de" data-mask="00:00" value="<?=(!empty($quarta_tarde_de) && $quarta_tarde_de != "00:00" ? $quarta_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quarta_tarde_ate">até:</label>
										<input  type="time" name="quarta_tarde_ate" id="quarta_tarde_ate" data-mask="00:00" value="<?=(!empty($quarta_tarde_ate) && $quarta_tarde_ate != "00:00" ? $quarta_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						  <hr class="line-hr"/>
						<div class="wrapper_indent">
							<label>QUINTA FEIRA</label>
							<br />
							<div class="icheck-material-green">
								<input <?=(!empty($config_quinta) && $config_quinta == 'true' ? 'checked' : '');?> id="config_quinta" name="config_quinta" value="true" type="checkbox"> <label for="config_quinta"><strong style="color:#7233A1;"> PERIODO DA MANHÃ</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_manha_de">de:</label>									
										<input  type="time" name="quinta_manha_de" id="quinta_manha_de" data-mask="00:00" value="<?=(!empty($quinta_manha_de) && $quinta_manha_de != "00:00" ? $quinta_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_manha_ate">até:</label>
										<input  type="time" name="quinta_manha_ate" id="quinta_manha_ate" data-mask="00:00" value="<?=(!empty($quinta_manha_ate) && $quinta_manha_ate != "00:00" ? $quinta_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<div class="icheck-material-green">
								<input <?=(!empty($config_quintaa) && $config_quintaa == 'true' ? 'checked' : '');?> id="config_quintaa" name="config_quintaa" value="true" type="checkbox"><label for="config_quintaa"><strong style="color:#7233A1;"> PERIODO DA TARDE</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_tarde_de">de:</label>									
										<input  type="time" name="quinta_tarde_de" id="quinta_tarde_de" data-mask="00:00" value="<?=(!empty($quinta_tarde_de) && $quinta_tarde_de != "00:00" ? $quinta_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="quinta_tarde_ate">até:</label>
										<input  type="time" name="quinta_tarde_ate" id="quinta_tarde_ate" data-mask="00:00" value="<?=(!empty($quinta_tarde_ate) && $quinta_tarde_ate != "00:00" ? $quinta_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						  <hr class="line-hr"/>

						<div class="wrapper_indent">
							<label>SEXTA FEIRA</label>
							<br />
							<div class="icheck-material-green">
								<input <?=(!empty($config_sexta) && $config_sexta == 'true' ? 'checked' : '');?> id="config_sexta" name="config_sexta" value="true" type="checkbox"> <label for="config_sexta"><strong style="color:#7233A1;"> PERIODO DA MANHÃ</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_manha_de">de:</label>									
										<input  type="time" name="sexta_manha_de" id="sexta_manha_de" data-mask="00:00" value="<?=(!empty($sexta_manha_de) && $sexta_manha_de != "00:00" ? $sexta_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_manha_ate">até:</label>
										<input  type="time" name="sexta_manha_ate" id="sexta_manha_ate" data-mask="00:00" value="<?=(!empty($sexta_manha_ate) && $sexta_manha_ate != "00:00" ? $sexta_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<div class="icheck-material-green">
								<input <?=(!empty($config_sextaa) && $config_sextaa == 'true' ? 'checked' : '');?> id="config_sextaa" name="config_sextaa" value="true" type="checkbox"> <label for="config_sextaa"><strong style="color:#7233A1;"> PERIODO DA TARDE</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_tarde_de">de:</label>									
										<input  type="time" name="sexta_tarde_de" id="sexta_tarde_de" data-mask="00:00" value="<?=(!empty($sexta_tarde_de) && $sexta_tarde_de != "00:00" ? $sexta_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sexta_tarde_ate">até:</label>
										<input  type="time" name="sexta_tarde_ate" id="sexta_tarde_ate" data-mask="00:00" value="<?=(!empty($sexta_tarde_ate) && $sexta_tarde_ate != "00:00" ? $sexta_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						  <hr class="line-hr"/>
						
						<div class="wrapper_indent">
							<label>SABADO</label>
							<br />
							<div class="icheck-material-green">
								<input <?=(!empty($config_sabado) && $config_sabado == 'true' ? 'checked' : '');?> id="config_sabado" name="config_sabado" value="true" type="checkbox"> <label for="config_sabado"><strong style="color:#7233A1;"> PERIODO DA MANHÃ</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_manha_de">de:</label>									
										<input  type="time" name="sabado_manha_de" id="sabado_manha_de" data-mask="00:00" value="<?=(!empty($sabado_manha_de) && $sabado_manha_de != "00:00" ? $sabado_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_manha_ate">até:</label>
										<input  type="time" name="sabado_manha_ate" id="sabado_manha_ate" data-mask="00:00" value="<?=(!empty($sabado_manha_ate) && $sabado_manha_ate != "00:00" ? $sabado_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<div class="icheck-material-green">
								<input <?=(!empty($config_sabadoo) && $config_sabadoo == 'true' ? 'checked' : '');?> id="config_sabadoo" name="config_sabadoo" value="true" type="checkbox"> <label for="config_sabadoo"><strong style="color:#7233A1;"> PERIODO DA TARDE</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_tarde_de">de:</label>									
										<input  type="time" name="sabado_tarde_de" id="sabado_tarde_de" data-mask="00:00" value="<?=(!empty($sabado_tarde_de) && $sabado_tarde_de != "00:00" ? $sabado_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="sabado_tarde_ate">até:</label>
										<input  type="time" name="sabado_tarde_ate" id="sabado_tarde_ate" data-mask="00:00" value="<?=(!empty($sabado_tarde_ate) && $sabado_tarde_ate != "00:00" ? $sabado_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
						  <hr class="line-hr"/>
						
						<div class="wrapper_indent">
							<label>DOMINGO</label>
							<br />
							<div class="icheck-material-green">
								<input <?=(!empty($config_domingo) && $config_domingo == 'true' ? 'checked' : '');?> id="config_domingo" name="config_domingo" value="true" type="checkbox"> <label for="config_domingo"><strong style="color:#7233A1;"> PERIODO DA MANHÃ</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_manha_de">de:</label>									
										<input  type="time" name="domingo_manha_de" id="domingo_manha_de" data-mask="00:00" value="<?=(!empty($domingo_manha_de) && $domingo_manha_de != "00:00" ? $domingo_manha_de : "00:00");?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_manha_ate">até:</label>
										<input  type="time" name="domingo_manha_ate" id="domingo_manha_ate" data-mask="00:00" value="<?=(!empty($domingo_manha_ate) && $domingo_manha_ate != "00:00" ? $domingo_manha_ate : "00:00");?>" class="form-control"/> 
									</div>
								</div>
							</div>
							<div class="icheck-material-green">
								<input <?=(!empty($config_domingoo) && $config_domingoo == 'true' ? 'checked' : '');?> id="config_domingoo" name="config_domingoo" value="true" type="checkbox"><label for="config_domingoo"><strong style="color:#7233A1;"> PERIODO DA TARDE</strong></label>
							</div>
							<div class="row">						
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_tarde_de">de:</label>									
										<input  type="time" name="domingo_tarde_de" id="domingo_tarde_de" data-mask="00:00" value="<?=(!empty($domingo_tarde_de) && $domingo_tarde_de != "00:00" ? $domingo_tarde_de : '00:00');?>" class="form-control"/>									
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="domingo_tarde_ate">até:</label>
										<input  type="time" name="domingo_tarde_ate" id="domingo_tarde_ate" data-mask="00:00" value="<?=(!empty($domingo_tarde_ate) && $domingo_tarde_ate != "00:00" ? $domingo_tarde_ate : '00:00');?>" class="form-control"/> 
									</div>
								</div>
							</div>
						</div><!-- End wrapper_indent -->
					</div>
				</div>
			</div>

			  <hr class="line-hr"/>
<br>
			 

			<div class="mb-0 panel-group" id="accordion">
				
			 
				


				
<br>
				<div class="indent_title_in">
				 
					<h3>Redes Sociais</h3>
					<p>
						Insira as urls de suas redes sociais!
					</p>
				</div>
				<br />

				<div class="wrapper_indent">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="facebook_status">Facebook Status:</label>
								<select  class="form-control" name="facebook_status">
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
								<select  class="form-control" name="instagram_status">
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
								<select  class="form-control" name="twitter_status">
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
<br>
<hr class="line-hr"/>
<br>
<div class="indent_title_in">
					 
					 <h3>Imagens de fundo e de Perfil</h3>
					 <p>
						 Imagens que serão usadas na página inicial do site!
					 </p>
				 </div>
				 <br />
		<div class="mb-0 panel-group" id="accordion">
				<div class="panel panel-default">
					<div style="background-color: #7233A1;color: #ffffff;" class="panel-heading">
 	
					<h4 id="icon-set2" class="collapsed" data-toggle="collapse" aria-controls="collapse3" aria-expanded="false" data-parent="#accordion" href="#collapse3" class="panel-title expand">
							<div class="right-arrow pull-right"></div>
							<a style="color: #ffffff;" href="#">Clique aqui para personalizar sua loja</a>
						</h4>
					</div>

					<div id="collapse3" style="visibility:unset" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-md-12 col-sm-12">
						
 
				 
				 <div class="row">	
				 <div class="col-md-5">
					
            
              <div class="text-center menu-item-pic">
			   <div class="indent_title_in">
			  <h3>Logo Empresa</h3>
								</div>
                <?php 

             
              if (!empty($img_logo) && $img_logo != "" && $img_logo != UPLOAD_PATH."/uploads"."/".'default/LOGOPADRAO.png' && file_exists(UPLOAD_PATH."/uploads"."/".$img_logo) && !is_dir(UPLOAD_PATH."/uploads"."/".$img_logo)){
                $imgProd =  URL_IMAGE.$img_logo;
                $flag = true;
                $styleImg= "margin: 0 auto; align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;height: 340px;";
              }else{
                $styleImg= "";
                $imgProd =  "";
                $flag = false;
              };   
            ?>
                <div id="container-img" style="margin-bottom: 5px;align-items: center;display: flex;flex-direction: row;flex-wrap:wrap;justify-content:center;background-color:#ffffff;background: #7232A0; height:340px" class="container-hover cursor-pointer w-full box">
                 <div   style="display:<?= $flag == true ? "flex" : "none !important;" ?>"class="flex flex-row" id="show_img_prod">
                        <div  class="w-full">                          
                        <img style="<?= !empty($styleImg) ?$styleImg : ""  ?>" class="cursor-pointer" id="img_prod"  src="<?=!empty($imgProd) ? $imgProd : "" ?>"/>                       
                        </div>
                        <div id="remove-img"  class="remove-icon h-1/2">
                        <span  class="glyphicon glyphicon-trash"></span>
                  
                        </div>   
                </div>
               
                <input type="file" name="img_logo" id="file-5" class="" data-multiple-caption="{count} files selected" multiple />
                  <label style="display: <?= $flag ? "none" : ""?>" class="cursor-pointer" id="label-file" for="file-5"><img src="<?=URL_IMAGE.'img/upload_product.png'?>"/></label>  
                  <div id="label-icon" style="position:relative; top: -25px;color:white;font-size:24px;font-weight:unset" class="w-full" style="background:#7233A1; color:white;margin 0 auto;">
                    <label id="label-text" style="display: <?= $flag ? "none" : ""?>" style="font-weight:unset"  for="file-5">Enviar imagem...</label>
                </div>   
                </div>
                  </div>
              
     
			</div>
					  
					 <div class="col-md-5">
					 
						
							<div class="text-center menu-item-pic">
							<div class="indent_title_in">	
							<h3>Fundo Empresa</h3>
			</div>
								<?php 

             
              if (!empty($img_header) && $img_header != "" && $img_header != UPLOAD_PATH."/uploads"."/".'default/FUNDOLOJAPADRAO.png' && file_exists(UPLOAD_PATH."/uploads"."/".$img_header) && !is_dir(UPLOAD_PATH."/uploads"."/".$img_header)){
                $imgProd =  URL_IMAGE.$img_header;
                $flag = true;
                $styleImg= "margin: 0 auto; align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;height: 340px;";
              }else{
                $styleImg= "";
                $imgProd =  "";
                $flag = false;
              };   
            ?>
                <div id="container-img-2" style="margin-bottom: 5px;;align-items: center;display: flex;flex-direction: row;flex-wrap:wrap;justify-content:center;background-color:#ffffff;background: #7232A0; height:340px" class="container-hover cursor-pointer w-full box">
                 <div   style="display:<?= $flag == true ? "flex" : "none !important;" ?>"class="flex flex-row" id="show_img_prod-2">
                        <div class="w-full">                          
                        <img style="<?= !empty($styleImg) ?$styleImg : ""  ?>" class="cursor-pointer" id="img_prod-2"  src="<?=!empty($imgProd) ? $imgProd : "" ?>"/>                       
                        </div>
                        <div id="remove-img-2"  class="remove-icon-2 h-1/2">
                        <span  class="glyphicon glyphicon-trash"></span>
                  
                        </div>   
                </div>
               
                <input type="file" name="img_header" id="file-6" class="" data-multiple-caption="{count} files selected" multiple />
                  <label style="display: <?= $flag ? "none" : ""?>" class="cursor-pointer" id="label-file-2" for="file-6"><img src="<?=URL_IMAGE.'img/upload_product.png'?>"/></label>  
                  <div id="label-icon-2" style="position:relative; top: -25px;color:white;font-size:24px;font-weight:unset" class="w-full" style="background:#7233A1; color:white;margin 0 auto;">
                    <label id="label-text-2" style="display: <?= $flag ? "none" : ""?>" style="font-weight:unset"  for="file-6">Enviar imagem...</label>
                </div>   
                </div>
                  </div>
              
     
					  
					 </div>
				 </div><!-- End wrapper_indent -->
 			
						 
						</div>


					</div>
				</div>
				<br>
				   
			
				 
				<div class="wrapper_indent">
					<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>" />
					<input type="hidden" name="sendempresa" value="true" />
					<button style="background-color: #00BB07;" type="input" class="btn_1">Salvar Alterações</button>
					 
					</div><!-- End wrapper_indent -->
					<div style="margin-bottom:0px !important" class="panel-group" id="accordion">

					</form>

				</section><!-- End section 1 -->

</div>
		</div>
				</div>
		 
 

 
	<script src="js/flowbite.min.js"></script>


	 


<!-- COMMON SCRIPTS -->





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


 
 
<script>
	$( function() {
		$( "#datepicker" ).datepicker();
	} );
</script>


 