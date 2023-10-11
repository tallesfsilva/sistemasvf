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
   
    $res->draw = 1;
    $res->recordsTotal =  $lerbanco->getRowCount();
    $res->recordsFiltered = $lerbanco->getRowCount();;
    
    foreach($lerbanco->getResult() as $tt){
      extract($tt);
        array_push($res->data, array("nome_cat" => "<div id=\"msg_$id\"></div><td  id=\"nome_cat_$id\"><input type=\"text\" data-iduser=\"{$userlogin['user_id']}\" name=\"nome_cat\" data-url=\"{$site}cadastros\" data-idcat=\"{$id}\" value=\"{$nome_cat}\" class=\"atualiza_cat form-control\" placeholder=\"Nome da categoria...\">
        <span hidden>{$nome_cat}</span></td>", 
        "excluir" => "<td><button data-url=\"{$site}cadastros\" style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete deletar_cat\" data-idcat=\"$id\"><span class=\"glyphicon glyphicon-trash\"></span></button>")) ;
 
 
          
   

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
  