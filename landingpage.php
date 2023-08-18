<?php
$login = new Login(3);

$loginUrl = LOGIN;
if($login->CheckLogin()):
  $idusuar = $_SESSION['userlogin']['user_id'];
  $lerbanco->ExeRead('ws_empresa', "WHERE user_id = :idcliente", "idcliente={$idusuar}");
  if (!$lerbanco->getResult()):       
  else:
    foreach ($lerbanco->getResult() as $i):
      extract($i);
    endforeach;

    header("Location: {$site}{$nome_empresa_link}/new-home");
  endif;
else:   
  header("Location: {$loginUrl}");
endif;
?>
