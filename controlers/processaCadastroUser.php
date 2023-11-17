<?php 
ob_start();
session_start();
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
require '../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
 

$res['message'] = "";
$res['success'] = false;

function validaDadosCadastro($payLoad){

	try{
	
		global $lerbanco;
		$payLoad = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
		$linkuser = strip_tags(trim($payLoad['nome_empresa_link']));
		$linkuser = remove_especial_char(remove_accents($linkuser));
		$linkuser = str_replace(' ', '', $linkuser);
		
		$payLoad['nome_empresa_link'] = $linkuser;
		$cpf  = "";
	
		


		if(!empty($payLoad)) { //PRIMEIRO IF INICIO
			$payLoad = array_map('strip_tags', $payLoad);
			$payLoad = array_map('trim', $payLoad);	

			if (in_array('', $payLoad) || in_array('null', $payLoad)){ //SEGUNDO IF INICIO
				$res['message'] = "Os campos não podem ser vazios!";
				$res['success'] = false;
				echo json_encode($res);		 
			}elseif(!Check::Email($payLoad['user_email'])){ //SEGUNDO IF 
				$res['message'] = "O email informado é inválido!";
				$res['success'] = false;
				echo json_encode($res);		
			}elseif(strlen($payLoad['user_password']) <= 7){ //SEGUNDO IF 
				$res['message'] = "A senha deve ter no mínimo 7 caracteres";
				$res['success'] = false;
				echo json_encode($res);		
			} elseif($payLoad['user_password'] != $payLoad['user_password2']){//SEGUNDO IF 
				$res['message'] = "As senhas informadas não são iguais";
				$res['success'] = false;
				echo json_encode($res);			
			} elseif(!Check::validaCPF($payLoad['cpf_user'])){ //SEGUNDO IF 
				$res['message'] = "O CPF informado é invalido!";
				$res['success'] = false;
				echo json_encode($res);		
			} elseif(!preg_match("/^[0-9]{8}/", $payLoad['cep_empresa'])){ //SEGUNDO IF 
				$res['message'] = "O CEP informado é inváido!";
				$res['success'] = false;
				echo json_encode($res);		
			} else{
			
				//SEGUNDO IF 
					$cpf = preg_replace('/[^0-9]/', "", $payLoad['cpf_user'] );
					$lerbanco->ExeRead('ws_empresa', "WHERE binary nome_empresa_link = :linkuser", "linkuser={$linkuser}");//TERCEIRO IF INICIO
					if($lerbanco->getResult()){
						$res['message'] = "A URL da empresa já está cadastrada em nosso sistema!";
						$res['success'] = false;
						echo json_encode($res);	
					}else{
						$lerbanco->ExeRead('ws_users', "WHERE user_cpf = :user_cpf", "user_cpf={$cpf}");			 
						if($lerbanco->getResult()){// QUARTO IF INICIO
							$res['message'] = "O CPF informado já existe em nosso sistema";
							$res['success'] = false;
							echo json_encode($res);		
						}else{
								$lerbanco->ExeRead('ws_users', "WHERE user_email = :useremail", "useremail={$payLoad['user_email']}");
								if($lerbanco->getResult()){// QUARTO IF INICIO
									$res['message'] = "O Email informado já existe em nosso sistema";
									$res['success'] = false;
									echo json_encode($res);	
								}

							
						}	 
					
					}
					$res['success'] = true;
					echo json_encode($res);		
			}
			
			
		}
		

	} catch (PDOException $e) {
		$res['message'] = "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
		$res['success'] = false;
		echo json_encode($res);
		 
	}


}

