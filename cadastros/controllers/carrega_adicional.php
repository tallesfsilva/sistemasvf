<?php
session_cache_expire(60);
session_start();
require('../../_app/Config.inc.php');

 
$site = HOME;

$userlogin = $_SESSION['userlogin'];

 
 
try{

 
 
  $res = new stdClass();
 
  $res->data = array(); 
 
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
      
          $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and id_tipo != :idcattipo", "idcattipo={$pegaTipoAdicional[0]['id_tipo']}&userid={$userlogin['user_id']}");
      
          if($lerbanco->getResult()){
            foreach ($lerbanco->getResult() as $tipoAdcional){    
             
                extract($tipoAdcional); 
                
              $optionsTipo.= "<option value=\"{$tipoAdcional['id_tipo']}\">{$tipoAdcional['nome_adicional']}</option>";
              
            };
    
          }
        
           array_push($res->data, array("nome_cat" => "<td\"><select data-idadd=\"$id_adicionais\" class=\"categoria_grid form-control\" name=\"id_cat\" value=\"{$pegacatitens[0]['id']}\" id=\"categoria-adicional-grid\" name=\"nome_cat\" data-url=\"{$site}cadastros\" data-idcat=\"{$pegacatitens[0]['id']}\">
           {$variaveloption}{$optionsCat}</select>
          <span hidden>{$pegacatitens[0]['id']}</span></td>", "tipo_adicional" => "<td><select data-idadd=\"$id_adicionais\" class=\"atualiza_adicional form-control\" name=\"id_tipo_adicional\" value=\"{$pegaTipoAdicional[0]['id_tipo']}\" id=\"tipo-adicional-grid\" name=\"tipo_adicional\" data-url=\"{$site}cadastros\" data-idtipot=\"{$tt['id_tipo_adicional']}\">
          {$variaveloptionTipos}{$optionsTipo}</select> <span hidden>{$pegaTipoAdicional[0]['id_tipo']}</span></td>",
          "nome_adicional" => "<td><input type=\"text\" data-flag=\"true\" data-idadd=\"$id_adicionais\" data-url=\"{$site}cadastros\" value=\"{$tt['nome_adicional']}\"  name=\"nome_adicional\" class=\"atualiza_adicional form-control\"><span hidden>{$nome_adicional}</span></td>",
          "descricao_adicional"=> "<td><input rows=\"5\" cols=\"250\" type=\"text\" data-url=\"{$site}cadastros\" value=\"{$desc_adicional}\" data-idadd=\"$id_adicionais\" name=\"desc_adicional\" class=\"atualiza_adicional form-control\"></> <span hidden>\"{$desc_adicional}\"</span></td>",
          "valor_adicional" => "<td><input data-idadd=\"$id_adicionais\" data-url=\"{$site}cadastros\" type=\"text\" value=\"$valor_adicional\" name=\"valor_adicional\" class=\"atualiza_adicional form-control\">",
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
 
                    
  
?>
  