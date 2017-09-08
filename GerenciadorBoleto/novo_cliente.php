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
$clientes_active="active";
require_once 'menu.php';
?>
<form action="control/UsuarioControl.php?action=inserir" method="POST">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="title">Novo Cliente</h1>
        <div id="erro-submit" class="col-md-12"></div>
        <div class="col-md-6">
            <h4 class="title">Dados Básicos</h4>
            <div class="form-group col-md-12">
                <label for="cnpj">CNPJ:</label>
                <input id="cnpj" type="text" name="cnpj" class="form-control" placeholder="CNPJ"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-12">
                <label for="cnpj">Captcha:</label>
                <img id="captcha_cnpj" class="" src="<?php echo $imagem_cnpj; ?>"></br>
                <input id="captcha" type="text" maxlength="6" name="captcha_cnpj" class="form-control" placeholder="O que está escrito na imagem acima?"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-12">
                <label for="cnpj">Nome Empresarial:</label>
                <input id="nome" type="text" name="razao_social" class="form-control" placeholder="Nome Empresarial"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-12">
                <label for="email">E-mail:</label>
                <input id="email" type="text" name="email" class="form-control" placeholder="E-mail"/>
                <div class="erro"></div>
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="title">Endereço</h4>
            <div class="form-group col-md-12">
                <label for="cep">CEP:</label>
                <input id="cep" type="text" name="cep" class="form-control" placeholder="CEP"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-8">
                <label for="rua">Rua:</label>
                <input id="rua" type="text" name="rua" class="form-control" placeholder="Rua"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="numero">Número:</label>
                <input id="num" type="text" name="numero" class="form-control" placeholder="Número"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="uf">Estado:</label>
                <input id="estado" type="text" name="uf" class="form-control" placeholder="Estado"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="cidade">Cidade:</label>
                <input id="cidade" type="text" name="cidade" class="form-control" placeholder="Cidade"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="bairro">Bairro:</label>
                <input id="bairro" type="text" name="bairro" class="form-control" placeholder="Bairro"/>
                <div class="erro"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="complemento">Complemento:</label>
                <input id="complemento" type="text" name="complemento" class="form-control" placeholder="Complemento"/>
                <div class="erro"></div>
            </div>
        </div>
        <div id="cadastrar" class="col-md-12">
            <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Cadastrar</button>
        </div>
    </div>
</form>
</body>
<script src="assets/js/mascara_cliente.js" type="text/javascript"></script>
<script src="assets/js/carrega_cnpj.js" type="text/javascript"></script>
<script src="assets/js/carrega_cep.js" type="text/javascript"></script>
<script src="assets/js/valida_cliente.js" type="text/javascript"></script>
<link rel="stylesheet" href="assets/css/novo_cliente.css">

</html>
