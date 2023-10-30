<?php
ob_start();
 
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
    
    $lerbanco->ExeRead('ws_itens', "WHERE nome_item = :novoProd", "novoProd={$payLoad['nome_item']}");
    
    if($lerbanco->getResult()){
      $res['msg'] = "<div class=\"alert alert-info alert-dismissable\">                
              Já existe um produto com esse nome!
                </div>";
                $res['success'] = false;
                $res['error'] = true;
             echo json_encode($res);
    }else{


    $payLoad['nome_item'] = strip_tags(trim($payLoad['nome_item']));
    $payLoad['preco_item'] = strip_tags(trim($payLoad['preco_item']));
    $payLoad['descricao_item'] = strip_tags(trim($payLoad['descricao_item']));
    $payLoad['user_id'] = $userlogin['user_id'];
    $payLoad['config_total_s'] ="0";
    $payLoad['number_adicional'] ="0";
  
    $payLoad['dia_semana'] = (!empty($payLoad['dia_semana']) ? $payLoad['dia_semana']  : "null");
    
    
    
    
    if(empty($payLoad['nome_item']) || empty($payLoad['preco_item'])){
        $res['msg'] = "<div class=\"alert alert-info alert-dismissable\">                
                Preencha os campos obrigatórios!
                </div>";
                $res['success'] = false;
                $res['error'] = true;
        echo json_encode($res);  
     
     
    }else{
    
        if($payLoad['img_item'] == ''){
            $payLoad['img_item'] = 'false';
        };   
        if(empty($payLoad['id_cat'])){
           unset($payLoad['id_cat']);          
        }
      
        $payLoad['preco_item'] = Check::Valor($payLoad['preco_item']);
        
        if(!empty(json_decode($payLoad['adicionais'], true) )){
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
                
                        Item Adicionado ao Menu.
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
        
        Ocorreu um erro ao inserir o produto no banco de dados. Tente novamente!.
        </div>";  
        unset($_POST); 
        $res['success'] = false;
        $res['error'] = true;
        echo json_encode($res);
    
        
         
          };
  }else{
              unset($payLoad['adicionais']);     
              $addbanco->ExeCreate("ws_itens", $payLoad);
               

              if ($addbanco->getResult()){

                $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">

                Item Adicionado ao Menu.
                </div>";


                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
            }else{
            
                $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
            
                    Ocorreu um erro ao criar o produto. Por favor tente novamente\"
                    </div>";
            
            
                    $res['success'] = true;
                    $res['error'] = false;
                    echo json_encode($res);
          
            }
}
    }
}
};//FINAL DO PRIMEIRO IF / ELSE


}catch (PDOException $e) {
    echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
  }
 }


 function updateProduto($payLoad){

  try{
 
      global $lerbanco; 
      global $addbanco; 
      global $updatebanco; 
      global $deletbanco;
      
      
     $res['msg'] = "";
     $res['success'] = false;
     $res['error'] = false;
    
 
     $userlogin = $_SESSION['userlogin'];
 
  
     
 if(!empty($payLoad['action']) && !empty($payLoad)){ //INICIO DO PRIMEIRO IF / ELSE
     unset($payLoad['action']);
     
     // INICIO DA VALIDAÇÃO DA IMAGEM ITEM:
     if (isset($_FILES['img_item']['tmp_name']) && $_FILES['img_item']['tmp_name'] != ""){
         $payLoad['img_item'] = $_FILES['img_item'];
         $payLoad['img_item']['id_user'] = $userlogin['user_id'];
    }
     
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
     
     
    
    

     
     if(empty($payLoad['nome_item']) || empty($payLoad['preco_item'])){
         $res['msg'] = "<div class=\"alert alert-info alert-dismissable\">                
                 Preencha os campos obrigatórios!
                 </div>";
                 $res['success'] = false;
                 $res['error'] = true;
         echo json_encode($res);
     }else{
         $lerbanco->ExeRead('ws_itens', "WHERE nome_item = :novoProd", "novoProd={$payLoad['nome_item']}");
         if($lerbanco->getResult()){
          $res['msg'] = "<div class=\"alert alert-info alert-dismissable\">                
                  Já existe um produto com esse nome!
                    </div>";
                    $res['success'] = false;
                    $res['error'] = true;
                 echo json_encode($res);
                        
            
     }else{
        
         if(!empty($payLoad['img_item']) && $payLoad['img_item']== ''){
             $payLoad['img_item'] = 'false';
             $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$userlogin['user_id']}&iditem={$payLoad['id']}");

            if($lerbanco->getResult()){
              $item = $lerbanco->getResult()[0];
              if(file_exists(UPLOAD_PATH.'uploads/'.$item['img_item']) && !is_dir(UPLOAD_PATH.'uploads/'.$item['img_item'])){
                unlink(UPLOAD_PATH.'uploads/'.$item['img_item']);
            }
          }
            
          }
        
        if(empty($payLoad['id_cat'])){
          unset($payLoad['id_cat']);          
        }
         $payLoad['preco_item'] = Check::Valor($payLoad['preco_item']);
         if(!empty(json_decode($payLoad['adicionais'], true))){
              $adicionaisBuffer = array();
              foreach(json_decode($payLoad['adicionais'], true) as $adicionais){
                      array_push($adicionaisBuffer,  $adicionais);
      
              }
              
              
              unset($payLoad['adicionais']);
        
     
     
      $updatebanco->ExeUpdate("ws_itens", $payLoad, "where id = :idprod and user_id = :iduser", "idprod={$payLoad['id']}&iduser={$userlogin['user_id']}");
    
  
     if ($updatebanco->getResult()){
         $adicionaisArray = array();
         foreach($adicionaisBuffer as $key => $value){
          
             array_push($adicionaisArray, array('user_id' => $userlogin['user_id'], 'id_produto' => $payLoad['id'],
              'id_tipo_adicional' => $adicionaisBuffer[$key]['id_tipo_adicional'],'id_adicionais' =>  $adicionaisBuffer[$key]['id_adicionais']));
         }
         
  
         $deletbanco->ExeDelete("ws_produto_adicionais", "where id_produto = :idprod", "idprod={$payLoad['id']}");
             
         if ($deletbanco->getResult()){
                foreach($adicionaisArray as $adicional){
                    extract($adicional);
                      $addbanco->ExeCreate("ws_produto_adicionais", $adicional);
                  }
                
                  if ($addbanco->getResult()){
      
                      $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
              
                      Item atualizado com sucesso!.
                      </div>";
              
              
                      $res['success'] = true;
                      $res['error'] = false;
                      echo json_encode($res);
                  
              }else{
                  $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
              
                        Ocorreu um erro ao atualizar os adicionais. Por favor tente novamente\"
                      </div>";
              
              
                      $res['success'] = true;
                      $res['error'] = false;
                      echo json_encode($res);
              }
        
         }else{
             $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
         
             Ocorreu um erro ao atualizar os adicionais. Por favor tente novamente\"
             </div>";
     
     
             $res['success'] = true;
             $res['error'] = false;
             echo json_encode($res);
         }
     
     }else{
         $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
         
         <b class=\"alert-link\">Ocorreu um erro ao atualizar o produto no banco de dados. Tente novamente!.
         </div>";  
         unset($_POST); 
         $res['success'] = false;
         $res['error'] = true;
         echo json_encode($res);
     
         
          
     };
    }else{
      $deletbanco->ExeDelete("ws_produto_adicionais", "where id_produto = :idprod and  user_id = :iduser", "idprod={$payLoad['id']}&iduser={$userlogin['user_id']}");
      unset($payLoad['adicionais']);     
      $updatebanco->ExeUpdate("ws_itens", $payLoad, "where id = :idprod and user_id = :iduser", "idprod={$payLoad['id']}&iduser={$userlogin['user_id']}");
    
     if ($updatebanco->getResult()){

        $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">

        Item Atualizado com sucesso!.
        </div>";


        $res['success'] = true;
        $res['error'] = false;
        echo json_encode($res);
    }else{
    
        $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
    
            Ocorreu um erro ao atualizar o produto. Por favor tente novamente\"
            </div>";
    
    
            $res['success'] = true;
            $res['error'] = false;
            echo json_encode($res);
  
    }
    }
 }
}
 };//FINAL DO PRIMEIRO IF / ELSE
 
 
 }catch (PDOException $e) {
     echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
   }
  }
 



 function carregaAdcionaisUser(){


  try{
    global $lerbanco; 
    global $addbanco; 
    
     
   $res['msg'] = "";
   $res['success'] = false;
   $res['error'] = false;

   $userlogin = $_SESSION['userlogin'];
 
 
    $res = new stdClass();
   
    $res->data = array(); 
    $res->tipos = array();
    $payload =  filter_input_array(INPUT_POST, FILTER_DEFAULT);
  
 
    if(!empty($payload['idtipos'] && (int)$payload['idtipos']) && !empty($payload['iditem'] && (int)$payload['iditem']) ){
    
      foreach($payload['idtipos'] as $idtipo){

        $lerbanco->FullRead("select ad.id_adicionais, ad.nome_adicional 'nome_adicional', ad.valor_adicional,ad.desc_adicional, tp.id_tipo, tp.nome_adicional 'nome_tipo_adicional'
        from ws_adicionais_itens ad join ws_tipo_adicional tp on ad.id_tipo_adicional = tp.id_tipo where ad.user_id = {$userlogin['user_id']} and ad.id_tipo_adicional = {$idtipo}");
      
        if($lerbanco->getResult()){
         $nomeTipoAdicional = $lerbanco->getResult()[0];
         array_push($res->tipos, array('id_tipo' => $nomeTipoAdicional['id_tipo'], "nome_tipo_adicional" =>"<div class=\"indent_title_in\"><h3>{$nomeTipoAdicional['nome_tipo_adicional']}</h3></div>"));
   
        
         foreach($lerbanco->getResult() as $tt){
          extract($tt);
          $lerbanco->FullRead("select * from ws_produto_adicionais WHERE id_adicionais = :idadicional and user_id = :userId and id_produto = :idprod and id_tipo_adicional =:idtipo", "idadicional={$id_adicionais}&idprod={$payload['iditem']}&idtipo={$idtipo}&userId={$userlogin['user_id']}");
          if($lerbanco->getResult()){
                array_push($res->data, array('idtipo'=> $nomeTipoAdicional['id_tipo'], 'adicionais' => "<div class=\"m-3 icheck-material-green\"><input type=\"checkbox\" checked name=\"adicional_prod\" class=\"adicional\" data-idtipo=\"$id_tipo\" data-idad=\"{$id_adicionais}\" value=\"$id_adicionais\" id=ad_\"$id_adicionais\"><label for=ad_\"{$id_adicionais}\">{$nome_adicional} ({$valor_adicional})</label></div>"));
             }else{
              array_push($res->data, array('idtipo'=> $nomeTipoAdicional['id_tipo'], 'adicionais' => "<div class=\"m-3 icheck-material-green\"><input type=\"checkbox\" name=\"adicional_prod\" class=\"adicional\" data-idtipo=\"$id_tipo\" data-idad=\"{$id_adicionais}\" value=\"$id_adicionais\" id=ad_\"$id_adicionais\"><label for=ad_\"{$id_adicionais}\">{$nome_adicional} ({$valor_adicional})</label></div>"));
             }
                     
         
                
             }
      }else{
        $res->success = false;
        $res->data = array();
       
        echo json_encode($res);
      }

    }  
        $res->success = true;
      
        echo json_encode($res);
    }
  
    
   
  
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
              $style= "width:62px; height:38px;background-color: #00BB07";
              $value = "Sim";
              }else{
              $idButton = "btn_n";
              $classButton = "aceita_entrega atualizar_prod";
              $style= "width:62px; height:38px;background-color: #A70000";
              $value = "Não";
                }
              $descItem = !empty($descricao_item) ? limitarTexto($descricao_item, 30) : '';
          
              array_push($res->data, array("check_prod" => "<td><div class=\"flex justify-center items-center\"><div class=\"icheck-material-green\"><input  id=\"checkbox-product_{$id}\" type=\"checkbox\" class=\"check-products w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600\">
              <label for=\"checkbox-product_{$id}\" class=\"sr-only\">checkbox</label></div></div></td>",
             "img_prod" => "<td style=\"display: flex;justify-content: center; top: 5px;position: relative;\"><div style=\"width:40px;\" class=\"img-wrap\">{$imgProd}</td>", "nome_produto" => "<td id=\"nome_produto\" class=\"col-md-3 col-sm-2  px-6 py-4\"><span>{$nome_item}</span></td>",
              "cat_prod" => "<td><span>{$catProd}</span></td>", "preco_prod" => "<td><div style=\"position: relative;left: 15px;\"class=\"text-left\"><span>{$precoProd}</span></div></td>", 
              "estoque" => "<td><span>0</span></td>",
              "btn_disponivel" => "<td class=\"col-md-3 col-sm-2  px-6 py-4\"><button  data-url=\"{$site}cadastros\" id=\"{$idButton}\" style=\"{$style}\" value=\"{$value}\" class=\"$classButton\" data-idprod=\"{$id}\">$value</button><span hidden>{$value}</span></td>",
              "btn_editar" => "<td><a href=\"{$site}cadastros/editar-produto&idprod={$id}\"><button id=\"btn_s\" style=\"width:62px; height:38px; background: #00BB07 \" class=\"aceita_entrega\" data-title=\"Editar\"><span class=\"glyphicon glyphicon-pencil\"></span></button></a></td>",	
              "btn_excluir" => "<td><button data-url=\"{$site}cadastros\" data-idprod=\"{$id}\"style=\"width:62px; height:38px;background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete deleta_prod\"><span class=\"glyphicon glyphicon-trash\"></span>
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







   
function clonaProduto($playload){

  
  try{
       
    global $lerbanco; 
    global $deletbanco;
    global $addbanco;
  
  
    $idItem = $_POST['iditem'];
    $idusuario   = $_SESSION['userlogin']['user_id'];
     
 
     
       
    
    if( !empty($idItem) && (int)$idItem) {
 
         
       $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND id =:iditem", "userid={$idusuario}&iditem={$idItem}");
        
        if($lerbanco->getResult()){
          $sourceProd = $lerbanco->getResult()[0];
          $sourceProd['nome_item'] =  $sourceProd['nome_item'].' (Clonado) ';
          unset( $sourceProd['id']);

          $lerbanco->ExeRead('ws_itens', "WHERE user_id = :userid AND nome_item =:nomeitem", "userid={$idusuario}&nomeitem={$sourceProd['nome_item'] }");
        
        if($lerbanco->getResult()){

            $res['msg'] = "Já existe um produto com esse nome!";
            $res['success'] = false;
            $res['error'] = true;
          echo json_encode($res);

          }else{

          $addbanco->ExeCreate("ws_itens", $sourceProd);
          if($addbanco->getResult()){
            
                  $idProd = $addbanco->getResult();
                  $lerbanco->ExeRead('ws_produto_adicionais', "WHERE user_id = :userid AND id_produto =:iditem", "userid={$idusuario}&iditem={$idItem}");
                  if($addbanco->getResult()){
                        foreach($lerbanco->getResult() as $adicionais){
                          unset($adicionais['id_item']);
                          $adicionais['id_produto'] = $idProd;
                          $addbanco->ExeCreate("ws_produto_adicionais", $adicionais );

                        }
          
                        $res['msg']=  "Produto clonado com sucesso!";       
                      
                    
                    
                        
                        $res['success'] = true;
                        $res['error'] = false;
                        $res['id'] = $idProd;
                        echo json_encode($res);
                        
            
                      }else{

                          $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
                        
                          Ocorreu um problema ao clonar o produto, tente novamente!
                          </div>";
                      
                      
                          $res['success'] = false;
                          $res['error'] = true;
                          echo json_encode($res);
                
                        }        
        }else{

          $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
        
          Ocorreu um problema ao clonar o produto, tente novamente!
          </div>";
      
      
          $res['success'] = false;
          $res['error'] = true;
          echo json_encode($res);

        }     
      }
              
       
            }else{

              $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
            
              Ocorreu um problema ao clonar o produto, tente novamente!
              </div>";
          
          
              $res['success'] = false;
              $res['error'] = true;
              echo json_encode($res);

            }
  
          
      
      } else{

        $res['msg']=  "<div class=\"alert alert-success alert-dismissable\">
      
        Ocorreu um problema ao clonar o produto, tente novamente!
        </div>";
    
    
        $res['success'] = false;
        $res['error'] = true;
        echo json_encode($res);

      }  
      
      
    
    } catch (PDOException $e) {
        echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
    }
    
    
    
    
    
    
     
  }
 
 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$produtoObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  //Cadastro Produto - POST
  //body - action = pc 
  if(!empty($produtoObj['action']) && (string)$produtoObj['action'] && $produtoObj['action']=='pu'){
    updateProduto($produtoObj);

 } 

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


if(!empty($produtoObj['action']) && (string)$produtoObj['action'] && $produtoObj['action']=='uad' && !empty($produtoObj['iditem']) && (int)$produtoObj['iditem'] && !empty($produtoObj['idtipos']) && (int)$produtoObj['idtipos']){

  carregaAdcionaisUser($produtoObj);
}

if(!empty($produtoObj['action']) && (string)$produtoObj['action'] && $produtoObj['action']=='pcl' && !empty($produtoObj['iditem']) && (int)$produtoObj['iditem']){

  clonaProduto($produtoObj);
}


          
                    
ob_end_flush();
?>
  