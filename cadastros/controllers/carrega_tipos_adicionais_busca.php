<?php
session_cache_expire(60);
session_start();
require('../../_app/Config.inc.php');

 
$site = HOME;

$userlogin = $_SESSION['userlogin'];

$idcat =  filter_input(INPUT_GET,'idcat', FILTER_DEFAULT);

 
try{

  
  $res = new stdClass();
 
  $res->data = array(); 
  $res->success = false;

 
 
 
 $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid" , "&userid={$userlogin['user_id']}");
  
 if($lerbanco->getResult()){
   
 foreach ($lerbanco->getResult() as $cat){
         extract($cat);    
    
   array_push($res->data, $cat);
   
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
  