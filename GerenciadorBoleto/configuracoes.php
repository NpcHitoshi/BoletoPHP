<?php
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(__FILE__) . DS);
}
require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";
require_once BASE_DIR . "model" . DS . "Banco.php";
require_once BASE_DIR . "dao" . DS . "BancoDAO.php";
session_start();
$usuario = $_SESSION["cliente"];
if (($_SESSION["cliente"]) == null || $usuario->getTipoConta() == 0) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
include("getcaptcha.php");
?>
<?php
$configuracoes_active = "active";
require_once 'menu_adm.php';
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
        <li class="active title"><a data-toggle="tab" href="#empresa">Dados Empresa</a></li>
        <li class="title"><a data-toggle="tab" href="#banco">Dados Bancários</a></li>
        <li class="title"><a data-toggle="tab" href="#senha">Senha</a></li>
    </ul>
    <!-- Inicio Painel Abas-->
    <div id="tab-config" class="tab-content">
        <!-- Inicio Dados Empresa-->
        <div id="empresa" class="tab-pane fade in active">
            <div class="col-md-6">
                <h4 class="title">Dados Básicos</h4>
                <div class="container-fluid">
                    <form id="form-emp" action="control/ClienteControl.php?action=inserir" method="POST">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="documento">Nº do documento:</label>
                                <input id="documento" type="text" name="documento" class="form-control" placeholder="Nº do documento"/>
                                <div class="erro"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="cnpj">Captcha:
                                    <img id="captcha_cnpj" class="" src="<?php echo $imagem_cnpj ?>"></label>
                                    <input id="captcha" type="text" maxlength="6" name="captcha_cnpj" class="form-control" placeholder="O que está escrito na imagem acima?"/>
                                    <div class="erro"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="documento">Nome / Razão Social:</label>
                                    <input id="nome" type="text" name="nomeCliente" class="form-control" placeholder="Nome / Razão Social"/>
                                    <div class="erro"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="email">E-mail:</label>
                                    <input id="email" type="text" name="email" class="form-control" placeholder="E-mail"/>
                                    <div class="erro"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="title">Endereço</h4>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="cep">CEP:</label>
                                    <input id="cep" type="text" name="cep" class="form-control" placeholder="CEP"/>
                                    <div class="erro"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="rua">Rua:</label>
                                    <input id="rua" type="text" name="rua" class="form-control" placeholder="Rua"/>
                                    <div class="erro"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numero">Número:</label>
                                    <input id="num" type="text" name="numero" class="form-control" placeholder="Número"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="uf">Estado:</label>
                                    <input id="estado" type="text" name="uf" class="form-control" placeholder="Estado" readonly/>
                                    <div class="erro"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cidade">Cidade:</label>
                                    <input id="cidade" type="text" name="cidade" class="form-control" placeholder="Cidade" readonly/>
                                    <div class="erro"></div>
                                </div>
                            </div>

                            <div class="row">
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
                        </div>
                    </div>
                    <div id="cadastrar" class="col-md-12">
                        <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Atualizar</button>
                    </div>
                </form>
            </div>
            <!-- Fim Dados Empresa-->
            <!-- Inicio Dados Bancários-->
            <div id="banco" class="tab-pane fade">
                <div class="col-md-12">
                    <form id="form-banco" action="control/ClienteControl.php?action=inserir" method="POST">
                        <h4 class="title">Dados Básicos</h4>
                        <div class="form-group col-md-12">
                            <label for="cliente">Cliente:</label>
                            <select id="banco" name="codigoBanco" class="js-example-basic-single form-control">
                                <?php
                                $bDao = new BancoDAO();
                                $bancos[] = new Banco();
                                $bancos = $bDao->listarbancos();
                                foreach ($bancos as $objBanco) {
                                    ?>
                                    <option value="<?php echo $objBanco->getCodigoBanco() ?>"><?php echo $objBanco->getNomeBanco() ?></option>
                                    <?php } ?>
                                </select>
                                <div class="erro"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="agencia">Agência:</label>
                                <input id="agencia" type="text" name="agencia" class="form-control" placeholder="Agência"/>
                                <div class="erro"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="conta">Conta-Corrente:</label>
                                <input id="conta" type="text" name="conta" class="form-control" placeholder="Conta-Corrente"/>
                                <div class="erro"></div>
                            </div>
                            <div class="form-group col-md-1">
                                <label class="gasparzinho" for="dv">sas</label>
                                <input id="dv" type="text" name="dv" class="form-control" placeholder="DV"/>
                                <div class="erro"></div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="juros">Juros:</label>
                                <input id="juros" type="text" name="juros" class="form-control" placeholder="Juros"/>
                                <div class="erro"></div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="multa">Multa:</label>
                                <input id="multa" type="text" name="multa" class="form-control" placeholder="Multa"/>
                                <div class="erro"></div>
                            </div>
                        </div>
                        <div id="cadastrar" class="col-md-12">
                            <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Atualizar</button>
                        </div>
                    </form>
                </div>
                <!-- Fim Dados Bancários -->
                <!-- Inicio Senha -->
                <div id="senha" class="tab-pane fade">
                    <div class="col-md-12">
                        <form action="control/ClienteControl.php?action=inserir" method="POST">
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
                        </div>
                        <div id="cadastrar" class="col-md-12">
                            <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Atualizar</button>
                        </div>
                    </form>
                    </div>
                    <!-- Fim Senha-->
                    <!-- Fim Painel Abas-->
                </div>
            </div>
        </form>
    </body>
    <script src="assets/js/mascara_cliente.js" type="text/javascript"></script>
    <script src="assets/js/carrega_cnpj.js" type="text/javascript"></script>
    <script src="assets/js/carrega_cep.js" type="text/javascript"></script>
    <script src="assets/js/valida_cliente.js" type="text/javascript"></script>
    <script src="assets/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="assets/css/novo_cliente.css">
    <link href="assets/dist/css/select2.min.css" rel="stylesheet" />
    </html>
