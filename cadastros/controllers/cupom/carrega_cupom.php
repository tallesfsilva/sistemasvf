<?php

session_start();
require('../../../_app/Config.inc.php');

 



 
try{

  $site = HOME;
  $userlogin = $_SESSION['userlogin'];
 
  $res = new stdClass();
 
  $res->data = array();
 
 
 
  
  
  
  $lerbanco->FullRead("select * from cupom_desconto WHERE user_id = {$userlogin['user_id']}");
  if($lerbanco->getResult()){
   
    $res->draw = 1;
    $res->recordsTotal =  $lerbanco->getRowCount();
    $res->recordsFiltered = $lerbanco->getRowCount();;
    
    foreach($lerbanco->getResult() as $tt){
      extract($tt);
      $datavalidade = explode("-", $data_validade);
      $datavalidade = array_reverse($datavalidade);
      $datavalidade = implode("/",  $datavalidade);

      $idButton = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? 'btn_d' : (($mostrar_site == 1) ? 'btn_s' : 'btn_n' );
      $styleButton = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? "rgba(209,213,219,var(--tw-bg-opacity))" : (($mostrar_site==1) ? "#00BB07" : "#A70000;" );
      $buttonDisable = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? "disabled" : '' ;
      $buttonClass = (!isDateExpired($data_validade, 1) || $total_vezes==0) ? "button-disabled" : "";
      $buttonText = ($mostrar_site == 0 ? 'Não' : 'Sim');

      if(!isDateExpired($data_validade, 1)){
        $situacao= "<strong style='color: red;'>EXPIROU!</strong>";
      }elseif($total_vezes <= 0){
        $situacao="<strong style='color: red;'>ACABOU!</strong>";
      }else{
        $situacao= "<strong style='color: #82C152;'>ATIVO</strong>";
      };
      

        array_push($res->data, array("nome_cupom" => "<td  id=\"$id_cupom\"> <input data-url=\"{$site}cadastros\" data-flag = \"true\" id=\"cupom_{$id_cupom}\" data-idcupom=\"{$id_cupom}\" value=\"{$ativacao}\" oninput=\"this.value = this.value.replace(/[^a-z-A-Z-0-9]/g, '')\" type=\"text\" maxlength=\"20\" class=\"form-control atualiza_cupom\" name=\"ativacao\" aria-describedby=\"emailHelp\" placeholder=\"Ex: Cupom10\"><span hidden>{$ativacao}</span></td>",
        "porcentagem" => "<td><input data-url=\"{$site}cadastros\" data-idcupom=\"{$id_cupom}\" value=\"{$porcentagem}\" oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" required type=\"text\" class=\"form-control atualiza_cupom descontoporcentagem\" value=\"1\" maxlength=\"2\"  step=\"1\" pattern=\"[0-9]{2}\" name=\"porcentagem\" min=\"1\" max=\"99\" /><span hidden>{$porcentagem}</span></td>",
        "quantidade" => "<td><input data-url=\"{$site}cadastros\" data-idcupom=\"{$id_cupom}\" oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" type=\"text\" value=\"{$total_vezes}\" class=\"form-control atualiza_cupom numero\" name=\"total_vezes\" min=\"1\" maxlength=\"3\" max=\"999\" /><span hidden>{$total_vezes}</span></td>",
        "data_validade" => "<td> <input data-url=\"{$site}cadastros\" data-idcupom=\"{$id_cupom}\" type=\"text\" class=\"form-control atualiza_cupom\" name=\"data_validade\" id=\"datepicker\" data-mask=\"00/00/0000\" placeholder=\"00/00/0000\" value=\"{$datavalidade}\"/><span hidden>{$datavalidade}</span></td>",
        "situacao" => "<td><span>{$situacao}</span></td>",
        "exibir_no_site" => "<td><button data-url=\"{$site}cadastros\" id=\"{$idButton}\" style=\"background:{$styleButton}\" type=\"button\" {$buttonDisable}  class=\"aceita_entrega exibirsite {$buttonClass}\" data-idcupom=\"{$id_cupom}\">{$buttonText}</button>",
        "excluir" => "<td><button  data-url=\"{$site}cadastros\" style=\"background-color: #A70000;border-color: #A70000; margin: 3px;border-radius: 4px !important\" type=\"button\" class=\"btn_1 btn-delete excluircupom\" data-idcupom=\"$id_cupom\"><span class=\"glyphicon glyphicon-trash\"></span></button></td>"));
      
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
 
                    
  
?>
  