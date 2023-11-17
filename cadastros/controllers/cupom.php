<?php
ob_start();
 
session_start();
require('../../_app/Config.inc.php');  
 

function deletaCupom($payLoad){
    try{

        global $lerbanco;
        global $lerbanco;
        global $deletbanco;

        $userlogin = $_SESSION['userlogin'];
    
        $res['msg'] = "";
        $res['success'] = false;
        
         
         
        if(!empty($payLoad['idcupom']) && (int)$payLoad['idcupom']){
          $deletbanco->ExeDelete("cupom_desconto", "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$payLoad['idcupom']}");
            if($deletbanco->getResult()){
              $res['msg'] =  "Excluído com sucesso!";  
              $res['success'] = true;
              $res['error'] = false;
              echo json_encode($res);
            }else{
                $res['msg']  = "Ocorreu um erro no processamento!";
                    $res['success'] = false;
                    $res['error'] = true;
            }
          }else{
            $res['msg']  = "Ocorreu um erro no processamento!";
       
            $res['success'] = false;
            $res['error'] = true;
          }
            
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }


}


function mostraCupom($payLoad){

    try{

        $site = HOME;
        global $lerbanco;
        global $updatebanco;
        
        $userlogin = $_SESSION['userlogin'];
       
         $res['msg'] = "";
        $res['success'] = false;
        
        
        $lerbanco->ExeRead("cupom_desconto", "WHERE user_id = :iduser AND mostrar_site = :mostrarcupom", "iduser={$userlogin['user_id']}&mostrarcupom=1");
        if(!$lerbanco->getResult()){
        ////////////////////////////
            $updatemostrar['mostrar_site'] = 1;
            $updatebanco->ExeUpdate("cupom_desconto", $updatemostrar, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$payLoad['idcupom']}");
            if(!$updatebanco->getResult()){
                    $res['msg']  = "Ocorreu um erro no processamento!";
                    $res['success'] = false;
                    $res['error'] = true;
            echo json_encode($res);
            }else{
                $res['msg'] =  "Status do cupom atualizado com sucesso!";    
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
            };
        //////////////////////////
        }else{ // SE NÃO FAZ ISSO:
        
        $getid = $lerbanco->getResult();
        $idatualizazero = $getid[0]['id_cupom'];
        
        if($idatualizazero == $payLoad['idcupom']){
            $updatezerom['mostrar_site'] = 0;
            $updatebanco->ExeUpdate("cupom_desconto", $updatezerom, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$payLoad['idcupom']}");
            if(!$updatebanco->getResult()){
                $res['msg']  = "Ocorreu um erro no processamento!";
                    $res['success'] = false;
                    $res['error'] = true;
            }else{
                $res['msg'] =  "Status do cupom atualizado com sucesso!";    
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
            };
            
        }else{
        
            $updatezero['mostrar_site'] = 0;
            $updatebanco->ExeUpdate("cupom_desconto", $updatezero, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$idatualizazero}");
            if(!$updatebanco->getResult()){
                $res['msg']  = "Ocorreu um erro no processamento!";
                $res['success'] = false;
                $res['error'] = true;
            }else{
                $novonumeroum['mostrar_site'] = 1;
                $updatebanco->ExeUpdate("cupom_desconto", $novonumeroum, "WHERE user_id = :userid AND id_cupom = :idcupom", "userid={$userlogin['user_id']}&idcupom={$payLoad['idcupom']}");
                if(!$updatebanco->getResult()){
                    $res['msg']  = "Ocorreu um erro no processamento!";
                    $res['success'] = false;
                    $res['error'] = true;
                }else{
                    $res['msg'] =  "Status do cupom atualizado com sucesso!";              
                        $res['success'] = true;
                        $res['error'] = false;
                        echo json_encode($res);
                };
        
            };
            
        
        };
        
        }
        
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }


}


