<?php
 
 
 session_start();
  
require('../../_app/Config.inc.php');


$userlogin = $_SESSION['userlogin'];
 
try{

  $res['msg'] = "";
  $res['success'] = false;


  $atualizaAdicional = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  $flagName = $atualizaAdicional['flagName']=='false' ? false : true;
   
 

  if(!empty($atualizaAdicional) && isset($atualizaAdicional['id_adicionais']) && isset($atualizaAdicional['updateadicional'])){
          $lerbanco->ExeRead("ws_adicionais_itens", "WHERE user_id = :userid and nome_adicional = :nome", "userid={$userlogin['user_id']}&nome={$atualizaAdicional['nome_adicional']}");
          if ($lerbanco->getResult() && $flagName && !empty($flagName)){             

            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Já existe um adicional com este nome. Por favor selecione outro!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
          }else{


            if(!empty($atualizaAdicional['updateadicional'])){
              unset($atualizaAdicional['updateadicional']);
              $id_adicionais = $atualizaAdicional['id_adicionais'];
              unset($atualizaAdicional['id_adicionais']);
              unset($atualizaAdicional['flagName']);
             

              $atualizaAdicional = array_map('strip_tags', $atualizaAdicional);
              $atualizaAdicional = array_map('trim', $atualizaAdicional);
          
           
          if(empty($atualizaAdicional['id_cat'])){   
                $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                Por favor selecione uma categoria!
                </div>";
                $res['success'] = false;
                $res['error'] = true;  
                echo json_encode($res);
            
        } else if(empty($atualizaAdicional['valor_adicional'])){   
              
          $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
              Valor do Adicional é obrigatório!
              </div>";
              $res['success'] = false;
              $res['error'] = true;  
              echo json_encode($res);
         
        
        } else if(empty($atualizaAdicional['nome_adicional'])){   
            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Você precisa preecher o campo tipo de adcional para continuar!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
    }else{ 
      $atualizaAdicional['nome_adicional'] = strtoupper($atualizaAdicional['nome_adicional']);
      $atualizaAdicional['desc_adicional'] = strtoupper($atualizaAdicional['desc_adicional']);
      $atualizaAdicional['valor_adicional'] = (float) $atualizaAdicional['valor_adicional'];
          $updatebanco->ExeUpdate("ws_adicionais_itens", $atualizaAdicional, "WHERE user_id = :userid AND id_adicionais = :newcatupdat", "userid={$userlogin['user_id']}&newcatupdat={$id_adicionais}");
          if($updatebanco->getResult()){
              $res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
              <b class=\"alert-link\">SUCESSO!</b>Tipo Adicional atualizado com sucesso.
              </div>";
              $res['success'] = true;  
              $res['error'] = false;
              
             echo json_encode($res);
          }else{
            $res['msg'] =  "<div class=\"alert alert-danger alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
            <b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
            
          }
        }
 
 
 
  };
}
  }

}catch (PDOException $e) {
  echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
 
                    
  
?>
  