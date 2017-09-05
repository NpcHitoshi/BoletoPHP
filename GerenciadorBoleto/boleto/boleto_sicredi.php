<?php
header("Content-Type: text/html; charset=ISO-8859-1");

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Boleto.php";
require_once BASE_DIR . "model" . DS . "Usuario.php";
require_once BASE_DIR . "dao" . DS . "BoletoDAO.php";
require_once BASE_DIR . "dao" . DS . "UsuarioDAO.php";

session_start();
if (($_SESSION["usuario"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
$boleto = ($_SESSION["boleto"]);
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
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa		      		  |
// | 																	                                    |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenv Boleto SICREDI: Rafael Azenha Aquini <rafael@tchesoft.com>    |
// |                        Marco Antonio Righi <marcorighi@tchesoft.com> |
// | Homologação e ajuste de algumas rotinas.				               			  |
// |                        Marcelo Belinato  <mbelinato@gmail.com> 		  |
// +----------------------------------------------------------------------+
// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$data_venc = date("d/m/Y", strtotime($boleto->getDataVencimento()));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_boleto = str_replace("R$", "", $boleto->getValor()); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal

$dadosboleto["inicio_nosso_numero"] = date("y"); // Ano da geração do título ex: 07 para 2007 
$dadosboleto["nosso_numero"] = "13871";     // Nosso numero (máx. 5 digitos) - Numero sequencial de controle.
$dadosboleto["numero_documento"] = "27.030195.10"; // Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = "R$ ".$valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $boleto->getUsuario()->getRazaoSocial();
$dadosboleto["endereco1"] = $boleto->getUsuario()->getEndereco()->getRua() .", ".$boleto->getUsuario()->getEndereco()->getNumero();
$dadosboleto["endereco2"] = $boleto->getUsuario()->getEndereco()->getCidade()->getNomeCidade()." - ".
$boleto->getUsuario()->getEndereco()->getCidade()->getEstado()->getUf()." - ". $boleto->getUsuario()->getEndereco()->getCep();
// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Recebimento através do cheque Nº";
$dadosboleto["demonstrativo2"] = "Esta quitação só terá validade após o pagamento do cheque pelo banco pagador." ;
$dadosboleto["demonstrativo3"] = "Até o vencimento pagável em qualquer agência bancária.";
// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "PARA ATUALIZAR BOLETO ENTRA NO SITE: WWW.MICROVIL.COM.BR";
$dadosboleto["instrucoes2"] = "APOS VENCIMENTO COBRAR MULTA DE ".$boleto->getMulta()."%.";
$dadosboleto["instrucoes3"] = "APOS VENCIMENTO COBRAR MORA DIARIA DE R$ ".$boleto->getJuros();
$dadosboleto["instrucoes4"] = "";
// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N";     // N - remeter cobrança sem aceite do sacado  (cobranças não-registradas)
// S - remeter cobrança apos aceite do sacado (cobranças registradas)
$dadosboleto["especie"] = "REAL";
$dadosboleto["especie_doc"] = "DMI"; // OS - Outros segundo manual para cedentes de cobrança SICREDI
// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS DA SUA CONTA - SICREDI
$dadosboleto["agencia"] = "0725";  // Num da agencia (4 digitos), sem Digito Verificador
$dadosboleto["conta"] = "24354";  // Num da conta (5 digitos), sem Digito Verificador
$dadosboleto["conta_dv"] = "6";  // Digito Verificador do Num da conta
// DADOS PERSONALIZADOS - SICREDI
$dadosboleto["posto"] = "29";      // Código do posto da cooperativa de crédito
$dadosboleto["byte_idt"] = "2";   // Byte de identificação do cedente do bloqueto utilizado para compor o nosso número.
// 1 - Idtf emitente: Cooperativa | 2 a 9 - Idtf emitente: Cedente
$dadosboleto["carteira"] = "A";   // Código da Carteira: A (Simples) 
// SEUS DADOS
$dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos";
$dadosboleto["cpf_cnpj"] = "03.919.470/0001-41";
$dadosboleto["endereco"] = "Coloque o endereço da sua empresa aqui";
$dadosboleto["cidade_uf"] = "Piraquara / PR";
$dadosboleto["cedente"] = "MICROVIL AUTOMACAO COM LTDA";
// NÃO ALTERAR!
include("include/funcoes_sicredi.php");
include("include/layout_sicredi.php");
?>