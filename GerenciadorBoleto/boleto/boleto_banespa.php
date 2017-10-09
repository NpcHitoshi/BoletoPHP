<?php

header("Content-Type: text/html; charset=ISO-8859-1");

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Administrador.php";
require_once BASE_DIR . "model" . DS . "Boleto.php";
require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "model" . DS . "DadosBancario.php";
require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "dao" . DS . "AdministradorDAO.php";
require_once BASE_DIR . "dao" . DS . "BoletoDAO.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";

if (!isset($_SESSION["include"])) {
    session_start();
}

if (($_SESSION["usuario"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
$aDao = new AdministradorDAO();
$boleto = ($_SESSION["boleto"]);
$codigoBanco = 502;
$usuario = ($_SESSION["usuario"]);
$usuario->setDadosBancario($aDao->buscaBancoDadosBancarios($codigoBanco));
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Banespa : Fabio Gabbay                  		  |
// +----------------------------------------------------------------------+
// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
// DADOS DO BOLETO PARA O SEU CLIENTE
// MASCARA CPF /CNPJ
// MASCARA CPF / CNPJ
if (strlen($usuario->getDocumento()) === 14) {
    $documento = $usuario->getDocumento();
    $documento = substr($usuario->getDocumento(), 0, 2) . '.' . substr($usuario->getDocumento(), 2, 3) . '.' .
            substr($usuario->getDocumento(), 5, 3) . '/' . substr($usuario->getDocumento(), 8, 4) . '-' . substr($usuario->getDocumento(), 12);
} else {
    $documento = substr($usuario->getDocumento(), 0, 2) . '.' . substr($usuario->getDocumento(), 2, 3) . '.' .
            substr($usuario->getDocumento(), 5, 3) . '/' . substr($usuario->getDocumento(), 8, 4) . '-' . substr($usuario->getDocumento(), 12);
}
$cep = $boleto->getCliente()->getEndereco()->getCep();
$cep = substr($cep, 0, 2) . '.' . substr($cep, 2, 3) . '-' . substr($cep, 5);

$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.95;
$data_venc = date("d/m/Y", strtotime($boleto->getDataVencimento()));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = number_format($boleto->getValor(), 2, ",", "."); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal

$juros = number_format($boleto->getJuros(), 2, ",", ".");
$multa = $boleto->getMulta();

$dadosboleto["nosso_numero"] = $boleto->getNossoNumero(); // Nosso numero - REGRA: Máximo de 7 caracteres!
$dadosboleto["numero_documento"] = $boleto->getNumeroDocumento(); // Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y", strtotime($boleto->getDataEmissao())); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = "R$ " . $valor_cobrado;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $boleto->getCliente()->getNomeCliente();
$dadosboleto["endereco1"] = $boleto->getCliente()->getEndereco()->getRua() . ", " . $boleto->getCliente()->getEndereco()->getNumero();
$dadosboleto["endereco2"] = $boleto->getCliente()->getEndereco()->getCidade()->getNomeCidade() . " - " .
        $boleto->getCliente()->getEndereco()->getCidade()->getEstado()->getUf() . " - " . $boleto->getCliente()->getEndereco()->getCep();

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Recebimento através do cheque Nº";
$dadosboleto["demonstrativo2"] = "Esta quitação só terá validade após o pagamento do cheque pelo banco pagador.";
$dadosboleto["demonstrativo3"] = "Até o vencimento pagável em qualquer agência bancária.";
$dadosboleto["instrucoes1"] = "PARA ATUALIZAR BOLETO ENTRE NO SITE: WWW.MICROVIL.COM.BR";
$dadosboleto["instrucoes2"] = "APOS VENCIMENTO COBRAR MULTA DE " . $boleto->getMulta() . "%.";
$dadosboleto["instrucoes3"] = "APOS VENCIMENTO COBRAR MORA DIARIA DE R$ " . $juros . ".";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS PERSONALIZADOS - Banespa
$dadosboleto["codigo_cedente"] = $usuario->getDadosBancario()->getAgencia() . " " .
        $usuario->getDadosBancario()->getCodigoCedente() . " " .
        $usuario->getDadosBancario()->getDigitoVerificador(); // Código do cedente (Somente 11 digitos)
$dadosboleto["ponto_venda"] = $usuario->getDadosBancario()->getAgencia(); // Ponto de Venda = Agencia 
$dadosboleto["carteira"] = "COB";  // COB - SEM Registro
$dadosboleto["nome_da_agencia"] = $usuario->getDadosBancario()->getAgencia() . " " .
        $usuario->getDadosBancario()->getCodigoCedente() . " " .
        $usuario->getDadosBancario()->getDigitoVerificador();
// Nome da agencia (Opcional)
// SEUS DADOS
$dadosboleto["identificacao"] = $usuario->getNomeAdministrador();
$dadosboleto["cpf_cnpj"] = $documento;
$dadosboleto["endereco"] = $usuario->getEndereco()->getRua() . ", " . $usuario->getEndereco()->getNumero() .
        " - " . $usuario->getEndereco()->getBairro();
$dadosboleto["cidade_uf"] = $usuario->getEndereco()->getCidade()->getNomeCidade() . " / " .
        $usuario->getEndereco()->getCidade()->getEstado()->getUf();
$dadosboleto["cedente"] = $usuario->getNomeAdministrador();

// NÃO ALTERAR!
ob_start();
unset($_SESSION["boleto"]);
include("include/funcoes_banespa.php");
include("include/layout_banespa.php");

$content = ob_get_clean();

// convert
require_once(dirname(__FILE__) . '\html2pdf\html2pdf.class.php');
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr', array(0, 0, 0, 0));
    /* Abre a tela de impressão */
    //$html2pdf->pdf->IncludeJS("print(true);");

    $html2pdf->pdf->SetDisplayMode('real');

    /* Parametro vuehtml = true desabilita o pdf para desenvolvimento do layout */
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

    if (isset($_SESSION["include"])) {
        ob_clean();
    } else {
        /* Abrir no navegador */
        $html2pdf->Output('boleto' . $boleto->getNossoNumero() . '.pdf');
    }

    /* Salva o PDF no servidor para enviar por email */
    $html2pdf->Output('attachments/boleto.pdf', 'F');
    unset($_SESSION["include"]);
    /* Força o download no browser */
    //$html2pdf->Output('boleto.pdf', 'D');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
