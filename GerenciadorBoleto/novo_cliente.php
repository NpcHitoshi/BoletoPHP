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
  <link rel="stylesheet" href="assets/css/padrao.css">
</head>
<body>
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
  
  <div class="col-md-10 col-md-offset-1">
    <h1 class="title">Novo Cliente</h1>
    <h4 class="title">Dados da Empresa</h4>
    <div class="form-group col-md-6">
      <label for="cnpj">CNPJ:</label>
      <input id="cnpj" type="text" name="cnpj" class="form-control" placeholder="CNPJ"/>
    </div>
    <div class="form-group col-md-6">
      <label for="cnpj">Captcha:</label>
      <img id="captcha_cnpj" src="<?php echo $imagem_cnpj; ?>" border="0">
      <input id="cnpj" type="text" name="cnpj" class="form-control" placeholder="Digite o que vê na imagem acima."/>
    </div>
    <h4 class="title">Endereço</h4>
    <h4 class="title">Login</h4>
    <form>

      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd">
      </div>
      <div class="checkbox">
        <label><input type="checkbox"> Remember me</label>
      </div>
      <button type="submit" class="btn btn-default">Cadastrar</button>
    </form>
  </div>
</body>
</html>
