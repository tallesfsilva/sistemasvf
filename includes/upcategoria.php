<?php
session_cache_expire(60);
session_start();
require('../_app/Config.inc.php');
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

$updatebanco = new Update();
 
$novaCategoria = filter_input_array(INPUT_POST, FILTER_DEFAULT);

 if(!empty($novaCategoria) && isset($novaCategoria['cat_update']) && $novaCategoria['nome_cat']){
 
  $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid AND nome_cat = :cat", "userid={$userlogin['user_id']}&cat={$novaCategoria['nome_cat']}");
  if ($lerbanco->getResult()){
    echo "<div class=\"alert alert-info alert-dismissable\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
    Já existe uma categoria com este nome. Por favor selecione outro!
    </div>";
    //header("Refresh: 5; url={$site}{cadastro/categorias");
  }else{
      $novaCategoria = array_map('strip_tags', $novaCategoria);
      $novaCategoria = array_map('trim', $novaCategoria); 

  if($novaCategoria['nome_cat'] == ""){
    echo "<div class=\"alert alert-info alert-dismissable\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
    Você precisa preecher o campo com o nome da categoria para continuar!
    </div>";
   // header("Refresh: 5; url={$site}cadastros/categorias");
  }else{
    $newCategoriaName['nome_cat'] = strtoupper($novaCategoria['nome_cat']);
 
    $updatebanco->ExeUpdate("ws_cat",$newCategoriaName, "WHERE user_id = :userid AND id = :newcatupdat", "userid={$userlogin['user_id']}&newcatupdat={$novaCategoria['cat_id']}");
    if ($updatebanco->getResult()){
        echo "<div class=\"alert alert-success alert-dismissable\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
        <b class=\"alert-link\">SUCESSO!</b> A categoria foi atualizada.
        </div>";
        // header("Refresh: 5; url={$site}{cadastro/categorias");
    }else{        echo "<div class=\"alert alert-danger alert-dismissable\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>
        <b class=\"alert-link\">OCORREU UM ERRO!</b> Tente novamente.
        </div>";
        // header("Refresh: 5; url={$site}{cadastro/categorias");
    };
  };
};

}              
  
?>
  