
'use-strict' 
import{ noti } from './notification.js'

 
export const ad =  {

    table_ad : $('#cad_adicionais').DataTable({
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
            url : '../cadastros/controllers/adicionais.php?action=al'
        },
        "order": [],
        columns: [
            {data:'nome_cat'}, 
            {data: 'tipo_adicional'},
            {data: 'nome_adicional'},
            {data: 'descricao_adicional'},
            {data: 'valor_adicional'},
            {data: 'excluir'},


        ],
        createdRow: (row) => {            
                $(row).addClass('border-b text-center');
        },
        columnDefs: [
            { orderable: true, targets: 0 },
            { targets: [5], className: "delete_adicional"},            
        ]
    
    }), 

    update : () =>{   
                    
        $('#cad_adicionais').on('change','.atualiza_adicional', function(e){
                  
            e.preventDefault();
            
            let idAdicional = $(e.currentTarget).data('idadd');
            let url = $(e.currentTarget).data('url');    
            let flag = $(e.currentTarget).data('flag') ? $(e.currentTarget).data('flag') : false;
            let idTipoAdicional =     $("select[name='id_tipo_adicional']" ).filter('.'+'atualiza_adicional'+'[data-idadd="'+idAdicional+'"]').val();       
            let nomeAdicional =  $("input[name='nome_adicional']" ).filter('.'+'atualiza_adicional'+'[data-idadd="'+idAdicional+'"]').val();
            let descAdicional =  $("input[name='desc_adicional']" ).filter('.'+'atualiza_adicional'+'[data-idadd="'+idAdicional+'"]').val();
            let idCategoria =  $("select[name='id_cat']" ).filter('.'+'categoria_grid'+'[data-idadd="'+idAdicional+'"]').val();
            let valorAdicional =  $("input[name='valor_adicional']" ).filter('.'+'atualiza_adicional'+'[data-idadd="'+idAdicional+'"]').val();
        
         
       
        $.ajax({
            url: url + '/controllers/adicionais.php?action=au',
            method: "post",
            data: {flagName:flag, id_adicionais: idAdicional, id_tipo_adicional: idTipoAdicional, nome_adicional: nomeAdicional, desc_adicional: descAdicional, id_cat:idCategoria, valor_adicional:valorAdicional,},
        
            success: function(data){ 
                let j = JSON.parse(data);
        
                if(j.success && !j.error){                 
                    noti.init(j.error, j.msg)
                    ad.table_ad.ajax.reload();
                   
                }else if(!j.success & j.error){
                    noti.init(j.error, j.msg)  
                         ad.table_ad.ajax.reload();
               
                } 
                  
              }
            });
            
          })
          
    
     
       
    },

    create : () =>{

        $('#cadAdicionais').on('submit', function(e){

            e.preventDefault();
        
            let url = $(this).data('url');
           
            
            let nomeAdicional =  $("input[name='nome_adicional']",this).val();
            let idCategoria =  $("select[name='categoria-adicional']",this).val();
            let idTipoAdicional =  $("select[name='tipo-adicionais']",this).val();
          
            
            let valorAdicional = $("input[name='valor_adicional']",this).val()
            let descAdicional = $("textarea[name='desc_adicional']",this).val()
        
        
            $.ajax({
                url: url + '/controllers/adicionais.php?action=ac',
                method: "post",
                data: {nome_adicional: nomeAdicional,  desc_adicional:descAdicional, valor_adicional:valorAdicional, id_tipo_adicional :idTipoAdicional,id_cat:idCategoria},

                success: function(data){ 
                    let j = JSON.parse(data);

                    if(j.success && !j.error){
                        noti.init(j.error, j.msg)
                        $('#cadAdicionais')[0].reset();
                      
                        ad.table_ad.ajax.reload();
                    }else if(!j.success & j.error){
                        noti.init(j.error, j.msg)
                    }                      
                     
                }
                }); 
        })
 

},

    delete : () => {

        $("#cad_adicionais").on('click', '.deletar_adicional', function(e){
          
        
        let idAdicional = $(e.currentTarget).data('idad');
        let url = $(e.currentTarget).data('url');  
        if(!$('.growl-notification').is(":visible")){
        GrowlNotification.notify({
          title: 'Atenção!',
          description: '<center>Tem certeza de que deseja deletar esse adicional? </br>Isso irá excluir esse adicional do cadastro do produto.</center>',
          type: 'error',
          image: {
            visible: true,
            customImage: '/uploads/img/danger.png'
          },
          position: 'top-center',
          showProgress: true,
          showButtons: true,
          buttons: {
            action: {
              text: 'SIM',
              callback: function(){
                $.ajax({
                  url: url+'/controllers/adicionais.php?action=ae',
                  method: 'post',
                  data: {'id_adicional' : idAdicional},
    
    
                  success: function(data){ 
                    let j = JSON.parse(data)
                    if(j.success && !j.error){
                        noti.init(j.error, j.msg)
                       ad.table_ad.ajax.reload();
                    }  else if(!j.success & j.error){
                        noti.init(j.error, j.msg)
                    }
                  }
              });
                
              }
            },
            cancel: {
              text: 'NÃO'
            }
          },
          closeTimeout: 0
        });
    }else{
        return;
    }
    });
    },

    search : () => {
    $("#search_adicionais").off().on("keyup", function() {
                
        ad.table_ad.column(2).search(this.value).draw();
        

    });
    $("#categoria_adicionais_busca").change(function() {
        ad.table_ad.column(1).search("").draw();       
        ad.table_ad.column(0).search(this.value).draw();
       
    });

    $("#adicionais-busca").change(function() {
                
        ad.table_ad.column(1).search(this.value).draw();
         

    });

   
},

