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

?>
<script src="<?=$site;?>js/MSFmultiSelect.js"></script>

<style type="text/css">
  .msf_multiselect_container .msf_multiselect {
    border: 1px solid #e4e4e4;
    list-style-type:none;
    margin: 0;
    padding: 0;
    position: absolute;
    z-index: 240;
    width: 92%;
  }

  

#img-container{
      display:none;
    }

    .btn-delete:hover{
      text-decoration-line: none !important;
  background: #d19898 !important
    }

 
  .msf_multiselect li:hover, .sb_multiselect li:active, .sb_multiselect li:focus{
    background-color: #e5e5e5;
  }
  .msf_multiselect li.active{
    background-color: #e5e5e5;
      
  }
  .msf_multiselect li{
    padding-left: 4px;
    background-color: #ffffff;
    cursor: pointer;
  }
  .msf_multiselect_container textarea{
    resize: none;
    padding-left: 2px;
    padding-top: 2px;
    overflow: auto;
  }
  .msf_multiselect_container .msf_multiselect{
    height: 200px;
    overflow: auto;
    background-color: white;
    display: grid;
    text-align: left; 
  }
  .msf_multiselect label{
    display: block;
    margin-bottom: 1px;
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

  :focus-visible {
  outline: none !important;
}

</style>



<div  style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
	
<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
                                    <div  class="config-header w-full text-bold text-center text-white">
                                                    <p>Cadastro de Produtos</p>
                                            </div>	
                                   
        
        
                                        <section class="m-5 section-config" id="section-1">
 
    <div class="indent_title_in">
    
      <h3>Cadastrar produto:</h3>
      <p>Cadastre os produtos que serão exibidos em sua loja!</p>
    </div>
    <?php
    // require('includes/configItens.php');
    ?>
    <form method="post"  id="cadProduto" enctype="multipart/form-data">
      <div class="wrapper_indent">
       
        
          <div class="row">
            <div class="col-md-4">
              <div class="flex flex-col text-center">
              <div class="menu-item-pic">
                <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap:wrap;justify-content:center;background-color:#ffffff;background: #7232A0; height:340px" class="w-full box">
                  <input type="file" name="img_item" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" multiple />
                  <label for="file-5"><img src="<?=URL_IMAGE.'img/upload_product.png'?>"/></label>  
                </div>
                  </div>
                <!-- <div class="w-full" style="background:#7233A1; color:white;margin 0 auto;">
                <label for="file-5">Clique aqui para adicionar uma foto do produto</label>
                </div> -->
            </div>
            </div>
       

            <div class="col-md-8">
             <div class="row">
               <div class="col-md-12">
                 <div class="form-group">
                   <label>Nome do produto:</label>
                   <input placeholder="Nome do item" required type="text"  name="nome_item" class="form-control">
                 </div>
               </div>
                  </div>
                  <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label>Preço:</label>
                  <input required type="text" data-mask="#.##0,00" data-mask-reverse="true" maxlength="11" onkeypress="return formatar_moeda(this, '.', ',', event);" name="preco_item" class="form-control" placeholder="R$ 0,00" />
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-md-12">
            <div class="form-group">
             <label>Descrição do produto:</label>
             <textarea placeholder="Escreva uma descrição do item..." style="resize:none;" name="descricao_item" required class="form-control" rows="2"></textarea>
           </div>
           </div>
            </div>
            <div class="row">
            <div class="col-md-12">
            <div class="form-group">
             <label>Quais dias você vende este produto?</label>
             <div class="flex w-full flex-row" style="border: 1px solid; border-color: #D9D9D9">
             <div class="m-3 icheck-material-green">
						<input type="checkbox" name="todos_checked" value="true" id="op_todos" />
			             <label for="op_todos">Todos</label>
			            </div>   
             
             <div class="m-3 icheck-material-green">
						<input type="checkbox" name="domingo" value="true" id="op_domingo" />
			             <label for="op_domingo">Domingo</label>
			            </div>

            <div class="m-3 icheck-material-green">
						<input type="checkbox" name="segunda" value="true" id="op_segunda" />
			    <label for="op_segunda">Segunda</label>
			</div>

            <div class="m-3 icheck-material-green">
				  <input type="checkbox" name="terca" value="true" id="op_terca" />
			    <label for="op_terca">Terça</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" name="quarta" value="true" id="op_quarta" />
			    <label for="op_quarta">Quarta</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" name="quinta" value="true" id="op_quinta" />
			    <label for="op_quinta">Quinta</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" name="sexta" value="true" id="op_sexta" />
			    <label for="op_sexta">Sexta</label>
			</div>
 

            <div class="m-3 icheck-material-green">
						<input type="checkbox" name="sabado" value="true" id="op_sabado" />
			    <label for="op_sabado">Sábado</label>
			</div>
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
                    <select id="categoria_produto" class="list-categoria form-control" name="id_cat">
                    
                    </select>
                 </div>
                 </div>
                 <div class="col-md-12">
                    <div style="display:none" id="title_tipo" class="indent_title_in">
                        <h3>Tipos de Adicionais</h3>
                    </div>
                <div class="form-group">
                    <div style="display:none" id="container_tipos" class="flex flex-row w-full">

                    </div>
                    
                 </div>

            </div>

            <div class="col-md-12">
                    
                <div class="form-group">           
                    <div id="container_adicionais"></div>                         
                </div>

            </div>
</div>

           

 
 </div><!-- End strip_menu_items -->
 <hr /> 

 <div class="form-group">
           <div class="add_more_cat">
             <input type="hidden" name="disponivel" value="1">
           
             <input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>">
             <input type="submit" class="btn_1" value="ADICIONAR ITEM" name="add_item" />
           </div>
         </div>
         </div><!-- End row -->
</form>
 
</section><!-- End section 2 -->
</div><!-- End wrapper_indent -->
<script type="module" src="<?= $site;?>cadastros/js/main.js"></script>
  <script src="<?= $site;?>cadastros/js/datatables.min.js"></script>

<script>
  var select=new MSFmultiSelect(
    document.querySelector('#multiselect'),
    {

      onChange:function(checked,value,instance){
        console.log(checked,value,instance);


      },



      selectAll:true,  
      appendTo:'#myselect',
    //readOnly:true
}
);
</script>


