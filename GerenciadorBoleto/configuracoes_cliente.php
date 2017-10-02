<?php
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(__FILE__) . DS);
}
require_once BASE_DIR . "model" . DS . "Administrador.php";
require_once BASE_DIR . "dao" . DS . "AdministradorDAO.php";
require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";
require_once BASE_DIR . "model" . DS . "Banco.php";
require_once BASE_DIR . "dao" . DS . "BancoDAO.php";
require_once BASE_DIR . "model" . DS . "DadosBancario.php";

session_start();
$usuario = $_SESSION["usuario"];
if (($_SESSION["usuario"]) == null || $usuario->getTipoConta() == 1) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
include("getcaptcha.php");
?>
<?php
$configuracoes_active = "active";
require_once 'menu_cliente.php';
?>
<div class="col-md-10 col-md-offset-1">
    <h1 class="title">Configurações</h1>
    <?php if (isset($_SESSION["msg_retorno"])) { ?> 
        <div id="mensagem col-md-12">
            <?php
            echo $_SESSION["msg_retorno"];
            unset($_SESSION["msg_retorno"]);
            ?>
        </div>
    <?php } ?>
    <div id="erro-submit" class="col-md-12"></div>
    <ul class="nav nav-tabs">
        <li class="title"><a data-toggle="tab" href="#senha">Senha</a></li>
    </ul>
    <!-- Inicio Painel Abas-->
    <div id="tab-config" class="tab-content">
        <!-- Inicio Senha -->
        <div id="senha" class="tab-pane fade in active">
            <div class="col-md-12">
                <form id="form-senha" action="control/ClienteControl.php?action=editarSenha" method="POST">
                    <h4 class="title">Dados Básicos</h4>
                    <div class="form-group col-md-4">
                        <label for="senhaAtual">Senha Atual:</label>
                        <input id="senhaAtual" type="password" name="senhaAtual" class="form-control" placeholder="Senha Atual"/>
                        <div class="erro"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="novaSenha">Nova Senha:</label>
                        <input id="novaSenha" type="password" name="novaSenha" class="form-control" placeholder="Nova Senha"/>
                        <div class="erro"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="confirmaSenha">Confirmar Senha:</label>
                        <input id="confirmaSenha" type="password" name="confirmaSenha" class="form-control" placeholder="Confirmar Senha"/>
                        <div class="erro"></div>
                    </div>

                    <div id="cadastrar" class="col-md-12">
                        <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Fim Senha-->
        <!-- Fim Painel Abas-->
    </div>
</div>
</div>
</body>
<script src="assets/js/mascara_documento.js" type="text/javascript"></script>
<script src="assets/js/mascara_cep.js" type="text/javascript"></script>
<script src="assets/js/carrega_cnpj.js" type="text/javascript"></script>
<script src="assets/js/carrega_cep.js" type="text/javascript"></script>
<script src="assets/js/carrega_dados_banco.js" type="text/javascript"></script>
<script src="assets/js/valida_config.js" type="text/javascript"></script>
<script src="assets/js/mascara_valor.js" type="text/javascript"></script>
<script src="assets/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="assets/css/novo_cliente.css">
<link href="assets/dist/css/select2.min.css" rel="stylesheet" />
</html>
