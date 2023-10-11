<?php 
require('../../_app/Config.inc.php');
session_start();
$site = HOME;

try{
    
    $res['msg'] = "";
    $res['success'] = false;


     $idTipoAdicional = $_POST['id_tipo'];
   
     $idusuario = $_SESSION['userlogin'];
    
     if(!empty($idTipoAdicional) && (int) $idTipoAdicional && !empty($idusuario['user_id'])){

    $deletbanco->ExeDelete("ws_tipo_adicional", "WHERE user_id = :userid AND id_tipo = :fdv", "userid={$idusuario['user_id']}&fdv={$idTipoAdicional}");
    if($deletbanco->getResult()){
        $res['success'] = true;
        echo json_encode($res);


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
     
}catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }

