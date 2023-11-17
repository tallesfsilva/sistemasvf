<?php

$login = new Login(3);

if(!$login->CheckLogin()):
  unset($_SESSION['userlogin']);
  header("Location: {$site}");
else:
  $userlogin = $_SESSION['userlogin'];
endif;

$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);

if(!empty($logoff) && $logoff == true):
  $updateacesso = new Update;
  $dataEhora    = date('d/m/Y H:i');
  $ip           = get_client_ip();
  $string_last = array("user_ultimoacesso" => " Último acesso em: {$dataEhora} IP: {$ip} ");
  $updateacesso->ExeUpdate("ws_users", $string_last, "WHERE user_id = :uselast", "uselast={$userlogin['user_id']}");

  unset($_SESSION['userlogin']);
  header("Location: {$site}");
endif;

$meses = array(
  '01'=>'Janeiro',
  '02'=>'Fevereiro',
  '03'=>'Março',
  '04'=>'Abril',
  '05'=>'Maio',
  '06'=>'Junho',
  '07'=>'Julho',
  '08'=>'Agosto',
  '09'=>'Setembro',
  '10'=>'Outubro',
  '11'=>'Novembro',
  '12'=>'Dezembro'
);


$pegaMesGet = filter_input(INPUT_GET, 'm', FILTER_VALIDATE_INT);
$mesgett = '';
if(!empty($pegaMesGet) && ($pegaMesGet == '01' || $pegaMesGet == '02' || $pegaMesGet == '03' || $pegaMesGet == '04' || $pegaMesGet == '05' || $pegaMesGet == '06' || $pegaMesGet == '07' || $pegaMesGet == '08' || $pegaMesGet == '09' || $pegaMesGet == '10' || $pegaMesGet == '11' || $pegaMesGet == '12')):
  $mesgett = $pegaMesGet;
else:
 $mesgett = date('m');
endif;
?>
 
 