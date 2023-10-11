<?php
session_cache_expire(60);
session_start();
require('../../_app/Config.inc.php');

 
$site = HOME;

$userlogin = $_SESSION['userlogin'];
 
try{

 
 
  $res = new stdClass();
 
  $res->data = array();
 
 
 
  
  
  
  $lerbanco->FullRead("select id, nome_cat from ws_cat WHERE user_id = {$userlogin['user_id']}");
  if($lerbanco->getResult()){    
        
    foreach($lerbanco->getResult() as $tt){
      extract($tt);
        array_push($res->data, $tt);       
     }
      
     echo json_encode($res);
  }else{  
    $res->data = array();
    echo json_encode($res);
  }


 

}catch (PDOException $e) {
  echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
 
                    
  
?>
  