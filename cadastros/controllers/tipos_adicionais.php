<?php

ob_start();
 
session_start();
require('../../_app/Config.inc.php');  
 


function loadTipoAdicionalGrid($payLoad){


  
     
    try{
    
      global $lerbanco;
      $res = new stdClass();
     
      $res->data = array(); 
      $res->success = false;
    
      $site = HOME;

      $userlogin = $_SESSION['userlogin'];
       
      
     
     
     $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and id_cat = :idcat" , "idcat={$payLoad['idcat']}&userid={$userlogin['user_id']}");
      
      if($lerbanco->getResult()){
       
     foreach ($lerbanco->getResult() as $tipo){
      extract($tipo);   

      if(!empty($payLoad['idprod']) && (int)$payLoad['idprod']){

        $lerbanco->FullRead("select * from ws_produto_adicionais WHERE user_id = :userId and id_produto = :idprod and id_tipo_adicional =:idtipo", "idprod={$payLoad['idprod']}&idtipo={$id_tipo}&userId={$userlogin['user_id']}");
     
        if($lerbanco->getResult()){
          
          $tipo['checked'] = true;
        }
          
         array_push($res->data, $tipo);
      }else{
        array_push($res->data, $tipo);
      }
       
       
     };
      
      
        $res->success = true;
        echo json_encode($res);
              
           
     
            
        
      }else{
        $res->success = false;
        $res->data = array();
     
        echo json_encode($res);
      }
    
    
     
    
    }catch (PDOException $e) {
      echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
    }
     
                        
      
  
      





}

function atualizaTipoAdicional($payLoad){



 
    try{
    
      $res['msg'] = "";
      $res['success'] = false;
      global $lerbanco;
      global $updatebanco;

    
      $userlogin = $_SESSION['userlogin'];

      $payLoad = filter_input_array(INPUT_POST, FILTER_DEFAULT);
      $flagName = $payLoad['flagName']=='false' ? false : true;
     
    
      if(!empty($payLoad) && isset($payLoad['id_tipo'])){
        $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and nome_adicional = :nome and id_cat =:idcat ", "idcat={$payLoad['id_cat']}&userid={$userlogin['user_id']}&nome={$payLoad['nome_adicional']}");
              if ($lerbanco->getResult() && $flagName && !empty($flagName)){             
    
                $res['msg'] =  "Já existe um tipo de adicional com este nome na categoria selecionada. Por favor selecione outro!";
                $res['success'] = false;
                $res['error'] = true;  
               
                echo json_encode($res);
              }else{
    
     
                 
                  $id_tipo = $payLoad['id_tipo'];
                  unset($payLoad['id_tipo']);
                  unset($payLoad['flagName']);
    
                  $payLoad = array_map('strip_tags', $payLoad);
                  $payLoad = array_map('trim', $payLoad);
              
               
              if(empty($payLoad['id_cat'])){   
                    $res['msg'] =  "Por favor seleciona uma categoria!";
                    $res['success'] = false;
                    $res['error'] = true;
                    
                    echo json_encode($res);
                
            } else if($payLoad['quantidade']==""){   
                  
              $res['msg'] =  "Quantidade do tipo de adicional é obrigatória!";
                  $res['success'] = false;
                  $res['error'] = true;  
                  echo json_encode($res);
             
            
            } else if(empty($payLoad['nome_adicional'])){   
                $res['msg'] =  "Por favor preencha o campo nome do tipo de adicional";
                $res['success'] = false;
                $res['error'] = true;  
                
                echo json_encode($res);
        }else{ 
          $payLoad['nome_adicional'] = strtoupper($payLoad['nome_adicional']);
          $payLoad['quantidade'] = (int) $payLoad['quantidade'];
              $updatebanco->ExeUpdate("ws_tipo_adicional", $payLoad, "WHERE user_id = :userid AND id_tipo = :idtipo", "userid={$userlogin['user_id']}&idtipo={$id_tipo}");
              if($updatebanco->getResult()){
                  $res['msg'] =  "Atualizado com sucesso!";
                  $res['success'] = true;  
                  $res['error'] = false;          
    
                  
               
                  echo json_encode($res);
              }else{
                $res['msg'] =  "Ocorreu um erro no processamento. Por favor tente novamente!";
                $res['success'] = false;
                $res['error'] = true;  
                
                echo json_encode($res);
                
              }
            }
     
     
 
    }
      }
    
    }catch (PDOException $e) {
      echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
    }
     


}



