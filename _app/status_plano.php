<?php

$site = HOME;
$userId = $_SESSION['userlogin']['user_id'];	
$_SESSION['hasShowed'] =  false;
 
$lerbanco->FullRead("select * from ws_empresa WHERE binary user_id = :userId", "userId={$userId}");

		

if (!$lerbanco->getResult()){	
     
    // header("Location: {$site}");
}else{
    foreach ($lerbanco->getResult() as $i):
        extract($i);
    endforeach;

     
     
    $lerbanco->FullRead("select * from ws_users WHERE user_id = :user", "user={$userId}");
    if (!$lerbanco->getResult()){
     
    }else{
        foreach ($lerbanco->getResult() as $j):
            extract($j);
        endforeach;	
    }
   
 
}
       
if(!empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId){
    $planoUser = $_SESSION['userlogin']['user_plano'];
    $nomeplano = "";
    $valorplano = "";

    if($planoUser == 1){
        $nomeplano = $texto['nomePlanoUm'];
        $valorplano = "{$texto['valorPlanoUm']}.00";
    }elseif($planoUser == 2){
        $nomeplano = $texto['nomePlanoDois'];
        $valorplano = "{$texto['valorPlanoDois']}.00";
    }elseif($planoUser == 3){
        $nomeplano = $texto['nomePlanoTres'];
        $valorplano = "{$texto['valorPlanoTres']}.00";
    };

};

 



if(diasDatas(date('Y-m-d'), $empresa_data_renovacao) < 0 && !empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId){
    // unset($_SESSION['qr_code_base64']);
    // unset($_SESSION['qr_code']);
    // unset($_SESSION['id_payment']);
    // unset($_SESSION['status']);
    // unset($_SESSION['paymentScreen']);
    
    // unset($_SESSION['amount']);
    header("Location: {$site}renovacao"); 
}elseif(diasDatas(date('Y-m-d'), $empresa_data_renovacao) == 0 && !empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId){
    // unset($_SESSION['qr_code_base64']);
    // unset($_SESSION['qr_code']);
    // unset($_SESSION['id_payment']);
    // unset($_SESSION['status']);
    // unset($_SESSION['paymentScreen']);
    
    // unset($_SESSION['amount']);
    header("Location: {$site}renovacao"); 
}elseif(diasDatas(date('Y-m-d'), $empresa_data_renovacao) >= 1 && diasDatas(date('Y-m-d'), $empresa_data_renovacao) < 4 && !empty($_SESSION['userlogin']) && $_SESSION['userlogin']['user_id'] == $userId){
    // unset($_SESSION['qr_code_base64']);
    // unset($_SESSION['qr_code']);
    // unset($_SESSION['id_payment']);
    // unset($_SESSION['status']);
    // unset($_SESSION['paymentScreen']);
     
    // unset($_SESSION['amount']);
    header("Location: {$site}renovacao"); 
}else
?>	











 