<?php
require('../../_app/Config.inc.php');
$site = HOME;

try{

    $if_pag = $_POST['id_pag'];
    $iduser  = $_POST['iduser'];
    $msg = "";
 
    
    
    $lerbanco->ExeRead("ws_formas_pagamento", "WHERE user_id = :iduser AND id_f_pagamento = :id_pag", "iduser={$iduser}&id_pag={$if_pag}");
    
  
    if(!$lerbanco->getResult()){

        echo "false";
    }else{
        foreach ($lerbanco->getResult() as $i):
            extract($i);
        endforeach;

    if($aceita_entrega){
        $updateAceitaEntrega['aceita_entrega'] = 0;
        $updatebanco->ExeUpdate("ws_formas_pagamento", $updateAceitaEntrega, "WHERE user_id = :iduser AND id_f_pagamento = :id_pag", "iduser={$iduser}&id_pag={$if_pag}");
        if(!$updatebanco->getResult()){
            echo "false";
        }else{
            echo "success";
        }

    }else{
        $updateAceitaEntrega['aceita_entrega'] = 1;
        $updatebanco->ExeUpdate("ws_formas_pagamento", $updateAceitaEntrega, "WHERE user_id = :iduser AND id_f_pagamento = :id_pag", "iduser={$iduser}&id_pag={$if_pag}");
            if(!$updatebanco->getResult()){
                echo "false";
            }else{
                echo "success";
            }
    }    

   }    
       
} catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}



?>