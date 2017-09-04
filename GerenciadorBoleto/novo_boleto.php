<?php
if (!defined("DS")) {
define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
define('BASE_DIR', dirname(__FILE__) . DS);
}
require_once BASE_DIR . "model" . DS . "Usuario.php";
require_once BASE_DIR . "model" . DS . "Banco.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDAO.php";
require_once BASE_DIR . "dao" . DS . "BoletoDAO.php";
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
<form action="control/BoletoControl.php?action=gerar" method="POST">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="title">Novo Boleto</h1>
        <h4 class="title">Dados Boleto</h4>

        <div class="form-group col-md-12">
            <label for="nomeBanco">Banco:</label>
            <select class="js-example-basic-single form-control">
                <?php
                $bDao = new BoletoDAO();
                $bancos[] = new Banco();
                $bancos = $bDao->listarBancos();
                foreach ($bancos as $objBanco) {
                ?>
                <option name="nomeBanco" placeholder="Selecione um Banco"><?php echo $objBanco->getNomeBanco() ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="numDoc">Cliente:</label>
            <select class="js-example-basic-single form-control">
                <?php
                $uDao = new UsuarioDAO();
                $ativos[] = new Usuario();
                $ativos = $uDao->listarUsuariosAtivos();
                foreach ($ativos as $objUsuario) {
                ?>
                <option name="cliente"><?php echo $objUsuario->getRazaoSocial() ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="numDoc">Nº Documento</label>
            <input id="numDoc" type="text" name="numeroDocumento" class="form-control" placeholder="Nº Documento"/>
        </div>
        <div class="form-group col-md-6">
            <label for="vencimento">Vencimento:</label>
            <input id="vencimento" type="date" name="dataVencimento" class="form-control" placeholder="Vencimento"/>
        </div>
        <div class="form-group col-md-3">
            <label for="multa">Multa (%):</label>
            <input id="multa" type="number" name="multa" class="form-control" placeholder="Multa"/>
        </div>
        <div class="form-group col-md-3">
            <label for="juros">Juros (P/Dia):</label>
            <input id="juros" type="text" name="juros" class="form-control" placeholder="Juros"/>
        </div>
        <div class="form-group col-md-6">
            <label for="valor">Valor:</label>
            <input id="valor" type="text" name="valor" class="form-control" placeholder="Valor"/>
        </div>

    </div>
    <div id="cadastrar" class="col-md-12">
        <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Gerar</button>
    </div>

</form>
</body>
<link rel="stylesheet" href="assets/css/novo_cliente.css">
<link href="assets/dist/css/select2.min.css" rel="stylesheet" />
<script src="assets/dist/js/select2.min.js"></script>
<script src="assets/js/combo_boleto.js"></script>
<script src="assets/js/mascara_valor.js"></script>
</html>
