
(function(){
         
    const loadCheck  =  {
    
    
     loadCheckTipos : () => {
        let countCheckBox = $('input[name=tipo_adicional').length;
        let countChecked = $('.tipo_adicional:checked').length;
        
        
        if(countCheckBox == countChecked){
            $('#todos_tipos').prop('checked', true);
        } else{
            $('#todos_tipos').prop('checked', false)
    } 
    },

    loadDiasCheked :  () => {


        let countCheckBox =  $(".dias_prod").length;
        let countChecked = $('.dias_prod:checked').length;

        if(countCheckBox == countChecked){
            $('#op_todos').prop('checked', true);
        } else{
            $('#op_todos').prop('checked', false)
        }

    },

    loadAdicionaisChecked : () =>{

  
        let checkTodos =  $('.adicional_todos');
       console.log(checkTodos)
        let idtipos = [];
        for(let i=0;i<checkTodos.length;i++){
            idtipos.push($(checkTodos[i]).data('idtipo'));
        };
        console.log(idtipos)
        for(let i=0;i<idtipos.length;i++){
            let countCheckBox =  $("input[name='adicional_prod']" ).filter('.'+'adicional'+'[data-idtipo="'+idtipos[i]+'"]').length;
            let countChecked =  $("input[name='adicional_prod']" ).filter('.'+'adicional:checked'+'[data-idtipo="'+idtipos[i]+'"]').length;
            if(countCheckBox == countChecked){            
                $('#adicionais_todos_'+idtipos[i]).prop('checked', true);
            } else{
           
                $('#adicionais_todos_'+idtipos[i]).prop('checked', false)
            }
    
        }

       


    },

    run : () => {
        loadCheck.loadCheckTipos();
        loadCheck.loadDiasCheked();
        loadCheck.loadAdicionaisChecked();

    }
    }
        
    loadCheck.run();



})()