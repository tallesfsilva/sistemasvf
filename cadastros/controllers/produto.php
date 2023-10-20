<?php
session_start();

require('../../_app/Config.inc.php');  




 

function atualizaDispProduto($payLoad){

  
  try{
       
    global $lerbanco; 
    global $addbanco; 
    global $updatebanco;
    
    $res['msg'] = "";
    $res['success'] = false;
    $res['error'] = false;

    $userlogin = $_SESSION['userlogin'];
    $getId = $payLoad['iditem'];
  
    $action = !empty($payLoad['lote']) ? $payLoad['action'] : false;
   
    
    if(is_array($getId) && count($getId)>1 && $action) {
    
      foreach($getId as $item){
       
        $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id = :f", "userid={$userlogin['user_id']}&f={$item}");
      
      if($lerbanco->getResult()){
        foreach($lerbanco->getResult() as $i){
          extract($i);
        }
      
        $novoStatus = array();
      
         if($disponivel == 0){
           $novoStatus['disponivel'] = 1;
         }else{
           $novoStatus['disponivel'] = 0;
         };
      
         $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id = :upp", "userid={$userlogin['user_id']}&upp={$item}");
         
        
        };
      }
      if($updatebanco->getResult()){
        $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
        Disponiblidade dos produtos atualizada!.
        </div>";
    
    
        $res['success'] = true;
        $res['error'] = false;
        echo json_encode($res);
      }else{
        $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
        Ocorreu um erro ao atualizar o produto!.
        </div>";
    
    
        $res['success'] = false;
        $res['error'] = true;
        echo json_encode($res);
      }
        
    
    
    }else if (is_array($getId) && count($getId)==1 && $action){
      $idProduct = $getId[0];
      $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id = :f", "userid={$userlogin['user_id']}&f={$idProduct}");
      if($lerbanco->getResult()){
        foreach($lerbanco->getResult() as $i){
          extract($i);
        }
      
        $novoStatus = array();
      
         if($disponivel == 0){
           $novoStatus['disponivel'] = 1;
         }else{
           $novoStatus['disponivel'] = 0;
         };
      
        
         $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id = :upp", "userid={$userlogin['user_id']}&upp={$idProduct}");
         if($updatebanco->getResult()){
          $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
          Disponiblidade do produto atualizada!.
          </div>";
      
      
          $res['success'] = true;
          $res['error'] = false;
          echo json_encode($res);
        }else{
          $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
          Ocorreu um erro ao atualizar o produto!.
          </div>";
      
      
          $res['success'] = false;
          $res['error'] = true;
          echo json_encode($res);
        }
          
        
        };
      
    
    } else{
     
        $idProduct = $getId;
        $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id = :f", "userid={$userlogin['user_id']}&f={$idProduct}");
        if($lerbanco->getResult()){
          foreach($lerbanco->getResult() as $i){
            extract($i);
          }			
          $novoStatus = array();
        
           if($disponivel == 0){
             $novoStatus['disponivel'] = 1;
           }else{
             $novoStatus['disponivel'] = 0;
           };		
          
           $updatebanco->ExeUpdate("ws_itens", $novoStatus, "WHERE user_id = :userid AND id = :upp", "userid={$userlogin['user_id']}&upp={$idProduct}");
           if($updatebanco->getResult()){
            $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
            Disponiblidade do produto atualizada!.
            </div>";
        
        
            $res['success'] = true;
            $res['error'] = false;
            echo json_encode($res);
          }else{
            $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
           Ocorreu um erro ao atualizar o produto!.
            </div>";
        
        
            $res['success'] = false;
            $res['error'] = true;
            echo json_encode($res);
          }
                
          };
    }
    
    
  
  } catch (PDOException $e) {
      echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
  


}


function cadastraProduto($payLoad){

 try{

     global $lerbanco; 
     global $addbanco; 
     
     
    $res['msg'] = "";
    $res['success'] = false;
    $res['error'] = false;

    $userlogin = $_SESSION['userlogin'];

    $lerbanco->FullRead("select * from ws_empresa WHERE binary user_id = :userId", "userId={$userlogin['user_id']}");
	if (!$lerbanco->getResult()){		 
	}else{
		foreach ($lerbanco->getResult() as $i):
			extract($i);
		endforeach;
    }

    
if(!empty($payLoad['action']) && !empty($payLoad)){ //INICIO DO PRIMEIRO IF / ELSE
    unset($payLoad['action']);
    
    // INICIO DA VALIDAÇÃO DA IMAGEM ITEM:
    if (isset($_FILES['img_item']['tmp_name']) && $_FILES['img_item']['tmp_name'] != ""){
        $payLoad['img_item'] = $_FILES['img_item'];
        $payLoad['img_item']['id_user'] = $userlogin['user_id'];
}else{
        $payLoad['img_item'] = '';
    };
    
    if(!empty($payLoad['img_item'])){                        
        $upload = new Upload("uploads/");
        $upload->Image($payLoad['img_item']);
    
        if(isset($upload) && $upload->getResult()){
            $payLoad['img_item'] = $upload->getResult();
        }elseif(is_array($payLoad['img_item'])){
         $payLoad['img_item'] = 'null';
    };                    
};
    
    // FINAL DA VALIDAÇÃO DA IMAGEM ITEM:
    
    
    $payLoad['nome_item'] = strip_tags(trim($payLoad['nome_item']));
    $payLoad['preco_item'] = strip_tags(trim($payLoad['preco_item']));
    $payLoad['descricao_item'] = strip_tags(trim($payLoad['descricao_item']));
    $payLoad['user_id'] = $userlogin['user_id'];
    $payLoad['config_total_s'] ="0";
    $payLoad['number_adicional'] ="0";
  
    $payLoad['dia_semana'] = (!empty($payLoad['dia_semana']) ? $payLoad['dia_semana']  : "null");
    
    
    
    
    if(empty($payLoad['id_cat']) || empty($payLoad['nome_item']) || empty($payLoad['preco_item']) || empty($payLoad['descricao_item'])){
        $res['msg'] = "<div class=\"alert alert-info alert-dismissable\">                
                Preencha os campos obrigatórios!
                </div>";
                $res['success'] = false;
                $res['error'] = true;
        echo json_encode($res);
    }elseif($payLoad['img_item'] == 'null'){
        $res['msg'] =  "<div class=\"alert alert-info alert-dismissable\">
        
        Formato de imagem não suportado!
        </div>";
        $res['success'] = false;
        $res['error'] = true;
        echo json_encode($res);

                    
     
     
    }else{
    
        if($payLoad['img_item'] == ''){
            $payLoad['img_item'] = 'false';
        };   
    
        $payLoad['preco_item'] = Check::Valor($payLoad['preco_item']);
       
        $adicionaisBuffer = array();
        foreach(json_decode($payLoad['adicionais'], true) as $adicionais){
                array_push($adicionaisBuffer,  $adicionais);

        }
       
        
        unset($payLoad['adicionais']);
       
    
    
    $addbanco->ExeCreate("ws_itens", $payLoad);
     $idProd = $addbanco->getResult();
 
    if ($addbanco->getResult() && $idProd){
        $adicionaisArray = array();
        foreach($adicionaisBuffer as $key => $value){
         
            array_push($adicionaisArray, array('user_id' => $userlogin['user_id'], 'id_produto' => $idProd,
             'id_tipo_adicional' => $adicionaisBuffer[$key]['id_tipo_adicional'],'id_adicionais' =>  $adicionaisBuffer[$key]['id_adicionais']));
        }
        
 
        if(!empty($adicionaisArray && (int)$adicionaisArray[0]['id_produto'])){
            
            foreach($adicionaisArray as $adicional){
                $addbanco->ExeCreate("ws_produto_adicionais", $adicional);
            }
          
            if ($addbanco->getResult()){

                $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
                <b class=\"alert-link\">SUCESSO!</b> Item Adicionado ao Menu.
                </div>";
        
        
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);

        }else{
            $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
        
                 Ocorreu um erro ao criar os adicionais. Por favor tente novamente\"
                </div>";
        
        
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
        }
      
        }else{
            $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
        
            Ocorreu um erro ao criar os adicionais. Por favor tente novamente\"
            </div>";
    
    
            $res['success'] = true;
            $res['error'] = false;
            echo json_encode($res);
        }
           
    }else{
        $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
        
        <b class=\"alert-link\">Ocorreu um erro ao inserir o produto no banco de dados. Tente novamente!.
        </div>";  
        unset($_POST); 
        $res['success'] = false;
        $res['error'] = true;
        echo json_encode($res);
    
        
         
    };
}
 
};//FINAL DO PRIMEIRO IF / ELSE


}catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
 }

