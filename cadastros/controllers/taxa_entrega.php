<?php

ob_start();
 
session_start();
require('../../_app/Config.inc.php');  
  
function deletaTaxaEntrega($payLoad){
    
    
    try{

        global $deletbanco;
 

        $userlogin = $_SESSION['userlogin'];
        
        $res['msg'] = "";
        $res['success'] = false;
        
         
        if(!empty($payLoad['id']) && (int) $payLoad['id']){
            $deletbanco->ExeDelete("bairros_delivery", "WHERE user_id = :userid AND id = :idtaxa", "userid={$userlogin['user_id']}&idtaxa={$payLoad['id']}");
            if($deletbanco->getResult()){
              $res['msg'] =  "Excluído com sucesso!";     
              $res['success'] = true;
              $res['error'] = false;
              echo json_encode($res);
            }else{
              $res['msg']  = "Ocorreu um erro no seu processamento. Tente novamente!";
                    $res['success'] = false;
                    $res['error'] = true;
            }
          }else{
            $res['msg']  = "Ocorreu um erro no seu processamento. Tente novamente!";
            $res['success'] = false;
            $res['error'] = true;
          }
            
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }


}


function atualizaTaxaEntrega($payLoad){


    try{

        global $lerbanco;
        global $updatebanco;

      
        $site = HOME;
        
        $res['msg'] = "";
        $res['success'] = false;
        $userlogin = $_SESSION['userlogin'];
         
        
        if(!empty($payLoad) && isset($payLoad['id']) && isset($payLoad['taxa'])){
                
             
         
                
              
                $payLoad['taxa'] = Check::Valor($payLoad['taxa']);
        
          
            if (in_array('', $payLoad ) || in_array('null', $payLoad )){
                     $res['msg']  = "Preencha todos os campos necessários!";
                    $res['success'] = false;
                    $res['error'] = true;
                    echo json_encode($res);
        
         
        }else{
            
                $updatebanco->ExeUpdate("bairros_delivery",$payLoad, "WHERE user_id = :userid AND id = :idfp", "userid={$userlogin['user_id']}&idfp={$payLoad['id']}");
                if ($updatebanco->getResult()){                                            
                    $res['msg'] =  "Atualizado com sucesso!";     
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);		 
                 
                }else{
                    $res['msg'] =  "Ocorreu um erro durante sua solicitação. Por favor tente novamente!>";  
                    
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                };
         
        
         
        };
        
        
        
        };
        
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }
         

}


function carregaTaxaEntrega(){


 
try{

    global $lerbanco;
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
   
        
}


function cadastraTaxaEntrega($payLoad){



    try{
        
        global $lerbanco;
        global $addbanco;

        $userlogin = $_SESSION['userlogin'];
        $res['msg'] = "";
        $res['success'] = false;
      
        if(!empty($payLoad) && !empty($payLoad['action'])){
            unset($payLoad['action']);
        
            if (in_array('', $payLoad) || in_array('null', $payLoad)){
            $res['msg']  = "Preencha todos os campos necessários!";
            $res['success'] = false;
            $res['error'] = true;
            echo json_encode($res);	 
        
        }else{
            $lerbanco->ExeRead('bairros_delivery', "WHERE user_id = :userid AND (uf = :u AND cidade = :c AND bairro = :v)", "userid={$userlogin['user_id']}&u={$payLoad['uf']}&c={$payLoad['cidade']}&v={$payLoad['bairro']}");
             
            if ($lerbanco->getResult()){
                $res['msg'] = "Taxa de entrega já registrada. Tente outra!";
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            
            }else{	 
                 
                $payLoad['bairro'] = tratar_nome($payLoad['bairro']);
               
                  $payLoad['taxa'] = Check::Valor($payLoad['taxa']);
        
            
                $payLoad['user_id']= $userlogin['user_id'];
                $payLoad['bairro']= strtoupper($payLoad['bairro']);
                $addbanco->ExeCreate("bairros_delivery", $payLoad);
                if ($addbanco->getResult()){                                            
                    $res['msg'] =  "Registrado com sucesso!";  
                    
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                 
                 
                }else{
                    $res['msg'] =  "Ocorreu um erro em sua solicitação. Por favor tente novamente!";                      
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                };
            };
        
        };
        
        
        
        };
        
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }
         




}



 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$taxaEntradaObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 
   //Carrega Tabela Taxa de Entrega - GET
  //body - action = tl
   if(!empty($action) && (string)$action && $action =='tl'){

      carregaTaxaEntrega();

   } 
  
  //Exclui Taxa de Entrega- POST
  //body - action = te
 
  if(!empty($action) && (string)$action && $action=='te' && (int)$taxaEntradaObj['id']){

    deletaTaxaEntrega($taxaEntradaObj);
}
  //Atualiza Taxa Entrega- POST
  //body - action = tu
if(!empty($action) && (string)$action && $action=='tu' && (int)$taxaEntradaObj['id']){

    atualizaTaxaEntrega($taxaEntradaObj);
}


 //Cadastra Taxa de Entrega- POST
  //body - action = tc
  if(!empty($action) && (string)$action && $action=='tc' && !empty($taxaEntradaObj)){

    cadastraTaxaEntrega($taxaEntradaObj);
}



 

          
                    
ob_end_flush();


?>














 