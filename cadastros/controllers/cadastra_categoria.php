<?php
 
 
 session_start();
  
require('../../_app/Config.inc.php');


$userlogin = $_SESSION['userlogin'];
 
try{

  $res['msg'] = "";
  $res['success'] = false;


  $capturacat = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  if(!empty($capturacat) && isset($capturacat['cadastrarcategoria'])){
          $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid and nome_cat = :cat", "userid={$userlogin['user_id']}&cat={$capturacat['nome_cat']}");
          if ($lerbanco->getResult()){
             

            $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            Já existe uma categoria com este nome. Por favor selecione outro!
            </div>";
            $res['success'] = false;
            $res['error'] = true;  
            echo json_encode($res);
          }else{


            if(!empty($capturacat['cadastrarcategoria'])){
              unset($capturacat['cadastrarcategoria']);
          
              $capturacat = array_map('strip_tags', $capturacat);
              $capturacat = array_map('trim', $capturacat);
          
              if(empty($capturacat['desc_cat'])){
               $capturacat['desc_cat'] = 'null';       
               };
 
            if(empty($capturacat['icon_cat'])){
            $capturacat['icon_cat'] = 'null';       
            };
    $capturacat['nome_cat'] = strtoupper($capturacat['nome_cat']);
       if(empty($capturacat['nome_cat'])){
   
        $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
        Você precisa preecher o campo com o nome da categoria para continuar!
        </div>";
        $res['success'] = false;
        $res['error'] = true;  
        echo json_encode($res);
    }else{
 
          $addbanco->ExeCreate("ws_cat", $capturacat);
          if($addbanco->getResult()){
              $res['msg'] =  "<div class=\"alert alert-success alert-dismissable\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
              <b class=\"alert-link\">SUCESSO!</b>Categoria criada com sucesso.
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
  