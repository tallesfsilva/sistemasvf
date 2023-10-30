<?php
 

$site = HOME;
$loginURL = LOGIN;

$login = new Login(3); 
 
$btn_hover_sim = '#7ccf7f !important';
  
$btn_hover_nao = '#d19898 !important';

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
     

    .datepicker {
    position: relative !important;
    top: -391px !important;
 
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
	
 
 
				<div  style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
					 
					
							
							<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
							<div  class="config-header w-full text-bold text-center text-white">
											<p>Cupons de Desconto</p>
									</div>	
							<div id="sendempresa"></div>


								<section class="m-5 section-config" id="section-1">
									 

                <div id="contato_do_site">
  <div style="background-color:#ffffff;" class="">     
    <div class="row"> 
      <div class="col-md-12">  
        <div id="success"></div>
        <div id="sendnewpass" class="indent_title_in">
        
          <h3>Cupom de Desconto</h3>
          <p>
            Ofereça descontos para conseguir mais clientes.
          </p>
          <br />
   
          <form data-url="<?=$site.'cadastros'?>" id="cadCupom" method="post">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Código de Ativação</label>
                  <input oninput="this.value = this.value.replace(/[^a-z-A-Z-0-9]/g, '')" type="text" maxlength="20" class="form-control" name="ativacao" aria-describedby="emailHelp" placeholder="Ex: Cupom10" />
                  <small id="emailHelp" class="form-text text-muted">Para enviar para seus clientes. (max. 20 caracteres)</small>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Desconto %</label>
                  <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" class="form-control descontoporcentagem"   placeholder="Digite a porcentagem de desconto." maxlength="2"  step="1" name="porcentagem" min="1" max="99" />
                  <small class="form-text text-muted">Porcentagem de desconto.</small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Data de Validade</label>
                  <input readonly type="text" class="form-control" name='data_validade' id="datepicker" data-mask="00/00/0000" placeholder="00/00/0000" />
                  <small id="emailHelp" class="form-text text-muted">Data de expiração do cupom</small>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Quantidade</label>
                  <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" class="form-control numero" name="total_vezes"  placeholder="Digite a quantidade de cupom." min="1" maxlength="3"      max="999" />
                  <small class="form-text text-muted">Número de vezes que o cupom pode ser usado!</small>
                </div>
              </div>
            </div>
            <input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
            <input type="hidden" name="lojaurl" value="<?=$Url[0];?>">
            <input type="hidden" name="action" value="cuc">
            <input type="hidden" name="mostrar_site" value="0">
            <button id="submitbtncupom" style="background-color: #00BB07;"class="btn_1 btn-success">Cadastrar Cupom</button>						
              <!-- <a id="submitbtncupom" class="btn btn-primary">Cadastrar Cupom</a> -->
          </form>
          <br/>      
   

       
          
          <div id="sucsesscupom"></div>

          <br />
         
            
  <hr class="line-hr"/>
          <br />
         
      <div class="row">  
        <div class="col-md-6">
          <label for="search_cupom">Buscar Cupom</label>						
          <input oninput="this.value = this.value.replace(/[^a-z-A-Z-0-9]/g, '')"  type="text" id="search_cupom"  class="form-control" placeholder="Digite o nome do cupom">
          <br />
  </div>
  <div class="col-md-6">
  <div class="form-group">
      
      <label for="categoria">Situação</label>						
      <select class="form-control" name="cupom-busca" id="cupom_busca_situacao">   
      <option value="">Selecione uma situação</option>
      <option value="EXPIROU">EXPIROU</option>
        <option value="ACABOU">ACABOU</option>
        <option value="ATIVO">ATIVO</option>
      </select>
 
    </div>
  </div>
 
  </div>

  </div>
          <div class="overflow-x-auto">
    
            <table style="display:none" id="cupoms" class="border w-full text-left text-gray-500 dark:text-gray-400">
 
               <thead style="background:#7232A0;" class="text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr class="text-center">
                    <th style="padding:25px;" scope="col" class="text-center px-6 py-3">Cupom</th>
                    <th  class="text-center px-6 py-3" scope="col">Desconto</th>
                    <th  class="text-center px-6 py-3" scope="col">Quantidade</th>
                    <th  class="text-center px-6 py-3" scope="col">Expira em</th>
                    <th  class="text-center px-6 py-3" scope="col">Situação</th>
                    <th  class="text-center px-6 py-3" scope="col">Exibir no site</th>
                    <th  class="text-center px-6 py-3" scope="col">Excluir</th>
                  </tr>
                </thead>
                
              </tbody>
            </table>
          </div>
       

      </div>

    </div><!-- End col  --> 

  </div><!-- End row  -->
</div>
</div><!-- End container  -->

				</div>
 
 
			</div><!-- End col  -->
	
	
 
</div>


  </div>
  </div>

 
</div>
				</section><!-- End section 1 -->
  
  

  <script type="module" src="<?= $site;?>cadastros/js/cupom/main.js"></script>
  <script src="<?= $site;?>cadastros/js/datatables.min.js"></script>
	<script src="js/flowbite.min.js"></script>
  <script>



$(document).ready(function(){


$('.descontoporcentagem').on('change', function(e){

    $(this).val($(this).val().replace(/[^0-9]+/g, ''));
  });





})

  </script>

 
  </html>