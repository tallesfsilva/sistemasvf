
'use-strict' 

import{ tipo } from './tipos_adicionais.js'

export const cad =  {

    table_cat : $('#categorias').DataTable({
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
            url : '../cadastros/controllers/carrega_categorias.php'
        },
        columns: [{data:'nome_cat'}, {data: 'excluir'}],
        createdRow: (row) => {            
                $(row).addClass('border-b text-center');
        },
        columnDefs: [
            { targets: [1], className: "delete_cat"},            
        ]
    
    }), 

    update : (e) =>{
        $('#categorias').on('change','.atualiza_cat', function(e){
              
           
       
        e.preventDefault();
    
     
        let url = $(this).data('url');
        
        let nomeCat =  $(this).val();
        let catId =   $(this).data('idcat'); 
        let catUpdate = true;
         
        
        $.ajax({
            url: url + '/controllers/update_categoria.php',
            method: "post",
            data: {nome_cat: nomeCat, cat_id: catId,  cat_update:catUpdate},
        
            success: function(data){ 
                let j = JSON.parse(data);
        
                if(j.success && !j.error){                 
                    cad.loadCategorias();
                    cad.table_cat.ajax.reload();
                    tipo.loadTable();
                   
                }else if(!j.success & j.error)
                $('#msg-cat').html(j.msg);   
               
                  
              }
            });
        })
    },

    create : () =>{

        $('#cadCategoria').on('submit', function(e){

            e.preventDefault();
        
         
            let url = $(this).data('url');
        
            let nomeCat =  $("input[name='nome_cat']",this).val();
         
            let userId = $("input[name='user_id']",this).val();
            let catCadastrar =  $("input[name='cadastrarcategoria']",this).val();
          
            $.ajax({
                url: url + '/controllers/cadastra_categoria.php',
                method: "post",
                data: {nome_cat: nomeCat, user_id: userId, cadastrarcategoria:catCadastrar},
        
                success: function(data){ 
                    let j = JSON.parse(data);
        
                    if(j.success && !j.error){
                        $('#msg-1').html(j.msg);
                        $('#cadCategoria')[0].reset();
                        cad.loadCategorias();
                        tipo.loadTable();
                        cad.table_cat.ajax.reload();
                       
                    }else if(!j.success & j.error)
                    $('#msg-1').html(j.msg);          
                      
                }
                });
        
                
        
        
         });
        

    },

    delete : () => {

        $("#categorias").on('click', '.deletar_cat', function(e){
          
        
        let idcat = $(e.currentTarget).data('idcat');
        let url = $(e.currentTarget).data('url');  
          
        GrowlNotification.notify({
          title: 'Atenção!',
          description: 'Tem certeza de que deseja deletar essa categoria? Isso irá apagar a categoria de todos os produtos associados a ela.',
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
                  url: url+'/controllers/deleta_categoria.php',
                  method: 'post',
                  data: {'idcat' : idcat},
    
    
                  success: function(data){ 
                    let j = JSON.parse(data)
                    if(j.success){
                        cad.loadCategorias();
                        cad.table_cat.ajax.reload();
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
    $("#search-categorias").off().on("keyup", function() {
                
        cad.table_cat.column(0).search(this.value).draw();

    });

},
   
    loadCategorias : () => {

          $.ajax({
            url: 'controllers/carrega_categorias_inputs.php',
            method: "get",            
    
            success: function(data){ 
                let j = JSON.parse(data);
                let listCat = $(".list-categoria");
                 for(let i=0;i<listCat.length;i++){
                    $(listCat[i]).empty();
                 }
                if(j.data.length){
                    $(".list-categoria").append("<option value=>Selecione uma Categoria</option>")
                    for(let i=0;i<j.data.length;i++){               
                      
                        $(".list-categoria").append("<option value="+j.data[i].id+">"+j.data[i].nome_cat+"</option>")
                    
                }
                }else{
                    $('.list-categoria').append("<option value=>Por favor cadastre uma categoria</option>")
                }              
                  
            }
            });
    },

    init : () => {
        cad.update();
        cad.create();
        cad.delete();
        cad.search();
        cad.loadCategorias();
    },
    fn : () => {
        return cad.init();
    },
    
  
 

}