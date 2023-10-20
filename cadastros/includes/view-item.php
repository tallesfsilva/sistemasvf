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
<script src="<?= $site;?>cadastros/js/datatables.min.js"></script> 
<script src="<?= $site;?>js/TableCheckAll.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clusterize.js/0.19.0/clusterize.min.css" integrity="sha512-8KLHxyeJ2I3BzL2ma1RZxwT1cc/U5Rz/uJg+G25tCrQ8sFfPz3MfJdKZegZDPijTxK2A3+b4kAXvzyK/OLLU5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script type="text/javascript">
            $(document).ready(function() {         
              // $('#img-container').hide();
             $( '#produtos' ).TableCheckAll();
            });         
              
       
        </script>
 
  <style>

    .btn-delete:hover{
      text-decoration-line: none !important;
  background: #d19898 !important
    }
    #img-container{
      display:none;
    }

    .td-img{
      display: flex;
  justify-content: center;
  top: 5px;
  position: relative;
    }

    .btns-lote:hover{

      background: #d19898 !important;
    }

    #btn_inativar:hover{
      background: #FFC00082 !important;
    }

  </style>



<script type="text/javascript">
            $(document).ready(function() {     
              
                $( '#produtos').TableCheckAll({
                    checkAllCheckboxClass: '.check-all-products',
                    checkboxClass: '.check-products'
                });
            });
        </script>
</head>
<html> 
	

 
				<div  style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
					 
					
							
							<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
							<div  class="config-header w-full text-bold text-center text-white">
											<p>Meus Produtos</p>
									</div>	
							<div id="sendempresa"></div>


								<section class="m-5 section-config" id="section-1">
									 
<div id="idview-item"></div>
<div style="background-color:#ffffff;" class="row">
  <div class="col-md-12">
    <div class="widget">
      <div class="indent_title_in">
      <div id="msg"></div>
      <h3>Listagem de Produtos:</h3>
    <p>
      <span>Para buscar mais produtos, utilize os filtros abaixo:</span><br />
  
   </p>
      </div>
      <div class="widget-content">
 


      <div class="form-group">
        <div class="row">			
          			
              <div class="col-md-8">
                    <label for="search_produto">Nome do Produto</label>						
                    <input type="text" id="search-product" name="search_produto" class="form-control" placeholder="Digite o nome do produto">
                </div>

                <div class="col-md-4">
                    <label for="categoria">Categoria</label>						
                    <select class="form-control" name="categorias" id="categoria">   
                    <?php
                    $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid", "userid={$userlogin['user_id']}");
                    if (!$lerbanco->getResult()):
                      echo "<option value=\"\">Adicione uma categoria</option>";
                    else:
                      echo "<option value=\"\">Todas</option>";
                      foreach ($lerbanco->getResult() as $cat):
                        extract($cat);
                        echo "<option value=\"{$nome_cat}\">{$nome_cat}</option>";
                      endforeach;
                    endif;
                  ?>  
                    </select>
                </div>
        </div>
        <br/>
        <div class="row">
        <br/>
            <div class="col-md-6">
                <div class="icheck-material-green">	        
                      <input type="checkbox" id="produtos_inativos" name="check_produtos_inativos" class="form-control">
                      <label for="produtos_inativos">Apenas produtos inativos</label>	
                </div>

             </div>

             <div class="col-md-6">
              <div class="flex flex-row justify-end">
                 
            
                  <div style="padding-right:10px" class="flex">
                  <a href="<?=$site.'cadastros/'?>produtos">
                      <button id="novo_produto" style="background-color: #00BB07;border-radius:3px !important"class="btn_1 btn_s btn-success"  name="sendAddBairro" value="Salvar" type="submit">Novo Produto</button>
                  </a>
                    </div> 

                  <div style="padding-right:10px" class="flex">
                      <button id="btn_inativar" data-url="<?= $site?>cadastros"  style="background-color: #FFC000;border-radius:3px !important"class="btn_1 btn-success">Inativar</button>
                  </div>

                  <div style="padding-right:10px" class="flex">
                      <button id="btn_excluir" data-url="<?= $site?>cadastros"  style="background-color: #A70000;border-radius:3px !important"class="btn_1 btns-lote btn-success">Excluir</button>
                  </div>
                  </div>

               </div>
        
             </div>
                  </br>
             <div id="msg_error"></div>	
       
  </div>
        <div class="table-responsive">
        
        <table id="produtos" class="border w-full text-left text-gray-500 dark:text-gray-400">
             <thead style="background:#7232A0;" class="text-white text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr class="text-center">
         
              <th scope="col" class="text-center px-6 py-3">
                    <div class="flex justify-center items-center">
                    <div class="icheck-material-green">			
                        <input id="checkbox-all-search" type="checkbox" class="check-all-products w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                  </div>
                      </div>
                </th>
                <th style="padding:25px;" scope="col" class="text-center px-6 py-3">Imagem</th>              
                <th scope="col" class="text-center px-6 py-3">Nome do Produto</th>
                <th scope="col" class="text-center px-6 py-3">Categoria</th>              
            
                <th scope="col" class="text-center px-6 py-3">Preço</th>    
                <th scope="col" class="text-center px-6 py-3">Estoque</th>
                <th scope="col" class="text-center px-6 py-3" data-sortable="false">Disponível</th>                  
                               
              
                <th scope="col" class="px-6 py-3" data-sortable="false">Editar</th>
                <th scope="col" class="px-6 py-3" data-sortable="false">Excluir</th>
              </tr>
            </thead>
            <tbody id="body-products"></tbody>
          
    </table>
  </div>
  <!-- <div class="data-table-toolbar">
   <?php
 
  //  $pager->ExePaginator("ws_itens", "WHERE user_id = :userid", "userid={$userlogin['user_id']}");
  //  echo $pager->getPaginator();
 
   ?>        
 </div> -->
</div>
</div>
</div>

</div>
 
 
 



<div id="resultadiasemana"></div>
 
 

<script type="text/javascript">
  $(document).ready(function(){
    $(".deletarItem").click(function(){

      var iddoitemdel = $(this).data('getiddell');

      GrowlNotification.notify({
        title: 'Atenção!',
        description: 'Tem certeza de que deseja deletar este item?',
        type: 'error',
        image: {
          visible: true,
          customImage: '<?=$site;?>img/danger.png'
        },
        position: 'top-center',
        showProgress: true,
        showButtons: true,
        buttons: {
          action: {
            text: ' Deletar',
            callback: function(){
              $.ajax({
                url: '<?=$site;?>includes/processadeletaritem.php',
                method: 'post',
                data: {'iditem' : iddoitemdel, 'iduser' : '<?=$userlogin['user_id'];?>'},
                success: function(data){
                  let t = JSON.parse(data);
                                  if(t.s){                     
                                      window.location.reload(1);
                                  }  
                }
              });

            }
          },
          cancel: {
            text: ' Cancelar'
          }
        },
        closeTimeout: 0
      });         

    });
  });
</script>
<br />
 
</div>
</div>
</div>
				</section><!-- End section 1 -->

</div>
		</div>
				</div>
 
        <script type="module" src="<?= $site;?>cadastros/js/produtos/main.js"></script>
<script src="<?= $site;?>cadastros/js/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clusterize.js/0.19.0/clusterize.js" integrity="sha512-uoW1yw3jmcdHJxya6AdkfeecPCq6wg41n/H9OhSI78rCec3dnPksZ/h4nanFv+SnXw8Kyb7wE4D0ao1qVoGeRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="js/flowbite.min.js"></script>

  
 
  </html>