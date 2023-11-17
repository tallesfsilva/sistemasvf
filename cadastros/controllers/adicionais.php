<?php

ob_start();
 
session_start();
require('../../_app/Config.inc.php'); 


function carregaAdicionalProduto($payLoad){


    
    
     
     
    try{
    
      global $lerbanco;

      $site = HOME;

      $userlogin = $_SESSION['userlogin'];
     
      $res = new stdClass();
     
      $res->data = array(); 
 
    
      
      if(!empty($payLoad['idtipo']) && (int)$payLoad['idtipo']){
      
       $lerbanco->FullRead("select ad.id_adicionais, ad.nome_adicional 'nome_adicional', ad.valor_adicional,ad.desc_adicional, tp.id_tipo, tp.nome_adicional 'nome_tipo_adicional'
       from ws_adicionais_itens ad join ws_tipo_adicional tp on ad.id_tipo_adicional = tp.id_tipo where ad.user_id = {$userlogin['user_id']} and ad.id_tipo_adicional = {$payLoad['idtipo']}");
     
       if($lerbanco->getResult()){
        $nomeTipoAdicional = $lerbanco->getResult()[0];
        array_push($res->data, array('id_tipo' => $nomeTipoAdicional['id_tipo']));
        array_push($res->data, array("nome_tipo_adicional" =>"<div class=\"indent_title_in\"><h3>{$nomeTipoAdicional['nome_tipo_adicional']}</h3></div>"));
       
        foreach($lerbanco->getResult() as $tt){
            extract($tt);
     
                array_push($res->data, array('adicionais' => "<div class=\"m-3 icheck-material-green\"><input type=\"checkbox\" name=\"adicional_prod\" class=\"adicional\" data-idtipo=\"$id_tipo\" data-idad=\"{$id_adicionais}\" value=\"$id_adicionais\" id=ad_\"$id_adicionais\"><label for=ad_\"{$id_adicionais}\">{$nome_adicional} ({$valor_adicional})</label></div>"));
            }
           
        $res->success = true;
     
         echo json_encode($res);
      }else{
        $res->success = false;
        $res->data = array();
       
        echo json_encode($res);
      }
    
      }else{
        $res->msg ="Ocorreu um erro em sua soliticação.";
        $res->success = false;
        $res->data = array();
        echo json_encode($res);
    }
     
    
    }catch (PDOException $e) {
      echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
    }
     

}


function carregaTabelaAdicional(){
     
try{

 
    global $lerbanco;

    $res = new stdClass();
   
    $res->data = array(); 
    $site = HOME;

    $userlogin = $_SESSION['userlogin'];
    
    $optionsCat = "";
    $optionsTipo= "";
    $pegacatitens = "";
    $variaveloption = ""; 
    $pegaTipoAdicional = "";
    $variaveloptionTipo = ""; 
   
  
   
    
    
     $lerbanco->ExeRead("ws_adicionais_itens", "where user_id = :userid and id_tipo_adicional != 0", "userid={$userlogin['user_id']}");
   
     if($lerbanco->getResult()){
     
      $res->draw = 1;
      $res->recordsTotal =  $lerbanco->getRowCount();
      $res->recordsFiltered = $lerbanco->getRowCount();;
      
      foreach($lerbanco->getResult() as $tt){
          extract($tt);
   
          //Categorias
          $lerbanco->FullRead("select cat.id,adi.id_adicionais, cat.nome_cat from ws_cat as cat join ws_adicionais_itens as adi on adi.id_cat = cat.id  WHERE adi.user_id = {$userlogin['user_id']} and adi.id_adicionais = {$id_adicionais}");
          
          if($lerbanco->getResult()){
            $pegacatitens = $lerbanco->getResult();       
      
            $variaveloption =  "<option value=\"{$pegacatitens[0]['id']}\">{$pegacatitens[0]['nome_cat']}</option>";  
        
            $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid and id != :idcattipo", "idcattipo={$pegacatitens[0]['id']}&userid={$userlogin['user_id']}");
        
            if($lerbanco->getResult()){
              foreach ($lerbanco->getResult() as $cat){    
               
                  extract($cat); 
                  
                $optionsCat.= "<option value=\"{$cat['id']}\">{$cat['nome_cat']}</option>";
                
              };
      
            }
    
            //Tipo Adicionais
    
            $lerbanco->FullRead("select tipo.id_tipo,adi.id_adicionais, tipo.nome_adicional from ws_tipo_adicional as tipo 
            join ws_adicionais_itens as adi on adi.id_tipo_adicional = tipo.id_tipo  WHERE adi.user_id = {$userlogin['user_id']} and adi.id_adicionais = {$id_adicionais}");
            
            $pegaTipoAdicional = $lerbanco->getResult();       
           
            $variaveloptionTipos =  "<option value=\"{$pegaTipoAdicional[0]['id_tipo']}\">{$pegaTipoAdicional[0]['nome_adicional']}</option>";  
        
            $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and id_tipo != :idcattipo and id_cat =:idcat ", "idcat={$pegacatitens[0]['id']}&idcattipo={$pegaTipoAdicional[0]['id_tipo']}&userid={$userlogin['user_id']}");
        
            if($lerbanco->getResult()){
              foreach ($lerbanco->getResult() as $tipoAdcional){    
               
                  extract($tipoAdcional); 
                  
                $optionsTipo.= "<option value=\"{$tipoAdcional['id_tipo']}\">{$tipoAdcional['nome_adicional']}</option>";
                
              };
      
            }
          
             array_push($res->data, array("nome_cat" => "<td\"><select data-idadd=\"$id_adicionais\" class=\"categoria_grid form-control\" name=\"id_cat\" value=\"{$pegacatitens[0]['id']}\" id=\"categoria-adicional-grid\" name=\"nome_cat\" data-url=\"{$site}cadastros\" data-idcat=\"{$pegacatitens[0]['id']}\">
             {$variaveloption}{$optionsCat}</select>
            <span hidden>{$pegacatitens[0]['id']}</span></td>", "tipo_adicional" => "<td><select data-idadd=\"$id_adicionais\" class=\"atualiza_adicional form-control\" name=\"id_tipo_adicional\" value=\"{$pegaTipoAdicional[0]['id_tipo']}\" id=\"tipo-adicional-grid_{$id_adicionais}\" name=\"tipo_adicional\" data-url=\"{$site}cadastros\" data-idtipot=\"{$tt['id_tipo_adicional']}\">
            {$variaveloptionTipos}{$optionsTipo}</select> <span hidden>{$pegaTipoAdicional[0]['id_tipo']}</span></td>",
            "nome_adicional" => "<td><input type=\"text\" data-flag=\"true\" data-idadd=\"$id_adicionais\" data-url=\"{$site}cadastros\" value=\"{$tt['nome_adicional']}\"  name=\"nome_adicional\" class=\"atualiza_adicional form-control\"><span hidden>{$tt['nome_adicional']}</span></td>",
            "descricao_adicional"=> "<td><input rows=\"5\" cols=\"250\" type=\"text\" data-url=\"{$site}cadastros\" value=\"{$desc_adicional}\" data-idadd=\"$id_adicionais\" name=\"desc_adicional\" class=\"atualiza_adicional form-control\"></> <span hidden>\"{$desc_adicional}\"</span></td>",
            "valor_adicional" => "<td><input data-idadd=\"$id_adicionais\" data-url=\"{$site}cadastros\" type=\"text\" value=\"$valor_adicional\"  max=\"999.99\"  maxlength=\"6\" name=\"valor_adicional\"class=\"valor_adicional atualiza_adicional form-control\"><span hidden>{$valor_adicional}</span></td>",
            "excluir" => "<td><button data-url=\"{$site}cadastros\" style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete deletar_adicional\" data-idad=\"$id_adicionais\"><span class=\"glyphicon glyphicon-trash\"></span></button>")) ;
            $optionsCat = "";
            $optionsTipo = "";
            
          }
         
      }
   
       echo json_encode($res);
    }else{
      $res->draw = 0;
      $res->recordsTotal =  0;
      $res->recordsFiltered = 0;
      $res->data = array();
     
      echo json_encode($res);
    }
  
  
   
  
  }catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
   
               
}


function atualizaAdicional($payLoad){


 
    try{
        global $lerbanco;
        global $updatebanco;
    
      $res['msg'] = "";
      $res['success'] = false;
    
      $userlogin = $_SESSION['userlogin'];
    
      
      $flagName = $payLoad['flagName']=='false' ? false : true;
       
     
      
      if(!empty($payLoad) && isset($payLoad['id_adicionais'])){
        $lerbanco->ExeRead("ws_adicionais_itens", "WHERE user_id = :userid and nome_adicional = :nome and id_tipo_adicional = :id_tipo and id_cat = :idcat", "id_tipo={$payLoad['id_tipo_adicional']}&idcat={$payLoad['id_cat']}&userid={$userlogin['user_id']}&nome={$payLoad['nome_adicional']}");
         
        if ($lerbanco->getResult()){             
    
                $res['msg'] =  "Já existe um adicional com este nome na categoria selecionada. Por favor selecione outro!";
                $res['success'] = false;
                $res['error'] = true;  
               
                echo json_encode($res);
              }else{
    
    
             
     
                  $id_adicionais = $payLoad['id_adicionais'];
                  unset($payLoad['id_adicionais']);
                  unset($payLoad['flagName']);
                 
    
                  $payLoad = array_map('strip_tags', $payLoad);
                  $payLoad = array_map('trim', $payLoad);
              
               
              if(empty($payLoad['id_cat'])){   
                    $res['msg'] =  "Por favor selecione uma categoria!";
                    $res['success'] = false;
                    $res['error'] = true;  
                   
                    echo json_encode($res);
              } else if(empty($payLoad['id_tipo_adicional'])){   
                    $res['msg'] =  "Por favor selecione um tipo de adicional";
                    $res['success'] = false;
                    $res['error'] = true;  
                    echo json_encode($res);
               
            } else if($payLoad['valor_adicional']==""){   
                  
              $res['msg'] =  "Valor do Adicional é obrigatório!";
                  $res['success'] = false;
                  $res['error'] = true;  
                 
                  echo json_encode($res);
             
            
            } else if(empty($payLoad['nome_adicional'])){   
                $res['msg'] =  " Você precisa preecher o campo nome do adicional para continuar!";
                $res['success'] = false;
                $res['error'] = true;  
              
                echo json_encode($res);
        }else{ 
          $payLoad['nome_adicional'] = strtoupper($payLoad['nome_adicional']);
          $payLoad['desc_adicional'] = strtoupper($payLoad['desc_adicional']);
          $payLoad['valor_adicional'] = (float) $payLoad['valor_adicional'];
              $updatebanco->ExeUpdate("ws_adicionais_itens", $payLoad, "WHERE user_id = :userid AND id_adicionais = :newcatupdat", "userid={$userlogin['user_id']}&newcatupdat={$id_adicionais}");
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
 
function deletaAdicional($payLoad){


    try{
        global $deletbanco;
        $res['msg'] = "";
        $res['success'] = false;
         
       
         $idusuario = $_SESSION['userlogin'];
    
         if(!empty($payLoad['id_adicional']) && (int)$payLoad['id_adicional'] && !empty($idusuario['user_id'])){
    
        $deletbanco->ExeDelete("ws_adicionais_itens", "WHERE user_id = :userid AND id_adicionais = :fdv", "userid={$idusuario['user_id']}&fdv={$payLoad['id_adicional']}");
        if($deletbanco->getResult()){
            $res['msg'] = "Excluído com sucesso!";
            $res['success'] = true;
            echo json_encode($res);
    
    
        }else{
            $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
            $res['success'] = false;
            echo json_encode($res);
        }  
           
    }else{
    $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
    $res['success'] = false;
    echo json_encode($res);
    }    
         
    }catch (PDOException $e) {
        echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
      }
    
 

}


function cadastraAdicional($payLoad){



    $userlogin = $_SESSION['userlogin'];
 
    try{
    
    global $lerbanco;
    global $addbanco;
      $res['msg'] = "";
      $res['success'] = false;
    
    
      
    
     
    
      if(!empty($payLoad)){
              $lerbanco->ExeRead("ws_adicionais_itens", "WHERE user_id = :userid and nome_adicional = :nome and id_cat = :idcat  and id_tipo_adicional = :id_tipo", "id_tipo={$payLoad['id_tipo_adicional']}&idcat={$payLoad['id_cat']}&userid={$userlogin['user_id']}&nome={$payLoad['nome_adicional']}");
              if ($lerbanco->getResult()){
                 
    
                $res['msg'] =  "Já existe um adicional com este nome na categoria selecionada. Por favor selecione outro!";
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
                } else if(empty($payLoad['id_tipo_adicional'])){   
                      $res['msg'] =  "Por favor selecione um tipo de adicional";
                      $res['success'] = false;
                      $res['error'] = true;  
                      echo json_encode($res);
                 
                
                
                } else if(($payLoad['valor_adicional']=='')){   
                  $res['msg'] =  "Valor do adicional é obrigatório";
                  $res['success'] = false;
                  $res['error'] = true;  
                  echo json_encode($res);
             
            
            } else if(empty($payLoad['nome_adicional'])){   
                $res['msg'] =  "Por favor preencha o nome do adicional";
                $res['success'] = false;
                $res['error'] = true;  
                echo json_encode($res);
        }else{ 
          $payLoad['nome_adicional'] = strtoupper($payLoad['nome_adicional']);
          $payLoad['nome_adicional'] = strtoupper($payLoad['nome_adicional']);
          $payLoad['medida_adicional'] = "UN";
          $payLoad['status_adicional'] = "1";
          $payLoad['categorias_adicional'] = "-1";
          $payLoad['user_id'] = $userlogin['user_id'];
              $addbanco->ExeCreate("ws_adicionais_itens", $payLoad);
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
$adicionaisObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 

//Deleta Adicional- POST
  //body - action = ae
  if(!empty($action) && (string)$action && $action=='ae' && !empty($adicionaisObj) && $adicionaisObj['id_adicional']){

    deletaAdicional($adicionaisObj);
}


 //Atualiza adicional payLoad- POST
  //body - action = au
  if(!empty($action) && (string)$action && $action=='au' && !empty($adicionaisObj)){

    atualizaAdicional($adicionaisObj);
}



 //Carrega Tabela Adicional- GET
  //body - action = al
  if(!empty($action) && (string)$action && $action=='al'){

    carregaTabelaAdicional();
}


 //Cadastra Adicional- POST
  //body - action = ac
  if(!empty($action) && (string)$action && $action=='ac' && !empty($adicionaisObj)){

    cadastraAdicional($adicionaisObj);
}
 
 //Carrega Adicional Produto = GET
  //body - action = ap
  if(!empty($action) && (string)$action && $action=='ap' && !empty($adicionaisObj['idtipo'])){

    carregaAdicionalProduto($adicionaisObj);
}
 





          
                    
ob_end_flush();


?>














 