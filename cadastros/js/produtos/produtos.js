'use-strict'


export const prod = {


    table_prod : $('#produtos').DataTable({
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
        "ajax" : {
            url : '../cadastros/controllers/produto.php?action=pl'
        },
       
        "order": [],
        columns: [
            {data: 'check_prod'}, 
            {data: 'img_prod'},         
            {data: 'nome_produto'},   
            {data: 'cat_prod'},           
            {data: 'desc_prod'},
            {data: 'preco_prod'},
            {data: 'estoque'},
            {data: 'btn_disponivel'},
            {data: 'btn_editar'},
            {data: 'btn_excluir'},
            
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
            {target: 1, className : "td-img"}   , 
            
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
                    $('input[name=dia_prod').prop('checked', true);
                }else{
                    $('input[name=dia_prod').prop('checked', false);
                }

               
        })
        

        $('input[name=dia_prod').change(function(){
            let countCheckBox = $('input[name=dia_prod').length;
            let countChecked = $('input[name=dia_prod').is(":checked").length;

            if(countCheckBox == countChecked){
                $('#op_todos').prop('checked', true);
            } else{
                $('#op_todos').prop('checked', false)
            }

           
    })


    },

    atualizarProd : () => {



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
            console.log(adicionaisArray);

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

    search : () =>{

                
        $("#search-product").off().on("keyup", function() {
                
            prod.table_prod.column(2).search(this.value).draw();

     });


     $('#categoria').change( function(){
         
        prod.table_prod.column(3).search(this.value).draw();
        });


        $('#produtos_inativos').change( function(){
          
            if(!$(this).is(':checked')){           
               
                prod.table_prod.columns().search('').draw();
                                  
            }else {
                prod.table_prod.column(7).search('Não').draw();               
            }                
       })      
       
     
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

        $('#btn_excluir').click(function(){

            var rows = $('#produtos tr :checked');
            
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
             
          
                $("#img_prod").attr("src",  tmppath.toString());
                $("#img_prod").attr("style", "margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;height: 340px;");    
                $('#show_img_prod').show();
                $("#label-file").hide();
            });

                    $("#show_img_prod").on('click', function(e){

                        $('#file-5').click();

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
                    $("#container_adicional_"+j.data[0].id_tipo).append( $(".ad_"+j.data[0].id_tipo));
                  
                    for(let i=0;i<j.data.length;i++){         
                        $('#ad_'+j.data[0].id_tipo).append(j.data[i].adicionais);
                     
                         }
                         
                         $("#container_adicional_"+j.data[0].id_tipo).css('display', "flex");
                      
                }else{
                    $("#title_adicional").hide();
                  
                }
             
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
          
            let idcat = $(this).val();

          $.ajax({
            url: 'controllers/carrega_tipos_adicionais_inputs.php?idcat='+idcat,
            method: "get",            
    
            success: function(data){ 
                let j = JSON.parse(data);  
               
                if(j.data.length){
                   $("#title_tipo").show();                   
                    for(let i=0;i<j.data.length;i++){         
                      
                        $('#container_tipos').append("<div class='m-3 icheck-material-green'><input type=checkbox class='tipo_adicional' name='tipo_adicional' data-idtipo="+j.data[i].id_tipo+" value="+j.data[i].id_tipo+" id=tipo_"+j.data[i].id_tipo+" ><label for=tipo_"+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</label></div>")
                         }
                        $('#container_tipos').css('display', "flex");

                }else{
                    $("#title_tipo").hide();
                  
                }
                prod.loadAdicionais();
            }
           
            });

        });
    },


    init : () => {
        // ad.update();
        // ad.loadTiposAdicionaisBusca();
        // ad.loadTiposAdicionaisGrid();
        // ad.delete();
        prod.search();
        prod.loadTiposAdicionais();
        prod.create();
        prod.loadImgProd();
        prod.atualizarProd();
        prod.delete();
        prod.checkDiasSemana();
       
       //ad.create();
    },
    fn : () => {
        return prod.init();
    },
    
    


}
 