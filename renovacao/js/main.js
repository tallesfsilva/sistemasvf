


(async function(){
"use strict"    
const t =  setInterval( async function () {
            var q = $('#noti').data('id');
            var s = $('#noti').data('url');       
            
                if(q && s){
                $.ajax({
                    url: s+"notification?q="+q.toString(),           
                    success: function (d) {                    
                        Cookies.remove('minutes');
                        Cookies.remove('seconds');
                        Cookies.remove('time'); 
                        if(d.paymentPaid && !d.error && d.paymentStatus == 'approved'){					
                         setTimeout(function(){
                                clearInterval(t);
                                window.location.assign(s+"sucesso/?q=true");                                
                            },3000)				
                        }else if(d.error){                            
                            return;
                        }
                    }
                });
            }else{
                return;
            }
            }, 30000);
            $('#pix_copy').on('click', async function(){                               
                    await navigator.clipboard.writeText($('#pix_qr').text()).then( () => {
                        $('#msg_pix').show();
                        setTimeout(function(){
                            $('#msg_pix').fadeOut();
                        },3000);                       
                    });

            })



          
var j = $('#noti').data('expiration'); 
 

var timer = j, minutes, seconds;
   
const y = setInterval(function(){   
                Cookies.set('time', timer)
                Cookies.set('minutes', parseInt(timer / 60, 10));
                Cookies.set('seconds',  parseInt(timer % 60, 10));         
                minutes =  Cookies.get('minutes');
                seconds =  Cookies.get('seconds');
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
               $('#minutes').text( minutes + ":" + seconds);              
                if (--timer < 0) {
                    timer = duration;
                    Cookies.remove('minutes');
                    Cookies.remove('seconds');
                    Cookies.remove('time');
                    var q = $('#minutes').data('id');
                    var s = $('#minutes').data('url');    
                    $('#minutes').text("O Pix expirou!");          
                    clearInterval(y);      
                    clearInterval(t);  
                        if(q && s){
                        $.ajax({
                            url: s+"notification?q="+q.toString()+"&pc=true",
                            success: function(){
                                window.location.reload();
                            }       
                             
                        });
                    }else{
                        return;
                    } 
                }
            }, 1000);           
            
    })();

 
 