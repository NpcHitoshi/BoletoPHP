<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de Boletos | Login</title>
        <link rel="stylesheet" href="assets/css/index.css">
        <script src="assets/js/jquery-1.2.6.pack.js" type="text/javascript"></script>
        <script src="assets/js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript" /></script>
    <?php
    define('DS', DIRECTORY_SEPARATOR);
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
    ?>
</head>
<body>
    <div class="login-page">
        <div class="form">
            <h2><img src="assets/images/logo.png" id="logo"></h2>
            <form class="register-form">
                <input type="text" name="email" placeholder="E-mail"/>
                <button>Enviar</button>
                <p class="message">Lembrou sua senha? <a href="#">Login</a></p>
            </form>

            <form class="login-form" action="control/ProcessaLogin?action=login" method="POST">
                <input id="cnpj" type="text" name="cnpj" placeholder="CNPJ" required/>
                <input id="senha" type="password" name="senha" placeholder="Senha" required/>
                <button type="submit">login</button>
                <p class="message">Esqueceu sua senha? <a href="#">Enviar E-mail</a></p>
            </form>
        </div>
    </div>
    <!--<script src="assets/js/index.js"></script> !-->
</body>
</html>
