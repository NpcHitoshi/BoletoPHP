<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de Boletos | Clientes</title>
        <link rel="stylesheet" href="assets/css/main.css">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/filtro.js"></script>
        <script src="assets/js/modalExcluir.js"></script>
        <link rel="stylesheet" href="assets/css/padrao.css">
    </head>
    <body>
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
            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/GerenciadorBoleto/index.php");
        }
        ?>
        <nav class="navbar navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">GPHP</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class=""><a href="#">Boletos</a></li>
                    <li class="active"><a href="#">Clientes</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Usuário</a></li>
                    <li><a href="control/ProcessaLogin?action=logout"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
                </ul>
            </div>
        </nav>

        <div class="col-md-10 col-md-offset-1">
            <h1 class="title">Clientes</h1>
            <a href="./novo_cliente.php"><button class="btn btn-default col-md-offset-10 col-md-2" >Novo Cliente</button></a>

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#ativado">Ativados</a></li>
                <li><a data-toggle="tab" href="#desativado">Desativados</a></li>
            </ul>

            <div class="tab-content">
                <div id="ativado" class="tab-pane fade in active">
                    <input class="form-control input-lg" id="buscar" alt="table1" placeholder="Pesquisar..." type="text">
                    <table class="table1 table table-hover table-inverse">
                        <thead>
                            <tr>
                                <th class="col-md-5">Nome Empresarial</th>
                                <th class="col-md-2">CNPJ</th>
                                <th class="col-md-3">E-mail</th>
                                <th class="col-md-2" colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><?php
                                $uDao = new UsuarioDao();
                                $retorno[] = new Usuario();
                                $retorno = $uDao->listarUsuariosAtivos();
                                foreach ($retorno as $obj) {
                                    ?>
                                    <td class="busca col-md-4"><?php echo $obj->getRazaoSocial() ?></td>
                                    <td class="col-md-2"><?php echo $obj->getCnpj() ?></td>
                                    <td class="col-md-3"><?php echo $obj->getEmail() ?></td>
                                    <td class="col-md-3">
                                        <button class='btn btn-edit' > 
                                            <span class='glyphicon glyphicon-edit'></span> Editar
                                        </button>
                                        <button id="btexcluir" name="control/UsuarioControl?action=desativar&codigo=<?php echo $obj->getCodigoUsuario()?>" class="btn btn-delete" data-toggle="modal" data-target="#modalDelete">
                                            <span class="glyphicon glyphicon-remove"></span> Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div id="desativado" class="tab-pane fade">
                    <input class="form-control input-lg" id="buscar1" alt="table2" placeholder="Pesquisar..." type="text">
                    <table class="table2 table table-hover table-inverse">
                        <thead>
                            <tr>
                                <th class="col-md-5">Nome Empresarial</th>
                                <th class="col-md-2">CNPJ</th>
                                <th class="col-md-3">E-mail</th>
                                <th class="col-md-2" colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><?php
                                $uDao = new UsuarioDao();
                                $retorno[] = new Usuario();
                                $retorno = $uDao->listarUsuariosDesativados();
                                foreach ($retorno as $obj) {
                                    ?>
                                    <td class="busca col-md-4"><?php echo $obj->getRazaoSocial() ?></td>
                                    <td class="col-md-2"><?php echo $obj->getCnpj() ?></td>
                                    <td class="col-md-3"><?php echo $obj->getEmail() ?></td>
                                    <td class="col-md-3">
                                        <button class='btn btn-edit' > 
                                            <span class='glyphicon glyphicon-edit'></span> Editar
                                        </button>
                                        <button class="btn btn-delete" data-toggle="modal" data-target="#modalDelete">
                                            <span class="glyphicon glyphicon-remove"></span> Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
                    <a href="" id="Excsim"><button type="button" class="btn btn-yes">Sim</button></a>
                    <button type="button" class="btn btn-delete" data-dismiss="modal">Não</button>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
