<?php

session_start();
require('../../../_app/Config.inc.php');

 



 
try{

  $site = HOME;
  $userlogin = $_SESSION['userlogin'];
 
  $res = new stdClass();
 
  $res->data = array();
 
 
 
  
  
  
  $lerbanco->ExeRead("bairros_delivery", "WHERE user_id = :userid ORDER BY id DESC", "userid={$userlogin['user_id']}");
  if($lerbanco->getResult()){
   
    $res->draw = 1;
    $res->recordsTotal =  $lerbanco->getRowCount();
    $res->recordsFiltered = $lerbanco->getRowCount();;
    
    foreach($lerbanco->getResult() as $tt){
      extract($tt);
    
  
     
      

        array_push($res->data, array("estado" => "<td> <span>{$uf}</span></td>",
        "cidade" => "<td> <span>{$cidade}</span></td>",
        "bairro" => "<td> <span>{$bairro}</span></td>",
        "taxa_de_entrega" => "<div class=\"flex justify-center\" <td> <input data-url=\"{$site}cadastros\" type=\"text\" name=\"taxa\" value=\"{$taxa}\" data-idtaxa=\"{$id}\" maxlength=\"6\"  data-mask=\"#.##0,00\"   step=\"1\"  data-mask-reverse=\"true\" class=\"form-control w-1/2 text-center atualiza_taxa\" placeholder=\"0,00\"><span hidden>{$taxa}</span></td></div>",
        
        "excluir" => "<td><button data-url=\"{$site}cadastros\" data-idtaxa=\"{$id}\"style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete delete_taxa\"><span class=\"glyphicon glyphicon-trash\"></span>
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
  