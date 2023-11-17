<?php

ob_start();
 
session_start();
require('../../_app/Config.inc.php');  



function atualizaSenhaCliente($payLoad){


    try{
  
        global $lerbanco;
        global $updatebanco;
      
        $res = new stdClass();
        $userlogin = $_SESSION['userlogin'];
       
      
        if(!empty($payLoad)){	
       

            $lerbanco->ExeRead("ws_users", "WHERE user_email = :a and user_id != :iduser", "iduser={$userlogin['user_id']}&a={$payLoad['user_email']}");
            if ($lerbanco->getResult()){
                foreach ($lerbanco->getResult() as $j){
                    extract($j);
                };

            if (!empty($user_email) && $user_email == $payLoad['user_email']){              
                    $res->msg ="O e-mail informado já existe!";
                    $res->success = false;
                    $res->error = true;
                    echo json_encode($res);
            };
        }else{

            $lerbanco->ExeRead("ws_users", "WHERE user_email = :a and user_id = :iduser", "iduser={$userlogin['user_id']}&a={$payLoad['user_email']}");
            if ($lerbanco->getResult()){
                foreach ($lerbanco->getResult() as $j){
                    extract($j);
                };
            }
          $payLoad = array_map('strip_tags', $payLoad);
          $payLoad = array_map('trim', $payLoad);
      
          if(in_array('', $payLoad) || in_array('null', $payLoad)){
            $res->msg ="Preencha todos os campos obrigatórios!";
            $res->success = false;
            $res->error = true;
            echo json_encode($res);
          }elseif ($payLoad['user_password'] != $payLoad['confirmpass']){
          $res->msg ="As senhas informadas não são iguais!";
            $res->success = false;
            $res->error = true;
            echo json_encode($res);

          }elseif (md5($payLoad['passatual']) != $user_password){
                $res->msg ="Senha atual é inválida";
                  $res->success = false;
                  $res->error = true;
                  echo json_encode($res);
      
           
          }elseif (!Check::Email($payLoad['user_email'])){       
            $res->msg ="O e-mail informado e inválido!";
            $res->success = false;
            $res->error = true;
            echo json_encode($res);
        }elseif(strlen($payLoad['user_password']) <= 7 || strlen($payLoad['confirmpass']) <= 7){
          $res->msg ="A senha deve conter o mínimo de 8 caracteres!";
          $res->success = false;
          $res->error = true;
          echo json_encode($res);
        }else{
      
           
      
      
          $novosdados = array();
          $novosdados['user_password'] = md5($payLoad['user_password']);
          $updatebanco->ExeUpdate("ws_users", $novosdados, "WHERE user_id = :uid", "uid={$userlogin['user_id']}");
          if ($updatebanco->getResult()){
            $res->msg ="Atualizado com sucesso!";
            $res->success = true;
            $res->error = false;
            echo json_encode($res);				
          }else{
            $res->msg ="Ocorreu um erro no processamento. Por favor tente novamente!";
            $res->success = false;
            $res->error = true;
            echo json_encode($res);			
          };
        };			
      };
      
    }else{
        $res->msg ="Ocorreu um erro no processamento. Por favor tente novamente!";
        $res->success = false;
        $res->error = true;
        echo json_encode($res);			
    }
      }catch (PDOException $e) {
        echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
      }
        

}

