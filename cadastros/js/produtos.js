'use-strict'


export const prod = {





    loadAdicionais : () => {
        $('.tipo_adicional').change(function(e){
            
            let idtipo = $(e.currentTarget).data('idtipo')


            if(!$(e.currentTarget).is(':checked')){
                $("#container_adicional_"+idtipo).remove();
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
        // ad.search();
        prod.loadTiposAdicionais();
        
       
       //ad.create();
    },
    fn : () => {
        return prod.init();
    },
    



}