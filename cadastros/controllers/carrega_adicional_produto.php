<?php
session_cache_expire(60);
session_start();
require('../../_app/Config.inc.php');

 
$site = HOME;

$userlogin = $_SESSION['userlogin'];

 
 
try{

 
 
  $res = new stdClass();
 
  $res->data = array(); 
  $idtipo =  filter_input(INPUT_GET,'idtipo', FILTER_DEFAULT);

  
  if(!empty($idtipo && (int)$idtipo)){
  
   $lerbanco->FullRead("select ad.id_adicionais, ad.nome_adicional 'nome_adicional', ad.valor_adicional,ad.desc_adicional, tp.id_tipo, tp.nome_adicional 'nome_tipo_adicional'
   from ws_adicionais_itens ad join ws_tipo_adicional tp on ad.id_tipo_adicional = tp.id_tipo where ad.user_id = {$userlogin['user_id']} and ad.id_tipo_adicional = {$idtipo}");
 
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
 
                    
  
?>
  