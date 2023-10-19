
'use-strict' 

 
export const f_pagamento =  {

    
    table_formas : $('#formas-pagamento').DataTable({
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
     
        processing: true,
        "ajax" : {
            url : '../cadastros/controllers/formas_pagamento/carrega_formas_pagamento.php',
            
        },
       
        "order": [],
        columns: [
            {data:'forma_pagamento'}, 
            {data: 'aceita'},          
            {data: 'excluir'},

        ],
        createdRow: (row) => {            
                $(row).addClass('border-b text-center');
        },
        columnDefs: [
            { orderable: true, targets: 0 },           
        ],


        "initComplete": function () {
            var api = this.api();
            
            $('#formas-pagamento').show();
            api.columns.adjust();
          },
      
    
    }), 
 
 


    update : () =>{   
                    
        $('#formas-pagamento').on('change','.atualiza_forma', function(e){
                  
            e.preventDefault();
          
            let idfp = $(e.currentTarget).data('idfp');
            let formaPagamento = $(e.currentTarget).val();
            let url = $(e.currentTarget).data('url');    
          
            let updateForma = true;
           
       
        $.ajax({
            url: url + '/controllers/formas_pagamento/update_formas_pagamento.php',
            method: "post",
            data: {id_f_pagamento: idfp, f_pagamento:formaPagamento, updateforma: updateForma},
        
            success: function(data){ 
                let j = JSON.parse(data);
                $('#msg1').html("");
                $('#msg1').show();   
                if(j.success && !j.error){   
                
                    $('#msg1').html(j.msg);
                               
                    setTimeout(function(){                   
               
                        $('#msg1').fadeOut();
                    },3000)
                    f_pagamento.table_formas.ajax.reload();
                   
                }else if(!j.success & j.error){
                    $('#msg1').html(j.msg);  
                    setTimeout(function(){
                        
                       
                        $('#msg1').fadeOut();
                    },3000)
                         f_pagamento.table_formas.ajax.reload();
               
                } 
                  
              }
            });
     
          })
          
    
     
       
    },

    create : () =>{

        $('#cadFormasPagamento').on('submit', function(e){

            e.preventDefault();
             
                    

            let url = $(this).data('url');
           
            
        
        
            $.ajax({
                url: url + '/controllers/formas_pagamento/cadastra_formas_pagamento.php',
                method: "post",
                data: $('#cadFormasPagamento').serialize(),

                success: function(data){ 
                    let j = JSON.parse(data);
                    $('#msg').html("");
                    $('#msg').show();
                    if(j.success && !j.error){
                        $('#msg').html(j.msg);  
                        setTimeout(function(){
                        
                          
                            $('#msg').fadeOut();
                        },3000)
                        $('#cadFormasPagamento')[0].reset();
                        f_pagamento.table_formas.ajax.reload();         
                     
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

    delete : () => {

        $("#formas-pagamento").on('click', '.delete_forma', function(e){     
        
    
                var idfp = $(e.currentTarget).data('idfp');
                let url = $(e.currentTarget).data('url');  
                GrowlNotification.notify({
                    title: 'Atenção!',
                    description: 'Tem certeza de que deseja deletar essa forma de pagamento?',
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
                                url: url+'/controllers/formas_pagamento/deleta_formas_pagamento.php',
                              method: 'post',
                              data: {'idfp' : idfp,},
                              success: function(data){
                                let j = JSON.parse(data);
                                $('#msg1').html("");
                                $('#msg1').show();
                                if(j.success && !j.error){  
                                    $('#msg1').html(j.msg);                            
                                    setTimeout(function(){
                        
                                     
                                        $('#msg1').fadeOut();
                                    },3000)                  
                                    f_pagamento.table_formas.ajax.reload();                            
                                 
                                }else{
                                    $('#msg1').html(j.msg);  
                                    setTimeout(function(){
                        
                                      
                                        $('#msg1').fadeOut();
                                    },3000)
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
    
 
    $("#search_forma").off().on("keyup", function() {
                
        f_pagamento.table_formas.column(0).search(this.value).draw();
         

    });

   
},
       
    init : () => {         
     
        f_pagamento.search();  
        f_pagamento.create();
        f_pagamento.delete();
        f_pagamento.update();
       
    },
    fn : () => {
        return f_pagamento.init();
    },
    
  
 

}