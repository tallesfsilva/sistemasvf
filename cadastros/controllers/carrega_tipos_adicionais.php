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
        "quantidade" => "<td><input type=\"text\" data-idtipo=\"$id_tipo\" data-url=\"{$site}cadastros\" value=\"$quantidade\" oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\"  step=\"1\" min=\"1\" max=\"99\" name=\"quantidade\" class=\"atualiza_tipo form-control\" placeholder=\"Digite uma quantidade do adicional obrigatória\"><span hidden>{$quantidade}</span></td>",
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
 
                    
  
?>
  