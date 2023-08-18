<?php
ob_start();
session_start();

require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');

require('../_app/Helpers/Check.class.php');

 
 $portEmail = MAILPORT;
 $hostEmail = MAILHOST;
 $userEmail = MAILUSER;
 $passEmail = MAILPASS;
 $site = HOME;


$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$read = new Read;
  

function validateEmail($data){

    $email = filter_var($data, FILTER_VALIDATE_EMAIL);

    return $email;  
}
try{

    if($data['email']){
            $isEmail = validateEmail($data['email']);
            $isCPF = !$isEmail ? Check::validaCPF($data['email']) : false;
            $data['email'] = $isCPF ? str_replace(array('.', '-'), "", $data['email']) : $data['email'];
            $field = $isCPF ? 'user_cpf' : 'user_email';
      
            $read->ExeRead("ws_users", "WHERE ".$field."= :e", "e={$data['email']}");   

            if ($read->getResult() && $read->getResult()[0]['user_email'] ){       
                
                $emailUser = $read->getResult()[0]['user_email'];
                $expFormat = mktime(
                date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
                );
                $expDate = date("Y-m-d H:i:s",$expFormat);
                $token = bin2hex(random_bytes(66));
              
                //$key = md5((2418*2).$data['email']);
                 
                $key = $token; //. $addKey;
          
                $create = new Create;
                $arrayReset['email'] = $data['email']; 
                $arrayReset['keyString'] = $key; 
                $arrayReset['expDate'] = $expDate;
        
                
                $create->ExeCreate('password_reset_temp', $arrayReset);
                $output ='<p>Caro usuário,</p>';
                $output.='<p>Foi realizada uma solicitação para redefinição de senha. Por favor clique no seguinte link para recuperar sua senha. O link enviado expira em 24 horas.</p>';
                $output.='<p>-------------------------------------------------------------</p>';
                $output.='<p><a href="'.$site.'reset?key='.$key.'&action=reset" target="_blank">
                '.$site.'reset?key='.$key.'&action=reset</a></p>';			
                $output.='<p>-------------------------------------------------------------</p>';
                $output.='<p>Caso você não tenha efetuado essa solicitação, nenhuma ação é requerida, sua senha não será redefinida. Em todo caso, recomendamos que faça login em sua conta e efetue a redefinição de senha por questão de segurança.</p>';   	
                $output.='<p>Obrigado,</p>';
                $output.='<p>Sistema de Venda Fácil</p>';
                $body = $output; 
                $subject = "Sistema Venda Fácil - Redefinição de Senha"; 
                
                $email_to = $emailUser;
                $fromserver =  $userEmail; 
                require('../_app/Library/PHPMailer/PHPMailerAutoload.php');
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->CharSet = "UTF-8";
                $mail->Host = $hostEmail; // Enter your host here
                $mail->SMTPAuth = true;
                $mail->Username = $userEmail; // Enter your email here
                $mail->Password = $passEmail; //Enter your password here
                $mail->Port = $portEmail;
                $mail->SMTPDebug  = 0;  
                $mail->SMTPSecure = "ssl";
                $mail->IsHTML(true);
                $mail->From = $userEmail;
                $mail->FromName = "Sistema Venda Fácil";
                $mail->Sender = $fromserver; // indicates ReturnPath header
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($email_to);
            

                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    }else{
                        $res = array("msg" => "Usuário encontrado", "s" => true, "a" => $emailUser);  
                        echo json_encode($res);            
                    }       
            } else{
                $res = array("msg" => "Usuário não encontrado", "success" => false);
                echo json_encode($res);
            } 
        
}
} catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
ob_end_flush();