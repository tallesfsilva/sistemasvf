
'use-strict' 
import{ noti } from '../notification.js'
 
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
            url : '../cadastros/controllers/cupom.php?action=cul'
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
              url: url + '/controllers/cupom.php',
              method: 'post',
              data: {'idcupom' : idcupom, action : "cum"},
              success: function(data){
                $('.exibirsite').prop('disabled', false);
                let j = JSON.parse(data);
          
              
                if(j.success && !j.error){
                    noti.init(j.error, j.msg);
                 
                    cupom.table_cupom.ajax.reload();
                 
                }else if(!j.success & j.error){
                    noti.init(j.error,j.msg);
                    cupom.table_cupom.ajax.reload();   
                 
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
            url: url + '/controllers/cupom.php',
            method: "post",
            data: {action: "cuu", flagName:flag, id_cupom: idCupom, ativacao: nomeCupom, porcentagem: descontoCupom,  data_validade: dataValidaCupom, total_vezes: totalVezesCupom},
        
            success: function(data){ 
                let j = JSON.parse(data);
        
                if(j.success && !j.error){
                    noti.init(j.error, j.msg);
                 
                    cupom.table_cupom.ajax.reload();
                 
                }else if(!j.success & j.error){
                    noti.init(j.error,j.msg);
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
                url: url + '/controllers/cupom.php',
                method: "post",
                data: $('#cadCupom').serialize(),

                success: function(data){ 
                    let j = JSON.parse(data);
                   
                    if(j.success && !j.error){
                        noti.init(j.error, j.msg);
                        $('#cadCupom')[0].reset();
                        cupom.table_cupom.ajax.reload();
                     
                    }else if(!j.success & j.error){
                        noti.init(j.error,j.msg);
                        cupom.table_cupom.ajax.reload();   
                     
                    }                            
                   
                }
                }); 
        })
 

},

    delete : () => {

        $("#cupoms").on('click', '.excluircupom', function(e){     
        
                if(!$('.growl-notification').is(":visible")){
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
                                url: url+'/controllers/cupom.php',
                              method: 'post',
                              data: {'idcupom' : idcupom, action: "cue"},
                              success: function(data){
                                let j = JSON.parse(data);
                                if(j.success && !j.error){
                                    noti.init(j.error, j.msg);
                                  
                                    cupom.table_cupom.ajax.reload();
                                    $('.excluircupom').prop('disabled', false);
                                }else if(!j.success & j.error){
                                    noti.init(j.error,j.msg);
                                    cupom.table_cupom.ajax.reload();   
                                 
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
    
    $("#cupom_busca_situacao").change(function() {
         
        cupom.table_cupom.column(4).search(this.value).draw();
       
    });

    $("#search_cupom").off().on("keyup", function() {
                
        cupom.table_cupom.column(0).search(this.value).draw();
         

    });

   
},
       
    init : () => {         
     
        cupom.search();     
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