function updateCupom($payLoad){


    try{
        
        global $lerbanco;
        global $updatebanco;
        $site = HOME;
        
        $res['msg'] = "";
        $res['success'] = false;
        $userlogin = $_SESSION['userlogin'];
        $flagName = $payLoad['flagName'] == "true" ? true : false;
        
        if(!empty($payLoad) && isset($payLoad['id_cupom'])){
                
            $lerbanco->ExeRead('cupom_desconto', "WHERE user_id = :userid AND ativacao = :pativacao", "userid={$userlogin['user_id']}&pativacao={$payLoad['ativacao']}");
            

            $payLoad['data_validade'] = explode("/", $payLoad['data_validade']);
            $payLoad['data_validade'] = array_reverse($payLoad['data_validade']);
            $payLoad['data_validade'] = implode("-",  $payLoad['data_validade']);
        
            if($payLoad['total_vezes'] == '0' || $payLoad['total_vezes'] == ''){
                $res['msg']  = "Quantidade não pode ser 0!";
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            } elseif($payLoad['porcentagem'] == '0' || $payLoad['porcentagem'] == '' ){
                $res['msg']  = "O desconto não pode ser 0!";
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            
            } elseif( ($payLoad['ativacao'] == '' || $payLoad['ativacao'] == 'null') ||  ($payLoad['data_validade']=='' || $payLoad['data_validade'] == 'null')){
            $res['msg']  = "Preencha todos os campos necessários!";
            $res['success'] = false;
            $res['error'] = true;
            echo json_encode($res);
        
            } elseif(!isDateExpired($payLoad['data_validade'], 1)){
                $res['msg']  = "A data informada está expirada!";
              
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            
            }elseif ($lerbanco->getResult() && !empty($flagName) && $flagName  ){             
        
                $res['msg'] =  "Já existe um cupom com essa ativação! exclua e crie outra com novas propriedades.";
                $res['success'] = false;
                $res['error'] = true;  
               
                echo json_encode($res);
            }else {
            
                unset($payLoad ['action']);
                unset($payLoad ['flagName']);
                $payLoad  = array_map('strip_tags', $payLoad );
                $payLoad  = array_map('trim', $payLoad ); 
         
        
        
            if($payLoad ['porcentagem'] == ''){
                (int) $payLoad ['porcentagem'] = 1;
            }elseif((int) $payLoad ['porcentagem'] < 1){
                $payLoad ['porcentagem'] = 1;
            }elseif((int) $payLoad ['porcentagem'] > 100){
                $payLoad ['porcentagem'] = 100;
            }else{ 
                $payLoad ['porcentagem'] = str_replace('.', '', $payLoad ['porcentagem']);
                $payLoad ['porcentagem'] = str_replace(',', '', $payLoad ['porcentagem']);
                $payLoad ['porcentagem'] = (int) $payLoad ['porcentagem'];    
            };
        
            if($payLoad ['total_vezes'] == ''){
                (int) $payLoad ['total_vezes'] = 1;            
            }else{ 
                $payLoad ['total_vezes'] = str_replace('.', '', $payLoad ['total_vezes']);
                $payLoad ['total_vezes'] = str_replace(',', '', $payLoad ['total_vezes']);
                $payLoad ['total_vezes'] = (int) $payLoad ['total_vezes'];    
            };
         
        
        
            
             
             
                 
                
                $updatebanco->ExeUpdate("cupom_desconto",$payLoad, "WHERE user_id = :userid AND id_cupom = :idCupom", "userid={$userlogin['user_id']}&idCupom={$payLoad['id_cupom']}");
                if ($updatebanco->getResult()){                                            
                    $res['msg'] =  "Cupom atualizado com sucesso!";     
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                 
                 
                }else{
                    $res['msg'] =  "Ocorreu um erro no processamento";  
                    
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                };
         
        
        }
            
        }else{
      
                $res['msg'] =  "Ocorreu um erro no processamento";  
                
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
             
     
        }
        
        
        
       
        
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }
         




}

 

