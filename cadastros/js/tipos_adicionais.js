'use-strict'


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
             url : '../cadastros/controllers/carrega_tipos_adicionais.php'
         },
            columns: [{data:'nome_cat'}, 
                    {data: 'tipo_adicional'},
                    {data: 'quantidade'},
                    {data: 'excluir'}         
                  ],
            createdRow: (row) => {            
                    $(row).addClass('border-b text-center');
            },
            columnDefs: [
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
            let updateAdicional =  true;
           

    
      
       
        
        $.ajax({
            url: url + '/controllers/update_tipo_adicional.php',
            method: "post",
            data: {flagName: flag, id_tipo: idTipo, nome_adicional: nomeAdicional,  updatetipoadicional: updateAdicional, id_cat:idCategoria, quantidade:qtd,},
        
            success: function(data){ 
                let j = JSON.parse(data);
        
                if(j.success && !j.error){                 
                        
                    tipo.table_tipos.ajax.reload();
                   
                }else if(!j.success & j.error)
                $('#msg-tip').html(j.msg);   
               
                  
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
                let cadAdicional =  true;
                let qtd = $("input[name='quantidade']",this).val()
            
                $.ajax({
                    url: url + '/controllers/cadastra_tipo_adicional.php',
                    method: "post",
                    data: {nome_adicional: nomeAdicional,  cadastratipoadicional: cadAdicional, id_cat:idCategoria, quantidade:qtd,},

                    success: function(data){ 
                        let j = JSON.parse(data);

                        if(j.success){
                            $('#msg-tip').html(j.msg);
                            $('#cadTipoAdicional')[0].reset();
                            tipo.table_tipos.ajax.reload();
                        }else{
                            $('#msg-tip').html(j.msg);
                        }                      
                         
                    }
                    }); 
            })
     

    },

    delete : () => {
     
        $('#tipo_adicionais').on('click', '.deletar_tipo', function(e){

            let idtipo = $(e.currentTarget).data('idtipo');
            let url = $(e.currentTarget).data('url');  
            GrowlNotification.notify({
              title: 'Atenção!',
              description: 'Tem certeza de que deseja deletar esse tipo de adicional?',
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
                      url: url+'/controllers/deleta_tipo_adicional.php',
                      method: 'post',
                      data: {'id_tipo' : idtipo},
                      success: function(data){ 
                        let j = JSON.parse(data)
                        if(j.success){
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

          });
      
    },

    search : () => {
        $("#search_tipo_adicional").off().on("keyup", function() {
                
            tipo.table_tipos.column(1).search(this.value).draw();
        
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