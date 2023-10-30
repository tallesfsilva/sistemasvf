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



$getIdItem = filter_input(INPUT_GET, 'idprod', FILTER_VALIDATE_INT);

if(!isset($getIdItem)):
 header("Location: {$site}cadastros/view-item");
else:
  $lerbanco->ExeRead("ws_itens", "WHERE user_id = :userid AND id = :aa", "userid={$userlogin['user_id']}&aa={$getIdItem}");
  if ($lerbanco->getResult()):
    foreach ($lerbanco->getResult() as $dd):
      extract($dd);
    endforeach;
  else:
    
  endif;
endif;

$idprod = $id;

?>
<script src="<?=$site;?>js/MSFmultiSelect.js"></script>

<style type="text/css">
   
  #remove-img:hover{

    opacity:0.40 !important;

}

.container-hover:hover{
  opacity:0.40 !important;
}

#img-container{
      display:none;
    }



 

 

 

#img-container{
      display:none;
    }

    .btn-delete:hover{
      text-decoration-line: none !important;
  background: #d19898 !important
    }

 
   

  .btns-lote:hover{

background: #d19898 !important;
}

#btn_clonar:hover{
background: #FFC00082 !important;
}
 
  .item-adicional, #container_tipos{
    border: 1px solid rgb(217, 217, 217);
   
  }

  #file-5{
    width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1
  }
.remove-icon{
  position: absolute;
  right: 10px;
  margin: 10px;
  font-size: 25px;
 
  z-index: 1999;
  color: white;
  background: #00000024;
  border-radius: 10px;
  border: 2px solid;
    border-top-color: currentcolor;
    border-right-color: currentcolor;
    border-bottom-color: currentcolor;
    border-left-color: currentcolor;
  border-color: transparent;
  display: flex;
  align-items: center;
  width: 60px;
  height: 50px;
  justify-content: center;
}
  :focus-visible {
  outline: none !important;
}

</style>

<script>

  $(document).ready(function(){

    if($('#show_img_prod').is(':visible')){
      $('#container-img').removeClass('container-hover')
    }
   
  })

</script>

<div  style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
	
<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
                                    <div  class="config-header w-full text-bold text-center text-white">
                                                    <p><?= $nome_item ?></p>
                                            </div>	
                                   
        
        
                                        <section class="m-5 section-config" id="section-1">
 
    <div class="indent_title_in">
    
      <h3>Editar produto:</h3>
      <p>Edite seus os produtos que serão exibidos em sua loja!</p>
    </div>
    <?php
    // require('includes/configItens.php');
    ?>

    
    <form data-url="<?=$site?>cadastros" id="updateProduto" enctype="multipart/form-data">
      <div class="wrapper_indent">
       
        
          <div class="row">
            <div class="col-md-4">
              <div class="flex flex-col text-center">
              <div class="menu-item-pic">
                <?php 

             
              if (!empty($img_item) && $img_item != "" && file_exists(UPLOAD_PATH."/uploads"."/".$img_item) && !is_dir(UPLOAD_PATH."/uploads"."/".$img_item)){
                $imgProd =  URL_IMAGE.$img_item;
                $flag = true;
                $styleImg= "margin: 0 auto; align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;height: 340px;";
              }else{
                $styleImg= "";
                $imgProd =  "";
                $flag = false;
              };   
            ?>
                <div id="container-img" style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap:wrap;justify-content:center;background-color:#ffffff;background: #7232A0; height:340px" class="container-hover cursor-pointer w-full box">
                 <div   style="display:<?= $flag == true ? "flex" : "none !important;" ?>"class="flex flex-row" id="show_img_prod">
                        <div class="w-full">                          
                        <img style="<?= !empty($styleImg) ?$styleImg : ""  ?>" class="cursor-pointer" id="img_prod"  src="<?=!empty($imgProd) ? $imgProd : "" ?>"/>                       
                        </div>
                        <div id="remove-img"  class="remove-icon h-1/2">
                        <span  class="glyphicon glyphicon-trash"></span>
                  
                        </div>   
                </div>
               
                <input type="file" name="img_item" id="file-5" class="" data-multiple-caption="{count} files selected" multiple />
                  <label style="display: <?= $flag ? "none" : ""?>" class="cursor-pointer" id="label-file" for="file-5"><img src="<?=URL_IMAGE.'img/upload_product.png'?>"/></label>  
                  <div id="label-icon" style="position:relative; top: -25px;color:white;font-size:24px;font-weight:unset" class="w-full" style="background:#7233A1; color:white;margin 0 auto;">
                    <label id="label-text" style="display: <?= $flag ? "none" : ""?>" style="font-weight:unset"  for="file-5">Enviar imagem...</label>
                </div>   
                </div>
                  </div>
              
            </div>
            </div>
       

            <div class="col-md-8">
             <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                   <label>Nome do produto:<span style="color:red">*</span></label>
                   <input placeholder="Nome do item"  value="<?=$nome_item;?>" type="text"  name="nome_item" class="form-control">
                 </div>
               </div>
                  </div>
                  <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label>Preço:<span style="color:red">*</span></label>
                  <input type="text" value="<?=$preco_item;?>" data-mask="#.##0,00" data-mask-reverse="true" maxlength="11" onkeypress="return formatar_moeda(this, '.', ',', event);" name="preco_item" class="form-control" placeholder="R$ 0,00" />
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-md-12">
            <div class="form-group">
             <label>Descrição do produto:</label>
             <textarea placeholder="Escreva uma descrição do item..." style="resize:none;" name="descricao_item" class="form-control" rows="2"><?=$descricao_item;?></textarea>
           </div>
           </div>
            </div>
            <div class="row">
            <div class="col-md-12">
            <div class="form-group">
             <label>Quais dias você vende este produto?</label>
             <div class="flex w-full dias-produto flex-row" style="border: 1px solid; border-color: #D9D9D9">
             <div class="m-3 icheck-material-green">
						<input type="checkbox" name="dia_prod" value="todos_checked" id="op_todos" />
			             <label for="op_todos">Todos</label>
			            </div>  
                     
                
                        
             <div class="m-3 icheck-material-green">
						    <input type="checkbox"  class="dias_prod" name="dia_prod" value="domingo" id="op_domingo" />
			             <label for="op_domingo">Domingo</label>
			            </div>

            <div class="m-3 icheck-material-green">
						<input type="checkbox"  class="dias_prod"  name="dia_prod" value="segunda" id="op_segunda" />
			          <label for="op_segunda">Segunda</label>
			      </div>

            <div class="m-3 icheck-material-green">
				  <input type="checkbox" class="dias_prod" name="dia_prod"  value="terca" id="op_terca" />
			    <label for="op_terca">Terça</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" class="dias_prod" name="dia_prod" value="quarta" id="op_quarta" />
			    <label for="op_quarta">Quarta</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" class="dias_prod" name="dia_prod" value="quinta" id="op_quinta" />
			    <label for="op_quinta">Quinta</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" class="dias_prod" name="dia_prod"  value="sexta" id="op_sexta" />
			    <label for="op_sexta">Sexta</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" class="dias_prod" name="dia_prod" value="true" id="op_sabado" />
			    <label for="op_sabado">Sábado</label>
			</div>
        
                    <?php
                  
                

        ?>
          <script>
               

                      let qt =  $('.dias_prod').length;
                      let checkBox =     $('.dias_prod');
           
                      for(let i=0;i<qt;i++){
                        
                        if("<?=$dia_semana?>".includes($(checkBox[i]).val())){                       
                          $(checkBox[i]).prop('checked', true);
                        }
                    }


                 


                  </script>