function atualizaFinanceiroCliente($payLoad){
    try{
  
        global $lerbanco;
        global $updatebanco;
      
        $res = new stdClass();
        $userlogin = $_SESSION['userlogin'];
         
      
        if(!empty($payLoad)){	
            $payLoad = array_map('strip_tags', $payLoad);
            $payLoad = array_map('trim', $payLoad);

            if(in_array('', $payLoad) || in_array('null', $payLoad)){
              
            $res->msg ="Preencha todos os campos obrigatórios!";
            $res->success = false;
            $res->error = true;
            echo json_encode($res);		
             }else{				 

                $updatebanco->ExeUpdate("ws_empresa", $payLoad, "WHERE user_id = :user", "user={$userlogin['user_id']}");
                if ($updatebanco->getResult()){
                  
                    $res->msg ="Atualiza com sucesso!";
                    $res->success = true;
                    $res->error = false;
                    echo json_encode($res);		
                }else{
                    $res->msg ="Ocorreu um erro no processamento. Por favor tente novamente!";
                       $res->success = false;
                         $res->error = true;
                     echo json_encode($res);
                };

            };
    

        }else{
            $res->msg ="Ocorreu um erro no processamento. Por favor tente novamente!";
            $res->success = false;
            $res->error = true;
            echo json_encode($res);			
      
        }

        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }
}


