
'use-strict' 
import{ noti } from './notification.js'



export const config = {



    update : () =>{


        $('#updateSenha').submit(function(e){

            e.preventDefault();

 
            let url = $(this).data('url');
           

          
            $.ajax({
                url: url + '/controllers/configuracoes.php?action=cus',
                method: "post",
                data:  $(this).serialize(),
        
                success: function(data){ 
                    let j = JSON.parse(data);
        
                    if(j.success && !j.error){
                        noti.init(j.error, j.msg)                    
                       
                        setTimeout(function(){

                            window.location.reload();

                        },3000)
                                       
                        
                       
                    }else if(!j.success & j.error)
                        noti.init(j.error, j.msg)       
                      
                }
                });
        
                
        


        })



        $('#updateFinanceiro').submit(function(e){

            e.preventDefault();

 
            let url = $(this).data('url');
         
        
          
            $.ajax({
                url: url + '/controllers/configuracoes.php?action=cuf',
                method: "post",
                data: $(this).serialize(),
        
                success: function(data){ 
                    let j = JSON.parse(data);
        
                    if(j.success && !j.error){
                        noti.init(j.error, j.msg)                    
                       
                        setTimeout(function(){

                            window.location.reload();

                        },3000)
                                       
                        
                       
                    }else if(!j.success & j.error)
                        noti.init(j.error, j.msg)       
                      
                }
                });
        
                
        


        });



        $('#updatePedido').submit(function(e){

            e.preventDefault();

 
            let url = $(this).data('url');
         
            let formData = new FormData($("#updatePedido")[0])
           


            let imgItemLogo = $('#file-5')[0] ? $('#file-5')[0].files[0] : "";
            let removImgLogo = $('#file-5').data('rmv');
   

            (imgItemLogo!=undefined && imgItemLogo != null && imgItemLogo!="") ? formData.set('img_logo', imgItemLogo) : formData.delete('img_logo');
            (removImgLogo == true && removImgLogo != undefined && (imgItemLogo==undefined || imgItemLogo == null || imgItemLogo == "")) ?  formData.set('img_logo', "") : "";
        


            let imgItemHeader = $('#file-6')[0] ? $('#file-6')[0].files[0] :  "";
            let removImgHeader = $('#file-6').data('rmv');
  
            (imgItemHeader!=undefined && imgItemHeader != null && imgItemHeader!="" ) ? formData.set('img_header', imgItemHeader) : formData.delete('img_header');
            (removImgHeader == true && removImgHeader != undefined && (imgItemHeader==undefined || imgItemHeader == null || imgItemHeader == '')) ?  formData.set('img_header',  "") : "";
        


            $.ajax({
                url: url + '/controllers/configuracoes.php?action=cup',
                method: "post",
                processData: false,
                contentType: false,
                data: formData,
        
                success: function(data){ 
                    let j = JSON.parse(data);
        
                    if(j.success && !j.error){
                        noti.init(j.error, j.msg)                    
                       
                        setTimeout(function(){

                            window.location.reload();

                        },3000)
                                       
                        
                       
                    }else if(!j.success & j.error)
                        noti.init(j.error, j.msg)       
                      
                }
                });
        
                
        


        })

    },
    loadImgProd : () =>{
       
      
       
        $("#file-5").change(function(event) {  
            
            var tmppath = URL.createObjectURL(event.target.files[0]);  
         
            $("#img_prod").attr("src",  "");
            $("#img_prod").attr("src",  tmppath.toString());
            $("#img_prod").attr("style", "margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;height: 340px;");    
            $('#show_img_prod').show();
            $("#label-file").hide();
            $("#label-icon").hide();
            
            $('#container-img').removeClass('container-hover');
            // $(this).val(null);
       
        });

                $("#show_img_prod").on('click', function(e){

                    $('#file-5').click();

                })

                $("#remove-img").on('click', function(e){


                    $("#img_prod").attr("src",  "");
                    $("#img_prod").attr("style", "");
                    $('#show_img_prod').hide();
                    $("#label-file").show();
                    $("#label-icon").show();
                    $('#label-text').show();
                    $('#container-img').addClass('container-hover')
                    $("#file-5").attr('data-rmv', "true");
                    $("#file-5").val(null);
                    e.stopPropagation();

                })

                //File 6


                $("#file-6").change(function(event) {  
            
                    var tmppath = URL.createObjectURL(event.target.files[0]);  
                 
                    $("#img_prod-2").attr("src",  "");
                    $("#img_prod-2").attr("src",  tmppath.toString());
                    $("#img_prod-2").attr("style", "margin: 0 auto;height: 340px;");    
                    $('#show_img_prod-2').show();
                    $("#label-file-2").hide();
                    $("#label-icon-2").hide();
                    
                    $('#container-img-2').removeClass('container-hover');
                    // $(this).val(null);
               
                });
        
                        $("#show_img_prod-2").on('click', function(e){
        
                            $('#file-6').click();
        
                        })
        
                        $("#remove-img-2").on('click', function(e){
        
        
                            $("#img_prod-2").attr("src",  "");
                            $("#img_prod-2").attr("style", "");
                            $('#show_img_prod-2').hide();
                            $("#label-file-2").show();
                            $("#label-icon-2").show();
                            $('#label-text-2').show();
                            $('#container-img-2').addClass('container-hover')
                            $("#file-6").attr('data-rmv', "true");
                            $("#file-6").val(null);
                            e.stopPropagation();
        
                        })
        
    
    
                 
    
    
  
  

},

    init : () =>{

        config.update();
        config.loadImgProd();



    },

    fn : () => {
        return config.init();
    },
    













}