</div>
</div>
          </div>
            </div>

        
           </div>
           
         
       </div><!-- End form-group -->
  
     <br/>
     <div class="form-group indent_title_in">
    
    <h3>Categorias, Tipos e Adicionais:</h3>
    <p>Selecione a categoria, tipos e adicionais ao seu produto.</p>
   </div>

                <div class="row">

         

                <div class="col-md-12">
                <div class="form-group">
                    <label><span style="color: red;"></span> Categoria</label>        
                    <select id="categoria_produto" data-url="<?=$site?>cadastros/"data-idprod="<?=$id?>" class="form-control" name="id_cat">
                            <?php
                            
                            $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid and id = :idcatpro", "userid={$userlogin['user_id']}&idcatpro={$id_cat}");
                            $categoriaProd = $lerbanco->getResult()[0];                          
                            $variaveloption = "<option value=\"{$categoriaProd['id']}\">{$categoriaProd['nome_cat']}</option>";
                          
                            $lerbanco->ExeRead("ws_cat", "WHERE user_id = :userid", "userid={$userlogin['user_id']}");
                            if (!$lerbanco->getResult()):
                            echo "<option value=\"\">Adicione uma categoria</option>";
                            else:
                            $lerbanco->ExeRead('ws_cat', "WHERE user_id = :userid AND id != :idcatt", "userid={$userlogin['user_id']}&idcatt={$categoriaProd['id']}");
                            echo $variaveloption;
                            foreach ($lerbanco->getResult() as $cat):
                                extract($cat);
                                echo "<option value=\"{$id}\">{$nome_cat}</option>";
                            endforeach;
                           
                            endif;
                             ?>
                         </select>
                    
                    
                 </div>
                 </div>

                 <div class="col-md-12">
                    <div id="title_tipo" class="indent_title_in">
                        <h3>Tipos de Adicionais</h3>
                    </div>
                          
                
                 
                <div class="form-group">
                    <div id="container_tipos" class="flex flex-row w-full">
                       
    
                    </div>
                    
                 </div>

            </div>

            <div class="col-md-12">
                    
                <div class="form-group">           
                    <div id="container_adicionais">
           
                    </div>                         
                </div>

            </div>

             
</div>

           

 
 </div><!-- End strip_menu_items -->

 </form>
 <div class="form-group">
 
 
 <div class="col-md-12">
              <div class="flex flex-row justify-end">
                 
            
                  <div style="padding-right:10px" class="flex">
                 
                      <button  data-idprod="<?=$idprod?>" data-url="<?=$site."cadastros"?>" id="salvar_produto" style="background-color: #00BB07;border-radius:3px !important"class="btn_1 btn_s btn-success"  name="sendAddBairro" value="Salvar" type="submit">Salvar</button>
                
                    </div> 

                  <div style="padding-right:10px" class="flex">
                      <button id="btn_clonar" data-idprod="<?=$idprod?>" data-url="<?= $site?>cadastros"  style="background-color: #FFC000;border-radius:3px !important"class="btn_1 btn-success">Clonar</button>
                  </div>

                  <div style="padding-right:10px" class="flex">
                  <button data-url="<?=$site.'cadastros'?>" data-idprod="<?=$idprod?>"style="background-color: #A70000;border-color: #A70000;border-radius: 4px !important" type="button" class="btn_1 btn-delete deleta_prod">Excluir</span>
                      
                  </div>
                  </div>

               </div>
        
             </div>
          
         </div>
         </div><!-- End row -->

 
</section><!-- End section 2 -->
</div><!-- End wrapper_indent -->
<script type="module" src="<?= $site;?>cadastros/js/produtos/main.js"></script>
<!-- <script src="<?= $site;?>cadastros/js/produtos/editar.js"></script> -->
<script src="<?= $site;?>cadastros/js/datatables.min.js"></script>
 

