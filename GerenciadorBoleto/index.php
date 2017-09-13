<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de Boletos | Login</title>
        <link rel="stylesheet" href="assets/css/index.css">
        <script src="assets/js/jquery-1.2.6.pack.js" type="text/javascript"></script>
        <?php
        define('DS', DIRECTORY_SEPARATOR);
        define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
        session_start();
        ?>
    </head>
    <body>
        <div class="login-page">
            <div class="form">
                <?php if (isset($_SESSION["msg_retorno"])) { ?> 
                    <div id="erro">
                        <?php echo $_SESSION["msg_retorno"];
                        unset($_SESSION["msg_retorno"]);
                        ?>
                    </div>
                <?php } ?>
                <h2><img src="assets/images/logo.png" id="logo"></h2>
                <form class="register-form" action="control/ClienteControl.php?action=emailSenha" method="POST">
                    <input class="documento" type="text" name="documento" placeholder="Documento"/>
                    <button type="submit">Enviar</button>
                    <p class="message">Lembrou sua senha? <a href="#">Login</a></p>
                </form>

                <form class="login-form" action="control/ProcessaLogin.php?action=login" method="POST">
                    <input class="documento" type="text" name="documento" placeholder="Nº de Documento" required/>
                    <input id="senha" type="password" name="senha" placeholder="Senha" required/>
                    <button type="submit">login</button>
                    <p class="message">Esqueceu sua senha? <a href="#">Enviar E-mail</a></p>
                </form>
            </div>
        </div>
        <script src="assets/js/index.js"></script>
        <script src="assets/js/mascara_cliente.js"></script>
    </body>
</html>