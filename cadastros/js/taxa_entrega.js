
'use-strict' 

 
export const entrega =  {

    
    table_taxa : $('#taxa-entrega').DataTable({
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
            url : '../cadastros/controllers/taxa_entrega/carrega_taxa_entrega.php'
        },
       
        "order": [],
        columns: [
            {data:'estado'}, 
            {data: 'cidade'},          
            {data: 'bairro'},
            {data: 'taxa_de_entrega'},
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
            
            $('#taxa-entrega').show();
            api.columns.adjust();
          },
      
    
    }), 
 
 


    update : () =>{   
                    
        $('#taxa-entrega').on('change','.atualiza_taxa', function(e){
                  
            e.preventDefault();
          
            let idTaxa = $(e.currentTarget).data('idtaxa');
            let valorTaxa = $(e.currentTarget).val();
            let url = $(e.currentTarget).data('url');    
          
            let updateTaxa = true;
           
       
        $.ajax({
            url: url + '/controllers/taxa_entrega/update_taxa_entrega.php',
            method: "post",
            data: {id: idTaxa, taxa:valorTaxa, updatetaxa: updateTaxa},
        
            success: function(data){ 
                let j = JSON.parse(data);
                $('#msg1').html("");
                $('#msg1').show();   
                if(j.success && !j.error){   
                
                    $('#msg1').html(j.msg);
                               
                    setTimeout(function(){                   
               
                        $('#msg1').fadeOut();
                    },3000)
                    entrega.table_taxa.ajax.reload();
                   
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

        $('#cadTaxaEntrega').on('submit', function(e){

            e.preventDefault();
             
                    

            let url = $(this).data('url');
           
            
        
        
            $.ajax({
                url: url + '/controllers/taxa_entrega/cadastra_taxa_entrega.php',
                method: "post",
                data: $('#cadTaxaEntrega').serialize(),

                success: function(data){ 
                    let j = JSON.parse(data);
                    $('#msg').html("");
                    $('#msg').show();
                    if(j.success && !j.error){
                        $('#msg').html(j.msg);  
                        setTimeout(function(){                
                          
                            $('#msg').fadeOut();
                        },3000)
                        $('#cadTaxaEntrega')[0].reset();
                        entrega.table_taxa.ajax.reload();         
                     
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

        $("#taxa-entrega").on('click', '.delete_taxa', function(e){     
        
    
                var idTaxa = $(e.currentTarget).data('idtaxa');
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
                                url: url + '/controllers/taxa_entrega/deleta_taxa_entrega.php',
                              method: 'post',
                              data: {'id' : idTaxa,},
                              success: function(data){
                                let j = JSON.parse(data);
                                $('#msg1').html("");
                                $('#msg1').show();
                                if(j.success && !j.error){  
                                    $('#msg1').html(j.msg);                            
                                    setTimeout(function(){
                        
                                     
                                        $('#msg1').fadeOut();
                                    },3000)                  
                                    entrega.table_taxa.ajax.reload();                            
                                 
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

    loadOptions : () =>{
            
            let url = $('#estados_busca').data('url');
          

            $.getJSON(url+ 'estados_cidades.json', function (data) {

            var items = [];
            var options = '<option value="">Selecione o Estado</option>';	
                
            $.each(data, function (key, val) {
                options += '<option value="' + val.sigla + '">' + val.sigla + '</option>';
            });					
            $("#estados_busca").html(options);				
    
            $("#estados_busca").change(function () {				
    
                var options_cidades = '';
                var str = "";					
    
                $("#estados_busca option:selected").each(function () {
                    str += $(this).text();
                });
    
                $.each(data, function (key, val) {
                    if(val.sigla == str) {							
                        $.each(val.cidades, function (key_city, val_city) {
                            options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                        });							
                    }
                });
    
                $("#cidades_busca").html(options_cidades);
    
            }).change();		
    
        });
    


    },


    search : () => {
       
        $("#estados_busca").change(function() {
            entrega.table_taxa.column(1).search("").draw();       
            entrega.table_taxa.column(0).search(this.value).draw();
           
        });

        $("#cidades_busca").change(function() {               
            entrega.table_taxa.column(1).search(this.value).draw();
           
        });
 
    $("#search_taxa").off().on("keyup", function() {
                
        entrega.table_taxa.column(2).search(this.value).draw();
         

    });

   
},
       
    init : () => {         
        entrega.loadOptions();
        entrega.search();  
        entrega.create();
        entrega.delete();
        entrega.update();
       
    },
    fn : () => {
        return entrega.init();
    },
    
  
 

}