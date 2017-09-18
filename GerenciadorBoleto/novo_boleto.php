<?php
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(__FILE__) . DS);
}
require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "model" . DS . "Banco.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";
require_once BASE_DIR . "dao" . DS . "BoletoDAO.php";
require_once BASE_DIR . "dao" . DS . "BancoDAO.php";
session_start();
if (($_SESSION["cliente"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
?>
<?php
$boletos_active = "active";
require_once 'menu_adm.php';
?>
<form action="control/BoletoControl.php?action=gerar" method="POST" target="_blank">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="title">Novo Boleto</h1>
        <div id="erro-submit" class="col-md-12"></div>
        <h4 class="title">Dados Boleto</h4>
        <div class="form-group col-md-12">
            <label for="banco">Banco:</label>
            <select id="banco" name="codigoBanco" class="js-example-basic-single form-control">
                <?php
                $bancoDao = new BancoDAO();
                $bancos[] = new Banco();
                $bancos = $bancoDao->listarBancos();
                foreach ($bancos as $objBanco) {
                    ?>
                    <option value="<?php echo $objBanco->getCodigoBanco() ?>"><?php echo $objBanco->getNomeBanco() ?></option>
                    <?php } ?>
                </select>
                <div class="erro"></div>
            </div>

            <div class="form-group col-md-12">
                <label for="cliente">Cliente:</label>
                <select id="cliente" name="codigoCliente" class="js-example-basic-single form-control">
                    <?php
                    $uDao = new ClienteDAO();
                    $ativos[] = new Cliente();
                    $ativos = $uDao->listarClientesAtivos();
                    foreach ($ativos as $objCliente) {
                        ?>
                        <option value="<?php echo $objCliente->getCodigoCliente() ?>"><?php echo $objCliente->getNomeCliente() ?></option>
                        <?php } ?>
                    </select>
                    <div class="erro"></div>
                </div>
                <div class="form-group col-md-6">
                    <label for="numDoc">Nº Documento</label>
                    <input id="numDoc" type="text" name="numeroDocumento" value="" class="form-control" placeholder="Nº Documento"/>
                    <div class="erro"></div>
                </div>
                <div class="form-group col-md-6">
                    <label for="vencimento">Vencimento:</label>
                    <input id="vencimento" type="date" name="dataVencimento" class="form-control" placeholder="Vencimento"/>
                    <div class="erro"></div>
                </div>
                <div class="form-group col-md-3">
                    <label for="multa">Multa (%):</label>
                    <input id="multa" type="number" name="multa" value="3" class="form-control" placeholder="Multa"/>
                    <div class="erro"></div>
                </div>
        
                <div class="form-group col-md-3">
                    <label for="juros">Juros (Diário):</label>
                    <input id="juros" type="text" name="juros" value="" class="form-control" placeholder="Juros"/>
                    <div class="erro"></div>
                </div>
        
                <div class="form-group col-md-6">
                    <label for="valor">Valor:</label>
                    <input id="valor" type="text" name="valor" class="form-control" placeholder="Valor"/>
                    <div class="erro"></div>
                </div>

            </div>
            <div id="cadastrar" class="col-md-12">
                <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Gerar</button>
            </div>
            </div>
        </form>
</body>
<link rel="stylesheet" href="assets/css/novo_cliente.css">
<link href="assets/dist/css/select2.min.css" rel="stylesheet" />
<script src="assets/dist/js/select2.min.js"></script>
<script src="assets/js/combo_boleto.js"></script>
<script src="assets/js/mascara_valor.js"></script>
<script src="assets/js/valida_boleto.js"></script>

<script src="assets/js/carrega_num_doc.js"></script>
</html>
