<?php
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(__FILE__) . DS);
}
require_once BASE_DIR . "model" . DS . "Usuario.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDao.php";
session_start();
if (($_SESSION["usuario"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
include("getcaptcha.php");
?>
<?php
$boletos_active = "active";
require_once 'menu.php';
?>
<form action="control/UsuarioControl.php?action=inserir" method="POST">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="title">Novo Boleto</h1>
        <h4 class="title">Dados Boleto</h4>
        <div class="form-group col-md-12">
            <label for="numDoc">Cliente:</label>
            <select class="js-example-basic-single form-control">
              <option value="AL">Alabama</option>
              ...
              <option value="WY">Wyoming</option>
          </select>
      </div>
      <div class="form-group col-md-6">
        <label for="numDoc">Nº Documento</label>
        <input id="numDoc" type="text" name="numDoc" class="form-control" placeholder="Nº Documento"/>
    </div>
    <div class="form-group col-md-6">
        <label for="vencimento">Vencimento:</label>
        <input id="vencimento" type="date" name="vencimento" class="form-control" placeholder="Vencimento"/>
    </div>
    <div class="form-group col-md-6">
        <label for="multa">Multa(%):</label>
        <input id="multa" type="number" name="multa" class="form-control" placeholder="Multa"/>
    </div>
    <div class="form-group col-md-6">
        <label for="valor">Valor:</label>
        <input id="valor" type="text" name="multa" class="form-control" placeholder="Multa"/>
    </div>

</div>
<div id="cadastrar" class="col-md-12">
    <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Cadastrar</button>
</div>

</div>
</form>
</body>
<link rel="stylesheet" href="assets/css/novo_cliente.css">
<link href="assets/dist/css/select2.min.css" rel="stylesheet" />
<script src="assets/dist/js/select2.min.js"></script>
<script src="assets/js/combo_boleto.js"></script>
<script src="assets/js/mascara_valor.js"></script>
</html>
