<?php
ob_start();
 
session_start();
require('../../_app/Config.inc.php');  
 
function deletaFormasPagamento($payLoad){
    try{

        global $deletbanco;


        $userlogin = $_SESSION['userlogin'];
 
        $res['msg'] = "";
        $res['success'] = false;
        
         
        if(!empty($payLoad['idfp']) && (int) $payLoad['idfp']){
            $deletbanco->ExeDelete("ws_formas_pagamento", "WHERE user_id = :userid AND id_f_pagamento = :idfp", "userid={$userlogin['user_id']}&idfp={$payLoad['idfp']}");
            if($deletbanco->getResult()){
              $res['msg'] =  "Excluído com sucesso!";     
              $res['success'] = true;
              $res['error'] = false;
              echo json_encode($res);
            }else{
              $res['msg']  = "Ocorreu um erro na exclusão da forma de pagamento";
                    $res['success'] = false;
                    $res['error'] = true;
            }
          }else{
            $res['msg']  = "Ocorreu um erro no processamento";
            $res['success'] = false;
            $res['error'] = true;
          }
            
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }
}

function updateFormasPagamento($payLoad){


    
try{
   
    global $lerbanco;
global $updatebanco;
   
    $site = HOME;
    
    $res['msg'] = "";
    $res['success'] = false;
    $userlogin = $_SESSION['userlogin'];
     
    
    if(!empty($payLoad) && isset($payLoad['id_f_pagamento'])){
        unset($payLoad['action']);
        
        
        $lerbanco->ExeRead('ws_formas_pagamento', "WHERE user_id = :userid AND f_pagamento = :nome", "userid={$userlogin['user_id']}&nome={$payLoad['f_pagamento']}");
        if ($lerbanco->getResult()){
            $res['msg'] = "   Já existe uma forma de pagamento com este nome!";
    
          
            $res['success'] = false;
            $res['error'] = true;
            echo json_encode($res);
        
        }else {	
            unset($payLoad ['updateforma']);
         
            $payLoad  = array_map('strip_tags', $payLoad );
            $payLoad  = array_map('trim', $payLoad ); 
            $payLoad['f_pagamento'] = strtoupper($payLoad['f_pagamento']);
      
        if (in_array('', $payLoad ) || in_array('null', $payLoad )){
              $res['msg']  = "Preencha todos os campos necessários!";
                
         
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
    
     
    }else{
        
         
         
             
            
            $updatebanco->ExeUpdate("ws_formas_pagamento",$payLoad, "WHERE user_id = :userid AND id_f_pagamento = :idfp", "userid={$userlogin['user_id']}&idfp={$payLoad['id_f_pagamento']}");
            if ($updatebanco->getResult()){                                            
                $res['msg'] =  "Atualizado com sucesso!";
                
           
                     
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
             
             
            }else{
                $res['msg'] =  "Ocorreu um problema ao atualizar a forma de pagamento. Tente novamente!";
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
            };
     
    
    }
        
    };
    
    
    
    };
    
    }catch (PDOException $e) {
        echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
      }
}

