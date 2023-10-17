
'use-strict' 

 
export const cupom =  {

    
    table_cupom : $('#cupoms').DataTable({
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
            url : '../cadastros/controllers/cupom/carrega_cupom.php'
        },
       
        "order": [],
        columns: [
            {data:'nome_cupom'}, 
            {data: 'porcentagem'},
            {data: 'quantidade'},
            {data: 'data_validade'},
            {data: 'situacao'},
            {data: 'exibir_no_site'},
            {data: 'excluir'},


        ],
        createdRow: (row) => {            
                $(row).addClass('border-b text-center');
        },
        columnDefs: [
            { orderable: true, targets: 0 },
            { targets: [6], className: "delete_cupom"},            
        ],


        "initComplete": function () {
            var api = this.api();
            
            $('#cupoms').show();
            api.columns.adjust();
          },
      
    
    }), 

    showCalendar : () =>{
        $("#cupoms" ).on('focus', 'input#datepicker.atualiza_cupom', function(e){
           $(e.currentTarget).datepicker({
            autoclose: true,
            container: true,
            format: 'dd/mm/yyyy',
            daysOfWeekDisabled: '0,6',
            todayHighlight: true,
            orientation: 'top',         
             }).on('changeDate', function(){             
                   
                    $(this).trigger('change');               
                  
             })
           
        });

        
        
         
    },

    mostrarCupom : () => {
        $('#cupoms').on('click', '.exibirsite', function(e){
            var idcupom = $(e.currentTarget).data('idcupom');
            $(this).prop('disabled', true);

            let url = $(this).data('url');
      
            $.ajax({
              url: url + '/controllers/cupom/mostra_cupom.php',
              method: 'post',
              data: {'iddocupom' : idcupom},
              success: function(data){
                $('.exibirsite').prop('disabled', false);
                let j = JSON.parse(data);
                $('#msg1').html("");
                $('#msg1').show();
                if(j.success && !j.error){                 
                    $('#msg1').html(j.msg);  
                    setTimeout(function(){                      
                       
                        $('#msg1').fadeOut();
                        $('#msg1').html("");
                    },3000)
                     cupom.table_cupom.ajax.reload();                    
                   
                }else if(!j.success & j.error){
                    $('#msg1').html(j.msg);  
                    setTimeout(function(){                        
                      
                        $('#msg1').fadeOut();
                    },3000)   
                    cad.table_cat.ajax.reload();
                }
      
              }
            });
          });


    },



    update : (e) =>{   
                    
        $('#cupoms').on('change','.atualiza_cupom', function(e){
                  
            e.preventDefault();
          
            let idCupom = $(e.currentTarget).data('idcupom');
            let url = $(e.currentTarget).data('url');    
            let flag = $(e.currentTarget).data('flag') ? $(e.currentTarget).data('flag') : false;
            let nomeCupom =  $("input[name='ativacao']" ).filter('.'+'atualiza_cupom'+'[data-idcupom="'+idCupom+'"]').val();
            let descontoCupom =  $("input[name='porcentagem']" ).filter('.'+'atualiza_cupom'+'[data-idcupom="'+idCupom+'"]').val();
            let totalVezesCupom =  $("input[name='total_vezes']" ).filter('.'+'atualiza_cupom'+'[data-idcupom="'+idCupom+'"]').val();
            let dataValidaCupom =  $("input[name='data_validade']" ).filter('.'+'atualiza_cupom'+'[data-idcupom="'+idCupom+'"]').val();
            let updateCupom = true;
           
       
        $.ajax({
            url: url + '/controllers/cupom/update_cupom.php',
            method: "post",
            data: {updatecupom: updateCupom, flagName:flag, id_cupom: idCupom, ativacao: nomeCupom, porcentagem: descontoCupom,  data_validade: dataValidaCupom, total_vezes: totalVezesCupom},
        
            success: function(data){ 
                let j = JSON.parse(data);
        
                if(j.success && !j.error){   
                    $('#msg1').html("");
                    $('#msg1').show();               
                    setTimeout(function(){
                        
                      
                        $('#msg1').fadeOut();
                    },3000)
                    cupom.table_cupom.ajax.reload();
                   
                }else if(!j.success & j.error){
                    $('#msg1').html(j.msg);  
                    setTimeout(function(){
                        
                       
                        $('#msg1').fadeOut();
                    },3000)
                         cupom.table_cupom.ajax.reload();
               
                } 
                  
              }
            });
     
          })
          
    
     
       
    },

    create : () =>{

        $('#cadCupom').on('submit', function(e){

            e.preventDefault();
             
                    

            let url = $(this).data('url');
           
            
        
        
            $.ajax({
                url: url + '/controllers/cupom/cadastra_cupom.php',
                method: "post",
                data: $('#cadCupom').serialize(),

                success: function(data){ 
                    let j = JSON.parse(data);
                    $('#msg').html("");
                    $('#msg').show();
                    if(j.success && !j.error){
                        $('#msg').html(j.msg);  
                        setTimeout(function(){
                        
                          
                            $('#msg').fadeOut();
                        },3000)
                        $('#cadCupom')[0].reset();
                        cupom.table_cupom.ajax.reload();
                     
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

        $("#cupoms").on('click', '.excluircupom', function(e){     
        
    
                var idcupom = $(e.currentTarget).data('idcupom');
                let url = $(e.currentTarget).data('url');  
                GrowlNotification.notify({
                    title: 'Atenção!',
                    description: 'Tem certeza de que deseja deletar esse cupom?',
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
                                url: url+'/controllers/cupom/deleta_cupom.php',
                              method: 'post',
                              data: {'iddocupom' : idcupom,},
                              success: function(data){
                                let j = JSON.parse(data);
                                $('#msg1').html("");
                                $('#msg1').show();
                                if(j.success && !j.error){  
                                    $('#msg1').html(j.msg);                            
                                    setTimeout(function(){
                        
                                     
                                        $('#msg1').fadeOut();
                                    },3000)                  
                                    cupom.table_cupom.ajax.reload();                            
                                    $('.excluircupom').prop('disabled', false);
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

//     search : () => {
//     $("#search_adicionais").off().on("keyup", function() {
                
//         ad.table_ad.column(2).search(this.value).draw();
        

//     });
//     $("#categoria_adicionais_busca").change(function() {
//         ad.table_ad.column(1).search("").draw();       
//         ad.table_ad.column(0).search(this.value).draw();
       
//     });

//     $("#adicionais-busca").change(function() {
                
//         ad.table_ad.column(1).search(this.value).draw();
         

//     });

   
// },
   
    // loadTiposAdicionaisGrid : () => {

    //     $('#cad_adicionais').on('change','#categoria-adicional-grid', function(e){
                  
    //         e.preventDefault();
    //       let idcat = $(this).val();
    //       let idadd = $(this).data('idadd')

    //       $.ajax({
    //         url: 'controllers/carrega_tipos_adicionais_inputs.php?idcat='+idcat,
    //         method: "get",            
    
    //         success: function(data){ 
    //             let j = JSON.parse(data);           
    //             if(j.data.length){
    //                 $("#tipo-adicional-grid_"+idadd).empty();                    
    //                 $("#tipo-adicional-grid_"+idadd).append("<option value=>Selecione um Tipo de Adicional</option>")
    //                 for(let i=0;i<j.data.length;i++){           
                      
    //                     $("#tipo-adicional-grid_"+idadd).append("<option value="+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</option>")
                    
    //                      }
                      

    //             }else{
    //                 $("#tipo-adicional-grid_"+idadd).empty();               
    //                 $("#tipo-adicional-grid_"+idadd).append("<option value=>Por favor cadastre um tipo de adicional</option>")
    //             }
               
             
    //         }
             
    //         });
            
    //       })
    // },

 


    // loadTiposAdicionais : () => {
    //     $('#categoria_adicionais').change(function(e){

    //         let idcat = $(this).val();

    //       $.ajax({
    //         url: 'controllers/carrega_tipos_adicionais_inputs.php?idcat='+idcat,
    //         method: "get",            
    
    //         success: function(data){ 
    //             let j = JSON.parse(data);           
    //             if(j.data.length){
    //                 $(".list-tipo-adcionais").empty();                    
    //                 $(".list-tipo-adcionais").append("<option value=>Selecione um Tipo de Adicional</option>")
    //                 for(let i=0;i<j.data.length;i++){           
                      
    //                     $(".list-tipo-adcionais").append("<option value="+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</option>")
                    
    //                      }


    //             }else{
    //                 $(".list-tipo-adcionais").empty();               
    //                 $('.list-tipo-adcionais').append("<option value=>Por favor cadastre um tipo de adicional</option>")
    //             }
             
    //         }
             
    //         });

    //     });
    // },


    // loadTiposAdicionaisBusca : () => {
    //     $('#categoria_adicionais_busca').change(function(e){
    //         let idcat = $(this).val();
              
    //         $.ajax({
    //           url: 'controllers/carrega_tipos_adicionais_inputs.php?idcat='+idcat,
    //           method: "get",            
                
    
    //         success: function(data){ 
    //             let j = JSON.parse(data);           
    //             if(j.data.length){
    //                 $("#adicionais-busca").empty();      
    //                 $('#adicionais-busca').append("<option value=>Selecione um  Tipo de Adicional</option>")
    //                 for(let i=0;i<j.data.length;i++){          
                      
    //                     $("#adicionais-busca").append("<option value="+j.data[i].id_tipo+">"+j.data[i].nome_adicional+"</option>")
                    
    //                      }
    //             } 
             
    //         }
             
    //         });

    //     });
    // },

    //  loadTable : () =>{

    //     ad.table_ad.ajax.reload();
    // },
    
    init : () => {
        // ad.update();
        // ad.loadTiposAdicionaisBusca();
        // ad.loadTiposAdicionaisGrid();
        // ad.delete();
        // ad.search();
        // ad.loadTiposAdicionais();
        cupom.mostrarCupom();
        cupom.create();
        cupom.delete();
        cupom.update();
        cupom.showCalendar();
    },
    fn : () => {
        return cupom.init();
    },
    
  
 

}