<?php
include("getcaptcha.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de Boletos | Novo Cliente</title>
        <link rel="stylesheet" href="assets/css/main.css">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/filtro.js"></script>
        <script src="assets/js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript" /></script>
    <script src="assets/js/novo_cliente.js" type="text/javascript"></script>
    <script src="assets/js/carrega_cnpj.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/css/padrao.css">
    <link rel="stylesheet" href="assets/css/novo_cliente.css">

</head>
<body>
<<<<<<< HEAD
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
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
      </ul>
    </div>
  </nav>
  <form>
    <div class="col-md-10 col-md-offset-1">
      <h1 class="title">Novo Cliente</h1>
      <div class="col-md-6">
        <h4 class="title">Dados Básicos</h4>
        <div class="form-group col-md-12">
          <label for="cnpj">CNPJ:</label>
          <input id="cnpj" type="text" name="cnpj" class="form-control" placeholder="CNPJ"/>
        </div>
        <div class="form-group col-md-12">
          <label for="cnpj">Captcha:</label>
          <img id="captcha_cnpj" class="" src="<?php echo $imagem_cnpj; ?>"></br>
          <input id="captcha" type="text" maxlength="6" name="captcha_cnpj" class="form-control" placeholder="O que está escrito na imagem acima?"/>
        </div>
        <div class="form-group col-md-12">
          <label for="cnpj">Nome Empresarial:</label>
          <input id="nome" type="text" name="nome" class="form-control" placeholder="Nome Empresarial"/>
        </div>
        <div class="form-group col-md-12">
          <label for="cep">E-mail:</label>
          <input id="email" type="text" name="email" class="form-control" placeholder="E-mail"/>
        </div>
      </div>
      <div class="col-md-6">
        <h4 class="title">Endereço</h4>
        <div class="form-group col-md-12">
          <label for="cep">CEP:</label>
          <input id="cep" type="text" name="cep" class="form-control" placeholder="CEP"/>
        </div>
        <div class="form-group col-md-8">
          <label for="cep">Rua:</label>
          <input id="rua" type="text" name="rua" class="form-control" placeholder="Rua"/>
=======
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
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Sair</a></li>
            </ul>
>>>>>>> origin/master
        </div>
    </nav>
    <div class="col-md-10 col-md-offset-1">
        <form action="control/ProcessaLogin?action=adicionar" method="POST">
            <h1 class="title">Novo Cliente</h1>
            <div class="col-md-6">
                <h4 class="title">Dados Básicos</h4>
                <div class="form-group col-md-12">
                    <label for="cnpj">CNPJ:</label>
                    <input id="cnpj" type="text" name="cnpj" class="form-control" placeholder="CNPJ"/>
                </div>
                <div class="form-group col-md-12">
                    <label for="cnpj">Nome Empresarial:</label>
                    <input id="nome" type="text" name="razao_social" class="form-control" placeholder="Nome Empresarial"/>
                </div>
                <div class="form-group col-md-12">
                    <label for="cnpj">Captcha:</label>
                    <img id="captcha_cnpj" class="" src="<?php echo $imagem_cnpj; ?>"></br>
                    <input id="captcha" type="text" name="captcha_cnpj" class="form-control" placeholder="O que está escrito na imagem acima?"/>
                </div>
                <div class="form-group col-md-12">
                    <label for="e-mail">E-mail:</label>
                    <input id="email" type="text" name="email" class="form-control" placeholder="E-mail"/>
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="title">Endereço</h4>
                <div class="form-group col-md-12">
                    <label for="cep">CEP:</label>
                    <input id="cep" type="text" name="cep" class="form-control" placeholder="CEP"/>
                </div>
                <div class="form-group col-md-8">
                    <label for="cep">Rua:</label>
                    <input id="rua" type="text" name="rua" class="form-control" placeholder="Rua"/>
                </div>
                <div class="form-group col-md-4">
                    <label for="cep">Número:</label>
                    <input id="num" type="text" name="numero" class="form-control" placeholder="Número"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="cep">Estado:</label>
                    <input id="estado" type="text" name="estado" class="form-control" placeholder="Estado"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="cep">Cidade:</label>
                    <input id="cidade" type="text" name="cidade" class="form-control" placeholder="Cidade"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="cep">Bairro:</label>
                    <input id="bairro" type="text" name="bairro" class="form-control" placeholder="Bairro"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="cep">Complemento:</label>
                    <input id="complemento" type="text" name="complemento" class="form-control" placeholder="Complemento"/>
                </div>
            </div>
            <div id="cadastrar" class="col-md-12">
                <button type="submit" class="btn btn-default col-md-offset-5 col-md-2">Cadastrar</button>
            </div>
        </form>
    </div>
</body>
</html>
