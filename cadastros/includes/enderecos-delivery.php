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


								<section class="section-config" id="section-1">
									 

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
 
 
<form class="form-horizontal"  id="cadTaxaEntrega"  data-url="<?=$site.'cadastros'?>" role="form" method="post">
 <br />
 <div class="form-group"> 
 <div class="flex flex-col">
 <label class="col-sm-1 ">UF:</label>       
   <div class="col-sm-12">
     <select class="form-control" name="uf" id="estados2">     
     </select>
   </div>
</div>
 </div>
 <div class="form-group"> 
   <label class="col-sm-1">Cidade:</label>       
   <div class="col-sm-12">
     <select class="form-control" name="cidade" id="cidades2">    
     </select>
   </div>
 </div>
 <div class="form-group">
  <label class="col-sm-1">Bairro:</label>
  <div class="col-sm-12">
    
    <input type="text" name="bairro" class="form-control" placeholder="Selecione um bairro">
  
</div>
</div>

 <div class="form-group">
  <label class="col-sm-2">Valor da Taxa:</label>
  <div class="col-sm-10">
   <div class="input-group">    
    <input type="text" name="taxa" maxlength="6"  max="999.99"  data-mask="#.##0,00"   data-mask-reverse="true" class="form-control" placeholder="(Digite 0 para taxa gratuita)">
  </div>
</div>
</div>
<input type="hidden" name="action" value="tc">
<button style="background-color: #00BB07;"class="btn_1 btn-success"  name="sendAddBairro" value="Salvar" type="submit">Cadastrar Endereço</button>
<!-- <input type="submit" name="sendAddBairro" value="Cadastrar Endereço" class="btn btn-success" /> -->

</form>
<br/>
<br/>

<hr style="position: relative;top: -13px;" class="line-hr"/>
<br/>
 
 
<div class="row">  
      <div class="col-md-4">
        <label for="search_taxa">Buscar Taxa de Entrega</label>						
        <input oninput="this.value = this.value.replace(/[^a-z-A-Z ]/g, '')"   type="text" id="search_taxa"  class="form-control" placeholder="Digite o nome de um bairro">
        <br />
        
      </div>
<div class="col-md-4"> 
 <label class="col-sm-1 ">UF:</label>       
   <div class="col-sm-12">
     <select  data-url="<?=$site?>"  class="form-control"   id="estados_busca"> 
     
     </select>
   </div>
</div>
 
<div class="col-md-4">
   <label class="col-sm-1">Cidade:</label>       
   <div class="col-sm-12">
     <select class="form-control" id="cidades_busca">   
     
     </select>
   </div>
  </div>
    
   
    </div>
         
       
<div class="form-group">        
 <div class=""> 
<div id="msg1"></div>
<div class="overflow-x-auto">
    <table style="display:none" id="taxa-entrega" class="border w-full text-left text-gray-500 dark:text-gray-400">
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
      
    </table>
</div>
 </div>
</div>





<br />
 
</div>
</div>
				</section><!-- End section 1 -->

</div>
		</div>
				</div>
		 
  
 
  <script type="module" src="<?= $site;?>cadastros/js/taxa_entrega/main.js"></script>
  <script src="<?= $site;?>cadastros/js/datatables.min.js"></script>
	<script src="js/flowbite.min.js"></script>

 
  </html>