function cadastrarCupom($payLoad){


    try{
	
        $res['msg'] = "";
        $res['success'] = false;
        global $lerbanco;
        global $deletbanco;
        global $addbanco;
         
        if(!empty($payLoad['action'])){
            unset($payLoad['action']);


            $payLoad['data_validade'] = explode("/", $payLoad['data_validade']);
            $payLoad['data_validade'] = array_reverse($payLoad['data_validade']);
            $payLoad['data_validade'] = implode("-",  $payLoad['data_validade']);
        
            if($payLoad['total_vezes'] == '0' || $payLoad['total_vezes'] == ''){
                $res['msg']  = "Quantidade não pode ser 0!";
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            } elseif($payLoad['porcentagem'] == '0' || $payLoad['porcentagem'] == '' ){
                $res['msg']  = "O desconto não pode ser 0!";
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            
            } elseif( ($payLoad['ativacao'] == '' || $payLoad['ativacao'] == 'null') ||  ($payLoad['data_validade']=='' || $payLoad['data_validade'] == 'null')){
            $res['msg']  = "Preencha todos os campos necessários!";
            $res['success'] = false;
            $res['error'] = true;
            echo json_encode($res);
        
            } elseif(!isDateExpired($payLoad['data_validade'], 1)){
                $res['msg']  = "A data informada está expirada!";
              
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            
            }else{
            $payLoad = array_map('strip_tags', $payLoad);
            $payLoad = array_map('trim', $payLoad); 
        
        
            if($payLoad['porcentagem'] == ''){
                (int) $payLoad['porcentagem'] = 1;
            }elseif((int) $payLoad['porcentagem'] < 1){
                $payLoad['porcentagem'] = 1;
            }elseif((int) $payLoad['porcentagem'] > 100){
                $payLoad['porcentagem'] = 100;
            }else{ 
                $payLoad['porcentagem'] = str_replace('.', '', $payLoad['porcentagem']);
                $payLoad['porcentagem'] = str_replace(',', '', $payLoad['porcentagem']);
                $payLoad['porcentagem'] = (int) $payLoad['porcentagem'];    
            };
        
            if($payLoad['total_vezes'] == ''){
                (int) $payLoad['total_vezes'] = 1;            
            } 
                $payLoad['total_vezes'] = str_replace('.', '', $payLoad['total_vezes']);
                $payLoad['total_vezes'] = str_replace(',', '', $payLoad['total_vezes']);
                $payLoad['total_vezes'] = (int) $payLoad['total_vezes'];    
         
            
            $lerbanco->ExeRead('cupom_desconto', "WHERE user_id = :userid AND ativacao = :pativacao", "userid={$payLoad['user_id']}&pativacao={$payLoad['ativacao']}");
            if ($lerbanco->getResult()){
                $res['msg'] = "Já existe um cupom com esse código de ativação!";
                $res['success'] = false;
                $res['error'] = true;
                echo json_encode($res);
            
            }else{
                $urlsite = $payLoad['lojaurl'];
                unset($payLoad['lojaurl']);
                
                $addbanco->ExeCreate("cupom_desconto", $payLoad);
                if ($addbanco->getResult()){                                            
                    $res['msg'] =  "Registrado com sucesso!";     
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                 
                 
                }else{
                    $res['msg'] =  "Ocorreu um erro no processamento!"; 
                    
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
                };
            };
        
        
            
 
        
  
    }
        };
        
        }catch (PDOException $e) {
            echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
          }

}


 function carregaCupom(){

 
    try {

    
  $site = HOME;
  $userlogin = $_SESSION['userlogin'];
 
  $res = new stdClass();
 
  $res->data = array();
  global $lerbanco;

 
 
  
  
  
  $lerbanco->FullRead("select * from cupom_desconto WHERE user_id = {$userlogin['user_id']}");
  if($lerbanco->getResult()){
   
    $res->draw = 1;
    $res->recordsTotal =  $lerbanco->getRowCount();
    $res->recordsFiltered = $lerbanco->getRowCount();;
    
    foreach($lerbanco->getResult() as $tt){
      extract($tt);
      $datavalidade = explode("-", $data_validade);
      $datavalidade = array_reverse($datavalidade);
      $datavalidade = implode("/",  $datavalidade);

      $idButton = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? 'btn_d' : (($mostrar_site == 1) ? 'btn_s' : 'btn_n' );
      $styleButton = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? "rgba(209,213,219,var(--tw-bg-opacity))" : (($mostrar_site==1) ? "#00BB07" : "#A70000;" );
      $buttonDisable = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? "disabled" : '' ;
      $buttonClass = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? "button-disabled" : "";
      $buttonText = ($mostrar_site == 0 ? 'Não' : 'Sim');

      if(!isDateExpired($data_validade, 1)){
        $situacao= "<strong style='color: red;'>EXPIROU!</strong>";
      }elseif($total_vezes <= 0){
        $situacao="<strong style='color: red;'>ACABOU!</strong>";
      }else{
        $situacao= "<strong style='color: #82C152;'>ATIVO</strong>";
      };
      

        array_push($res->data, array("nome_cupom" => "<td  id=\"$id_cupom\"> <input data-url=\"{$site}cadastros\" data-flag = \"true\" id=\"cupom_{$id_cupom}\" data-idcupom=\"{$id_cupom}\" value=\"{$ativacao}\" oninput=\"this.value = this.value.replace(/[^a-z-A-Z-0-9]/g, '')\" type=\"text\" maxlength=\"20\" class=\"form-control atualiza_cupom\" name=\"ativacao\" aria-describedby=\"emailHelp\" placeholder=\"Ex: Cupom10\"><span hidden>{$ativacao}</span></td>",
        "porcentagem" => "<td><input data-url=\"{$site}cadastros\" data-idcupom=\"{$id_cupom}\" value=\"{$porcentagem}\" oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" required type=\"text\" class=\"form-control atualiza_cupom descontoporcentagem\" value=\"1\" maxlength=\"2\"  step=\"1\" pattern=\"[0-9]{2}\" name=\"porcentagem\" min=\"1\" max=\"99\" /><span hidden>{$porcentagem}</span></td>",
        "quantidade" => "<td><input data-url=\"{$site}cadastros\" data-idcupom=\"{$id_cupom}\" oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" type=\"text\" value=\"{$total_vezes}\" class=\"form-control atualiza_cupom numero\" name=\"total_vezes\" min=\"1\" maxlength=\"3\" max=\"999\" /><span hidden>{$total_vezes}</span></td>",
        "data_validade" => "<td> <input readonly data-url=\"{$site}cadastros\" data-idcupom=\"{$id_cupom}\" type=\"text\" class=\"form-control atualiza_cupom\" name=\"data_validade\" id=\"datepicker\" data-mask=\"00/00/0000\" placeholder=\"00/00/0000\" value=\"{$datavalidade}\"/><span hidden>{$datavalidade}</span></td>",
        "situacao" => "<td><span>{$situacao}</span></td>",
        "exibir_no_site" => "<td><button data-url=\"{$site}cadastros\" id=\"{$idButton}\" style=\"background:{$styleButton}\" type=\"button\" {$buttonDisable}  class=\"aceita_entrega exibirsite {$buttonClass}\" data-idcupom=\"{$id_cupom}\">{$buttonText}</button>",
        "excluir" => "<td><button  data-url=\"{$site}cadastros\" style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete excluircupom\" data-idcupom=\"$id_cupom\"><span class=\"glyphicon glyphicon-trash\"></span></button></td>"));
      
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

 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$cupomObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 
   //Carrega Tabela Cupom - GET
  //body - action = cul
   if(!empty($action) && (string)$action && $action =='cul'){

      carregaCupom();

   } 

  //Mostra Cupom Site - POST
  //body - action = cum
 
  if(!empty($cupomObj['action']) && (string)$cupomObj['action'] && $cupomObj['action']=='cum' && (int)$cupomObj['idcupom']){

    mostraCupom($cupomObj);
}
 
  


  //Atualiza Cupom - POST
  //body - action = cuu
if(!empty($cupomObj['action']) && (string)$cupomObj['action'] && $cupomObj['action']=='cuu' && (int)$cupomObj['id_cupom']){

    updateCupom($cupomObj);
}


 //Cadastra Cupom - POST
  //body - action = cuc
  if(!empty($cupomObj['action']) && (string)$cupomObj['action'] && $cupomObj['action']=='cuc'){

    cadastrarCupom($cupomObj);
}

  //Exclui Cupom - POST
  //body - action = cue
 
  if(!empty($cupomObj['action']) && (string)$cupomObj['action'] && $cupomObj['action']=='cue' && (int)$cupomObj['idcupom']){

    deletaCupom($cupomObj);
}




 

          
                    
ob_end_flush();


?>