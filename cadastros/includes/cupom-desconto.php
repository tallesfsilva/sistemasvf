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
	<script>
		$(document).ready(function(){
			$('#img-container').remove();
		})
	
			 
	</script>

  <style>

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
          <form id="formcupom" method="post">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Código de Ativação</label>
                  <input oninput="this.value = this.value.replace(/[^a-z-A-Z-0-9]/g, '')"required type="text" maxlength="20" class="form-control" name="ativacao" aria-describedby="emailHelp" placeholder="EX: CUPOM10" />
                  <small id="emailHelp" class="form-text text-muted">Para enviar para seus clientes. (max. 20 caracteres)</small>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Desconto %</label>
                  <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required type="text" class="form-control descontoporcentagem" value="1" maxlength="2"  step="1" pattern="[0-9]{2}" name="porcentagem" min="1" max="99" />
                  <small class="form-text text-muted">Porcentagem de desconto.</small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Data de Validade</label>
                  <input required type="text" class="form-control" name='data_validade' id="datepicker" data-mask="00/00/0000" placeholder="00/00/0000" />
                  <small id="emailHelp" class="form-text text-muted">Data de expiração do cupom</small>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Quantidade</label>
                  <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required type="text" class="form-control numero" name="total_vezes" value="1" min="1" maxlength="3"  step="1" pattern="[0-9]{3}" max="999" />
                  <small class="form-text text-muted">Número de vezes que o cupom pode ser usado!</small>
                </div>
              </div>
            </div>
            <input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
            <input type="hidden" name="lojaurl" value="<?=$Url[0];?>">
            <input type="hidden" name="submitcupomconfirm" value="true">
            <input type="hidden" name="mostrar_site" value="0">
            <button id="submitbtncupom" style="background-color: #00BB07;"class="btn_1 btn-success">Cadastrar Cupom</button>						
              <!-- <a id="submitbtncupom" class="btn btn-primary">Cadastrar Cupom</a> -->
          </form>
          <br/>      
      <hr style="position: relative;top: -13px;" class="line-hr"/>

       
          <script type="text/javascript">
              

            $(document).ready(function(){
              $('#submitbtncupom').click(function(){
                $.ajax({
                  url: '<?=$site;?>includes/processasubmitcupom.php',
                  method: 'post',
                  data: $('#formcupom').serialize(),
                  success: function(data){
                    $('#sucsesscupom').html(data);
                  }
                });
              });
            });
          </script>
          <div id="sucsesscupom"></div>

          <br />
          <br />
        
          <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-500 dark:text-gray-400">
             <thead style="background:#7232A0;" class="text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                <tbody>
                  <?php
                 
                    $lerbanco->ExeRead('cupom_desconto', "WHERE user_id = :userid ORDER BY id_cupom DESC", "userid={$userlogin['user_id']}");
                    if ($lerbanco->getResult()):
              
                  foreach ($lerbanco->getResult() as $dadoscupons):
                    extract($dadoscupons); 
                    ?>
                    <tr class="text-center">
                    <td><?=$ativacao;?></th>
                      <td  ><?=$porcentagem;?> %</td>
                      <td ><?=$total_vezes;?></td>
                      <td>
                        <?php
                        $datavalidade = explode("-", $data_validade);
                        $datavalidade = array_reverse($datavalidade);
                        $datavalidade = implode("/",  $datavalidade);
                        echo $datavalidade;
                        ?>                      
                      </td>
                      <td >

                        <?php
                        if(!isDateExpired($data_validade, 1)):
                          echo "<strong style='color: red;'>EXPIROU!</strong>";
                        elseif($total_vezes <= 0):
                         echo "<strong style='color: red;'>ACABOU!</strong>";
                       else:
                        echo "<strong style='color: #82C152;'>ATIVO</strong>";
                      endif;
                      ?> 

                    </td>
                    <td><button style="background: <?=$mostrar_site ? '#00BB07' : '#A70000' ?>" type="button" class="btn btn-defalt aceita_entrega exibirsite" data-idcupom="<?=$id_cupom;?>"><?=($mostrar_site == 0 ? 'Não' : 'Sim');?></button></td>
                    <td><button  style="background-color: #A70000; margin-top: 3px;border-radius: 4px !important" type="button" class="btn_1 btn-delete excluircupom" data-idcupom="<?=$id_cupom;?>">Excluir</button></td>
                  </tr>
                  <?php
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
          <?php
        endif;
        ?>

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
  
 
        <script type="text/javascript">
  $(document).ready(function(){
    $('.exibirsite').click(function(){
      var idcupom = $(this).data('idcupom');
      $(this).prop('disabled', true);

      $.ajax({
        url: '<?=$site;?>includes/processamostrarcupom.php',
        method: 'post',
        data: {'iddocupom' : idcupom, 'url' : '<?=$Url[0];?>', 'iduser' : '<?=$userlogin['user_id'];?>'},
        success: function(data){
          $('.exibirsite').prop('disabled', false);
          if(data == 'erro1'){
            x0p('Opss...', 
              'Ocorreu um arro!',
              'error', false);
          }else if(data == 'erro0'){
            window.location.replace('<?=$site.'cadastros/cupom-desconto';?>');
          }

        }
      });
    });
  });
</script>



<script type="text/javascript">
  $(document).ready(function(){
    $('.excluircupom').click(function(){
      var idcupom = $(this).data('idcupom');
      x0p({
        title: 'Atenção!',
        text: 'Tem certeza de que deseja excluir esse cupom?',
        animationType: 'slideUp',
        buttons: [
        {
          type: 'error',
          key: 49,
          text: 'Cancelar',

        },
        {
          type: 'info',
          key: 50,
          text: 'Excluir'
        }
        ]
      }).then(function(data) {
        if(data.button == 'error'){

        }else if(data.button == 'info'){

          $.ajax({
            url: '<?=$site;?>includes/processadeletarcupom.php',
            method: 'post',
            data: {'iddocupom' : idcupom, 'url' : '<?=$Url[0];?>', 'iduser' : '<?=$userlogin['user_id'];?>'},
            success: function(data){
              $('#sucsesscupom').html(data);
              $('.excluircupom').prop('disabled', false);
            }
          });
        }
      });
    });
  });
</script>

 
	<script src="js/flowbite.min.js"></script>
  <script>



$(document).ready(function(){


$('.descontoporcentagem').on('change', function(e){

    $(this).val($(this).val().replace(/[^0-9]+/g, ''));
  });





})

  </script>

 
  </html>