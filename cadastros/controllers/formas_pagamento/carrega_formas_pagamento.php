<?php

session_start();
require('../../../_app/Config.inc.php');

 



 
try{

  $site = HOME;
  $userlogin = $_SESSION['userlogin'];
 
  $res = new stdClass();
 
  $res->data = array();
 
 
 
  
  
  
  $lerbanco->FullRead("select * from ws_formas_pagamento WHERE user_id = {$userlogin['user_id']}");
  if($lerbanco->getResult()){
   
    $res->draw = 1;
    $res->recordsTotal =  $lerbanco->getRowCount();
    $res->recordsFiltered = $lerbanco->getRowCount();;
    
    foreach($lerbanco->getResult() as $tt){
      extract($tt);
    
 
       if($aceita_entrega) { 
          $idButton = "btn_s";
          $classButton = "aceita_entrega";
          $style= "background-color: #00BB07";
          $value = "Sim";
       }else{
        $idButton = "btn_n";
        $classButton = "aceita_entrega";
        $style= "background-color: #00BB07";
        $value = "Não";
        }
     
      

        array_push($res->data, array("forma_pagamento" => "<td> <input data-url=\"{$site}cadastros\" data-flag = \"true\" id=\"f_pagamento{$id_f_pagamento}\" data-idfp=\"{$id_f_pagamento}\" value=\"{$f_pagamento}\" oninput=\"this.value = this.value.replace(/[^a-z-A-Z ]/g, '')\"   maxlength=\"30\" type=\"text\"  name=\"f_pagamento\" class=\"form-control atualiza_forma\" placeholder=\"Dinheiro, Crédito Visa, etc...\"><span hidden>{$f_pagamento}</span></td>",
        "aceita" => "<td><button id=\"{$idButton}\" class=\"{$classButton}\" style=\"{$style}\" data-url=\"{$site}cadastros\" data-idfp=\"{$id_f_pagamento}\">{$value}</button></td>",       
        "excluir" => "<td><button data-url=\"{$site}cadastros\" data-idfp=\"{$id_f_pagamento}\"style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete delete_forma\"><span class=\"glyphicon glyphicon-trash\"></span>
        </button></td>"));
      
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
  