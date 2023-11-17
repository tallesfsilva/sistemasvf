import {config } from "./configuracao.js"

$(document).ready(function(){

  config.fn();

    $("#cep_empresa").on('blur', function(){
 

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
      
      
      $('#cep_empresa').on('blur', function(e){   
                  
      
            $(this).val($(this).val().replace(/[^0-9]+/g, ''));
           
            const value = $(this).val();
            const url = `https://viacep.com.br/ws/${value}/json/`;      
            
            $.ajax({
              url: url,
              method: 'get', 
            
              headers: {
                'Access-Control-Allow-Origin': '*',
                },
                   
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
                    $("#cep_empresa").mask("00-000.000", {reverse:true})
      
              }
      
              })
      })
      
      $('#cep_empresa').on('change', function(e){
        
        $('#end_bairro_empresa').val("");
        $('#end_rua_n_empresa').val("");
        $("[name='end_uf_empresa']").val("").change();
        $("[name='cidade_empresa']").val("").change();
      })
      
      



})