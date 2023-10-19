<?php
session_start();


 
$site = HOME;

function cadastraProduto($payLoad){
    require('../../_app/Config.inc.php');   
 

 try{
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
        
                <b class=\"alert-link\">Ocorreu um erro ao criar os adicionais. Por favor tente novamente\"
                </div>";
        
        
                $res['success'] = true;
                $res['error'] = false;
                echo json_encode($res);
        }
      
        }else{
            $res['msg']=  "<div class=\"alert alert-danger alert-dismissable\">
        
            <b class=\"alert-link\">Ocorreu um erro ao criar os adicionais. Por favor tente novamente\"
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


 
  
 
try{

  
 
$action =  filter_input(INPUT_GET,'action', FILTER_DEFAULT);
$produtoObj = filter_input_array(INPUT_POST, FILTER_DEFAULT);



  //Cadastro Produto - POST
  //body - action = pc 
  if(!empty($produtoObj['action']) && (string)$produtoObj['action'] && $produtoObj['action']=='pc'){

      cadastraProduto($produtoObj);

   }


}catch (PDOException $e) {
  echo "Ocorreu um erro em sua solicitação. Por favor tentar novamente " . $e->getMessage();
}
 
                    
  
?>
  