formataValorAdicional : () => {

    $(".valor_adicional").mask('#.##0,00', {reverse: true});
 


},
   
    loadTiposAdicionaisGrid : () => {

        $('#cad_adicionais').on('change','#categoria-adicional-grid', function(e){
                  
            e.preventDefault();
          let idcat = $(this).val();
          let idadd = $(this).data('idadd')
          noti.init(true, "Por favor selecione um tipo de adicional");
          $.ajax({
            url: 'controllers/tipos_adicionais.php?action=tag',
            method: "post",
            data: {"idcat": idcat},            
    
            success: function(data){ 
                let j = JSON.parse(data);           
                if(j.data.length){
                    $("#tipo-adicional-grid_"+idadd).empty();                    
                    $("#tipo-adicional-grid_"+idadd).append("<option value=>Selecione um Tipo de Adicional</option>")
                    for(let i=0;i<j.data.length;i++){           
                      
                        $("#tipo-adicional-grid_"+idadd).append("<option value="+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</option>")
                    
                         }
                      

                }else{
                    $("#tipo-adicional-grid_"+idadd).empty();               
                    $("#tipo-adicional-grid_"+idadd).append("<option value=>Por favor cadastre um tipo de adicional</option>")
                }
               
             
            }
             
            });
            
          })
    },

 


    loadTiposAdicionais : () => {
        $('#categoria_adicionais').change(function(e){

            let idcat = $(this).val();
            if(idcat != 'undefined' && idcat != '' ){
          $.ajax({
            url: 'controllers/tipos_adicionais.php?action=tag',
            method: "post",         
            data: {"idcat": idcat},            
            
    
            success: function(data){ 
                let j = JSON.parse(data);           
                if(j.data.length){
                    $(".list-tipo-adcionais").empty();                    
                    $(".list-tipo-adcionais").append("<option value=>Selecione um Tipo de Adicional</option>")
                    for(let i=0;i<j.data.length;i++){           
                      
                        $(".list-tipo-adcionais").append("<option value="+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</option>")
                    
                         }


                }else{
                    $(".list-tipo-adcionais").empty();               
                    $('.list-tipo-adcionais').append("<option value=>Por favor cadastre um tipo de adicional</option>")
                }
             
            }
             
            });
        }else{
            $(".list-tipo-adcionais").empty();                    
            $(".list-tipo-adcionais").append("<option value=>Selecione um Tipo de Adicional</option>")
        }
        });
    },


    loadTiposAdicionaisBusca : () => {
        $('#categoria_adicionais_busca').change(function(e){
            let idcat = $(this).val();
              
            $.ajax({
              url: 'controllers/tipos_adicionais.php?action=tag',
            method: "post",         
            data: {"idcat": idcat},                       
                
    
            success: function(data){ 
                let j = JSON.parse(data);           
                if(j.data.length){
                    $("#adicionais-busca").empty();      
                    $('#adicionais-busca').append("<option value=>Selecione um  Tipo de Adicional</option>")
                    for(let i=0;i<j.data.length;i++){          
                      
                        $("#adicionais-busca").append("<option value="+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</option>")
                    
                         }
                } 
             
            }
             
            });

        });
    },

     loadTable : () =>{

        ad.table_ad.ajax.reload();
    },
    
    init : () => {
        ad.update();
        ad.loadTiposAdicionaisBusca();
        ad.loadTiposAdicionaisGrid();
        ad.delete();
        ad.search();
        ad.loadTiposAdicionais();
        ad.formataValorAdicional();
        ad.create();
    },
    fn : () => {
        return ad.init();
    },
    
  
 

}