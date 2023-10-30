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

<?php
$getdellbairro = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

if(!empty($getdellbairro)):

	$lerbanco->ExeRead('ws_formas_pagamento', "WHERE user_id = :userid AND id_f_pagamento = :v1", "userid={$userlogin['user_id']}&v1={$getdellbairro}");
	if ($lerbanco->getResult()):
		$deletbanco->ExeDelete("ws_formas_pagamento", "WHERE user_id = :userid AND id_f_pagamento = :k1", "userid={$userlogin['user_id']}&k1={$getdellbairro}");
		if ($deletbanco->getResult()):
			header("Location: {$site}cadastros/cadastrar-formas-pagamento");
		else:
			echo "<script>
			x0p('Opss...', 
			'Ocorreu um Erro!',
			'error', false);
			</script>";
		endif;
	endif;
endif;
?>

<html>

<head>
 

  <style>

    #img-container{
      display:none;
    }

    body{
      background-image : unset !important;
    }

    .btn-delete:hover{
      text-decoration-line: none !important;
  background: #d19898 !important
    }

  
    .aceita_entrega{
      border: none;
     font-family: inherit;
  font-size: inherit;
  color: #fff;
 
    background-color: rgb(30, 190, 165);
 
  padding: 10px 20px;
  outline: none;
  font-size: 12px;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  transition: all 0.3s;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px; 
  font-weight: 600;
  display: inline-block;
  text-align: center;
    }
   
  </style>
</head>
<html> 
	
<?php  echo '<body style="background-color:white">'; ?>
 
				<div  style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
					 
					
							
							<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
							<div  class="config-header w-full text-bold text-center text-white">
											<p>Formas de Pagamento</p>
									</div>	
							<div id="sendempresa"></div>


								<section class="m-5 section-config" id="section-1">
									 

                <div id="contato_do_site">
	<div style="background-color:#ffffff;" class="">   		 
		<div class="row"> 
			<div class="col-md-12">  				
				<div id="sendnewpass" class="indent_title_in">
			 
					<h3><strong>Formas de Pagamento</strong> </h3>
					<p>
						<span>Cadastre as formas de pagamento que você aceita em sua loja!</span>
					</p>
					<br />
				 
       
					<form data-url="<?=$site.'cadastros'?>" id="cadFormasPagamento" method="post">
						<div class="form-group">							
							<label for="f_pagamento">Forma de Pagamento</label>						
							<input oninput="this.value = this.value.replace(/[^a-z-A-Z ]/g, '')"   maxlength="30" type="text" id="f_pagamento" name="f_pagamento" class="form-control" placeholder="Dinheiro, Crédito Visa, etc...">
                </div>                 
                <input type="hidden" name="action" value="fc"/>
             	
                <button style="background-color: #00BB07;"class="btn_1 btn-success"  type="submit">Cadastrar Pagamento</button>						
					 
					</form>
	 			
			 

				</div>
          
<hr style="position: relative;top: -13px;" class="line-hr"/>
<br/>
 
		
	
	
<br />
          <br />
        
         
      <div class="row">  
        <div class="col-md-12">
          <label for="search_cupom">Buscar Forma de Pagamento</label>						
          <input oninput="this.value = this.value.replace(/[^a-z-A-Z ]/g, '')"   type="text" id="search_forma"  class="form-control" placeholder="Digite o nome de uma forma de pagamento">
          <br />
  </div>
  
 
  </div>

 
<div class="form-group">   
       

  
<div id="msg1"></div>
<div class="overflow-x-auto">
    <table style="display:none" id="formas-pagamento" class="border w-full text-left text-gray-500 dark:text-gray-400">
        <thead style="background:#7232A0;" class="text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>               
                <th style="padding:25px;" scope="col" class=" text-center px-6 py-3">
                   Forma de Pagamento
                </th>
                <th scope="col" class="text-center px-6 py-3">
                   Aceita na Entrega?
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
  </div>

 



 
<br />
 
</div>
</div>
</div>
				</section><!-- End section 1 -->

</div>
		</div>
				</div>
		 
        <script type="text/javascript">
  $(document).ready(function(){
   
 
      $('.aceita_entrega').click(function(){
      var id_pag = $(this).data('id_pag');
      $(this).prop('disabled', true);

      $.ajax({
        url: 'includes/processa-aceita-entrega.php',
        method: 'post',
        data: {'id_pag' : id_pag, 'iduser' : '<?=$userlogin['user_id'];?>'},
        success: function(data){
          console.log(data);
          $('#aceita_entrega').prop('disabled', false);
          if(data == 'false'){
            x0p('Opss...', 
              'Ocorreu um erro!',
              'error', false);
          }else if(data == 'success'){
            window.location.replace('<?=$site.'cadastros/cadastrar-formas-pagamento';?>');
          }

        }
      });
    });
     
  
  });
</script>

 
<script type="module" src="<?= $site;?>cadastros/js/formas_pag/main.js"></script>
<script src="<?= $site;?>cadastros/js/datatables.min.js"></script>
	<script src="js/flowbite.min.js"></script>

 
  </html>