function cadastrarFormasPagamento($payLoad){


    try{
        global $lerbanco;
        global $addbanco;

        $userlogin = $_SESSION['userlogin'];
        $res['msg'] = "";
        $res['success'] = false;
        
         
        if(!empty($payLoad)){
            unset($payLoad['action']);
        
            if (in_array('', $payLoad) || in_array('null', $payLoad)){
                $res['msg']  = "Preencha todos os campos necessários!";
         
            $res['success'] = false;
            $res['error'] = true;
            echo json_encode($res);	 
        
        }else{
            
            $lerbanco->ExeRead('ws_formas_pagamento', "WHERE user_id = :userid AND f_pagamento = :nome", "userid={$userlogin['user_id']}&nome={$payLoad['f_pagamento']}");
            if ($lerbanco->getResult()){
                $res['msg'] = "Já existe uma forma de pagamento com este nome!";
            
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            
            }else{	 
                $payLoad['aceita_entrega']= 1;
                $payLoad['user_id']= $userlogin['user_id'];
                $payLoad['f_pagamento']= strtoupper($payLoad['f_pagamento']);
                $addbanco->ExeCreate("ws_formas_pagamento", $payLoad);
                if ($addbanco->getResult()){                                            
                    $res['msg'] =  "Registrado com sucesso!";  
                    
                      
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                 
                 
                }else{
                    $res['msg'] =  "Ocorreu um erro em sua solicitação, por favor tente novamente!";  
                    
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                };
            };
        
        };
        
        
        
        };
        
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }
         


}


 function carregaFormasPagamento(){

 
    try {

    $site = HOME;
    $userlogin = $_SESSION['userlogin'];
   
    $res = new stdClass();
   
    $res->data = array();
   
   
   global $lerbanco;
    
    
    
    $lerbanco->FullRead("select * from ws_formas_pagamento WHERE user_id = {$userlogin['user_id']}");
    if($lerbanco->getResult()){
     
      $res->draw = 1;
      $res->recordsTotal =  $lerbanco->getRowCount();
      $res->recordsFiltered = $lerbanco->getRowCount();;
      
      foreach($lerbanco->getResult() as $tt){
        extract($tt);
      
   
         if($aceita_entrega) { 
            $idButton = "btn_s";
            $classButton = "aceita_entrega";
            $style= "background-color: #00BB07";
            $value = "Sim";
         }else{
          $idButton = "btn_n";
          $classButton = "aceita_entrega";
          $style= "background-color: #00BB07";
          $value = "Não";
          }
       
        
  
          array_push($res->data, array("forma_pagamento" => "<td> <input data-url=\"{$site}cadastros\" data-flag = \"true\" id=\"f_pagamento{$id_f_pagamento}\" data-idfp=\"{$id_f_pagamento}\" value=\"{$f_pagamento}\" oninput=\"this.value = this.value.replace(/[^a-z-A-Z ]/g, '')\"   maxlength=\"30\" type=\"text\"  name=\"f_pagamento\" class=\"form-control atualiza_forma\" placeholder=\"Dinheiro, Crédito Visa, etc...\"><span hidden>{$f_pagamento}</span></td>",
          "aceita" => "<td><button id=\"{$idButton}\" class=\"{$classButton}\" style=\"{$style}\" data-url=\"{$site}cadastros\" data-idfp=\"{$id_f_pagamento}\">{$value}</button></td>",       
          "excluir" => "<td><button data-url=\"{$site}cadastros\" data-idfp=\"{$id_f_pagamento}\"style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete delete_forma\"><span class=\"glyphicon glyphicon-trash\"></span>
          </button></td>"));
        
        }
          echo json_encode($res);
    }else{
      $res->draw = 1;
      $res->recordsTotal =  0;
      $res->recordsFiltered = 0;
      $res->data = array();
  
      echo json_encode($res);
    }
  
  
   
  
  }catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
   
                      
 }

 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$formasPagamentoObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 
   //Carrega Tabela Forma de Pagamento - GET
  //body - action = fl
   if(!empty($action) && (string)$action && $action =='fl'){

      carregaFormasPagamento();

   } 
  
  //Exclui Forma de Pagamento - POST
  //body - action = fe
 
  if(!empty($formasPagamentoObj['action']) && (string)$formasPagamentoObj['action'] && $formasPagamentoObj['action']=='fe' && (int)$formasPagamentoObj['idfp']){

    deletaFormasPagamento($formasPagamentoObj);
}
  //Atualiza Forma de Pagamento - POST
  //body - action = fu
if(!empty($formasPagamentoObj['action']) && (string)$formasPagamentoObj['action'] && $formasPagamentoObj['action']=='fu' && (int)$formasPagamentoObj['id_f_pagamento']){

    updateFormasPagamento($formasPagamentoObj);
}


 //Cadastra Forma de Pagamento - POST
  //body - action = fc
  if(!empty($formasPagamentoObj['action']) && (string)$formasPagamentoObj['action'] && $formasPagamentoObj['action']=='fc'){

    cadastrarFormasPagamento($formasPagamentoObj);
}



 

          
                    
ob_end_flush();


?>