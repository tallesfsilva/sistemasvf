
'use-strict' 

import{ tipo } from './tipos_adicionais.js'
import{ ad } from './adicionais.js'
import{ noti } from './notification.js'

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
            url : '../cadastros/controllers/categorias.php?action=cl'
        },
        columns: [{data:'nome_cat'}, {data: 'excluir'}],
        createdRow: (row) => {            
                $(row).addClass('border-b text-center');
        },
        "order": [],
        columnDefs: [
            { orderable: true, targets: 0 },
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
            url: url + '/controllers/categorias.php',
            method: "post",
            data: {nome_cat: nomeCat, cat_id: catId,  cat_update:catUpdate , action: "cu"},
        
            success: function(data){ 
                let j = JSON.parse(data);
        
                if(j.success && !j.error){    
                    noti.init(j.error, j.msg)             
                    cad.loadCategorias();
                    tipo.loadTable();
                    ad.loadTable();  
                    cad.table_cat.ajax.reload();
                    
                   
                }else if(!j.success & j.error){
                    noti.init(j.error,j.msg);
                     
                    cad.table_cat.ajax.reload();
                }
            
               
                  
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
                url: url + '/controllers/categorias.php',
                method: "post",
                data: {nome_cat: nomeCat, user_id: userId, action: "cc" , cadastrarcategoria:catCadastrar},
        
                success: function(data){ 
                    let j = JSON.parse(data);
        
                    if(j.success && !j.error){
                        noti.init(j.error, j.msg)                    
                        $('#cadCategoria')[0].reset();
                        cad.loadCategorias();
                        tipo.loadTable();
                        ad.loadTable();                      
                        cad.table_cat.ajax.reload();
                       
                    }else if(!j.success & j.error)
                        noti.init(j.error, j.msg)       
                      
                }
                });
        
                
        
        
         });
        

    },

    delete : () => {

        $("#categorias").on('click', '.deletar_cat', function(e){
          
        
        let idcat = $(e.currentTarget).data('idcat');
        let url = $(e.currentTarget).data('url');  
        if(!$('.growl-notification').is(":visible")){
        GrowlNotification.notify({
          title: 'Atenção!',
          description: '<center>Tem certeza de que deseja deletar essa categoria?</br> Isso irá apagar todos os tipos de adicionais e adicionais vinculados a essa categoria.</center>',
          type: 'error',
          image: {
            visible: true,
            customImage: url+'img/danger.png'
          },
          position: 'top-center',
          showProgress: true,
          closeWith : ['button'],
          showButtons: true,
          buttons: {
            action: {
              text: 'SIM',
              callback: function(){
                $.ajax({
                  url: url+'/controllers/categorias.php',
                  method: 'post',
                  data: {'idcat' : idcat, "action" : "ce"},
    
    
                  success: function(data){ 
                    let j = JSON.parse(data)
                    if(j.success && !j.error){
                        noti.init(j.error, j.msg)
                        tipo.loadTable();
                        ad.loadTable();    
                        cad.loadCategorias();
                        cad.table_cat.ajax.reload();
                    }else if(!j.success & j.error)
                         noti.init(j.error, j.msg)       
                  
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
    $("#search-categorias").off().on("keyup", function() {
                
        cad.table_cat.column(0).search(this.value).draw();

    });

},
   
    loadCategorias : () => {

          $.ajax({
            url: 'controllers/categorias.php?action=cli',
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