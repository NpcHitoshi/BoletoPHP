<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de Boletos | Clientes</title>
        <link rel="stylesheet" href="assets/css/main.css">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="assets/css/padrao.css">
    </head>
    <body>
<nav class="navbar navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="navbar-brand" href="">GeBo</span>
        </div>
        <ul class="nav navbar-nav">
            <li class="<?php if (isset($boletos_active)) {
                echo $boletos_active;
            }
            ?>"><a href="boletos.php">Boletos</a></li>
            <li class="<?php if (isset($clientes_active)) {
                echo $clientes_active;
            }
            ?>"><a href="clientes.php">Clientes</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <div class="navbar-header">
            <span class="navbar-brand" href=""><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["cliente"]->getNomeCliente()?></span>
        </div>
            <li><a href="control/ProcessaLogin.php?action=logout"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
        </ul>
    </div>
</nav>