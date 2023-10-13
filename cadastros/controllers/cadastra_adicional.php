<?php
 
 
 session_start();
  
require('../../_app/Config.inc.php');


$userlogin = $_SESSION['userlogin'];
 
try{

  $res['msg'] = "";
  $res['success'] = false;


  $adicional = filter_input_array(INPUT_POST, FILTER_DEFAULT);

 

  if(!empty($adicional) && isset($adicional['cadastraadicional'])){
          $lerbanco->ExeRead("ws_adicionais_itens", "WHERE user_id = :userid and nome_adicional = :nome", "userid={$userlogin['user_id']}&nome={$adicional['nome_adicional']}");
          if ($lerbanco->getResult()){
             

            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Já existe um tipo de adicional com este nome. Por favor selecione outro!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
          }else{


            if(!empty($adicional['cadastraadicional'])){
              unset($adicional['cadastraadicional']);
          
              $adicional = array_map('strip_tags', $adicional);
              $adicional = array_map('trim', $adicional);
          
           
          if(empty($adicional['id_cat'])){   
                $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                Por favor selecione uma categoria!
                </div>";
                $res['success'] = false;
                $res['error'] = true;  
                echo json_encode($res);
            
            } else if(empty($adicional['valor_adicional'])){   
              $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
              Quantidade do tipo de adicional é obrigatório!
              </div>";
              $res['success'] = false;
              $res['error'] = true;  
              echo json_encode($res);
         
        
        } else if(empty($adicional['nome_adicional'])){   
            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Você precisa preecher o campo tipo de adcional para continuar!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
    }else{ 
      $adicional['nome_adicional'] = strtoupper($adicional['nome_adicional']);
      $adicional['nome_adicional'] = strtoupper($adicional['nome_adicional']);
      $adicional['medida_adicional'] = "UN";
      $adicional['status_adicional'] = "1";
      $adicional['categorias_adicional'] = "-1";
      $adicional['user_id'] = $userlogin['user_id'];
          $addbanco->ExeCreate("ws_adicionais_itens", $adicional);
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
  