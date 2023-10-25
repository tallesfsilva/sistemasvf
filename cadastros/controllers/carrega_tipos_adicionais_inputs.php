<?php
session_cache_expire(60);
session_start();
require('../../_app/Config.inc.php');

 
$site = HOME;

$userlogin = $_SESSION['userlogin'];

$idcat =  filter_input(INPUT_GET,'idcat', FILTER_DEFAULT);
$idprod = filter_input(INPUT_GET,'idprod', FILTER_DEFAULT);

 
try{

  
  $res = new stdClass();
 
  $res->data = array(); 
  $res->success = false;

 
 
 
 $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and id_cat = :idcat" , "idcat={$idcat}&userid={$userlogin['user_id']}");
  
  if($lerbanco->getResult()){
   
 foreach ($lerbanco->getResult() as $tipo){
  extract($tipo);    
  $lerbanco->FullRead("select * from ws_produto_adicionais WHERE user_id = :userId and id_produto = :idprod and id_tipo_adicional =:idtipo", "idprod={$idprod}&idtipo={$id_tipo}&userId={$userlogin['user_id']}");
 
  if($lerbanco->getResult()){
    
    $tipo['checked'] = true;
  }
    
   array_push($res->data, $tipo);
   
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
 
                    
  
?>
  