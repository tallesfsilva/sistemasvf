<?php 

require('../../_app/Config.inc.php');
session_start();
 
try{
    
    $res['msg'] = "";
    $res['success'] = false;


     $idAdicional = $_POST['id_adicional'];
   
     $idusuario = $_SESSION['userlogin'];

     if(!empty($idAdicional) && (int)$idAdicional && !empty($idusuario['user_id'])){

    $deletbanco->ExeDelete("ws_adicionais_itens", "WHERE user_id = :userid AND id_adicionais = :fdv", "userid={$idusuario['user_id']}&fdv={$idAdicional}");
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

?>