function atualizaConfigcardapiofacil($payLoad){


    try{
  
        global $lerbanco;
        global $updatebanco;
      
        $res = new stdClass();
        $userlogin = $_SESSION['userlogin'];

         
	 
      
        if(!empty($payLoad)){	

            if ($payLoad && !empty($payLoad['sendempresa'])){					

               
                
                $lerbanco->FullRead("select img_logo, img_header from ws_empresa WHERE user_id = :user", "user={$userlogin['user_id']}");
                if (!$lerbanco->getResult()){
                 
                }else{
                    foreach ($lerbanco->getResult() as $j):
                        extract($j);
                    endforeach;	
                }
                if(isset($payLoad['img_logo']) && empty($payLoad['img_logo'])){
                    $payLoad['img_logo'] = empty($payLoad['img_logo']) && $payLoad['img_logo']=='' ? "-1" : $payLoad['img_logo'];
                  
                }
                if(isset($payLoad['img_header']) && empty($payLoad['img_header']) ){
                  
                    $payLoad['img_header'] = empty($payLoad['img_header']) && $payLoad['img_header']=='' ? "-1" : $payLoad['img_header'];
                }



                if(in_array('', $payLoad) || in_array('null', $payLoad)){
                    
                    $res->msg ="Preencha todos os campos obrigatórios!";
                    $res->success = false;
                    $res->error = true;
                    echo json_encode($res);		
                     }else{
                        if(isset($payLoad['img_logo']) && !empty($payLoad['img_logo'])){
                        $payLoad['img_logo'] = !empty($payLoad['img_logo']) && $payLoad['img_logo']=='-1' ? "" : $payLoad['img_logo'];
                       
                        }

                    
                    if(isset($payLoad['img_header']) && !empty($payLoad['img_header']) ){
                             
                            $payLoad['img_header'] = !empty($payLoad['img_header']) && $payLoad['img_header']=='-1' ? "" : $payLoad['img_header'];
                            }



            // INICIO DA VALIDAÇÃO DA IMAGEM DE FUNDO
            if (isset($_FILES['img_header']['tmp_name']) && $_FILES['img_header']['tmp_name'] != ""){
                $payLoad['img_header'] = $_FILES['img_header'];
                $payLoad['img_header']['id_user'] = $userlogin['user_id'] ;
          } 
         
             if(isset($payLoad['img_header']) && empty($payLoad['img_header']) && !empty($img_header) && file_exists(UPLOAD_PATH.'uploads/'.$img_header) && !is_dir(UPLOAD_PATH.'uploads/'.$img_header)){
                
                unlink(UPLOAD_PATH.'uploads/'.$img_header);
                };
            if(!empty($payLoad['img_header'])){                       
                $upload = new Upload("uploads/");
                $upload->Image($payLoad['img_header']);

                if(isset($upload) && $upload->getResult()){
                    $payLoad['img_header'] = $upload->getResult();
              
                }elseif(is_array($payLoad['img_header'])){
                
                    $payLoad['img_header'] == "";
                };



    };
        // FIM DA VALIDAÇÃO DA IMAGEM DE FUNDO


                    // INICIO DA VALIDAÇÃO DA IMAGEM PERFIL
    if (isset($_FILES['img_logo']['tmp_name']) && $_FILES['img_logo']['tmp_name'] != ""){
        $payLoad['img_logo'] = $_FILES['img_logo'];
        $payLoad['img_logo']['id_user'] = $userlogin['user_id'] ;
    } 


    if(isset($payLoad['img_logo'])&& empty($payLoad['img_logo']) && !empty($img_logo) && file_exists(UPLOAD_PATH.'uploads/'.$img_logo) && !is_dir(UPLOAD_PATH.'uploads/'.$img_logo)){
       
       unlink(UPLOAD_PATH.'uploads/'.$img_logo);
   }					

    if(!empty($payLoad['img_logo'])){                    
        $upload = new Upload("uploads/");
         
        $upload->Image($payLoad['img_logo']);

        if (isset($upload) && $upload->getResult()){	

            $payLoad['img_logo'] = $upload->getResult();

    }elseif(is_array($payLoad['img_logo'])){
 
        $payLoad['img_logo'] == "";
    };

};


                unset($payLoad['sendempresa']);
                unset($payLoad['_wysihtml5_mode']);
                unset($payLoad['data_close']);
                $payLoad['end_bairro_empresa'] = tratar_nome($payLoad['end_bairro_empresa']);

                if(!empty($payLoad['minimo_delivery'])){				
                    $payLoad['minimo_delivery'] = Check::Valor($payLoad['minimo_delivery']);
                }else{
                    $payLoad['minimo_delivery'] = '0.00';
                };



                        // LIMPA OS CAMPOS RETIRANDO TAGS E ESPAÇOS DESNECESSÁRIOS
                $payLoad = array_map('strip_tags', $payLoad);
                $payLoad = array_map('trim', $payLoad);

                if(!empty($payLoad['confirm_delivery'])){
                    $payLoad['confirm_delivery'] = "true";
                }else{
                    $payLoad['confirm_delivery'] = "false";
                };
                if(!empty($payLoad['confirm_balcao'])){
                    $payLoad['confirm_balcao'] = "true";
                }else{
                    $payLoad['confirm_balcao'] = "false";
                };
                if(!empty($payLoad['confirm_mesa'])){
                    $payLoad['confirm_mesa'] = "true";
                }else{
                    $payLoad['confirm_mesa'] = "false";
                };	


                        // COMO NÃO EXISTE UM INPUT PARA IMAGEM TEMOS QUE FAZER VALIDAÇÃO VIA $_FILE MESMO
                
              
if(empty($payLoad['facebook_empresa'])){
    unset($payLoad['facebook_empresa']);
};

if(empty($payLoad['instagram_empresa'])){
    unset($payLoad['instagram_empresa']);
};

if(empty($payLoad['twitter_empresa'])){
    unset($payLoad['twitter_empresa']);
};

                        // FIM DA VALIDAÇÃO DA IMAGEM DE PERFIL 
                        //---------------------------				

if (!Check::Email($payLoad['email_empresa'])){
   
    $res->msg ="O email informado não é valido!";
    $res->success = false;
      $res->error = true;
  echo json_encode($res);

}else{						
    $payLoad['telefone_empresa'] = preg_replace("/[^0-9]/", "", $payLoad['telefone_empresa']);
    $payLoad['user_id'] = $userlogin['user_id'];	

    //$payLoad['config_delivery'] = Check::Valor($payLoad['config_delivery']);

    $payLoad['config_segunda'] = (!empty($payLoad['config_segunda']) && $payLoad['config_segunda'] == "true" ? $payLoad['config_segunda'] : "false");	

    $payLoad['config_terca'] = (!empty($payLoad['config_terca']) && $payLoad['config_terca'] == "true" ? $payLoad['config_terca'] : "false");		

    $payLoad['config_quarta'] = (!empty($payLoad['config_quarta']) && $payLoad['config_quarta'] == "true" ? $payLoad['config_quarta'] : "false");

    $payLoad['config_quinta'] = (!empty($payLoad['config_quinta']) && $payLoad['config_quinta'] == "true" ? $payLoad['config_quinta'] : "false");

    $payLoad['config_sexta'] = (!empty($payLoad['config_sexta']) && $payLoad['config_sexta'] == "true" ? $payLoad['config_sexta'] : "false");

    $payLoad['config_sabado'] = (!empty($payLoad['config_sabado']) && $payLoad['config_sabado'] == "true" ? $payLoad['config_sabado'] : "false");

    $payLoad['config_domingo'] = (!empty($payLoad['config_domingo']) && $payLoad['config_domingo'] == "true" ? $payLoad['config_domingo'] : "false");


    $payLoad['config_segundaa'] = (!empty($payLoad['config_segundaa']) && $payLoad['config_segundaa'] == "true" ? $payLoad['config_segundaa'] : "false");	

    $payLoad['config_tercaa'] = (!empty($payLoad['config_tercaa']) && $payLoad['config_tercaa'] == "true" ? $payLoad['config_tercaa'] : "false");		

    $payLoad['config_quartaa'] = (!empty($payLoad['config_quartaa']) && $payLoad['config_quartaa'] == "true" ? $payLoad['config_quartaa'] : "false");

    $payLoad['config_quintaa'] = (!empty($payLoad['config_quintaa']) && $payLoad['config_quintaa'] == "true" ? $payLoad['config_quintaa'] : "false");

    $payLoad['config_sextaa'] = (!empty($payLoad['config_sextaa']) && $payLoad['config_sextaa'] == "true" ? $payLoad['config_sextaa'] : "false");

    $payLoad['config_sabadoo'] = (!empty($payLoad['config_sabadoo']) && $payLoad['config_sabadoo'] == "true" ? $payLoad['config_sabadoo'] : "false");

    $payLoad['config_domingoo'] = (!empty($payLoad['config_domingoo']) && $payLoad['config_domingoo'] == "true" ? $payLoad['config_domingoo'] : "false");


                            //COMEÇO A FAZER A GRAVAÇÃO DOS DADOS::::::::::::::::::::::::::::::::::::::::::::::::::
    $lerbanco->ExeRead('ws_empresa', "WHERE user_id = :v", "v={$userlogin['user_id']}");
    if (!$lerbanco->getResult()){	
        $addbanco->ExeCreate("ws_empresa", $payLoad);
        if ($addbanco->getResult()){												
            $res->msg ="Atualizado com sucesso!!";
            $res->success = true;
              $res->error = false;
          echo json_encode($res);

        }else{
            $res->msg ="Ocorreu um erro no processamento. Por favor tente novamente!";
            $res->success = false;
              $res->error = true;
            echo json_encode($res);
        };

    }else{
        $updatebanco->ExeUpdate("ws_empresa", $payLoad, "WHERE user_id = :up", "up={$userlogin['user_id']}");
        if ($updatebanco->getResult()){
            
            $res->msg ="Atualizado com sucesso!!";
                       $res->success = true;
                         $res->error = false;
                     echo json_encode($res);
         
        }else{
            $res->msg ="Ocorreu um erro no processamento. Por favor tente novamente!";
            $res->success = false;
              $res->error = true;
            echo json_encode($res);
        };
    };					

};
                     }
};


        }else{
            $res->msg ="Ocorreu um erro no processamento. Por favor tente novamente!";
            $res->success = false;
            $res->error = true;
            echo json_encode($res);			
      
        }





}catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }



}
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$configuracaoObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 

if(!empty($action) && (string)$action && $action =='cuf' && !empty($configuracaoObj)){

    atualizaFinanceiroCliente($configuracaoObj);

 } 

 
if(!empty($action) && (string)$action && $action =='cus' && !empty($configuracaoObj)){

    atualizaSenhaCliente($configuracaoObj);

 } 

  if(!empty($action) && (string)$action && $action =='cup' && !empty($configuracaoObj)){

    atualizaConfigcardapiofacil($configuracaoObj);

 } 



 ob_end_flush();
?>