function carregaProdutos(){

    try{
        global $lerbanco;   
   

        $site = HOME;
        $res = new stdClass();
      
       
        $res->data = array();
       
        $userlogin = $_SESSION['userlogin'];
       
        $lerbanco->ExeRead("ws_itens", "WHERE user_id = :userid ORDER BY id ", "userid={$userlogin['user_id']}"); 
        
        
        
        if($lerbanco->getResult()){
         
          $res->draw = 1;
          $res->recordsTotal =  $lerbanco->getRowCount();
          $res->recordsFiltered = $lerbanco->getRowCount();;
          
          foreach($lerbanco->getResult() as $tt){
              extract($tt);    
    
                     
            if (!empty($img_item) && $img_item != "" && file_exists(UPLOAD_PATH."/uploads"."/".$img_item) && !is_dir(UPLOAD_PATH."/uploads"."/".$img_item)){
              $imgProd =  Check::Image($img_item, 'Imagem-item', 40, 33);
            }else{
              $imgProd = Check::Image('img/camara2.png', 'Imagem-item', 40, 33);
            };   
 
            $catProd = "";
            $lerbanco->ExeRead('ws_cat', "WHERE user_id = :userid AND id = :idcatt", "userid={$userlogin['user_id']}&idcatt={$id_cat}");
            if($lerbanco->getResult()){
              $dadoscat = $lerbanco->getResult();
              $catProd =  $dadoscat[0]['nome_cat'];
            };

            $precoProd = !empty($preco_item) ? 'R$ '.Check::Real($preco_item) : "0";

            if($disponivel && (int)$disponivel==1) { 
              $idButton = "btn_s";
              $classButton = "aceita_entrega atualizar_prod";
              $style= "background-color: #00BB07";
              $value = "Sim";
              }else{
              $idButton = "btn_n";
              $classButton = "aceita_entrega atualizar_prod";
              $style= "background-color: #A70000";
              $value = "Não";
                }

            extract($tt);
              array_push($res->data, array("check_prod" => "<td><div class=\"flex justify-center items-center\"><div class=\"icheck-material-green\"><input  id=\"checkbox-product_{$id}\" type=\"checkbox\" class=\"check-products w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600\">
              <label for=\"checkbox-product_{$id}\" class=\"sr-only\">checkbox</label></div></div></td>",
             "img_prod" => "<td style=\"display: flex;justify-content: center; top: 5px;position: relative;\"><div style=\"width:40px;\" class=\"img-wrap\">{$imgProd}</td>", "nome_produto" => "<td id=\"nome_produto\" class=\"col-md-3 col-sm-2  px-6 py-4\"><span>{$nome_item}</span></td>",
              "cat_prod" => "<td><span>{$catProd}</span></td>", "desc_prod" => "<td><span>{$descricao_item}</span></td>","preco_prod" => "<td><span>{$precoProd}</span></td>", 
              "estoque" => "<td><span>1</span></td>",
              "btn_disponivel" => "<td class=\"col-md-3 col-sm-2  px-6 py-4\"><button  data-url=\"{$site}cadastros\" id=\"{$idButton}\" style=\"{$style}\" value=\"{$value}\" class=\"$classButton\" data-idprod=\"{$id}\">$value</button><span hidden>{$value}</span></td>",
              "btn_editar" => "<td><a href=\"{$site}cadastros/editar-produto?idprod={$id}\"><p data-placement=\"top\" data-toggle=\"tooltip\" title=\"Editar\"><button class=\"btn btn-primary\" data-title=\"Editar\"><span class=\"glyphicon glyphicon-pencil\"></span></button></a></td>",	
              "btn_excluir" => "<td><button data-url=\"{$site}cadastros\" data-idprod=\"{$id}\"style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete deleta_prod\"><span class=\"glyphicon glyphicon-trash\"></span>
              </button></td>"));
       
                
         
      
          }
            
           echo json_encode($res);
        }else{
          $res->draw = 1;
          $res->recordsTotal =  0;
          $res->recordsFiltered = 0;
          $res->data = array();
      
          echo json_encode($res);
        }
      
      
       
      
      }catch (PDOException $e) {
        echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
      }
       
                          



}
 
  
function deletaProduto($payload){

  
try{
	   
  global $lerbanco; 
  global $deletbanco;


  $idItem = $_POST['iditem'];
  $idusuario   = $_SESSION['userlogin']['user_id'];
   
  
  $lote = !empty($_POST['lote']) ? $_POST['lote'] : false;
   
     
  
  if( is_array($idItem) && count($idItem)>1 && $lote) {
    
      foreach($idItem as $item){
       
              $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$idusuario}&iditem={$item}");
      
      if($lerbanco->getResult()){
        foreach($lerbanco->getResult() as $i){
          extract($i);
        }
              if(file_exists(URL_IMAGE.$img_item) && !is_dir(URL_IMAGE.$img_item)){
                  unlink(URL_IMAGE.$img_item);
              }
        
              $deletbanco->ExeDelete("ws_itens", "WHERE user_id = :userid AND id = :iditem", "userid={$idusuario}&iditem={$item}");
            
              if(!$deletbanco->getResult()){
                    $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
              
                    Ocorreu um erro ao excluir o produto. Tente novamente por favor. 
                  </div>";
              
              
                  $res['success'] = false;
                  $res['error'] = true;
                  echo json_encode($res);
               }
      
            }else{
              $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
                Ocorreu um erro ao recuperar o produto do banco de dados. Tente novamente por favor. 
               </div>";
           
           
               $res['success'] = false;
               $res['error'] = true;
               echo json_encode($res);
            }
     
          }

          $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
         Os produtos foram excluídos com sucesso!
         </div>";
     
     
         $res['success'] = true;
         $res['error'] = false;
         echo json_encode($res);
         
    
  }else if (is_array($idItem) && count($idItem)==1 && $lote){
      $idProduct = $idItem[0];
          $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$idusuario}&iditem={$idProduct}");
      
      if($lerbanco->getResult()){
        foreach($lerbanco->getResult() as $i){
          extract($i);
        }
              if(file_exists(URL_IMAGE.$img_item) && !is_dir(URL_IMAGE.$img_item)){
                  unlink(URL_IMAGE.$img_item);
              }
        
              $deletbanco->ExeDelete("ws_itens", "WHERE user_id = :userid AND id = :iditem", "userid={$idusuario}&iditem={$idProduct}");
              if($deletbanco->getResult()){
                 $deletbanco->ExeDelete("ws_relacao_tamanho", "WHERE 	id_user = :userid AND id_item = :iditem", "userid={$idusuario}&iditem={$idProduct}");
              
                 $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
                 O produto foi excluído com sucesso!
                </div>";
            
            
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
              }else{
                     
                $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
                Ocorreu um erro ao excluir o produto. Tente novamente por favor. 
               </div>";
           
           
               $res['success'] = false;
               $res['error'] = true;
               echo json_encode($res);
              }
      }
        
           
    
    } else{	 
           
          $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$idusuario}&iditem={$idItem}");
      
      if($lerbanco->getResult()){
        foreach($lerbanco->getResult() as $i){
          extract($i);
        }
              if(file_exists(URL_IMAGE.$img_item) && !is_dir(URL_IMAGE.$img_item)){
                  unlink(URL_IMAGE.$img_item);
              }
        
              $deletbanco->ExeDelete("ws_itens", "WHERE user_id = :userid AND id = :iditem", "userid={$idusuario}&iditem={$idItem}");
              if($deletbanco->getResult()){
                 $deletbanco->ExeDelete("ws_relacao_tamanho", "WHERE 	id_user = :userid AND id_item = :iditem", "userid={$idusuario}&iditem={$idItem}");
              
                 $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
                  O produto foi excluído com sucesso!
                 </div>";
             
             
                 $res['success'] = true;
                 $res['error'] = false;
                 echo json_encode($res);
              }else{
                 
                $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
          
                Ocorreu um erro ao excluir o produto. Tente novamente por favor. 
               </div>";
           
           
               $res['success'] = false;
               $res['error'] = true;
               echo json_encode($res);
              }
      }
    }
    
    
  
  } catch (PDOException $e) {
      echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
  
  
  
  
  
  
   
}
 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$produtoObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);



  //Cadastro Produto - POST
  //body - action = pc 
  if(!empty($produtoObj['action']) && (string)$produtoObj['action'] && $produtoObj['action']=='pc'){
      cadastraProduto($produtoObj);

   } 
   //Carrega Tabela Produto - GET
  //body - action = pl
   if(!empty($action) && (string)$action && $action =='pl'){

      carregaProdutos();

   } 
   //Atualiza Disponibilidade do Produto - POST
  //body - action = pd 
   if(!empty($produtoObj['action']) && (string)$produtoObj['action'] && $produtoObj['action']=='pd' && !empty($produtoObj['iditem']) && (int)$produtoObj['iditem']){
 
       atualizaDispProduto($produtoObj);
  }

  //Exclui Produto - POST
  //body - action = pe
  // lote = true - vários produtos 
  if(!empty($produtoObj['action']) && (string)$produtoObj['action'] && $produtoObj['action']=='pe' && !empty($produtoObj['iditem']) && (int)$produtoObj['iditem']){

    deletaProduto($produtoObj);
}


          
                    
  
?>
  