function cadastraUsuario($payLoad){
	
 
try{

	

	global $texto;
	global $addbanco;
	$login = LOGIN;

	$emailUser  = MAILUSER;
	$senhaEmail = MAILPASS;
	$portaEmail = MAILPORT;
	$hostEmail  = MAILHOST;

	if(!empty($payLoad)){

		 $payLoad = filter_input_array(INPUT_POST, FILTER_DEFAULT);

		 
		

		$linkuser = strip_tags(trim($payLoad['nome_empresa_link']));
		$linkuser = remove_especial_char(remove_accents($linkuser));
		$linkuser = str_replace(' ', '', $linkuser);

		$payLoad['nome_empresa_link'] = $linkuser;
		$cpf  = "";

			// INICIO ARRAY DO USUARIO.
			$cadatroUsuario = array();
		
			$cadatroUsuario['user_name'] = $payLoad['user_name'];
			$cadatroUsuario['user_lastname'] = $payLoad['user_lastname'];
			$cadatroUsuario['user_email'] = $payLoad['user_email'];
			$cadatroUsuario['user_cpf'] = $cpf;	
			$cadatroUsuario['user_telefone'] = $payLoad['user_telefone'];
			$cadatroUsuario['user_password'] = md5($payLoad['user_password']);
			$cadatroUsuario['user_plano'] = (int)$payLoad['user_plano'];	 
			$cadatroUsuario['user_level'] = 3;	 
			$cadatroUsuario['user_status'] = 1;
			$cadatroUsuario['user_cont'] = 1;
			$cadatroUsuario['user_nome_plano'] = "Teste";
			$cadatroUsuario['user_dias_plano'] = 7;
			$cadatroUsuario['status_assinatura_plano'] = "";
			$cadatroUsuario['codigo_assinante'] = "";
			$cadatroUsuario['user_data_renova'] = date("Y-m-d", strtotime("+{$texto['DiasDeTeste']} days"));;		 
			$cadatroUsuario['user_registration'] = date('Y-m-d H:i:s');
			$cadatroUsuario['user_img_perfil'] = 'default/LOGOPADRAO.png';
			// FIM ARRAY DO USUARIO.

			//INICIO ARRAY DA EMPRESA
			$cadatroUsuarioEmpresa = array();
			$cadatroUsuarioEmpresa['nome_empresa'] = $payLoad['nome_empresa'];
			$cadatroUsuarioEmpresa['nome_empresa_link'] = $payLoad['nome_empresa_link'];
			$cadatroUsuarioEmpresa['end_uf_empresa'] = $payLoad['end_uf_empresa'];
			$cadatroUsuarioEmpresa['cidade_empresa'] = $payLoad['cidade_empresa'];
			$cadatroUsuarioEmpresa['end_bairro_empresa'] = $payLoad['end_bairro_empresa'];
			$cadatroUsuarioEmpresa['end_rua_n_empresa'] = $payLoad['end_rua_n_empresa'];
			$cadatroUsuarioEmpresa['email_empresa'] = $payLoad['user_email'];
			$cadatroUsuarioEmpresa['cep_empresa'] = $payLoad['cep_empresa'];
			
			$cadatroUsuarioEmpresa['facebook_empresa'] = 'www.facebook.com';
			$cadatroUsuarioEmpresa['instagram_empresa'] = 'www.instagram.com';
			$cadatroUsuarioEmpresa['twitter_empresa'] = 'wwww.twitter.com';

			$cadatroUsuarioEmpresa['telefone_empresa'] = preg_replace("/[^0-9]/", "", $payLoad['user_telefone']);
			$cadatroUsuarioEmpresa['empresa_data_renovacao'] = date("Y-m-d", strtotime("+{$texto['DiasDeTeste']} days"));
			$cadatroUsuarioEmpresa['img_logo'] = 'default/LOGOPADRAO.png';
			$cadatroUsuarioEmpresa['descricao_empresa'] = 'Empresa de delivery';
			$cadatroUsuarioEmpresa['img_header'] = 'default/FUNDOLOJAPADRAO.png';
			
			//FIM ARRAY DA EMPRESA falta >   
				
			
			
			$addbanco->ExeCreate("ws_users", $cadatroUsuario);
			
			
			
			if(!$addbanco->getResult()){
				$res['message'] = "Ocorreu um error na criação de seu cadastro, favor tentar novamente!";
				$res['success'] = false;
				echo json_encode($res);
			}else{

				$cadatroUsuarioEmpresa['user_id'] = $addbanco->getResult();
				$addbanco->ExeCreate("ws_empresa", $cadatroUsuarioEmpresa);
				
				if(!$addbanco->getResult()){
					$res['message'] = "Ocorreu um error na criação de seu cadastro, favor tentar novamente!";
					$res['success'] = false;
					echo json_encode($res);
				}else{
						require('../_app/Library/PHPMailer/PHPMailerAutoload.php');
						// ENVIA O EMAIL PARA O CLIENTE
										///////////////////////////////
						$Mailer = new PHPMailer();
										
						$lerbanco->FullRead("select termo_cliente from configuracoes_site");
						$termo = $lerbanco->getResult() ? $lerbanco->getResult()[0]['termo_cliente'] : "";
						
						$dompdf = new Dompdf();
						$dompdf->loadHtml($termo);
						$dompdf->setPaper('A4', 'portrait');
						$dompdf->render();
						$output = $dompdf->output();
						file_put_contents('contrato.pdf', $output);
					
						$Mailer->IsSMTP();						 
						$Mailer->isHTML(true);
						$Mailer->SMTPDebug  = 0;  				 
						$Mailer->CharSet = "UTF-8";				  
						$Mailer->SMTPAuth = true;
						$Mailer->SMTPSecure = 'ssl';			
						$Mailer->Host = $hostEmail;			
						$Mailer->Port = $portaEmail;				
						$Mailer->Username = $emailUser;
						$Mailer->Password = $senhaEmail;				
						$Mailer->From = $emailUser;			
						$Mailer->FromName = "Sistema Venda Fácil";			
						$Mailer->Subject = 'Sistema Venda Fácil - Novo cadastro';
						$Mailer->AddAttachment('contrato.pdf', 'contrato.pdf');

						$horario = date('d/m/Y - H:i:s');
							//Corpo da Mensagem
						$Mailer->Body = "

						DETALHES: <br /><br />

						Nome: {$payLoad['user_name']}<br />
						Email: {$payLoad['user_email']}<br />
						Tel:  {$payLoad['user_telefone']}<br />
						Link: {$payLoad['nome_empresa_link']}<br />
						Plano: {$payLoad['user_plano']}

						<br /><br />


						PEDIDO TOP <hr> {$horario}

						";

							//Corpo da mensagem em texto
						$Mailer->AltBody = '';

							//Destinatario 
						$Mailer->AddAddress($payLoad['user_email']);

						if(!$Mailer->Send()){
							echo "Mailer Error: " . $mail->ErrorInfo;					 
						}else{
								unlink('contrato.pdf');
								$res['message'] = "Seu cadastro foi criado. Você receberá um email com seus dados!";
								$res['success'] = true;
								$res['url'] = $login;
								echo json_encode($res);
							//echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
						}
										///////////////////////////////
										// ENVIA O EMAIL PARA O CLIENTE
						
					}

				} 
		}
	} catch (PDOException $e) {
		$res['message'] = "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
		$res['success'] = false;
		echo json_encode($res);
		 
	}

}

 
 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$cadastroObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 

if(!empty($action) && (string)$action && $action=='check' && !empty($cadastroObj)){

    validaDadosCadastro($cadastroObj);
}

if(!empty($action) && (string)$action && $action=='cad' && !empty($cadastroObj)){

    cadastraUsuario($cadastroObj);
}


ob_end_flush();
?>