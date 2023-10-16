<?php
 

$site = HOME;
$loginURL = LOGIN;

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
?>


<html>

<head>
 
  <style>

#img-container{
      display:none;
    }

    .btn-delete:hover{
      text-decoration-line: none !important;
  background: #d19898 !important
    }

  </style>
</head>
<html> 
	

 
				<div  style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
					 
					
							
							<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
							<div  class="config-header w-full text-bold text-center text-white">
											<p>Taxa de Entrega</p>
									</div>	
							<div id="sendempresa"></div>


								<section class="m-5 section-config" id="section-1">
									 

<div id="adicionarbairro"></div>
<div style="background-color:#ffffff;" class="container">
 <div class="row"> 
  <div class="col-md-12"> 
   <div id="sendnewpass" class="indent_title_in">
     
    <h3>Endereços de Entrega:</h3>
    <p>
      <span>Adicione todos os bairros que vocês entregam!.</span><br />
  
   </p>
 </div>

 <?php
 $getdellbairro = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

 if(!empty($getdellbairro)):

  $lerbanco->ExeRead('bairros_delivery', "WHERE user_id = :userid AND id = :v1", "userid={$userlogin['user_id']}&v1={$getdellbairro}");
  if ($lerbanco->getResult()):
  $deletbanco->ExeDelete("bairros_delivery", "WHERE user_id = :userid AND id = :k1", "userid={$userlogin['user_id']}&k1={$getdellbairro}");
    if ($deletbanco->getResult()):
      echo "<div class=\"alert alert-success alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <b class=\"alert-link\">SUCESSO!</b> Bairro deletado do sistema.
      </div>";
     // header("Refresh: 3; url={$site}cadastros/enderecos-delivery#adicionarbairro");
    else:
      echo "<div class=\"alert alert-danger alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <b class=\"alert-link\">OCORREU UM ERRO DE CONEXÃO!</b> Tente novamente.
      </div>";
      // header("Refresh: 3; url={$site}cadastros/enderecos-delivery#adicionarbairro");
    endif;
  endif;
endif;




$addBairros = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if($addBairros && isset($addBairros['sendAddBairro'])):
  unset($addBairros['sendAddBairro']);

  $addBairros = array_map('strip_tags', $addBairros);
  $addBairros = array_map('trim', $addBairros);

  if(in_array('', $addBairros) || in_array('null', $addBairros)):
    echo "<div class=\"alert alert-info alert-dismissable\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
  Preencha todos os campos!
  </div>";
else:
  $addBairros['bairro'] = tratar_nome($addBairros['bairro']);
  $addBairros['taxa'] = Check::Valor($addBairros['taxa']);

  $lerbanco->ExeRead('bairros_delivery', "WHERE user_id = :userid AND (uf = :u AND cidade = :c AND bairro = :v)", "userid={$userlogin['user_id']}&u={$addBairros['uf']}&c={$addBairros['cidade']}&v={$addBairros['bairro']}");

  if(!$lerbanco->getResult()):   
    $addbanco->ExeCreate("bairros_delivery", $addBairros);
    if($addbanco->getResult()):                        
      echo "<div class=\"alert alert-success alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <b class=\"alert-link\">SUCESSO!</b> Bairro inserido no sistema.
      </div>";
    else:
      echo "<div class=\"alert alert-danger alert-dismissable\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
      <b class=\"alert-link\">OCORREU UM ERRO TENTE NOVAMENTE!</b> Tente novamente.
      </div>";
    endif;
  else:
    echo "<div class=\"alert alert-info alert-dismissable\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
    Você já cadastrou esse bairro!
    </div>";
  endif;
endif;
endif;
?>
<form class="form-horizontal" action="#adicionarbairro" role="form" method="post">
 <br />
 <div class="form-group"> 
 <div class="flex flex-col">
 <label class="col-sm-1 ">UF:</label>       
   <div class="col-sm-12">
     <select required class="form-control" name="uf" id="estados2">     
     </select>
   </div>
</div>
 </div><div class="form-group"> 
   <label class="col-sm-1">Cidade:</label>       
   <div class="col-sm-12">
     <select required class="form-control" name="cidade" id="cidades2">    
     </select>
   </div>
 </div>
 <div class="form-group">
  <label class="col-sm-1">Bairro:</label>
  <div class="col-sm-12">
    
    <input type="text" required name="bairro" class="form-control" placeholder="Nome do bairro...">
  
</div>
</div>

 <div class="form-group">
  <label class="col-sm-2">Valor da Taxa:</label>
  <div class="col-sm-10">
   <div class="input-group">    
    <input type="text" required name="taxa" maxlength="6"  data-mask="#.##0,00"   step="1"  data-mask-reverse="true" class="form-control" placeholder="0,00">
  </div>
</div>
</div>
<input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
<button style="background-color: #00BB07;"class="btn_1 btn-success"  name="sendAddBairro" value="Salvar" type="submit">Cadastrar Endereço</button>
<!-- <input type="submit" name="sendAddBairro" value="Cadastrar Endereço" class="btn btn-success" /> -->
<br/>
<br/>

<hr style="position: relative;top: -13px;" class="line-hr"/>
<br/>
<br/>


<div class="form-group">        
 <div class=""> 

<div class="overflow-x-auto">
    <table class="border w-full text-left text-gray-500 dark:text-gray-400">
        <thead style="background:#7232A0;" class="text-white text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th style="padding:25px;" scope="col" class="text-center px-6 py-3">
                    Estado
                </th>
                <th scope="col" class="text-center px-6 py-3">
                    Cidade
                </th>
                <th scope="col" class="text-center px-6 py-3">
                   Bairro
                </th>
                <th scope="col" class="text-center px-6 py-3">
                   Valor
                </th>
                <th scope="col" class="text-center px-6 py-3">
                   Excluir
                </th>
                
                
            </tr>
        </thead>
        <tbody>

        <?php
   $lerbanco->ExeRead("bairros_delivery", "WHERE user_id = :userid ORDER BY id DESC", "userid={$userlogin['user_id']}");
   
   if($lerbanco->getResult()){
     foreach($lerbanco->getResult() as $tt){
       extract($tt);                                   
      
     ;
     ?>
      <tr  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
 
            <td scope="row" class="text-center">
                   <?= $uf ?>
     </td>
   
                <td class="text-center">
                <?= $cidade ?>
                </td>
                <td class="text-center">
                <?= $bairro ?>
                </td>
                <td class="text-center">
                <?= $taxa ?>
                </td>
                <td class="text-center">
               
               <a title="Deletar" href="<?=$site.'cadastros/enderecos-delivery&delete='.$id.'#adicionarbairro';?>">
                  <button style="background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important" type="button" class="btn_1 btn-delete text-black">
                  <span class="glyphicon glyphicon-trash"></span>
                  </button>
                </a><br />
  
                </td>
            </tr>
           
     <?php
     }
    };
   ?>
  
            
        </tbody>
    </table>
</div>
 </div>
</div>




</form>
<br />
 
</div>
</div>
				</section><!-- End section 1 -->

</div>
		</div>
				</div>
		 
 

 
	<script src="js/flowbite.min.js"></script>

 
  </html>