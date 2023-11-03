<?php 
ob_start();
session_start();
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
 
$login = LOGIN;

$emailUser  = MAILUSER;
$senhaEmail = MAILPASS;
$portaEmail = MAILPORT;
$hostEmail  = MAILHOST;
 


$inputDadosCadastro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$linkuser = strip_tags(trim($inputDadosCadastro['nome_empresa_link']));
$linkuser = remove_especial_char(remove_accents($linkuser));
$linkuser = str_replace(' ', '', $linkuser);

$inputDadosCadastro['nome_empresa_link'] = $linkuser;
$cpf  = "";

$res['message'] = "";
$res['success'] = true;
$check = false;
try{
		if(!empty($inputDadosCadastro)) { //PRIMEIRO IF INICIO
			$inputDadosCadastro = array_map('strip_tags', $inputDadosCadastro);
			$inputDadosCadastro = array_map('trim', $inputDadosCadastro);	

			if (in_array('', $inputDadosCadastro) || in_array('null', $inputDadosCadastro)){ //SEGUNDO IF INICIO
				$res['message'] = "Os campos não podem ser vazios!";
				$res['success'] = false;
				echo json_encode($res);		 
			}elseif(!Check::Email($inputDadosCadastro['user_email'])){ //SEGUNDO IF 
				$res['message'] = "O email informado é inválido!";
				$res['success'] = false;
				echo json_encode($res);		
			}elseif(strlen($inputDadosCadastro['user_password']) <= 7){ //SEGUNDO IF 
				$res['message'] = "A senha deve ter no mínimo 7 caracteres";
				$res['success'] = false;
				echo json_encode($res);		
			} elseif($inputDadosCadastro['user_password'] != $inputDadosCadastro['user_password2']){//SEGUNDO IF 
				$res['message'] = "As senhas informadas não são iguais";
				$res['success'] = false;
				echo json_encode($res);			
			} elseif(!Check::validaCPF($inputDadosCadastro['cpf_user'])){ //SEGUNDO IF 
				$res['message'] = "O CPF informado é invalido!";
				$res['success'] = false;
				echo json_encode($res);		
			} elseif(!preg_match("/^[0-9]{8}/", $inputDadosCadastro['cep_empresa'])){ //SEGUNDO IF 
				$res['message'] = "O CEP informado é inváido!";
				$res['success'] = false;
				echo json_encode($res);		
			} else{
			
				//SEGUNDO IF 
					$cpf = preg_replace('/[^0-9]/', "", $inputDadosCadastro['cpf_user'] );
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
								$lerbanco->ExeRead('ws_users', "WHERE user_email = :useremail", "useremail={$inputDadosCadastro['user_email']}");
								if($lerbanco->getResult()){// QUARTO IF INICIO
									$res['message'] = "O Email informado já existe em nosso sistema";
									$res['success'] = false;
									echo json_encode($res);	
								}

							
						}	 
					
					}
					
			}
			$check=true;
		}

		if($check && $res['success']){

		 
			// INICIO ARRAY DO USUARIO.
			$cadatroUsuario = array();
		
			$cadatroUsuario['user_name'] = $inputDadosCadastro['user_name'];
			$cadatroUsuario['user_lastname'] = $inputDadosCadastro['user_lastname'];
			$cadatroUsuario['user_email'] = $inputDadosCadastro['user_email'];
			$cadatroUsuario['user_cpf'] = $cpf;	
			$cadatroUsuario['user_telefone'] = $inputDadosCadastro['user_telefone'];
			$cadatroUsuario['user_password'] = md5($inputDadosCadastro['user_password']);
			$cadatroUsuario['user_plano'] = (int)$inputDadosCadastro['user_plano'];	 
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
			$cadatroUsuarioEmpresa['nome_empresa'] = $inputDadosCadastro['nome_empresa'];
			$cadatroUsuarioEmpresa['nome_empresa_link'] = $inputDadosCadastro['nome_empresa_link'];
			$cadatroUsuarioEmpresa['end_uf_empresa'] = $inputDadosCadastro['end_uf_empresa'];
			$cadatroUsuarioEmpresa['cidade_empresa'] = $inputDadosCadastro['cidade_empresa'];
			$cadatroUsuarioEmpresa['end_bairro_empresa'] = $inputDadosCadastro['end_bairro_empresa'];
			$cadatroUsuarioEmpresa['end_rua_n_empresa'] = $inputDadosCadastro['end_rua_n_empresa'];
			$cadatroUsuarioEmpresa['email_empresa'] = $inputDadosCadastro['user_email'];
			$cadatroUsuarioEmpresa['cep_empresa'] = $inputDadosCadastro['cep_empresa'];
		 
			$cadatroUsuarioEmpresa['telefone_empresa'] = preg_replace("/[^0-9]/", "", $inputDadosCadastro['user_telefone']);
			$cadatroUsuarioEmpresa['empresa_data_renovacao'] = date("Y-m-d", strtotime("+{$texto['DiasDeTeste']} days"));
			$cadatroUsuarioEmpresa['img_logo'] = 'default/LOGOPADRAO.png';
			$cadatroUsuarioEmpresa['descricao_empresa'] = 'Empresa de deliveryt';
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
						

						$horario = date('d/m/Y - H:i:s');
							//Corpo da Mensagem
						$Mailer->Body = "

						DETALHES: <br /><br />

						Nome: {$inputDadosCadastro['user_name']}<br />
						Email: {$inputDadosCadastro['user_email']}<br />
						Tel:  {$inputDadosCadastro['user_telefone']}<br />
						Link: {$inputDadosCadastro['nome_empresa_link']}<br />
						Plano: {$inputDadosCadastro['user_plano']}

						<br /><br />


						PEDIDO TOP <hr> {$horario}

						";

							//Corpo da mensagem em texto
						$Mailer->AltBody = '';

							//Destinatario 
						$Mailer->AddAddress($inputDadosCadastro['user_email']);

						if(!$Mailer->Send()){
							echo "Mailer Error: " . $mail->ErrorInfo;					 
						}else{
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

//endif;//SEGUNDO IF FIM
 

ob_end_flush();
?>