 
 (function ($) { 

var close = window.parent.$('#btn_container').children()[0];
$('#cep').mask('00-000.000');
$('#cpf_user').mask('000.000.000-00');
$('#user_telefone').mask('(00) 00000-0000');



$("#user_email").on('blur', function(){

  if($(this).val().trim() != ""){
    if($(this).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null){
      x0p('Opsss', 
            'O Email informado é inválido',
            'error', false);
            $(this).val("") ;
      return false;
    }
  }
})
 


$("#cadastrarUser").click(function(){
  //formCadastro
  // $(this).html('<i class="icon-spin5 animate-spin"></i> AGUARDE...');
  // $(this).prop('disabled', true);

  $.ajax({
    url: '../controlers/processaCadastroUser.php',
    method: 'post',
    data: $('#formCadastro').serialize(),
    success: function(data){
      var res = JSON.parse(data);
      if(!res.success && res.message){
        x0p('Opsss', 
          res.message,
          'error', false);
        $('#cadastrarUser').html('Cadastrar Minha Loja');
        $('#cadastrarUser').prop('disabled', false);
      }else if(res.success){
        x0p('Sucesso!', 
            res.message, 
            'ok', false);
           $('#cadastrarUser').html('Cadastrar Minha Loja');
           $('#cadastrarUser').prop('disabled', false);
            setTimeout(function(){
                window.parent.location.replace(res.url);
            },2000)
         

      }
    //   }else if(data == "erro2"){
    //     x0p('Opsss', 
    //       'O E-mail informado e inválido!',
    //       'error', false);
    //     $('#cadastrarUser').html('Cadastrar Minha Loja');
    //     $('#cadastrarUser').prop('disabled', false);
    //   }else if(data == "erro3"){
    //     x0p('Opsss', 
    //       'A senha informada deve ter no mínimo 8 caracteres!',
    //       'error', false);
    //     $('#cadastrarUser').html('Cadastrar Minha Loja');
    //     $('#cadastrarUser').prop('disabled', false);
    //   }else if(data == "erro4"){
    //     x0p('Opsss', 
    //       'As senhas não coincidem!',
    //       'error', false);
    //     $('#cadastrarUser').html('Cadastrar Minha Loja');
    //     $('#cadastrarUser').prop('disabled', false);
    //   }else if(data == "erro5"){
    //     x0p('Opsss', 
    //       'Esse link não está disponível!',
    //       'error', false);
    //     $('#cadastrarUser').html('Cadastrar Minha Loja');
    //     $('#cadastrarUser').prop('disabled', false);
    //   }else if(data == "erro6"){
    //     x0p('Opsss', 
    //       'Já existe uma conta com esses dados!',
    //       'error', false);
    //     $('#cadastrarUser').html('Cadastrar Minha Loja');
    //     $('#cadastrarUser').prop('disabled', false);
    //   }else if(data == "erro0"){
    //     x0p('Opsss', 
    //       'OCORREU UM ERRO AO CADASTRAR!',
    //       'error', false);
    //     $('#cadastrarUser').html('Cadastrar Minha Loja');
    //     $('#cadastrarUser').prop('disabled', false);
    //   }else{
    //    x0p('Sucesso!', 
    //     'Agora você pode fazer login.', 
    //     'ok', false);
    //    $('#cadastrarUser').html('Cadastrar Minha Loja');
    //    $('#cadastrarUser').prop('disabled', false);
    //  }
     
   }
 });

}); 





function isCpf(cpf) {
   
  cpf = cpf.replace('/[^0-9]+/g,', "");
  var exp = /\.|-/g;

  var exp = /\.|-/g;
  cpf = cpf.toString().replace(exp, "");
  var digitoDigitado = parseInt(cpf.charAt(9) + cpf.charAt(10));
  var soma1 = 0, soma2 = 0;
  var vlr = 11;
  for (var i = 0; i < 9; i++) {
      soma1 += parseInt(cpf.charAt(i) * (vlr - 1));
      soma2 += parseInt(cpf.charAt(i) * vlr);
      vlr--;
  }
  soma1 = (((soma1 * 10) % 11) === 10 ? 0 : ((soma1 * 10) % 11));
  soma2 = (((soma2 + (2 * soma1)) * 10) % 11);
  if (cpf === "11111111111" || cpf === "22222222222" || cpf === "33333333333" || cpf === "44444444444" || cpf === "55555555555" || cpf === "66666666666" || cpf === "77777777777" || cpf === "88888888888" || cpf === "99999999999" || cpf === "00000000000") {
      var digitoGerado = null;
  } else {
      var digitoGerado = (soma1 * 10) + soma2;
  }
  if (digitoGerado !== digitoDigitado) {
      return false;
  }
  return true;
}

$("#cpf_user").on('blur', function(){
 

  if($(this).val().trim().match((/^\d{2}[0-9]/))!=null){
    if($(this).val().trim().match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) == null || !isCpf($(this).val().trim())){ 
          x0p('Opsss', 
          'O CPF informado é inválido!',
          'error', false);
          $(this).val("") ;
          return;            
    
    } 
  }

})


$('#cep').on('blur', function(e){   
  
      

      $(this).val($(this).val().replace(/[^0-9]+/g, ''));
      const value = $(this).val();
      const url = `https://viacep.com.br/ws/${value}/json/`;      
      
      $.ajax({
        url: url,
        method: 'get',       
        success: function(data){
              if(data.erro){
                x0p('Opsss', 
                'O CEP informado é inválido!',
                'error', false);
                $('#cep').val("") ;
                return;
              }
              $('#end_bairro_empresa').val(data.bairro);
              $('#end_rua_n_empresa').val(data.logradouro);
              $("[name='end_uf_empresa']").val(data.uf).change();
              $("[name='cidade_empresa']").val(data.localidade).change();

        }

        })
})

$('#cep').on('change', function(e){
  
  $('#end_bairro_empresa').val("");
  $('#end_rua_n_empresa').val("");
  $("[name='end_uf_empresa']").val("").change();
  $("[name='cidade_empresa']").val("").change();
})



$('#user_lastname').on('input', function(){


  $(this).val($(this).val().replace(/[^A-Za-zÀ-ú ]/i, ""));


})

$('#user_name').on('input', function(){

      $(this).val($(this).val().replace(/[^A-Za-zÀ-ú ]/i, ""));



})

$('body').on('opened', function(e){ 
 
  bodyStatus = e.detail.active;
  plano = e.detail.plano; 
  
 if (bodyStatus && plano){ 
      switch(plano){
        case 1:
          $("[name='user_plano']").val("1").change();
          break;
        case 2:
          $("[name='user_plano']").val("2").change();
          $("[name='user_plano']").css("pointer-events", "none");
          break;
        case 3:
          $("[name='user_plano']").val("3").change();
          $("[name='user_plano']").css("pointer-events", "none");
          break
        default:
          $("[name='user_plano']").val("").change();
          $("[name='user_plano']").css("pointer-events", "none");
          break;
        }
    
  
 }

 
 

 
})
 
 





 

$(close).on('click', function(){

    var inputs = $('#formCadastro .form-control');

    for(var i=0 ;i<inputs.length;i++) {
      if(inputs[i].tagName="SELECT"){
        $(inputs[i]).val("").change();
      }else{
        $(inputs[i]).val("");  
      }
               
           
        };      
        
}) 


$(window).scroll(function() {
 if($(this).scrollTop() > 10){
   $(close).fadeOut();
 }else{
   $(close).fadeIn();
 }

 })  


})(jQuery);