function carregaTableTiposAdicionais(){


   
 
    try{

        $site = HOME;
    
    global $lerbanco;
    
    $userlogin = $_SESSION['userlogin'];
     
      $res = new stdClass();
     
      $res->data = array(); 
     
     $optionsCat = "";
     $pegacatitens = "";
     $variaveloption = ""; 
     $arrayCat = array();
    
     
      
      
      $lerbanco->FullRead("select id_tipo,user_id, id_cat, nome_adicional, quantidade from ws_tipo_adicional WHERE user_id = {$userlogin['user_id']}");
      if($lerbanco->getResult()){
       
        $res->draw = 1;
        $res->recordsTotal =  $lerbanco->getRowCount();
        $res->recordsFiltered = $lerbanco->getRowCount();;
        
        foreach($lerbanco->getResult() as $tt){
          extract($tt);
     
            $lerbanco->FullRead("select cat.desc_cat,cat.icon_cat, cat.id, tipo.id_tipo, cat.nome_cat from ws_cat as cat join ws_tipo_adicional as tipo on tipo.id_cat = cat.id WHERE tipo.user_id = {$userlogin['user_id']} and tipo.id_tipo = {$id_tipo}");
            
           
            $pegacatitens = $lerbanco->getResult();       
           
            $variaveloption =  "<option value=\"{$pegacatitens[0]['id']}\">{$pegacatitens[0]['nome_cat']}</option>";  
       
            $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid and id != :idcattipo", "idcattipo={$pegacatitens[0]['id']}&userid={$userlogin['user_id']}");
        
            if($lerbanco->getResult()){
              foreach ($lerbanco->getResult() as $cat){    
               
                  extract($cat); 
                  
                $optionsCat.= "<option value=\"{$cat['id']}\">{$cat['nome_cat']}</option>";
                
              };
      
            }
          
             array_push($res->data, array("nome_cat" => "</div><td  data-idtipo=\"$id_tipo\"><select data-idtipo=\"$id_tipo\" class=\"atualiza_tipo form-control\" name=\"id_cat\" value=\"{$pegacatitens[0]['id']}\" id=\"categoria-tipo\" name=\"nome_cat\" data-url=\"{$site}cadastros\" data-idcat=\"{$tt['id_cat']}\">
             {$variaveloption}{$optionsCat}</select>
            <span hidden>{$pegacatitens[0]['id']}</span></td>", "tipo_adicional" => "<td><input type=\"text\" data-flag=\"true\" data-idtipo=\"$id_tipo\" data-url=\"{$site}cadastros\" value=\"$nome_adicional\"oninput=\"this.value = this.value.toUpperCase()\" name=\"nome_adicional\" class=\"atualiza_tipo form-control\" placeholder=\"Digite um nome para o tipo de adicional\"> <span hidden>{$nome_adicional}</span></td>",
            "quantidade" => "<td><input type=\"text\" data-idtipo=\"$id_tipo\" data-url=\"{$site}cadastros\" value=\"$quantidade\" oninput=\"this.value = this.value > parseInt('20') ? '' : this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\"  step=\"1\" min=\"1\" max=\"20\" name=\"quantidade\" class=\"atualiza_tipo form-control\" placeholder=\"Digite uma quantidade do adicional obrigatória\"><span hidden>{$quantidade}</span></td>",
            "excluir" => "<td><button data-url=\"{$site}cadastros\" style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete deletar_tipo\" data-idtipo=\"$id_tipo\"><span class=\"glyphicon glyphicon-trash\"></span></button>")) ;
            $optionsCat = "";
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



function deletaTipoAdicional($payLoad){

    try{
    

        global $deletbanco;

        $res['msg'] = "";
        $res['success'] = false;
    
        
         
       
         $idusuario = $_SESSION['userlogin'];
        
         if(!empty($payLoad['id_tipo']) && (int) $payLoad['id_tipo'] && !empty($idusuario['user_id'])){
            
                $deletbanco->ExeDelete("ws_tipo_adicional", "WHERE user_id = :userid AND id_tipo = :fdv", "userid={$idusuario['user_id']}&fdv={$payLoad['id_tipo']}");
                if($deletbanco->getResult()){
                    $res['msg'] = "Excluído com sucesso!";
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
    
    
        }else{
            $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
        }  
           
    }else{
        $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
        $res['success'] = false;
        $res['error'] = true;  
        echo json_encode($res);
    }    
         
    }catch (PDOException $e) {
        echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
      }
    
    
}



function cadastraTipoAdicional($payLoad){
    

 
try{

  $res['msg'] = "";
  $res['success'] = false;
  $userlogin = $_SESSION['userlogin'];

  global $lerbanco;
  global $addbanco;

 

  if(!empty($payLoad)){
          $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and nome_adicional = :nome and id_cat =:idcat ", "idcat={$payLoad['id_cat']}&userid={$userlogin['user_id']}&nome={$payLoad['nome_adicional']}");
          if ($lerbanco->getResult()){
             

            $res['msg'] =  "Já existe um tipo de adicional com este nome na categoria selecionada. Por favor selecione outro!";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
          }else{


           
          
              $payLoad = array_map('strip_tags', $payLoad);
              $payLoad = array_map('trim', $payLoad);
          
           
          if(empty($payLoad['id_cat'])){   
                $res['msg'] =  "Por favor selecione uma categoria!";
                $res['success'] = false;
                $res['error'] = true;  
                echo json_encode($res);
            
            } else if($payLoad['quantidade'] == ""){   
              $res['msg'] =  "Quantidade do tipo de adicional é obrigatório!";
              $res['success'] = false;
              $res['error'] = true;  
              echo json_encode($res);
         
        
        } else if(empty($payLoad['nome_adicional'])){   
            $res['msg']  = "Preencha todos os campos necessários!";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
    }else{ 
      $payLoad['nome_adicional'] = strtoupper($payLoad['nome_adicional']);
      $payLoad['quantidade'] = (int) $payLoad['quantidade'];
      $payLoad['user_id'] = $userlogin['user_id'];
          $addbanco->ExeCreate("ws_tipo_adicional", $payLoad);
          if($addbanco->getResult()){
              $res['msg'] =  "Registrado com sucesso!";
              $res['success'] = true;  
              $res['error'] = false;  
              echo json_encode($res);
          }else{
            $res['msg'] =  "Ocorreu um erro no processamento. Por favor tente novamente!";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
            
          }
        }
 
 
 
 
}
  }

}catch (PDOException $e) {
  echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
 
                    
  
 
  
}

 


 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$tipoAdicionalObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 
  
  //Exclui Tipo de Adicional POST
  //body - action = tae
 
  if(!empty($action) && (string)$action && $action=='tae' && !empty($tipoAdicionalObj['id_tipo']) && (int)$tipoAdicionalObj['id_tipo']){

    deletaTipoAdicional($tipoAdicionalObj);
}
  //Atualiza Tipo de Adicional- POST
  //body - action = tu
if(!empty($action) && (string)$action && $action=='tau' && !empty($tipoAdicionalObj['id_tipo']) && (int)$tipoAdicionalObj['id_tipo']){

    atualizaTipoAdicional($tipoAdicionalObj);
}


 //Cadastra Tipo de Adicional- POST
  //body - action = tc
  if(!empty($action) && (string)$action && $action=='tac' && !empty($tipoAdicionalObj)){

    cadastraTipoAdicional($tipoAdicionalObj);
}
    //Carrega Tabela Tipo Adicional - GET
  //body - action = ltp
  if(!empty($action) && (string)$action && $action =='tal'){

    carregaTableTiposAdicionais($tipoAdicionalObj);

   } 

     //Carrega Inpus Tipo Adicional Table Adicionais - POST
  //body - action = tag
  if(!empty($action) && (string)$action && $action =='tag' && !empty($tipoAdicionalObj) && (int)$tipoAdicionalObj['idcat'] ){

    loadTipoAdicionalGrid($tipoAdicionalObj);

   } 



          
                    
ob_end_flush();


?>














 