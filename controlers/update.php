<?php

ob_start();
session_start();

require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');

$site = HOME;

try{
        $res['msg'] = "";
        $res['status'] = false;
        if(isset($_POST["senha1"]) && isset($_POST["email"]) && isset($_POST["senha2"]) && isset($_POST["action"]) &&
        ($_POST["action"]=="update")){
         
                    $error="";
                    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    $curDate = date("Y-m-d H:i:s");

                    if ($data['senha1']!=$data['senha2']){
                        $res['msg'] = "As senhas não são iguais. Por favor informe a senha corretamente";
                        $res['status'] = false;
                        echo json_encode($res);
                        return;
                    }
                    
                     
                        $novaSenha = md5($data['senha1']);
                        $update = new Update;

                        $arrayUpdate['user_password'] = $novaSenha;
                        
                        $resUpdate = $update->ExeUpdate('ws_users', $arrayUpdate, "WHERE user_email = :email", "email={$data['email']}");
                            
                        $delete = new Delete;
                        $resDelete = $delete->ExeDelete('password_reset_temp', "where email= :a", "a={$data['email']}");				 			
                       
                        
            
                        $res['msg'] = "Sua senha foi alterada com sucesso. Você será redirecionado para a página de login.";
                        $res['status'] = true;
                        $res['url'] = $site.'/login';

                        echo json_encode($res);
                	
            }

            }catch (PDOException $e) {
                echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
        }
        ob_end_flush();
?>