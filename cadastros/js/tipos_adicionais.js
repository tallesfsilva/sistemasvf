'use-strict'

import{ ad } from './adicionais.js'

import{ noti } from './notification.js'

export const tipo = {
 

    table_tipos : $('#tipo_adicionais').DataTable({
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
             url : '../cadastros/controllers/tipos_adicionais.php?action=tal'
         },
            columns: [{data:'nome_cat'}, 
                    {data: 'tipo_adicional'},
                    {data: 'quantidade'},
                    {data: 'excluir'}         
                  ],
            createdRow: (row) => {            
                    $(row).addClass('border-b text-center');
            },
            "order": [],
            columnDefs: [
                { orderable: true, targets: 0 },
                { targets: [3], className: "delete_tipo"},            
            ]
    }), 

    update : (e) =>{
       
        $('#tipo_adicionais').on('change','.atualiza_tipo', function(e){
              
        
            let idTipo = $(e.currentTarget).data('idtipo');
            let url = $(e.currentTarget).data('url');  
            let flag = $(e.currentTarget).data('flag') ? $(e.currentTarget).data('flag') : false;
            let nomeAdicional =  $("input[name='nome_adicional']" ).filter('.'+'atualiza_tipo'+'[data-idtipo="'+idTipo+'"]').val();
            let idCategoria =  $("select[name='id_cat']" ).filter('.'+'atualiza_tipo'+'[data-idtipo="'+idTipo+'"]').val();
            let qtd =  $("input[name='quantidade']" ).filter('.'+'atualiza_tipo'+'[data-idtipo="'+idTipo+'"]').val();
         
           

    
      
       
        
        $.ajax({
            url: url + '/controllers/tipos_adicionais.php?action=tau',
            method: "post",
            data: {flagName: flag, id_tipo: idTipo, nome_adicional: nomeAdicional, id_cat:idCategoria, quantidade:qtd,},
        
            success: function(data){ 
                let j = JSON.parse(data);
        
                if(j.success && !j.error){    
                    noti.init(j.error, j.msg)                        
                    ad.loadTiposAdicionaisBusca();  
                    ad.loadTiposAdicionais();                           
                    ad.loadTable();  
                    tipo.table_tipos.ajax.reload();
                   
                }else if(!j.success & j.error){
                    noti.init(j.error, j.msg)            
                    tipo.table_tipos.ajax.reload();
                       
                } 
            }
            });
        })
    },

    create : () =>{      
                $('#cadTipoAdicional').on('submit', function(e){

                e.preventDefault();
            
                let url = $(this).data('url');
               
                
                let nomeAdicional =  $("input[name='nome_adicional']",this).val();
                let idCategoria =  $("select[name='id_cat']",this).val();
               
                let qtd = $("input[name='quantidade']",this).val()
            
                $.ajax({
                    url: url + '/controllers/tipos_adicionais.php?action=tac',
                    method: "post",
                    data: {nome_adicional: nomeAdicional, id_cat:idCategoria, quantidade:qtd,},

                    success: function(data){ 
                        let j = JSON.parse(data);

                        if(j.success && !j.error){
                            noti.init(j.error, j.msg);
                            $('#cadTipoAdicional')[0].reset();            
                            ad.loadTiposAdicionaisBusca();  
                            ad.loadTiposAdicionais();                           
                            ad.loadTable();
                            tipo.table_tipos.ajax.reload();
                         } else if(!j.success && j.error){
                            noti.init(j.error,j.msg);
                     
                        }                      
                    }
                  
                    }); 
            })
     

    },

    delete : () => {
     
        $('#tipo_adicionais').on('click', '.deletar_tipo', function(e){

            let idtipo = $(e.currentTarget).data('idtipo');
            let url = $(e.currentTarget).data('url');  
            if(!$('.growl-notification').is(":visible")){
            GrowlNotification.notify({
              title: 'Atenção!',
              description: '<center>Tem certeza de que deseja deletar esse tipo de adicional?</br> Isso irá apagar todos os adicionais vinculados a este tipo de adicional.</center>',
              type: 'error',
              image: {
                visible: true,
                customImage: url+'img/danger.png'
              },
              position: 'top-center',
              showProgress: true,
              showButtons: true,
              buttons: {
                action: {
                  text: 'SIM',
                  callback: function(){
                    $.ajax({
                      url: url+'/controllers/tipos_adicionais.php?action=tae',
                      method: 'post',
                      data: {'id_tipo' : idtipo},
                      success: function(data){ 
                        let j = JSON.parse(data)
                        if(j.success && !j.error){
                            noti.init(j.error, j.msg)           
                            ad.loadTiposAdicionaisBusca();  
                            ad.loadTiposAdicionais();                           
                            ad.loadTable();
                            tipo.table_tipos.ajax.reload();
                        }  else if(!j.success && j.error){
                            noti.init(j.error, j.msg)    ;
                            tipo.table_tipos.ajax.reload();   
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
       
        $("#search_tipo_adicional").off().on("keyup", function() {
                
            tipo.table_tipos.column(1).search(this.value).draw();
        
        });

        $("#categoria-busca-tipo").change(function() {
                
            tipo.table_tipos.column(0).search(this.value).draw();
    
        });
    
        

},

   
    init : () => {
        tipo.update();
        tipo.create();
        tipo.delete();
        tipo.search();
    },
    fn : () => {
        return tipo.init();
    },

    loadTable : () =>{

        tipo.table_tipos.ajax.reload();
    }
    
  
}