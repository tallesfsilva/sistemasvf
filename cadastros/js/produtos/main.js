import {prod } from './produtos.js'
import {cad } from '../categorias.js'


$(document).ready(function(){
    cad.loadCategorias();
    prod.fn();  
  
  
    var clusterize = new Clusterize({ 
       
        scrollId: 'produtos_wrapper',
        contentElem: document.getElementById('body-products')
      });
 
      

})