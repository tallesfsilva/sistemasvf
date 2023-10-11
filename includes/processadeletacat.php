<?php 
session_start();
require('../_app/Config.inc.php');
$site = HOME;


$idcategoria = $_POST['idcat']; 

$idusuario = $_SESSION['userlogin'];
 

$deletbanco->ExeDelete("ws_cat", "WHERE user_id = :userid AND id = :fdv", "userid={$idusuario['user_id']}&fdv={$idcategoria}");
if($deletbanco->getResult()):

    $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id_cat = :fff", "userid={$idusuario}&fff={$idcategoria}");

    if($lerbanco->getResult()):

    foreach ($lerbanco->getResult() as $i):
        extract($i);

        if(file_exists(URL_IMAGE.$img_item) && !is_dir(URL_IMAGE.$img_item)):
          unlink(URL_IMAGE.$img_item);
        endif;
        
    endforeach;

    $novoStatus['id_cat'] = -1;
    $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id_cat = :upp", "userid={$idusuario}&upp={$idcategoria}");
    
    else:
    endif;

endif;