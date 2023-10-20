document.querySelector("html").classList.add('js');

var fileInput  = document.querySelectorAll( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");    
    actual = document.querySelectorAll('.lightbox');
  
      
button.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput.focus();  
    }  
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});  
 
for(let i=0;i<fileInput.length;i++){
    fileInput[i].addEventListener( "change", function( event ) {  
        
        var tmppath = URL.createObjectURL(event.target.files[0]);  
        actual[i].src =  tmppath;
        actual[i].setAttribute("style", "width:240px !important; height:240px !important;");    
             
    });
    
}




