<?php
ob_start();
 
session_start();
require('../../_app/Config.inc.php');  
 


function carregaCategoriaInputs(){

   
  try{
  
    $site = HOME;
    global $lerbanco;

    $userlogin = $_SESSION['userlogin'];
   
    $res = new stdClass();
   
    $res->data = array();
   
   
   
    
    
    
    $lerbanco->FullRead("select id, nome_cat from ws_cat WHERE user_id = {$userlogin['user_id']}");
    if($lerbanco->getResult()){    
          
      foreach($lerbanco->getResult() as $tt){
        extract($tt);
          array_push($res->data, $tt);       
       }
        
       echo json_encode($res);
    }else{  
      $res->data = array();
      echo json_encode($res);
    }
  
  
   
  
  }catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
   
                      
 
    


}

function cadastraCategoria($payLoad){
    
 
try{
    $userlogin = $_SESSION['userlogin'];
    $res['msg'] = "";
    $res['success'] = false;
    
    global $addbanco;
    global $lerbanco;
  
    $capturacat = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  
    if(!empty($capturacat) && isset($capturacat['cadastrarcategoria'])){
            $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid and nome_cat = :cat", "userid={$userlogin['user_id']}&cat={$capturacat['nome_cat']}");
            if ($lerbanco->getResult()){
               
  
              $res['msg'] =  "Já existe uma categoria com este nome!";
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
     
          $res['msg'] =  " Por favor preencha todos os campos obrigatórios!";
          $res['success'] = false;
          $res['error'] = true;  
          echo json_encode($res);
      }else{
            unset($capturacat['action']);
            $addbanco->ExeCreate("ws_cat", $capturacat);
            if($addbanco->getResult()){
                $res['msg'] =  "Categoria criada com sucesso!";
                $res['success'] = true;  
                $res['error'] = false;  
                echo json_encode($res);
            }else{
              $res['msg'] =  "Ocorreu um erro inesperado. Por favor tente novamente!";
         
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
}  

function updateCategoria($payLoad){

try{
    $userlogin = $_SESSION['userlogin'];
    global $updatebanco;
    global $lerbanco;

  $res['msg'] = "";
  $res['success'] = false;

  $novaCategoria = filter_input_array(INPUT_POST, FILTER_DEFAULT);  

  if(!empty($payLoad) && isset($payLoad['cat_update']) && $payLoad['nome_cat']){
  
   $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND nome_cat = :cat", "userid={$userlogin['user_id']}&cat={$payLoad['nome_cat']}");
   if ($lerbanco->getResult()){
    $res['msg'] =  "Já existe uma categoria com este nome. Por favor selecione outro!";
 
    $res['success'] = false;
    $res['error'] = true;  
   
    echo json_encode($res);
     
     
   }else{
       $novaCategoria = array_map('strip_tags', $payLoad);
       $novaCategoria = array_map('trim', $payLoad); 
 
   if($payLoad['nome_cat'] == ""){

    $res['msg'] =  "Você precisa preecher o campo com o nome da categoria para continuar!";
  
    $res['success'] = false;
    $res['error'] = true;  
    echo json_encode($res);
  
   }else{
     $newCategoriaName['nome_cat'] = strtoupper($payLoad['nome_cat']);
     unset($payLoad['action']);
     $updatebanco->ExeUpdate("ws_cat",$newCategoriaName, "WHERE user_id = :userid AND id = :newcatupdat", "userid={$userlogin['user_id']}&newcatupdat={$payLoad['cat_id']}");
     if ($updatebanco->getResult()){

      $res['msg'] =  " Categoria atualizada com sucesso!";
      $res['success'] = true;  
      $res['error'] = false;  
      $res['data'] = $novaCategoria['nome_cat'];
      echo json_encode($res);
         
     }else{    
      $res['msg'] =  "Ocorreu um erro ao atualizar a categoria. Tenta novamente";
      $res['success'] = false;
      $res['error'] = true;  
      echo json_encode($res);
       
     };
   };
 };
 
 }else{
  $res['msg'] =  "Ocorreu um erro ao atualizar a categoria. Tenta novamente";
  $res['success'] = false;
  $res['error'] = true;  
  echo json_encode($res);

 }

}catch (PDOException $e) {
  echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
 
                    
  
 
}
 

function deletaCaregoria($payLoad){


    try{
        global $deletbanco;
        global $lerbanco;
        global $updatebanco;
        $res['msg'] = "";
        $res['success'] = false;
      
     
        $idusuario = $_SESSION['userlogin'];
         
        
      if(!empty($payLoad['idcat']) && (int) $payLoad['idcat'] && !empty($idusuario['user_id'])){
      
        $deletbanco->ExeDelete("ws_cat", "WHERE user_id = :userid AND id = :fdv", "userid={$idusuario['user_id']}&fdv={$payLoad['idcat']}");
        if($deletbanco->getResult()){
        
               $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id_cat = :fff", "userid={$idusuario['user_id']}&fff={$payLoad['idcat']}");
            
                if($lerbanco->getResult()){
            
                foreach ($lerbanco->getResult() as $i){
                    extract($i);         
                    
                };  
                $novoStatus['id_cat'] = -1;
                $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id_cat = :upp", "userid={$idusuario['user_id']}&upp={$payLoad['idcat']}");
                
                $res['msg'] = "Categoria excluída com sucesso!";
                $res['error'] = false;
                $res['success'] = true;
                echo json_encode($res);
              }else{    
                $res['msg'] = "Categoria excluída com sucesso!";
                $res['error'] = false;
                $res['success'] = true;
                echo json_encode($res);
              }
      }else{
          $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
          $res['success'] = false;
          $res['error'] = true;
          echo json_encode($res);
        
        } 
        
      }else{
        $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
        $res['success'] = false;
        $res['error'] = true;
        echo json_encode($res);
      
      }
      } catch (PDOException $e) {
        echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
      }
       

}


function carregaCategorias(){

$userlogin = $_SESSION['userlogin'];
 
try{

  $site = HOME;
 
  $res = new stdClass();
 
  $res->data = array();
 
    global $lerbanco;
   
  
  
  
  $lerbanco->FullRead("select id, nome_cat from ws_cat WHERE user_id = {$userlogin['user_id']}");
  if($lerbanco->getResult()){
   
    $res->draw = 1;
    $res->recordsTotal =  $lerbanco->getRowCount();
    $res->recordsFiltered = $lerbanco->getRowCount();;
    
    foreach($lerbanco->getResult() as $tt){
      extract($tt);
        array_push($res->data, array("nome_cat" => "<td  id=\"nome_cat_$id\"><input type=\"text\" data-iduser=\"{$userlogin['user_id']}\" name=\"nome_cat\" data-url=\"{$site}cadastros\" data-idcat=\"{$id}\" value=\"{$nome_cat}\" class=\"atualiza_cat form-control\" placeholder=\"Nome da categoria...\">
        <span hidden>{$nome_cat}</span></td>", 
        "excluir" => "<td><button data-url=\"{$site}cadastros\" style=\"position:relative;left:75px;background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete deletar_cat\" data-idcat=\"$id\"><span class=\"glyphicon glyphicon-trash\"></span></button>")) ;
 
     
   

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
$categoriaObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 
   //Carrega Tabela Categoria - GET
  //body - action = pl
   if(!empty($action) && (string)$action && $action =='cl'){

      carregaCategorias();

   } 
  
  //Exclui Categoria - POST
  //body - action = ce
 
  if(!empty($categoriaObj['action']) && (string)$categoriaObj['action'] && $categoriaObj['action']=='ce' && (int)$categoriaObj['idcat']){

    deletaCaregoria($categoriaObj);
}
  //Atualiza Categoria - POST
  //body - action = cu
if(!empty($categoriaObj['action']) && (string)$categoriaObj['action'] && $categoriaObj['action']=='cu' && (int)$categoriaObj['cat_id']){

    updateCategoria($categoriaObj);
}


 //Cadastra Categoria - POST
  //body - action = cu
  if(!empty($categoriaObj['action']) && (string)$categoriaObj['action'] && $categoriaObj['action']=='cc'){

    cadastraCategoria($categoriaObj);
}


 //Carrega Categoria Inputs - GET
  //body - action = cli 
  if(!empty($action) && (string)$action && $action=='cli'){

    carregaCategoriaInputs($categoriaObj);
}




 

          
                    
ob_end_flush();


?>