

(function ($) {
    "use strict";
 
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(event){
            event.preventDefault();   
            var check = true;
            for(var i=0; i<input.length; i++) {
                if(validate(input[i]) == false){
                    showValidate(input[i]);
                    check=false;                     
                }
            } 
            if(check){
                    var d = {                
                        senha1 : $("input[name='senha1']").val(), 
                        senha2 :$("input[name='senha2']").val(), 
                        email: $("input[name='email']").val(), 
                        action: $("input[name='action']").val(),   
                    }      
                    event.preventDefault();
                    $.post("../controlers/update.php", d, function(r){
                    var c = JSON.parse(r);       

                    if(c.status && c.msg){
                            $('.validate-form').hide();
                            $('#msg_recover_1').text(c.msg);
                            $('#msg_recover_1').show();     
                            $('#msg_recover_1').removeClass('mb-5');                   
                            setTimeout(function(){
                                window.location.replace(c.url);
                            },4000)
                        }
                        if (c.status==false){
                            for(var i=0; i<input.length; i++) {                                
                                    showValidate(input[i]);
                                    check=false;                   
                            } 
                        }
                            }) 
                    }  
    });

    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
       
        if($(input).val().trim() == '' ){
            return false;
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