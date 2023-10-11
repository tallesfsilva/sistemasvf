<?php 
session_start();
require('../../_app/Config.inc.php');
$site = HOME;


try{

  $res['msg'] = "";
  $res['success'] = false;

  $idcategoria = $_POST['idcat']; 

  $idusuario = $_SESSION['userlogin'];
   
  
if(!empty($idcategoria) && (int) $idcategoria && !empty($idusuario['user_id'])){

  $deletbanco->ExeDelete("ws_cat", "WHERE user_id = :userid AND id = :fdv", "userid={$idusuario['user_id']}&fdv={$idcategoria}");
  if($deletbanco->getResult()){
  
         $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id_cat = :fff", "userid={$idusuario['user_id']}&fff={$idcategoria}");
      
          if($lerbanco->getResult()){
      
          foreach ($lerbanco->getResult() as $i){
              extract($i);         
              
          };  
          $novoStatus['id_cat'] = -1;
          $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id_cat = :upp", "userid={$idusuario['user_id']}&upp={$idcategoria}");
          
        
          $res['success'] = true;
          echo json_encode($res);
        }else{    
          $res['success'] = true;
          echo json_encode($res);          
        }
}else{
    $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
    $res['success'] = false;
    echo json_encode($res);
  
  } 
  
}else{
  $res['msg'] = "Ocorreu um erro ao executar a operação. Tente novamente";
  $res['success'] = false;
  echo json_encode($res);

}
} catch (PDOException $e) {
  echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
 