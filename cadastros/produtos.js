'use-strict'

import{ noti } from '../notification.js'

export const prod = {


    table_prod : $('#produtos').DataTable({
        "dom":'lrtip',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,       
        "bAutoWidth": false,
        "processing": true,      
        "responsive" : true,
        "search" : {
            "caseInsensitive": true,
             
        },
        
       
        "language": {          
            "zeroRecords": "Nenhum registro encontrado.",
            "infoEmpty": "Nenhum registro disponível"
        }, 
        "ajax" : {
            url : '../cadastros/controllers/produto.php?action=pl',
            
        },
        
       
        "order": [],
        columns: [
            {data: 'check_prod'}, 
            {data: 'img_prod'},         
            {data: 'nome_produto'},   
            {data: 'cat_prod'},         
            {data: 'preco_prod'},
            {data: 'estoque'},
            {data: 'btn_disponivel'},
            {data: 'btn_editar'},
            {data: 'btn_excluir'},
            
        ],
        "searchCols": [
            null,
            null,
            null,
            null,
            null,
            null,
            {"search" : 'Sim'},
            null,
            null,
      
        ],
        createdRow: (row) => {            
                $(row).addClass('border-b text-center');
        },
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        
        columnDefs: [
            { orderable: true, targets: 0 },  
            {target: 1, className : "td-img"}  
            
        ],


        "initComplete": function () {
            var api = this.api();
            
            $('#taxa-entrega').show();
            api.columns.adjust();
          },
          
       
    }),
   
    checkDiasSemana : () => {

        $('#op_todos').change(function(){
               
                if($(this).is(":checked")){                    
                    $('input[name=dia_prod]').prop('checked', true);
                }else{
                    $('input[name=dia_prod]').prop('checked', false);
                }

               
        })
        

        $(".dias_prod").change(function(){
           
            let countCheckBox =  $(".dias_prod").length;
            let countChecked = $('.dias_prod:checked').length;
     
            if(countCheckBox == countChecked){
                $('#op_todos').prop('checked', true);
            } else{
                $('#op_todos').prop('checked', false)
            }

           
    })
    $(document).ready(function(){

        let countCheckBox =  $(".dias_prod").length;
        let countChecked = $('.dias_prod:checked').length;
    
        if(countCheckBox == countChecked){
            $('#op_todos').prop('checked', true);
        } else{
            $('#op_todos').prop('checked', false)
        }
    })

    },

    checkTiposAdicionais : () => {
        $('.tipo_adicional_todos').change(function(e){
             
            if($(e.currentTarget).is(":checked")){                    
                $('input[name=tipo_adicional').prop('checked', true);
                $('input[name=tipo_adicional').trigger('change')
            }else{
                $('input[name=tipo_adicional').prop('checked', false);
                $('input[name=tipo_adicional').trigger('change')
            }

           
    })
    //Mover para arquivo específico da página
    $(document).ready(function(){
        
            let countCheckBox = $('input[name=tipo_adicional').length;
            let countChecked = $('.tipo_adicional:checked').length;
            
            
            if(countCheckBox == countChecked){
                $('#todos_tipos').prop('checked', true);
            } else{
                $('#todos_tipos').prop('checked', false)
            }

    });


    $('input[name=tipo_adicional').change(function(){
        let countCheckBox = $('input[name=tipo_adicional').length;
        let countChecked = $('.tipo_adicional:checked').length;
        
        
        if(countCheckBox == countChecked){
            $('#todos_tipos').prop('checked', true);
        } else{
            $('#todos_tipos').prop('checked', false)
        }

       
})


    },


    checkAdicionais : () => {
        $('.adicional_todos').change(function(e){
             
                let idtipo = $(e.currentTarget).data('idtipo');

            if($(e.currentTarget).is(":checked")){      
                 $("input[name='adicional_prod']" ).filter('.'+'adicional'+'[data-idtipo="'+idtipo+'"]').prop('checked', true);             
               
                 
                 //$("input[name='adicional_prod']" ).filter('.'+'adicional'+'[data-idtipo="'+idtipo+'"]').trigger('change')
            }else{
                $("input[name='adicional_prod']" ).filter('.'+'adicional'+'[data-idtipo="'+idtipo+'"]').prop('checked', false);             
               
                 
                //$("input[name='adicional_prod']" ).filter('.'+'adicional'+'[data-idtipo="'+idtipo+'"]').trigger('change')
            }

           
    })
    //Mover para arquivo específico da página 
    $(document).ready(function(){

  
 
        let checkTodos =  $('.adicional_todos');
       
        let idtipos = [];
        for(let i=0;i<checkTodos.length;i++){
            idtipos.push($(checkTodos[i]).data('idtipo'));
        };
     
        for(let i=0;i<idtipos.length;i++){
            let countCheckBox =  $("input[name='adicional_prod']" ).filter('.'+'adicional'+'[data-idtipo="'+idtipos[i]+'"]').length;
            let countChecked =  $("input[name='adicional_prod']" ).filter('.'+'adicional:checked'+'[data-idtipo="'+idtipos[i]+'"]').length;
            if(countCheckBox == countChecked){            
                $('#adicionais_todos_'+idtipos[i]).prop('checked', true);
            } else{
           
                $('#adicionais_todos_'+idtipos[i]).prop('checked', false)
            }
    
        }

       
     
    })

    $("input[name='adicional_prod']" ).change(function(e){

      
        let idtipo = $(e.currentTarget).data('idtipo');
 
        let countCheckBox =  $("input[name='adicional_prod']" ).filter('.'+'adicional'+'[data-idtipo="'+idtipo+'"]').length;
        let countChecked =  $("input[name='adicional_prod']" ).filter('.'+'adicional:checked'+'[data-idtipo="'+idtipo+'"]').length;
 
        if(countCheckBox == countChecked){            
            $('#adicionais_todos_'+idtipo).prop('checked', true);
        } else{
       
            $('#adicionais_todos_'+idtipo).prop('checked', false)
        }

       
})


    },



    atualizarProd : () => {

        $('.atualizar_prod').click(function(e){
            var idprod = $(e.currentTarget).data('idprod');
            let url = $(e.currentTarget).data('url');
            $.ajax({
              url: url + '/controllers/produto.php',
              method: "post",
              data: {'iditem' : idprod, "action" : "pd", lote : false},

              success: function(data){ 
                let j = JSON.parse(data);
                $('#msg').html("");
                $('#msg').show();
                if(j.success && !j.error){
                    $('#msg').html(j.msg);  
                    setTimeout(function(){              
                      
                        $('#msg').fadeOut();
                    },3000)
                    window.location.assign(url+'/editar-produto&idprod='+idprod) ; 
                            
                 
                }else{
                    $('#msg').html(j.msg);  
                    setTimeout(function(){                        
                     
                        $('#msg').fadeOut();
                    },3000)
                }                      
                 
              }
            });
          });




    $('#btn_inativar').click(function(){
        var rows = $('#produtos tbody tr :checked');
 
        var ids = [];
         
        for(let i=0;i<rows.length;i++){
            ids.push($(rows[i]).attr('id').split("_")[1]);
        }
        let url = $(this).data('url');
 
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
                            url: url + '/controllers/produto.php',
                            method: "post",
                            data: {'iditem' : ids, "action" : "pd", lote : true},
          
                            success: function(data){ 
                                let j = JSON.parse(data);
                                $('#msg').html("");
                                $('#msg').show();
                                if(j.success && !j.error){
                                    $('#msg').html(j.msg);  
                                    setTimeout(function(){              
                                      
                                        $('#msg').fadeOut();
                                    },3000)
                                    $('#checkbox-all-search').prop('checked', false);;
                                    prod.table_prod.ajax.reload();         
                                 
                                }else{
                                    $('#msg').html(j.msg);  
                                    setTimeout(function(){                        
                                     
                                        $('#msg').fadeOut();
                                    },3000)
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
                $('#msg').html("<div class='alert alert-info alert-dismissable'>"+
                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                "Por favor selecione pelo menos um produto!</div>") 
                setTimeout(function(){                        
                                     
                    $('#msg').fadeOut();
                },3000)               
            }
});
   

 




        $('#produtos').on('click', '.atualizar_prod', function(e){
            var idprod = $(e.currentTarget).data('idprod');
            let url = $(e.currentTarget).data('url');
            $.ajax({
              url: url + '/controllers/produto.php',
              method: "post",
              data: {'iditem' : idprod, "action" : "pd", lote : false},

              success: function(data){ 
                let j = JSON.parse(data);
                $('#msg').html("");
                $('#msg').show();
                if(j.success && !j.error){
                    $('#msg').html(j.msg);  
                    setTimeout(function(){              
                      
                        $('#msg').fadeOut();
                    },3000)
                 
                    prod.table_prod.ajax.reload();         
                 
                }else{
                    $('#msg').html(j.msg);  
                    setTimeout(function(){                        
                     
                        $('#msg').fadeOut();
                    },3000)
                }                      
                 
              }
            });
          });


    },

    create : () => {

        $('#cadProduto').on('submit', function(e){

            e.preventDefault();
             
                    

            let url = $(this).data('url');
            
            let adicionaisArray = [];
            let diasProdutoArray = [];

            $("input:checkbox[name=adicional_prod]:checked").each(function() {
                adicionaisArray.push({                    
                        "id_tipo_adicional" : $(this).data('idtipo'),
                        "id_adicionais" : $(this).data('idad')                
               
                              
                     
                })
           });

           $("input:checkbox[name=dia_prod]:checked").each(function() {
                  diasProdutoArray.push($(this).val())
                
            })
         

           let nomeItem = $('input[name=nome_item').val();
           let precoItem = $('input[name=preco_item').val();
           let idCat = $('select[name=id_cat').val();
           let descItem = $('textarea[name=descricao_item').val();
           let imgItem = $('#file-5')[0].files[0];
           
           let formData = new FormData();
           formData.append('img_item', imgItem);
           formData.append('action', 'pc');
           formData.append('disponivel', '1');
           formData.append('nome_item', nomeItem);
           formData.append('id_cat', idCat);
           formData.append('descricao_item', descItem);
           formData.append('preco_item', precoItem);
           formData.append('adicionais', JSON.stringify(adicionaisArray));
           formData.append('dia_semana', diasProdutoArray);

            
          
        
            $.ajax({
                url: url + '/controllers/produto.php',
                method: "post",   
                processData: false,
                contentType: false,       
                data: formData,

                success: function(data){ 
                    let j = JSON.parse(data);
                    $('#msg').html("");
                    $('#msg').show();
                    if(j.success && !j.error){
                        $('#msg').html(j.msg);  
                        setTimeout(function(){                
                          
                            $('#msg').fadeOut();
                        },3000)
                         window.location.assign(url+'/view-item') ;       
                     
                    }else{
                        $('#msg').html(j.msg);  
                        setTimeout(function(){                        
                         
                            $('#msg').fadeOut();
                        },3000)
                    }                      
                     
                }
                }); 
        })
 






    },


    update : () => {

        $('#salvar_produto').on('click', function(e){

            e.preventDefault();
       
                    

            let url = $(this).data('url');
            let idProd = $(this).data('idprod');
            
            let adicionaisArray = [];
            let diasProdutoArray = [];

            $("input:checkbox[name=adicional_prod]:checked").each(function() {
                adicionaisArray.push({                    
                        "id_tipo_adicional" : $(this).data('idtipo'),
                        "id_adicionais" : $(this).data('idad')                
               
                              
                     
                })
           });

           $("input:checkbox[name=dia_prod]:checked").each(function() {
                  diasProdutoArray.push($(this).val())
                
            })
         

           let nomeItem = $('input[name=nome_item').val();
           let precoItem = $('input[name=preco_item').val();
           let idCat = $('select[name=id_cat').val();
           let descItem = $('textarea[name=descricao_item').val();
           let imgItem = $('#file-5')[0] ? $('#file-5')[0].files[0] : "";
           let removImg = $('#file-5').data('rmv');
            console.log(removImg);
           let formData = new FormData();
           formData.append('id', idProd);
           (imgItem!=undefined && imgItem != null) ? formData.append('img_item', imgItem) : "";
           (removImg == true && removImg != undefined && imgItem==undefined && imgItem == null) ?  formData.append('img_item', "") : "";
           formData.append('action', 'pu');
           //formData.append('disponivel', '1');
           formData.append('nome_item', nomeItem);
           formData.append('id_cat', idCat);
           formData.append('descricao_item', descItem);
           formData.append('preco_item', precoItem);
           formData.append('adicionais', JSON.stringify(adicionaisArray));
           formData.append('dia_semana', diasProdutoArray);
   
        
          
        
            $.ajax({
                url: url + '/controllers/produto.php',
                method: "post",   
                processData: false,
                contentType: false,       
                data: formData,

                success: function(data){ 
                    let j = JSON.parse(data);
                    $('#msg').html("");
                    $('#msg').show();
                    if(j.success && !j.error){
                        $('#msg').html(j.msg);  
                        setTimeout(function(){                
                          
                            $('#msg').fadeOut();
                        },3000)
                       window.location.assign(url+'/view-item') ;       
                     
                    }else{
                        $('#msg').html(j.msg);  
                        setTimeout(function(){                        
                         
                            $('#msg').fadeOut();
                        },3000)
                    }                      
                     
                }
                }); 
        })
 







    },

    search : () =>{

                
        $("#search-product").off().on("keyup", function() {
                
            prod.table_prod.column(2).search(this.value).draw();

     });


     $('#categoria').change( function(){
         
        prod.table_prod.column(3).search(this.value).draw();
        });


        $('#produtos_inativos').change( function(){
          
            if(!$(this).is(':checked')){           
               
                prod.table_prod.columns(6).search('Sim').draw();
                                  
            }else {
                //prod.table_prod.column(6).data().filter(function(value, index){ return value == "Não"}.draw())
                prod.table_prod.column(6).search('Não').draw();               
            }                
       })      
       
     
    },


    clonaProduto : () =>{




        $('#btn_clonar').click(function(e){
            var idprod = $(e.currentTarget).data('idprod');
            let url = $(e.currentTarget).data('url');
            $.ajax({
              url: url + '/controllers/produto.php',
              method: "post",
              data: {'iditem' : idprod, "action" : "pcl"},

              success: function(data){ 
                let j = JSON.parse(data);
                $('#msg').html("");
                $('#msg').show();
                if(j.success && !j.error && j.id){
                   
                    window.location.assign(url+'/editar-produto&idprod='+j.id) ; 
                            
                 
                }else if(!j.success && j.error){
                    noti.init(j.error, j.msg)           
                    
                }                      
                 
              }
            });
          });




    },

    delete : ()=>{

        $("#produtos").on('click', '.deleta_prod', function(e){

            var idprod = $(e.currentTarget).data('idprod');
            let url = $(e.currentTarget).data('url');
      
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
                        url: url + '/controllers/produto.php',
                      method: 'post',
                      data: {'iditem' : idprod, action: "pe"},
                      success: function(data){
                        let j = JSON.parse(data);
                        $('#msg').html("");
                        $('#msg').show();
                        if(j.success && !j.error){
                            $('#msg').html(j.msg);  
                            setTimeout(function(){                
                              
                                $('#msg').fadeOut();
                            },3000)
                          
                            prod.table_prod.ajax.reload();         
                         
                        }else{
                            $('#msg').html(j.msg);  
                            setTimeout(function(){                        
                             
                                $('#msg').fadeOut();
                            },3000)
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


          $(".deleta_prod").on('click', function(e){

            var idprod = $(e.currentTarget).data('idprod');
            let url = $(e.currentTarget).data('url');
      
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
                        url: url + '/controllers/produto.php',
                      method: 'post',
                      data: {'iditem' : idprod, action: "pe"},
                      success: function(data){
                        let j = JSON.parse(data);
                        $('#msg').html("");
                        $('#msg').show();
                        if(j.success && !j.error){
                            $('#msg').html(j.msg);  
                            setTimeout(function(){                
                              
                                $('#msg').fadeOut();
                            },3000)
                            window.location.assign(url+'/view-item') ; 
                            
                         
                        }else{
                            $('#msg').html(j.msg);  
                            setTimeout(function(){                        
                             
                                $('#msg').fadeOut();
                            },3000)
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

        $('#btn_excluir').click(function(){

            var rows = $('#produtos tbody :checked');
            
            var ids = [];
             
            for(let i=0;i<rows.length;i++){
                ids.push($(rows[i]).attr('id').split("_")[1]);
            }
            let url = $(this).data('url');
         
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
                                        url: url + '/controllers/produto.php',
                                        method: "post",
                                        data: {'iditem' : ids, 'action' : "pe", "lote" : true},
                            
                                        success: function(data){ 
                                            let j = JSON.parse(data);
                                            $('#msg').html("");
                                            $('#msg').show();
                                            if(j.success && !j.error){
                                                $('#msg').html(j.msg);  
                                                setTimeout(function(){                
                                                  
                                                    $('#msg').fadeOut();
                                                },3000)
                                              
                                                prod.table_prod.ajax.reload();         
                                             
                                            }else{
                                                $('#msg').html(j.msg);  
                                                setTimeout(function(){                        
                                                 
                                                    $('#msg').fadeOut();
                                                },3000)
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
                            $('#msg').html("<div class='alert alert-info alert-dismissable'>"+
                            "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                            "Por favor selecione pelo menos um produto!</div>") 
                            setTimeout(function(){                        
                                                 
                                $('#msg').fadeOut();
                            },3000)               
                        }
            });
         
           
    
     









    },

    loadImgProd : () =>{
       
      
       
            $("#file-5").change(function(event) {  
                
                var tmppath = URL.createObjectURL(event.target.files[0]);  
             
                $("#img_prod").attr("src",  "");
                $("#img_prod").attr("src",  tmppath.toString());
                $("#img_prod").attr("style", "margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;height: 340px;");    
                $('#show_img_prod').show();
                $("#label-file").hide();
                $("#label-icon").hide();
                
                $('#container-img').removeClass('container-hover');
                $(this).val(null);
           
            });

                    $("#show_img_prod").on('click', function(e){

                        $('#file-5').click();

                    })

                    $("#remove-img").on('click', function(e){


                        $("#img_prod").attr("src",  "");
                        $("#img_prod").attr("style", "");
                        $('#show_img_prod').hide();
                        $("#label-file").show();
                        $("#label-icon").show();
                        $('#label-text').show();
                        $('#container-img').addClass('container-hover')
                        $("#file-5").attr('data-rmv', "true");

                        e.stopPropagation();

                    })
            
        
        
                     
        
        
      
      

    },


    loadAdicionais : () => {
        $('.tipo_adicional').change(function(e){
            
            let idtipo = $(e.currentTarget).data('idtipo')


            if(!$(e.currentTarget).is(':checked')){
                $("#container_adicional_"+idtipo).hide();
            }else if($(e.currentTarget).is(':checked') && $("#container_adicional_"+idtipo).length ){
                $("#container_adicional_"+idtipo).show();
            }else{
     
           
          $.ajax({
            url: 'controllers/carrega_adicional_produto.php?idtipo='+idtipo,
            method: "get",            
    
            success: function(data){ 
                let j = JSON.parse(data);  
              
                if(j.data.length && j.success){
           
                    $('#container_adicionais').append("<div id=container_adicional_"+j.data[0].id_tipo+ "   class='mt-5 flex flex-col w-full'></div>")
                    
                    $("#container_adicional_"+j.data[0].id_tipo).append("<div id=adc_"+j.data[0].id_tipo +"  class='flex flex-col mt-2'></div>")
                    $("#adc_"+j.data[0].id_tipo).append(j.data[1].nome_tipo_adicional)
                    $("#adc_"+j.data[0].id_tipo).append("<div id=ad_"+j.data[0].id_tipo+ "  class='item-adicional flex flex-row'></div>")
                    $("#container_adicional_"+j.data[0].id_tipo).append( $("#ad_"+j.data[0].id_tipo));
                    $("#ad_"+j.data[0].id_tipo).append("<div style='margin-right:80px;'class='m-3 icheck-material-green'><input data-idtipo="+j.data[0].id_tipo+ "  type=checkbox class='adicional_todos' name='adicional_todos' value='' id=adicionais_todos_"+j.data[0].id_tipo+ "><label for=adicionais_todos_"+j.data[0].id_tipo+"></label>Todos</div>")              
                    for(let i=0;i<j.data.length;i++){         
                        $('#ad_'+j.data[0].id_tipo).append(j.data[i].adicionais);
                     
                         }
                         
                         $("#container_adicional_"+j.data[0].id_tipo).css('display', "flex");
                      
                }else{
                    $("#title_adicional").hide();
                  
                }
                prod.checkAdicionais();
            }
             
            });
     
        }
        });



        
    },





    loadTiposAdicionais : () => {
        $('#categoria_produto').change(function(e){
           
            $('#container_tipos').html("");
            $('#container_tipos').hide();
            $('#container_adicionais').html("");
          
            let idcat = $("#categoria_produto").val();
            let idprod = $("#categoria_produto").data('idprod');

          $.ajax({
            url: 'controllers/carrega_tipos_adicionais_inputs.php?idcat='+idcat+'&idprod='+idprod,
            method: "get",            
    
            success: function(data){ 
                let j = JSON.parse(data);  
               
                if(j.data.length){
                   $("#title_tipo").show();     
                   $('#container_tipos').append("<div style='margin-right:80px;' class='m-3 icheck-material-green'><input type=checkbox class='tipo_adicional_todos' name='todos_tipo_adicional' value='' id=todos_tipos ><label for=todos_tipos></label>Todos</div>")              
                   
                    for(let i=0;i<j.data.length;i++){         
                         if(j.data[i].checked){
                            $('#container_tipos').append("<div class='m-3 icheck-material-green'><input type=checkbox class='tipo_adicional' checked name='tipo_adicional' data-idtipo="+j.data[i].id_tipo+" value="+j.data[i].id_tipo+" id=tipo_"+j.data[i].id_tipo+" ><label for=tipo_"+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</label></div>")
                         }else{
                            $('#container_tipos').append("<div class='m-3 icheck-material-green'><input type=checkbox class='tipo_adicional' name='tipo_adicional' data-idtipo="+j.data[i].id_tipo+" value="+j.data[i].id_tipo+" id=tipo_"+j.data[i].id_tipo+" ><label for=tipo_"+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</label></div>")
                         }
                        
                         }
                        $('#container_tipos').css('display', "flex");

                }else{
                    $("#title_tipo").hide();
                  
                }
                prod.loadAdicionaisUser();
                prod.loadAdicionais();
                prod.checkTiposAdicionais();
            }
           
            });

  
        });

        $(document).ready(function(){
         
                $('#container_tipos').html("");
                $('#container_tipos').hide();
                $('#container_adicionais').html("");
              
                let idcat = $("#categoria_produto").val();
                let idprod = $("#categoria_produto").data('idprod');
    
              $.ajax({
                url: 'controllers/carrega_tipos_adicionais_inputs.php?idcat='+idcat+'&idprod='+idprod,
                method: "get",            
        
                success: function(data){ 
                    let j = JSON.parse(data);  
                   
                    if(j.data.length){
                       $("#title_tipo").show();     
                       $('#container_tipos').append("<div style='margin-right:80px;' class='m-3 icheck-material-green'><input type=checkbox class='tipo_adicional_todos' name='todos_tipo_adicional' value='' id=todos_tipos ><label for=todos_tipos></label>Todos</div>")              
                       
                        for(let i=0;i<j.data.length;i++){         
                             if(j.data[i].checked){
                                $('#container_tipos').append("<div class='m-3 icheck-material-green'><input type=checkbox class='tipo_adicional' checked name='tipo_adicional' data-idtipo="+j.data[i].id_tipo+" value="+j.data[i].id_tipo+" id=tipo_"+j.data[i].id_tipo+" ><label for=tipo_"+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</label></div>")
                             }else{
                                $('#container_tipos').append("<div class='m-3 icheck-material-green'><input type=checkbox class='tipo_adicional' name='tipo_adicional' data-idtipo="+j.data[i].id_tipo+" value="+j.data[i].id_tipo+" id=tipo_"+j.data[i].id_tipo+" ><label for=tipo_"+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</label></div>")
                             }
                            
                             }
                            $('#container_tipos').css('display', "flex");
    
                    }else{
                        $("#title_tipo").hide();
                      
                    }
                    prod.loadAdicionaisUser();
                    prod.loadAdicionais();
                    prod.checkTiposAdicionais();
                }
               
                });
    
      
        })
    },

    loadAdicionaisUser : () =>{

        let idtipos = [];

        let tiposAdicionais = $('.tipo_adicional:checked');
        let idprod = $('#categoria_produto').data('idprod');
        let url = $('#categoria_produto').data('url');
        for(let i=0;i<tiposAdicionais.length;i++){
            idtipos.push($(tiposAdicionais[i]).data('idtipo'));
        }

          $.ajax({
                url: url + '/controllers/produto.php',
                method: "post",
                data: {"iditem": idprod,'idtipos' : idtipos, 'action' : "uad"},
    
                success: function(data){ 
                    let j = JSON.parse(data);
            
                    if(j.success && !j.error){
                        for(let i=0;i<j.tipos.length;i++){     
                                        
                            $('#container_adicionais').append("<div id=container_adicional_"+j.tipos[i].id_tipo+ "   class='mt-5 flex flex-col w-full'></div>")
                            
                            $("#container_adicional_"+j.tipos[i].id_tipo).append("<div id=adc_"+j.tipos[i].id_tipo +"  class='flex flex-col mt-2'></div>")
                            $("#adc_"+j.tipos[i].id_tipo).append(j.tipos[i].nome_tipo_adicional)
                            $("#adc_"+j.tipos[i].id_tipo).append("<div id=ad_"+j.tipos[i].id_tipo+ "  class='item-adicional flex flex-row'></div>")
                            $("#container_adicional_"+j.tipos[i].id_tipo).append( $("#ad_"+j.tipos[i].id_tipo));
                            $("#ad_"+j.tipos[i].id_tipo).append("<div style='margin-right:80px;'class='m-3 icheck-material-green'><input data-idtipo="+j.tipos[i].id_tipo+ "  type=checkbox class='adicional_todos' name='adicional_todos' value='' id=adicionais_todos_"+j.tipos[i].id_tipo+ "><label for=adicionais_todos_"+j.tipos[i].id_tipo+"></label>Todos</div>")              
                        }
                        for(let i=0;i<j.tipos.length;i++){  
                            
                                    for(let k=0;k<j.data.length;k++){                                                       
                                    j.data[k].idtipo == j.tipos[i].id_tipo ? $('#ad_'+j.tipos[i].id_tipo).append(j.data[k].adicionais) : "";
            
                }
                $("#container_adicional_"+j.data[i].id_tipo).css('display', "flex");
            }
                
                      
                                    
                }else{                  
                    $("#title_adicional").hide();
                  
                }
                prod.checkAdicionais();
                                             
                                            
                                                         
                                        }
                                        });
                                    
    },

    tableRows : () => {
        return prod.table_prod.rows().data();

    },


    init : () => {
        // ad.update();
        // ad.loadTiposAdicionaisBusca();
        // ad.loadTiposAdicionaisGrid();
        // ad.delete();
        prod.search();
        prod.update();
        prod.loadTiposAdicionais();
        prod.create();
        prod.loadImgProd();
        prod.clonaProduto();
        prod.atualizarProd();
        prod.delete();
        prod.checkDiasSemana();
        
      
       //ad.create();
    },
    fn : () => {
        return prod.init();
    },
    
    


}
 