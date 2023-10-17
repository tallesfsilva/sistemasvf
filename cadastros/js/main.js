import {cad } from './categorias.js'
import {tipo } from './tipos_adicionais.js'
import {ad } from './adicionais.js'
import {cupom } from './cupom.js'
$(document).ready(function (){    
    cad.fn();
    tipo.fn();
    ad.fn();
    cupom.fn();
 
    $('#btn_inativar').click(function(){
            var rows = $('#table1 tr :checked');
            
            var ids = [];
             
            for(let i=0;i<rows.length;i++){
                ids.push($(rows[i]).attr('id').split("_")[1]);
            }
            let u = $(this).data('url')+'includes/processaDisponibilidadeItens.php';
            let user = $(this).data('user');
            if(ids.length >0 ){
                GrowlNotification.notify({
                    title: 'Atenção!',
                    description: 'Confirma inativar os produtos selecionados?',
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
                        text: 'Inativar',
                        callback: function(){           
                                              
                            $.ajax({
                                url:u,
                                method: "post",
                                data: {'iditem' : ids, 'iduser' :  user, 'action' : true},
              
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
                }else{
                    $('#msg_error').html("<div class='alert alert-info alert-dismissable'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                    "Por favor selecione pelo menos uma linha!</div>")                
                }
               
             
            
           
           

    });



    $('#btn_excluir').click(function(){

        var rows = $('#table1 tr :checked');
        
        var ids = [];
         
        for(let i=0;i<rows.length;i++){
            ids.push($(rows[i]).attr('id').split("_")[1]);
        }
        let u = $(this).data('url')+'includes/processadeletaritem.php';
        let user = $(this).data('user');
        if(ids.length >0 ){
                    GrowlNotification.notify({
                        title: 'Atenção!',
                        description: 'Confirma a exclusão dos produtos?',
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
                                    url: u,
                                    method: "post",
                                    data: {'iditem' : ids, 'iduser' :   user, 'action' : true},
                        
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
                    }else{
                        $('#msg_error').html("<div class='alert alert-info alert-dismissable'>"+
                        "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                        "Por favor selecione pelo menos uma linha!</div>")                
                    }
        });
     
       

 

 
    $('#categoria').change( function(){
        var selSelection = $("#categoria").val();
        if(!selSelection) $("#table1 tr").show();
    else $("#table1 tr").show().filter(function(index){
        return $("#categoria-row:eq(0)", this).html().indexOf(selSelection) == -1;
    }).hide();})
          
    var table = $('#produtos').DataTable({
        "dom":'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,       
        "bAutoWidth": false,
        
        "search" : {
            "caseInsensitive": true,
             
        },
        "language": {          
            "zeroRecords": "Nenhum registro encontrado.",
            "infoEmpty": "Nenhum registro disponível"
        },
        
       
    });


    

        
        $('#produtos_inativos').change( function(){
          
            if(!$(this).is(':checked')){           
               
                table.columns().search('').draw();
                                  
            }else {
                table.column(6).search('Não').draw();               
            }                
       })      
            
        $("#search-product").off().on("keyup", function() {
                
            table.column(2).search(this.value).draw();

     });


 





  







 


 
 





 

})