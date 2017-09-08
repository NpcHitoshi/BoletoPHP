<?php
if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(__FILE__) . DS);
}
require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";
require_once BASE_DIR . "model" . DS . "Boleto.php";
require_once BASE_DIR . "dao" . DS . "BoletoDao.php";
session_start();
if (($_SESSION["cliente"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
?>
<?php
$boletos_active = "active";
require_once 'menu.php';
?>
<script src="assets/js/filtro.js"></script>
<script src="assets/js/manterModal.js"></script>
<link rel="stylesheet" href="assets/css/boletos.css">
<div class="col-md-10 col-md-offset-1">
    <h1 class="title">Boletos</h1>
    <a href="./novo_boleto.php"><button class="btn btn-default col-md-offset-10 col-md-2" >Novo Boleto</button></a>
    <div id="legenda" class="col-md-12">
        <div id="" class="color col-md-1 c-1"></div>
        <div class="col-md-2">- Aberto</div>
        <div id="" class="color col-md-1 c-2"></div>
        <div class="col-md-2">- Pago</div>
        <div id="" class="color col-md-1 c-3"></div>
        <div class="col-md-2">- 2ª+ Via</div>
    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#todos">Todos</a></li>
        <li><a data-toggle="tab" href="#abertos">Abertos</a></li>
        <li><a data-toggle="tab" href="#pagos">Pagos</a></li>
        <li><a data-toggle="tab" href="#2vias">2ª Vias</a></li>
    </ul>

    <div class="tab-content">
        <div id="todos" class="tab-pane fade in active">
            <input class="form-control input-lg" id="buscar" alt="table1" placeholder="Pesquisar..." type="text">
            <table class="table1 table table-hover table-inverse">
                <thead>
                    <tr>
                        <th class="col-md-3">Pagador</th>
                        <th class="col-md-2">Nosso Número</th>
                        <th class="col-md-2">Data de Vencimento</th>
                        <th class="col-md-4" colspan="4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><?php
                        $bDao = new BoletoDAO();
                        $boletos[] = new Boleto();
                        $boletos = $bDao->listarBoletos();
                        foreach ($boletos as $obj) {
                            ?>
                            <td class="busca col-md-4"><span class="color col-md-1 c-<?php echo $obj->getSituacao() ?>"></span><?php echo $obj->getCliente()->getNomeCliente() ?></td>
                            <td class="col-md-2"><?php echo $obj->getNossoNumero() ?></td>
                            <td class="col-md-2"><?php echo date("d/m/Y", strtotime($obj->getDataVencimento())); ?></td>
                            <td class="col-md-4">
                                <a class='btn btn-edit' target="_blank" href="control/BoletoControl.php?action=vizualizar&codigo=<?php echo $obj->getCodigoBoleto()?>">
                                    <span class='glyphicon glyphicon-info-sign'></span> Visualizar
                                </a>
                                <button id="bt2via" name="" class="btn btn-yes" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-duplicate"></span> 2ª Via
                                </button>
                                <button id="btemail" name="" class="btn btn-delete" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-send"></span> Enviar E-mail
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="pagos" class="tab-pane fade">
            <input class="form-control input-lg" id="buscar1" alt="table2" placeholder="Pesquisar..." type="text">
            <table class="table2 table table-hover table-inverse">
                <thead>
                    <tr>
                        <th class="col-md-3">Pagador</th>
                        <th class="col-md-2">Nosso Número</th>
                        <th class="col-md-2">Data de Vencimento</th>
                        <th class="col-md-4" colspan="4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><?php
                        $boletosPagos = $bDao->listarBoletosPagos();
                        foreach ($boletosPagos as $obj) {
                            ?>
                            <td class="busca col-md-4"><span class="color col-md-1 c-2"></span><?php echo $obj->getCliente()->getNomeCliente() ?></td>
                            <td class="col-md-2"><?php echo $obj->getNossoNumero() ?></td>
                            <td class="col-md-2"><?php echo date("d/m/Y", strtotime($obj->getDataVencimento())); ?></td>
                            <td class="col-md-4">
                                <a class='btn btn-edit' href="">
                                    <span class='glyphicon glyphicon-info-sign'></span> Visualizar
                                </a>
                                <button id="bt2via" name="" class="btn btn-yes" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-duplicate"></span> 2ª Via
                                </button>
                                <button id="btemail" name="" class="btn btn-delete" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-send"></span> Enviar E-mail
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="abertos" class="tab-pane fade">
            <input class="form-control input-lg" id="buscar2" alt="table3" placeholder="Pesquisar..." type="text">
            <table class="table3 table table-hover table-inverse">
                <thead>
                    <tr>
                        <th class="col-md-3">Pagador</th>
                        <th class="col-md-2">Nosso Número</th>
                        <th class="col-md-2">Data de Vencimento</th>
                        <th class="col-md-4" colspan="4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><?php
                        $boletosAbertos = $bDao->listarBoletosAbertos();
                        foreach ($boletosAbertos as $obj) {
                            ?>
                            <td class="busca col-md-4"><span class="color col-md-1 c-1"></span><?php echo $obj->getCliente()->getNomeCliente() ?></td>
                            <td class="col-md-2"><?php echo $obj->getNossoNumero() ?></td>
                            <td class="col-md-2"><?php echo date("d/m/Y", strtotime($obj->getDataVencimento())); ?></td>
                            <td class="col-md-4">
                                <a class='btn btn-edit' href="">
                                    <span class='glyphicon glyphicon-info-sign'></span> Visualizar
                                </a>
                                <button id="bt2via" name="" class="btn btn-yes" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-duplicate"></span> 2ª Via
                                </button>
                                <button id="btemail" name="" class="btn btn-delete" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-send"></span> Enviar E-mail
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="2vias" class="tab-pane fade">
            <input class="form-control input-lg" id="buscar3" alt="table4" placeholder="Pesquisar..." type="text">
            <table class="table4 table table-hover table-inverse">
                <thead>
                    <tr>
                        <th class="col-md-3">Pagador</th>
                        <th class="col-md-2">Nosso Número</th>
                        <th class="col-md-2">Data de Vencimento</th>
                        <th class="col-md-4" colspan="4"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><?php
                        $boletos2via = $bDao->listarBoletos2via();
                        foreach ($boletos2via as $obj) {
                            ?>
                            <td class="busca col-md-4"><span class="color col-md-1 c-3"></span><?php echo $obj->getCliente()->getNomeCliente() ?></td>
                            <td class="col-md-2"><?php echo $obj->getNossoNumero() ?></td>
                            <td class="col-md-2"><?php echo date("d/m/Y", strtotime($obj->getDataVencimento())); ?></td>
                            <td class="col-md-4">
                                <a class='btn btn-edit' href="">
                                    <span class='glyphicon glyphicon-info-sign'></span> Visualizar
                                </a>
                                <button id="bt2via" name="" class="btn btn-yes" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-duplicate"></span> 2ª Via
                                </button>
                                <button id="btemail" name="" class="btn btn-delete" data-toggle="modal" data-target="#modalDelete">
                                    <span class="glyphicon glyphicon-send"></span> Enviar E-mail
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Excluir -->
<div id="modalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Excluir Registro</h4>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este registro?</p>
            </div>
            <div class="modal-footer">
                <a href="" id="Excsime"><button type="button" class="btn btn-yes">Sim</button></a>
                <button type="button" class="btn btn-delete" data-dismiss="modal">Não</button>
            </div>
        </div>

    </div>
</div>



<!-- Modal Ativar -->
<div id="modalAtivar" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ativar Registro</h4>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja ativar este registro?</p>
            </div>
            <div class="modal-footer">
                <a href="" id="Excsima"><button type="button" class="btn btn-yes">Sim</button></a>
                <button type="button" class="btn btn-delete" data-dismiss="modal">Não</button>
            </div>
        </div>

    </div>
</div>
</body>

</html>
