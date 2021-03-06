<?
  $title = "Inserir novo endere�o";
  require_once("lib/configs.php");
	
 $clientes_id     = $_SESSION["xxClientesIDxx"];
 if(isset($_POST["btn_salvar"]) or isset($_POST["btn_salvar_x"]))
 {
   $campo = format_array($_POST);

   if(empty($campo['end_nome']))
    $erro .= "Preencha o nome <br />";
   if(empty($campo["logradouro"]))
    $erro .= "Preencha o endere�o <br />";
   if(empty($campo["numero"]))
    $erro .= "Preencha o n�mero da casa <br />";
   if(empty($campo["bairro"]))
    $erro .= "Preencha o bairro <br />";
   if(!validateField(array($campo["cep"]),'numeric',8))
    $erro .= "Preencha o CEP corretamente<br />";
   if(empty($campo["cidade"]))
    $erro .= "Preencha sua cidade <br />";
   if(empty($campo["uf"]))
    $erro .= "Selecione seu estado <br />";
   $campo['pri'] = (!empty($campo['pri'])?$campo['pri']:0);
   
   if(empty($erro)){

    $sql = "INSERT INTO clientes_end SET
    clientes_end_nome    = '".mysql_real_escape_string($campo['end_nome'])."',
    clientes_id 		 = '".mysql_real_escape_string($clientes_id)."',
    clientes_logradouro  = '".mysql_real_escape_string($campo['logradouro'])."',
    clientes_numero      = '".mysql_real_escape_string($campo['numero'])."',
    clientes_complemento = '".mysql_real_escape_string($campo['complemento'])."',
    clientes_bairro      = '".mysql_real_escape_string($campo['bairro'])."',
    clientes_cep         = '".mysql_real_escape_string($campo['cep'])."',
    clientes_cidade      = '".mysql_real_escape_string($campo['cidade'])."',
    clientes_uf          = '".mysql_real_escape_string($campo['uf'])."',
    clientes_pri         = '".mysql_real_escape_string($campo['pri'])."'";
    $result = $conn->sql($sql);
    $clientes_end_id = $conn->id();

    if($clientes_pri == 1)
    {
  	   // Atualiza os demais endere�os como n�o principal
        $sql = "UPDATE clientes_end SET clientes_pri = 0 WHERE clientes_end_id !='$clientes_end_id' AND clientes_id='$clientes_id'";
        $result = $conn->sql($sql);
    }
    $_SESSION["msg_operacao_end"] = "Endere�o criado com sucesso.";
    header("location: catalogo_enderecos.php");
  }
 }

  require_once("topo.php");
  require_once("lib/sessao.php");
  require_once("login_topo.php");
  require_once("busca.php");
  //require_once("categorias.php");
  //require_once("parceiros.php");
?>
<!-- Inserir novo endere�o -->
<script type='text/javascript' src='js/jquery.numeric.js'></script>
<script type='text/javascript' src='js/cadastro.js'></script>
<div id="conteudo" class="interna">
 <span class='back'><a href="catalogo_enderecos.php"><img src="banco_imagens/btn_voltar.gif" alt="Voltar" border="0" /></a></span>
 <h1><?=$title ?></h1>
 <p class='alert'><?= !empty($erro) ? $erro : "Campos com * s�o de preenchimento obrigat�rio" ?></p>
  <form id="frm_cadastro" action="<?= $pageAtual ?>" method="post">
    <div class='bordaForm'>
        <p><label for="clientes_end_nome">Nome:<span class='alert'>*</span>
         <span class='form'><input name="clientes_end_nome" type="text" size="40" value="<?=$campo['end_nome'] ?>" /></span></label>
      </p>
      <p>
        <label for="clientes_logradouro">Endere�o:<span class="alert">*</span>
        <span class='form'><input name="clientes_logradouro" type="text" size="26" value="<?=$campo['logradouro'] ?>" />
        N�:<span class="alert">*</span>
        <input name="clientes_numero" type="text" size="4" /></span></label>
      </p>
      <p>
        <label for="clientes_complemento">Complemento:
        <span class='form'><input name="clientes_complemento" type="text" size="40"  value="<?=$campo['complemento'] ?>" /></span></label>
      </p>
      <p>
        <label for="clientes_bairro">Bairro:<span class="alert">*</span>
        <span class='form'><input name="clientes_bairro" type="text" size="40"  value="<?=$campo['bairro'] ?>" /></span></label>
      </p>
      <p>
        <label for="clientes_cep">CEP:<span class="alert">*</span>
        <span class='form'><input name="clientes_cep" type="text" size="8" maxlength="8"  class="onlyNumbers" value="<?=$campo['cep'] ?>" />
        <span class="descCampo"> somente n�meros</span></span></label>
      </p>
      <p>
        <label for="clientes_cidade">Cidade:<span class="alert">*</span>
        <span class='form'><input name="clientes_cidade" type="text" size="40" value="<?=$campo['cidade'] ?>" /></span></label>
      </p>
      <p>
        <label for="clientes_uf">Estado:<span class="alert">*</span>
        <span class='form'><select name="clientes_uf">
          <?= fct_array_foreach(estados2(),$campo['uf']); ?>
         </select></span></label>
      </p>
      <p>
        <label for="clientes_pri"><input name="clientes_pri" type="checkbox"  class="noBorder" value="1" />
        <span class='form' style='padding-top:4px'>Principal</span></label>
      </p>
   </div>
   <input name="id" type="hidden" value="<?=$clientes_end_id ?>" />
   <br /><input name="btn_salvar" type="image" src="banco_imagens/btn_enviar.gif" class="noBorder btn" value="Enviar" />
   </form>
</div>
<? require_once("rodape.php"); ?>
