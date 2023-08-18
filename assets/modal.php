<?php
require('../_app/Config.inc.php');
require('../_app/Mobile_Detect.php');
$detect = new Mobile_Detect;
$site = HOME;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal</title>
    
    <link href="<?=$site;?>css/flowbite.min.css" type="text/css" rel="stylesheet">
    
    <!--Replace with your tailwind.css once created-->
     
    <link rel="stylesheet" type="text/css"  href="<?=$site;?>css/style.css"/>
  
    <link rel="stylesheet" type="text/css"  href="<?=$site;?>css/bootstrap.css"/>
     
    <link rel="stylesheet" type="text/css"  href="<?=$site;?>css/tailwind.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <!-- Define your gradient here - use online tools to find a gradient matching your branding-->
    <link href="<?= $site; ?>css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
    <script src="<?= $site; ?>css/x0popup-master/dist/x0popup.min.js"></script>
    <style>


.gradient {
    background: linear-gradient(90deg, #7233A1 0%, #8c52ff 100%);
  };
    </style>
  </head>
<body>
         <div class="relative w-full   max-h-full">
                  
        <div class="p-6">      
            <h3 id="msg_recover_1" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"></h3>
            <div id="cadastrar">
              <div class="main_title margin_mobile">
                <h2 class="nomargin_top">NUNCA FOI TÃO FÁCIL <strong style="color: #7233A1" >VENDER</strong> ONLINE</h2>
                <br />
                <p>
                 Garantia total de satisfação! Crie agora seu menu online e comece a vender. Você tem <b style="color: #7233A1" style="font-size: 25px;"><?=$texto['DiasDeTeste'];?></b> dias para testar.
               </p>
             </div>
             <div class="row">
               <div class="col-md-8 col-md-offset-2">
                 <form id="formCadastro" autocomplete="off" method="post">           
                  <div class="row">
                   <div class="col-md-4">
                    <div class="form-group">
                     <label for="nome_empresa">Nome da Loja</label>
                     <input maxlength="40" oninput="this.value = this.value.replace(/[^a-z-A-Z-0-9 ]/g, '')" type="text" autocomplete="off" id="nome_empresa" name="nome_empresa" class="form-control" required placeholder="Nome da Loja">
                   </div>
                 </div>

                 <div class="col-md-4">
                    <div class="form-group">
                     <label for="estados">Segmento</label>
                     <select name="segmento_empresa" class="form-control" >
                      <option value="">Selecione um Segmento</option>
                      <option value="1"><?=$texto['nomePlanoUm'];?></option>
                      <option value="2"><?=$texto['nomePlanoDois'];?></option>
                      <option value="3"><?=$texto['nomePlanoTres'];?></option>
              </select>    
                     </select>    
                   </div>
                 </div>

                 <div class="col-md-4">
                  <div class="form-group">
                  <label for="nome_empresa_link"><?=$site;?></label>
                   <input maxlength="30" oninput="this.value = this.value.replace(/[^a-z-0-9]/g, '')" style="type="text" autocomplete="off"  id="nome_empresa_link" name="nome_empresa_link" class="form-control" required placeholder="/ Use minúsculas e underline.">
                   <a class="btn btn-success btn-xs" id="verificarDisponibilidadeLink" style="color: #ffffff;cursor: pointer;margin-top: 5px;"><strong> verificar Disponibilidade </strong></a>
                 </div>
               </div>
             </div><!-- End row  -->
             <div class="row">

                
                <div class="col-md-2">
                    <div class="form-group">
                     <label for="cep">CEP</label>
                     <input required class="form-control" name="cep_empresa" id="cep">     
                      
                   </div>
                 </div>
                 <div class="col-md-5">
                    <div class="form-group">
                     <label for="end_bairro_empresa">Bairro</label>
                     <input oninput="this.value = this.value.replace(/[^a-z-A-Z ]/g, '')" maxlength="30" type="text" autocomplete="off" id="end_bairro_empresa" required name="end_bairro_empresa" class="form-control" placeholder="Bairro...">
                   </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                     <label for="end_rua_n_empresa">Rua / Nº</label>
                     <input oninput="this.value = this.value.replace(/[^a-z-A-Z-0-9 ]/g, '')" maxlength="50" type="text" autocomplete="off" id="end_rua_n_empresa" required name="end_rua_n_empresa" class="form-control" placeholder="Rua e Nº">
                   </div>
                  </div>
              
            </div><!-- End row  -->
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                     <label for="estados">Estado</label>
                     <select required class="form-control" name="end_uf_empresa" id="estados">     
                     </select>    
                   </div>
                 </div>
                 <div class="col-md-6">
                  <div class="form-group">
                   <label for="cidades">Cidade</label>
                   <select required class="form-control" name="cidade_empresa" id="cidades">    
                   </select>
                 </div>
                </div>

             
            </div><!-- End row  -->
            <hr />
            <div class="row">
             <div class="col-md-4 col-sm-5">
              <div class="form-group">
               <label for="user_name">Nome</label>
               <input type="text" maxlength="50" required autocomplete="off" class="form-control" id="user_name" name="user_name" placeholder="Seu Nome">
             </div>
            </div>
            <div class="col-md-4 col-sm-3">
              <div class="form-group">
               <label for="user_lastname">Sobrenome</label>
               <input type="text" maxlength="50" required autocomplete="off"  class="form-control" id="user_lastname" name="user_lastname" placeholder="Seu Sobrenome">
             </div>
            </div>

            <div class="col-md-4 col-sm-3">
                <div class="form-group">
                 <label for="user_lastname">CPF</label>
                 <input type="text" required autocomplete="off"  class="form-control" id="cpf_user" name="cpf_user" placeholder="CPF">
               </div>
              </div>
            
            </div>
            <div class="row">
             <div class="col-md-6 col-sm-6">
              <div class="form-group">
               <label for="user_email">E-mail:</label>
               <input maxlength="30" type="email" required autocomplete="off" id="user_email" name="user_email" class="form-control " placeholder="E-mail">
             </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
               <label for="user_telefone">Telefone para contato:</label>
               <input type="tel" required autocomplete="off"  id="user_telefone" name="user_telefone" class="form-control" placeholder="(99) 99999-9999" data-mask="(00) 00000-0000" maxlength="15">
             </div>
            </div>
            </div>
            <div class="row">
             <div class="col-md-6">
              <div class="form-group">
               <label for="user_password">Senha</label>
               <input type="password" required autocomplete="off" class="form-control" placeholder="*******" name="user_password"  id="user_password" />
             </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
               <label for="user_password2">Repita a Senha</label>
               <input type="password" required autocomplete="off"  class="form-control" placeholder="*******" name="user_password2"  id="user_password2" />
             </div>
            </div>
            </div><!-- End row  -->
            <div class="form-group">
              <label>Escolha seu plano</label>
              <select style="pointer-events: none;background-color: #dddbdb;" name="user_plano" class="form-control" >
                <option value="">Selecione um Plano</option>
                <option value="1"><?=$texto['nomePlanoUm'];?></option>
                <option value="2"><?=$texto['nomePlanoDois'];?></option>
                <option value="3"><?=$texto['nomePlanoTres'];?></option>
              </select>
            </div>
            
            <div id="pass-info" class="clearfix"></div>
            <!--
            <div class="row">
             <div class="col-md-6">
               <label>Leia os <a href="#0">termos e condições.</a></label>
             </div>
            </div>End row  -->
            <hr style="border-color:#ddd;">
            
            <div class="flex items-center justify-center">
              <input type="hidden" name=" empresa_status" value="true">
              <button type="button" id="cadastrarUser" class="max-[900px]:w-full w-2/2 mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-20 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out gradient">Cadastrar Minha Loja</button>
            </div>
           
            </div><!-- End col  -->
            </div><!-- End row  -->
            </form>
            </div><!-- End container  -->
            <!-- End Content =============================================== -->
          </div>
        </div>
      </div>
      
        <script src="<?=$site;?>/js/jquery-2.2.4.min.js"></script>
        <script src="<?=$site;?>/js/flowbite.min.js"></script>
        <script src="<?=$site;?>/js/common_scripts_min.js"></script>
        <script src="<?=$site;?>/js/bootstrap.min.js"></script>
        <script src="<?=$site;?>/js/functions.js"></script>
        <script src="<?=$site;?>/assets/validate.js"></script>
        <script src="<?=$site;?>/js/jquery.mask.js"></script>    
        <script src="<?=$site;?>/js/modal-plano.js"></script> 

    <script type="text/javascript">


   

        // LOGIN
       // $(document).ready(function(){
      //    $("#cadastrarUser").click(function(){
      //     //formCadastro
      //     $(this).html('<i class="icon-spin5 animate-spin"></i> AGUARDE...');
      //     $(this).prop('disabled', true);
      
      //     $.ajax({
      //       url: '<?=$site;?>controlers/processaCadastroUser.php',
      //       method: 'post',
      //       data: $('#formCadastro').serialize(),
      //       success: function(data){
      //         if(data == "erro1"){
      //           x0p('Opsss', 
      //             'Preencha todos os campos!',
      //             'error', false);
      //           $('#cadastrarUser').html('Cadastrar Minha Loja');
      //           $('#cadastrarUser').prop('disabled', false);
      //         }else if(data == "erro2"){
      //           x0p('Opsss', 
      //             'O E-mail informado e inválido!',
      //             'error', false);
      //           $('#cadastrarUser').html('Cadastrar Minha Loja');
      //           $('#cadastrarUser').prop('disabled', false);
      //         }else if(data == "erro3"){
      //           x0p('Opsss', 
      //             'A senha informada deve ter no mínimo 8 caracteres!',
      //             'error', false);
      //           $('#cadastrarUser').html('Cadastrar Minha Loja');
      //           $('#cadastrarUser').prop('disabled', false);
      //         }else if(data == "erro4"){
      //           x0p('Opsss', 
      //             'As senhas não coincidem!',
      //             'error', false);
      //           $('#cadastrarUser').html('Cadastrar Minha Loja');
      //           $('#cadastrarUser').prop('disabled', false);
      //         }else if(data == "erro5"){
      //           x0p('Opsss', 
      //             'Esse link não está disponível!',
      //             'error', false);
      //           $('#cadastrarUser').html('Cadastrar Minha Loja');
      //           $('#cadastrarUser').prop('disabled', false);
      //         }else if(data == "erro6"){
      //           x0p('Opsss', 
      //             'Já existe uma conta com esses dados!',
      //             'error', false);
      //           $('#cadastrarUser').html('Cadastrar Minha Loja');
      //           $('#cadastrarUser').prop('disabled', false);
      //         }else if(data == "erro0"){
      //           x0p('Opsss', 
      //             'OCORREU UM ERRO AO CADASTRAR!',
      //             'error', false);
      //           $('#cadastrarUser').html('Cadastrar Minha Loja');
      //           $('#cadastrarUser').prop('disabled', false);
      //         }else{
      //          x0p('Sucesso!', 
      //           'Agora você pode fazer login.', 
      //           'ok', false);
      //          $('#cadastrarUser').html('Cadastrar Minha Loja');
      //          $('#cadastrarUser').prop('disabled', false);
      //        }
             
      //      }
      //    });
      
      //   }); 
      //  });
      </script>
      
      
      <script type="text/javascript">
        $(document).ready(function(){
          $('#verificarDisponibilidadeLink').click(function(){
            var linkuser = $('#nome_empresa_link').val();
      
            if(linkuser == ''){
              x0p('Opss...', 
                'Antes preencha o campo!',
                'error', false);
            }else{
      
              $.ajax({
                url: '<?=$site?>controlers/processaverificadisponibilidadelink.php',
                method: 'post',
                data: {'linkuser' : linkuser},
                success: function(data){
      
                  if(data == 'true'){
                    x0p('Que pena! 😔', 
                      'Esse link não está disponível!',
                      'error', false);
                  }else{
                    $('#nome_empresa_link').val(data);
                    x0p('Muito bom! 😍', 
                      '<?=$site;?>'+data+' está disponível!', 
                      'ok', false);
                  }          
                }
              });
      
            }
          });
        });
      </script>
      
  <!--     
      
      <script language="JavaScript">
        window.onload = function() {
          document.addEventListener("contextmenu", function(e){
            e.preventDefault();
          }, false);
          document.addEventListener("keydown", function(e) {
                  //document.onkeydown = function(e) {
                    // "I" key
                    if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                      disabledEvent(e);
                    }
                    // "J" key
                    if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                      disabledEvent(e);
                    }
                    // "S" key + macOS
                    if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                      disabledEvent(e);
                    }
                    // "U" key
                    if (e.ctrlKey && e.keyCode == 85) {
                      disabledEvent(e);
                    }
                    // "F12" key
                    if (event.keyCode == 123) {
                      disabledEvent(e);
                    }
                  }, false);
          function disabledEvent(e){
            if (e.stopPropagation){
              e.stopPropagation();
            } else if (window.event){
              window.event.cancelBubble = true;
            }
            e.preventDefault();
            return false;
          }
        };
      </script> -->
  
  
  <script type="text/javascript"> 
  
    $('document').ready(function () {
  
      $.getJSON('<?=$site;?>estados_cidades.json', function (data) {
  
        var items = [];
        var options = '<option value="">Escolha um estado</option>';  
  
        $.each(data, function (key, val) {
          options += '<option value="' + val.sigla + '">' + val.sigla + '</option>';
        });         
        $("#estados").html(options);        
  
        $("#estados").change(function () {        
  
          var options_cidades = '<option value="<?=(!empty($cidade_empresa) ? $cidade_empresa : "");?>"><?=(!empty($cidade_empresa) ? $cidade_empresa : "Escolha uma Cidade");?></option>';
        var str = "";         

        $("#estados option:selected").each(function () {
          str += $(this).text();
        });

        $.each(data, function (key, val) {
          if(val.sigla == str) {              
            $.each(val.cidades, function (key_city, val_city) {
              options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
            });             
          }
        });
  
          $("#cidades").html(options_cidades);
  
        }).change();    
  
      });
  
    });
  
  </script>
  
  <script>
  
    $('#dinheiro').mask('#.##0,00', {reverse: true});
    $('.telefone').mask('(00) 0 0000-0000');
    $('.estado').mask('AA');
    $('.cep').mask('00-000.000');
    $('.cpf').mask('000-000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.rg').mask('00.000.000-0');
    $('.cep').mask('00000-000');
    $('.dataNascimento').mask('00/00/0000');
    $('.placaCarro').mask('AAA-0000');
    $('.horasMinutos').mask('00:00');
    $('.cartaoCredito').mask('0000 0000 0000 0000');
    $('.numero').mask('#########0');
    $('.descontoporcentagem').mask('##0');
  </script>
  </body>
 
</html>

 