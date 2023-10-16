<?php
 
 
 session_start();
  
require('../../_app/Config.inc.php');


$userlogin = $_SESSION['userlogin'];
 
try{

  $res['msg'] = "";
  $res['success'] = false;


  $AtualizaTipoAdicional = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  $flagName = $AtualizaTipoAdicional['flagName']=='false' ? false : true;
 

  if(!empty($AtualizaTipoAdicional) && isset($AtualizaTipoAdicional['id_tipo']) && isset($AtualizaTipoAdicional['updatetipoadicional'])){
    $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and nome_adicional = :nome and id_cat =:idcat ", "idcat={$AtualizaTipoAdicional['id_cat']}&userid={$userlogin['user_id']}&nome={$AtualizaTipoAdicional['nome_adicional']}");
          if ($lerbanco->getResult() && $flagName && !empty($flagName)){             

            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Já existe um tipo de adicional com este nome na categoria selecionada. Por favor selecione outro!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
           
            echo json_encode($res);
          }else{


            if(!empty($AtualizaTipoAdicional['updatetipoadicional'])){
              unset($AtualizaTipoAdicional['updatetipoadicional']);
              $id_tipo = $AtualizaTipoAdicional['id_tipo'];
              unset($AtualizaTipoAdicional['id_tipo']);
              unset($AtualizaTipoAdicional['flagName']);

              $AtualizaTipoAdicional = array_map('strip_tags', $AtualizaTipoAdicional);
              $AtualizaTipoAdicional = array_map('trim', $AtualizaTipoAdicional);
          
           
          if(empty($AtualizaTipoAdicional['id_cat'])){   
                $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                Por favor selecione uma categoria!
                </div>";
                $res['success'] = false;
                $res['error'] = true;
                
                echo json_encode($res);
            
        } else if($AtualizaTipoAdicional['quantidade']==""){   
              
          $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
              Quantidade do tipo de adicional é obrigatório!
              </div>";
              $res['success'] = false;
              $res['error'] = true;  
              echo json_encode($res);
         
        
        } else if(empty($AtualizaTipoAdicional['nome_adicional'])){   
            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Você precisa preecher o campo tipo de adcional para continuar!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            
            echo json_encode($res);
    }else{ 
      $AtualizaTipoAdicional['nome_adicional'] = strtoupper($AtualizaTipoAdicional['nome_adicional']);
      $AtualizaTipoAdicional['quantidade'] = (int) $AtualizaTipoAdicional['quantidade'];
          $updatebanco->ExeUpdate("ws_tipo_adicional", $AtualizaTipoAdicional, "WHERE user_id = :userid AND id_tipo = :newcatupdat", "userid={$userlogin['user_id']}&newcatupdat={$id_tipo}");
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
  