<?php
 
 
 session_start();
  
require('../../_app/Config.inc.php');


$userlogin = $_SESSION['userlogin'];
 
try{

  $res['msg'] = "";
  $res['success'] = false;


  $tipoAdicional = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  if(!empty($tipoAdicional) && isset($tipoAdicional['cadastratipoadicional'])){
          $lerbanco->ExeRead("ws_tipo_adicional", "WHERE user_id = :userid and nome_adicional = :nome and id_cat =:idcat ", "idcat={$tipoAdicional['id_cat']}&userid={$userlogin['user_id']}&nome={$tipoAdicional['nome_adicional']}");
          if ($lerbanco->getResult()){
             

            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Já existe um tipo de adicional com este nome na categoria selecionada. Por favor selecione outro!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
          }else{


            if(!empty($tipoAdicional['cadastratipoadicional'])){
              unset($tipoAdicional['cadastratipoadicional']);
          
              $tipoAdicional = array_map('strip_tags', $tipoAdicional);
              $tipoAdicional = array_map('trim', $tipoAdicional);
          
           
          if(empty($tipoAdicional['id_cat'])){   
                $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                Por favor selecione uma categoria!
                </div>";
                $res['success'] = false;
                $res['error'] = true;  
                echo json_encode($res);
            
            } else if($tipoAdicional['quantidade'] == ""){   
              $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
              Quantidade do tipo de adicional é obrigatório!
              </div>";
              $res['success'] = false;
              $res['error'] = true;  
              echo json_encode($res);
         
        
        } else if(empty($tipoAdicional['nome_adicional'])){   
            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Você precisa preecher o campo tipo de adcional para continuar!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
    }else{ 
      $tipoAdicional['nome_adicional'] = strtoupper($tipoAdicional['nome_adicional']);
      $tipoAdicional['quantidade'] = (int) $tipoAdicional['quantidade'];
      $tipoAdicional['user_id'] = $userlogin['user_id'];
          $addbanco->ExeCreate("ws_tipo_adicional", $tipoAdicional);
          if($addbanco->getResult()){
              $res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
              <b class=\"alert-link\">SUCESSO!</b>Tipo Adicional criado com sucesso.
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
  