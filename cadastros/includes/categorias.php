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
     
  .panel{
    border :0 !important;
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
 
	

 
				<div  style="padding-right: 0px;" class="container-main-page flex h-full justify-center items-center p-4">
					 
					
							
							<div style="background-color:#ffffff;color:black" class="container p-0 m-0">
									
							<div  class="config-header w-full text-bold text-center text-white">
											<p>Categoria de Produtos</p>
									</div>	
							<div id="sendempresa"></div>
              
 
								<section class="m-5 section-config" id="section-1">
                <div class="row">
                <div class="col-md-12"> 
                    <div class="indent_title_in">
                    <h3>Cadastrar Categoria</h3>
                          <p>
                          Cadastre categorias,tamanhos,tipos e adicionais de sua escolha.
                          </p>
                        <br />
                  </div>

    <div id="msg-1"></div>
    <div class="mb-0 panel-group" id="accordion-1">
				<div class="panel panel-default">
					<div style="background-color: #7233A1;color: #ffffff;" class="panel-heading">
						<h4 data-toggle="collapse" data-parent="#accordion-1" href="#collapse-cat" class="panel-title cat expand">
							<div class="right-arrow pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
							<a style="color: #ffffff;" href="#">Clique aqui para cadastrar uma categoria</a>
						</h4>
					</div>
          <div id="collapse-cat"  style="visibility:unset" class="panel-collapse  collapse">
                <form data-url="<?=$site.'cadastros'?>" id="cadCategoria" class="" id="formaddacate" method="post">
 <br />

  <div class="row">
        <div class="col-md-12 col-sm-6">
              <div  class="form-group">
         
 
              <label><span style="color: red;"></span> Categoria:</label>
           
              
              <input type="text" name="nome_cat" class="form-control" placeholder="Nome da categoria...">
              <input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>" />
          
  </div>
</div>


</div>
 

    
   
<input id="submitcat" name="cadastrarcategoria" value="Cadastar" type="submit" style="background-color: #00BB07;"class="btn_1 btn-success"></input>		
  </br>
  </br>
 
  <hr class="line-hr"/>
  </br>
 
  
 
      <label for="search_categorias">Buscar Categoria</label>						
      <input type="text" id="search-categorias"  class="form-control" placeholder="Digite o nome da categoria">

  </form>

  
          <br />
          
       
          <div class="overflow-x-auto">
            <div id="msg-cat"></div>
            <table id="categorias" data-url="<?=$site.'cadastros'?>" class="border w-full text-left text-gray-500 dark:text-gray-400">
 
               <thead style="background:#7232A0;" class="text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr class="text-center">
                    <th id="nome_cat" style="padding:25px;" scope="col" class="text-center cursor-pointer px-6 py-3">Categoria</th>
                       
                 
                    <th  class="text-center px-6 py-3" scope="col">Excluir</th>              
                  </tr>
                </thead>
                
                      
                    
                 
                  
               
            </table>
          </div>
                  </div>

      </div>

                  </br>
 <!-- Tipos de Adicionais -->


 
 <div class="mb-0 panel-group" id="accordion-1">
				<div class="panel panel-default">
					<div style="background-color: #7233A1;color: #ffffff;" class="panel-heading">
						<h4 data-toggle="collapse" data-parent="#accordion-1" href="#collapse-tad" class="panel-title cat expand">
							<div class="right-arrow pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
							<a style="color: #ffffff;" href="#">Clique aqui para cadastrar um tipo de adicional</a>
						</h4>
					</div>
          <div id="collapse-tad"  style="visibility:unset" class="panel-collapse collapse">
                <form data-url="<?= $site.'cadastros'?>" class="" id="cadTipoAdicional" method="post">
        <br />
 
 
  <div class="row">
  <div class="col-md-12 col-sm-6">
        <div class="form-group">
                    <div id="msg-2"></div>
                    <label for="categoria">Categoria</label>						
                    <select class="list-categoria form-control" name="id_cat" id="categoria">   
                    <?php
                   
                  ?>  
                    </select>
               
                  </div>
                  </div>
        <div class="col-md-6 col-sm-6">
              <div class="form-group">
              <label><span style="color: red;"></span> Tipo de adicional:</label>
           
              
              <input type="text" oninput="this.value = this.value.toUpperCase()" name="nome_adicional" class="form-control" placeholder="Digite um nome para o tipo de adicional">
              <input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>" />
              <input type="hidden" name="cadastratipoadicional" value="true" />
          </div>
        </div>

<div class="col-md-6 col-sm-6">
<div class="form-group">
  <label class="control-label">Quantidade:</label>
 
    
   
    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  value="0" step="1" min="1" max="99" name="quantidade" class="form-control" placeholder="Digite uma quantidade do adicional obrigatória">
 
</div>

</div>
 


</div>
 
 
 
    
   
<button id="" style="background-color: #00BB07;"class="btn_1 btn-success">Cadastrar</button>		
 
 
  </form>
          <br />
          <br />
        
  <hr class="line-hr"/>
  </br>
 
    <div class="row">
    <div class="col-md-6">
      <label for="search_tipo_adicional">Buscar Tipos de Adicionais</label>						
      <input type="text" id="search_tipo_adicional"  class="form-control" placeholder="Digite o nome do tipo de adicional">
  </div>

  <div class="col-md-6">
  <div class="form-group">
                   
                    <label for="categoria">Categoria</label>						
                    <select class="list-categoria form-control" name="id_cat" id="categoria-busca-tipo">   
                   
                    </select>
               
                  </div>
  </div>
  </div>
    </br>
      </br>   
      <div class="overflow-x-auto">
      <div id="msg-tip"></div>
            <table id="tipo_adicionais" class="border w-full text-left text-gray-500 dark:text-gray-400">
 
               <thead style="background:#7232A0;" class="text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr class="text-center">
                  <th  class="text-center cursor-pointer px-6 py-3" scope="col">Categoria</th>      
                    <th style="padding:25px;" scope="col" class="text-center cursor-pointer  px-6 py-3">Tipo Adicional</th>
                    <th  class="text-center cursor-pointer  px-6 py-3" scope="col">Quantidade</th>               
              
                    <th  class="text-center px-6 py-3" scope="col">Excluir</th>              
                  </tr>
                </thead>          
                    
                    
                    
                 
            </table>
          </div>
                  </div>

      </div>

    </div><!-- End Tipos de Adicionais--> 
                  </br>


      <!-- Cadastrar Adicionais -->


 
 <div class="mb-0 panel-group" id="accordion-1">
				<div class="panel panel-default">
					<div style="background-color: #7233A1;color: #ffffff;" class="panel-heading">
						<h4 data-toggle="collapse" data-parent="#accordion-1" href="#collapse-cad" class="panel-title cat expand">
							<div class="right-arrow pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
							 <a style="color: #ffffff;" href="#">Clique aqui para cadastrar um adicional</a> 
						</h4>
					</div>
          <div id="collapse-cad"  style="visibility:unset" class="panel-collapse  collapse">
                <form data-url="<?=$site?>cadastros" class="" id="cadAdicionais" method="post">
        <br />
 
 
  <div class="row">
  <div class="col-md-12 col-sm-6">
        <div class="form-group">
      
                    <label for="categoria">Categoria</label>						
                    <select class="list-categoria form-control" name="categoria-adicional" id="categoria_adicionais">   
                   
                    </select>
               
                  </div>
                  </div>

                  <div class="col-md-12 col-sm-6">
        <div class="form-group">
      
                    <label for="categoria">Tipo de Adicional</label>						
                    <select class="list-tipo-adcionais form-control" name="tipo-adicionais" id="adicionais">   
                    <option value=>Selecione um Tipo de Adicional</option>
                    </select>
               
                  </div>
                  </div>
        <div class="col-md-6 col-sm-6">
              <div class="form-group">
              <label><span style="color: red;"></span>Adicionais:</label>
           
              
              <input type="text" name="nome_adicional" class="form-control" placeholder="Digite o nome do adicional">
              <input type="hidden" name="user_id" value="<?=$userlogin['user_id'];?>" />
          
          </div>
        </div>



<div class="col-md-6 col-sm-6">
<div class="form-group">
  <label class="control-label">Valor do adicional:</label>
 
    
   
    <input type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="valor_adicional" class="form-control" placeholder="Digite um valor para seu adicional">
 
</div>

</div>
 
<div class="col-md-12 col-sm-6">
<div class="form-group">
  <label class="control-label">Descrição do adicional:</label>    
   
    <textarea rows="5" cols="250" name="desc_adicional" class="form-control" placeholder="Digite uma descrição do adicional"></textarea>
 
</div>

</div>

</div>
 
 
 
    
   
<button id="submitbtncupom" style="background-color: #00BB07;"class="btn_1 btn-success">Cadastrar</button>		
 
 
  </form>
  <br />
      
  <hr class="line-hr"/>
          <br />
         
      <div class="row">  
        <div class="col-md-4">
          <label for="search_adicionais">Buscar Adicional</label>						
          <input type="text" id="search_adicionais"  class="form-control" placeholder="Digite o nome do adicional">
          <br />
  </div>
  <div class="col-md-4">
  <div class="form-group">
      
      <label for="categoria">Categoria</label>						
      <select class="list-categoria form-control" name="categoria-adicional" id="categoria_adicionais_busca">   
     
      </select>
 
    </div>
  </div>
  <div class="col-md-4">
  <div class="form-group">
      
      <label for="categoria">Tipo de Adicional</label>						
      <select class="form-control" name="tipo-adicionais" id="adicionais-busca">   
      <option value=>Selecione um Tipo de Adicional</option>
      </select>
 
    </div>
  </div>

  </div>
          <br />   
      <div class="overflow-x-auto">
      <div id="msg-add"></div>
            <table id="cad_adicionais" class="border w-full text-left text-gray-500 dark:text-gray-400">
 
               <thead style="background:#7232A0;" class="text-white md:text-md\[20px]  text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr class="text-center">
                    <th style="padding:25px;" scope="col" class="cursor-pointer  text-center px-6 py-3">Categoria</th>
                    <th  class="text-center cursor-pointer px-6 py-3" scope="col">Tipo Adicional</th>                     
                    <th  class="text-center cursor-pointer px-6 py-3" scope="col">Adicional</th>                          
                    <th  class="text-center cursor-pointer px-6 py-3" scope="col">Descrição</th>  
                    <th  class="text-center cursor-pointer px-6 py-3" scope="col">Valor</th>    
                    <th  class="text-center cursor-pointer px-6 py-3" scope="col">Excluir</th>             
                  </tr>
                </thead>
                 
            </table>
          </div>
                  </div>

      </div>

    </div><!-- End Cadastrar Adicionais--> 



			</div><!-- End col  -->
	 
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

<script>

$( function() {


		
$( "#datepicker" ).datepicker();

$('#accordion-1 .cat').on('click', function(e){
  jQuery('#accordion-1 .collapse').collapse('hide');
})			
} );
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
<script type="module" src="<?= $site;?>cadastros/js/main.js"></script>
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