
(function ($) {
    "use strict";


    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100').not("#input_recover");
    var input_recover = $('#input_recover');
      

    $('.validate-form-2').on('submit',function(event){
        var check = true;
            event.preventDefault();
          
            if(validateInput(input_recover) == false){
                showValidate(input_recover);
                check=false;
            }else{
                event.preventDefault();
               
                $.post("../controlers/recover.php", {email : input_recover.val()}, function(c, s){
                    var r = JSON.parse(c);                    
                    if(r.s){     
                        $('#msg_recover_1').removeClass('mb-5');
                        $('#msg_recover_1').addClass('dark:text-gray-400');
                        $('#msg_recover_1').addClass('text-gray-500');
                        $('#msg_recover_1').removeClass('text-red-600 font-semibold');               
                        $('#msg_recover_1').html("Um e-mail com um link foi enviado para o endereço " + "<span class='mb-5 text-lg font-bold text-gray-500 dark:text-gray-400'>" + r.a + "</span>. Por favor utilize o link para efetuar a redefinição de sua senha.")
                        $('.validate-form-2').hide();      
                    }else{
                        $('#msg_recover_1').removeClass('dark:text-gray-400');
                        $('#msg_recover_1').removeClass('text-gray-500');
                        $('#msg_recover_1').addClass('text-red-600 font-semibold');
                        $('#msg_recover_1').text("Não foi encontrado uma conta com os dados informados. Favor informar o email ou CPF utilizados no cadastro de sua conta.")                      
                        
                    }
            })
        }
        

        return check;
    });

    $('#close_modal').on('click', function(e){         
            hideValidate(input_recover);
            $('#msg_recover_1').html("Digite seu e-mail ou CPF cadastrados<br>(somente números):")             
            $('#msg_recover_1').addClass('dark:text-gray-400');
            $('#msg_recover_1').addClass('text-gray-500');
            $('#msg_recover_1').removeClass('text-red-600 font-semibold');    
            input_recover.val("");     
    })


    $('#input_recover').on('keydown', function(event){

        if($('#input_recover').val().match((/^[0-9]/)) !=null && $('#input_recover').val() != ''){
            $('#input_recover').mask('000.000.000-00');
        }       

    });

    $('#input_recover').on('keydown', function(e){     
        
      if($('#input_recover').val() == ''){
           
            $('#input_recover').unmask();
            
        }          
     
    });
 

    function isCpf(cpf) {
   
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


    function validateInput (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim() == ''){
                $("#validate-input").attr('data-validate', 'CPF ou e-mail são obrigatórios') 
               return false;
           }else if($('#input_recover').val().trim().match((/^\d{2}[0-9]/))!=null){
                if($(input).val().trim().match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) == null){ 
                    $("#validate-input").attr('data-validate', 'O CPF informado é inválido')                   
                    return false;
                }
                if(isCpf($(input).val())==false){
                    $("#validate-input").attr('data-validate', 'O CPF informado é inválido!')   
                    return false;
                }
            }else if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null){
                $("#validate-input").attr('data-validate', 'O email digitado é inválido!')   
                return false;
                }
                   
        
          
        }
    }




    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form-2 .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('fa-eye');
            $(this).find('i').addClass('fa-eye-slash');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').removeClass('fa-eye-slash');
            $(this).find('i').addClass('fa-eye');
            showPass = 0;
        }
        
    });
    

})(jQuery);