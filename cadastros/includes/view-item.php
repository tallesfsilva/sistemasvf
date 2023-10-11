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
<script src="<?= $site;?>cadastros/js/main.js"></script>

<script type="text/javascript">
            $(document).ready(function() {         
              $('#img-container').hide();
             $( '#produtos' ).TableCheckAll();
            });         
              
       
        </script>
 
  <style>

    .btn-delete:hover{
      text-decoration-line: none !important;
  background: #d19898 !important
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
                      <button style="background-color: #FFC000;border-radius:3px !important"class="btn_1 btn-success"  name="sendAddBairro" value="Salvar" type="submit">Novo Produto</button>
                  </div> 

                  <div style="padding-right:10px" class="flex">
                      <button id="btn_inativar" data-url="<?= $site ?>" data-user="<?=$userlogin['user_id'];?>" style="background-color: #A70000;border-radius:3px !important"class="btn_1 btn-success">Inativar</button>
                  </div>

                  <div style="padding-right:10px" class="flex">
                      <button id="btn_excluir" data-url="<?= $site?>" data-user="<?=$userlogin['user_id'];?>" style="background-color: #A70000;border-radius:3px !important"class="btn_1 btn-success">Excluir</button>
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
              <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                    <div class="icheck-material-green">			
                        <input id="checkbox-all-search" type="checkbox" class="check-all-products w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                  </div>
                      </div>
                </th>
                <th style="padding:25px;" scope="col" class="px-6 py-3">Imagem</th>              
                <th scope="col" class="px-6 py-3">Nome do Produto</th>
                <th scope="col" class="px-6 py-3">Categoria</th>
                <th scope="col" class="px-6 py-3">Descrição</th>
                <th scope="col" class="px-6 py-3">Preço</th>    
                <th scope="col" class="px-6 py-3" data-sortable="false">Disponível</th>                  
                <th scope="col" class="px-6 py-3">Seleção de Adicionais</th>                      
              
                <th scope="col" class="px-6 py-3" data-sortable="false">Editar</th>
                <th scope="col" class="px-6 py-3" data-sortable="false">Excluir</th>
              </tr>
            </thead>

            <tbody id="table1">
              <?php
              //INICIO PAGINAÇÃO
              $getpage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
              $pager = new Pager("{$site}{$Url[0]}/view-item&page=");
              $pager->ExePager($getpage, 10);
              //FIM PAGINAÇÃO
              $lerbanco->ExeRead("ws_itens", "WHERE user_id = :userid ORDER BY id DESC LIMIT :limit OFFSET :offset", "userid={$userlogin['user_id']}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");              
              if (!$lerbanco->getResult()):
               $pager->ReturnPage();               
             else:
              foreach ($lerbanco->getResult() as $getItensBanco):
                extract($getItensBanco);               
                ?>
                <!-- INICIO DO LOOP DA LEITURA DO BANCO --> 
                <tr class="border-b">
                <td scope="row" class="w-4 p-4">
                    <div class="flex items-center">
                    <div class="icheck-material-green">			
                        <input id="checkbox-product_<?=$id?>" type="checkbox" class="check-products w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-product_<?=$id?>"" class="sr-only">checkbox</label>
                     </div>
                      </div>
                </td>
                 <td class="col-md-3 col-sm-2  px-6 py-4">
                  <div style="width:40px;" class="img-wrap">
                    <?php
                    if (!empty($img_item) && $img_item != "" && file_exists("uploads/{$img_item}") && !is_dir("uploads/{$img_item}")):
                      echo Check::Image('uploads/'.$img_item, 'Imagem-item', 40, 33);
                  else:
                    echo Check::Image('img/camara2.png', 'Imagem-item', 40, 33);
                  endif;
                  ?>
                </div>
              </td>
             
              <td id="nome_produto" class="col-md-3 col-sm-2  px-6 py-4"><?=(!empty($nome_item) ? limitarTexto($nome_item, 40) : '');?></td>
              <td id="categoria-row">
                
                <strong>
                  <?php
                  $lerbanco->ExeRead('ws_cat', "WHERE user_id = :userid AND id = :idcatt", "userid={$userlogin['user_id']}&idcatt={$id_cat}");
                  if($lerbanco->getResult()):
                    $dadoscat = $lerbanco->getResult();
                    echo $dadoscat[0]['nome_cat'];
                  endif;
                  ?>
                </strong>
              </td>
              <td class="col-md-3 col-sm-2  px-6 py-4"><?=(!empty($descricao_item) ? limitarTexto($descricao_item, 30) : '');?></td>
              <td class="col-md-3 col-sm-2  px-6 py-4"><?=(!empty($preco_item) ? 'R$ '.Check::Real($preco_item) : '');?></td>
              <td  id="atualizar_<?=$id;?>" data-id="<?=$id;?>" class="col-md-3 col-sm-2  px-6 py-4">
               <button id="<?= (!empty($disponivel) && $disponivel) == 1 ? 'btn_s'.$id : 'btn_n'.$id?>" value="<?=$id;?>" style="background: <?= (!empty($disponivel) && $disponivel) == 1 ? '#00BB07' : '#A70000;'?>" type="button" class="atualizar_<?=$id;?> aceita_entrega exibirsite"><?=(!empty($disponivel) && $disponivel) == 1 ? 'Sim' : 'Não'?></button>
                               
                <script type="text/javascript">
                  $(document).ready(function(){
                    $('.atualizar_<?=$id;?>').click(function(){
                      var idDoItem = $('#atualizar_<?=$id;?>').data('id');
                      $.ajax({
                        url: '<?=$site;?>includes/processaDisponibilidadeItens.php',
                        method: "post",
                        data: {'iditem' : idDoItem, 'iduser' : '<?=$userlogin['user_id'];?>'},

                        success: function(data){ 
                          window.location.reload(1);
                          //  window.location.replace('<?=$site.'cadastros/view-item';?>'); 
                        }
                      });
                    });
                  });


                </script>
              </td>   
              <td class="col-md-3 col-sm-2  px-6 py-4"><input type="number" data-produtoid="<?=$id;?>" class="form-control number_adicional" name="number_adicional" value="<?=(!empty($number_adicional) ? $number_adicional : "")?>" placeholder="0"></td>
                        
              <td class="col-md-3 col-sm-2  px-6 py-4">
                <center>
                  <a href="<?=$site.$Url[0].'/up-item&id='.$id.'#upitem';?>"><p data-placement="top" data-toggle="tooltip" title="Editar"><button class="btn btn-primary" data-title="Editar"><span class="glyphicon glyphicon-pencil"></span></button></p></a>
                </center>
              </td>
              <td class="col-md-3 col-sm-2  px-6 py-4">
           
                  <button style="background-color: #A70000;border-color: #A70000; margin-top: 3px;border-radius: 4px !important" data-getiddell="<?=$id;?>" class="btn_1 btn-delete deletarItem"><span class="glyphicon glyphicon-trash"></span></button>
           
              </td>
            </tr>  
            <!-- FINAL DO LOOP DA LEITURA DO BANCO --> 
            <?php
          endforeach;
        endif;
        ?>              
      </tbody>
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
  $('.number_adicional').change(function (){

    var valor_total_number = $(this).val();
    var id_produto = $(this).data('produtoid');
    var iduser = '<?=$userlogin['user_id'];?>';

    $.ajax({
      url: '<?=$site;?>controlers/edit-opcao-adicionais.php',
      method: "post",
      data: {'idproduto' : id_produto, 'valor' : valor_total_number, 'iduser' : iduser},

      success: function(data){       
        if(data == 'true'){
          x0p('Sucesso!', 
            'O item foi atualizado!', 
            'ok', false);
        }else if(data == 'false'){
          x0p('Opss...', 
            'OCORREU UM ERRO!',
            'error', false);
        }
      }
    }); 

  });
</script>

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
		 
 

 
	<script src="js/flowbite.min.js"></script>

 
  </html>