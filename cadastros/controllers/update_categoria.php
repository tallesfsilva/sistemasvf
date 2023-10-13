<?php
 
session_start();
require('../../_app/Config.inc.php');

 
$userlogin = $_SESSION['userlogin'];
 
try{

  $res['msg'] = "";
  $res['success'] = false;

  $updateAdicional = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  

  if(!empty($updateAdicional) && isset($updateAdicional['cat_update']) && $novaCategoria['nome_cat']){
  
   $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND nome_cat = :cat", "userid={$userlogin['user_id']}&cat={$novaCategoria['nome_cat']}");
   if ($lerbanco->getResult()){
    $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
    Já existe uma categoria com este nome. Por favor selecione outro!
    </div>";
    $res['success'] = false;
    $res['error'] = true;  
   
    echo json_encode($res);
     
     //header("Refresh: 5; url={$site}{cadastro/categorias");
   }else{
       $novaCategoria = array_map('strip_tags', $novaCategoria);
       $novaCategoria = array_map('trim', $novaCategoria); 
 
   if($novaCategoria['nome_cat'] == ""){

    $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
    Você precisa preecher o campo com o nome da categoria para continuar!
    </div>";
    $res['success'] = false;
    $res['error'] = true;  
    echo json_encode($res);
 
    // header("Refresh: 5; url={$site}cadastros/categorias");
   }else{
     $newCategoriaName['nome_cat'] = strtoupper($novaCategoria['nome_cat']);
    
     $updatebanco->ExeUpdate("ws_cat",$newCategoriaName, "WHERE user_id = :userid AND id = :newcatupdat", "userid={$userlogin['user_id']}&newcatupdat={$novaCategoria['cat_id']}");
     if ($updatebanco->getResult()){

      $res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
      <b class=\"alert-link\">SUCESSO!</b> A categoria foi atualizada.
      </div>";
      $res['success'] = true;  
      $res['error'] = false;  
      $res['data'] = $novaCategoria['nome_cat'];
      echo json_encode($res);
         
     }else{    
      $res['msg'] =  "<div class=\"alert alert-danger alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
      <b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
      </div>";
      $res['success'] = false;
      $res['error'] = true;  
      echo json_encode($res);
       
     };
   };
 };
 
 }else{
  $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
  Você precisa preecher o campo com o nome da categoria para continuar!
  </div>";
  $res['success'] = false;
  $res['error'] = true;  
  echo json_encode($res);

 }

}catch (PDOException $e) {
  echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
 
                    
  
?>
  