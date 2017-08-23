<?php
// Criado por Marcos Peli
// ultima atualização 30/Maio/2017 - incluido parametro token_cpf, necessário para consultas de CPF após última alteração da receita

// o objetivo dos scripts deste repositório é integrar consultas de CNPJ e CPF diretamente da receita federal
// para dentro de aplicações web que necessitem da resposta destas consultas para proseguirem, como e-comerce e afins.

require('funcoes.php');

// dados da postagem de formulário de CNPJ
$cnpj = $_GET['cnpj'];		
$cnpj = str_replace(".", "", $cnpj);
$cnpj = str_replace("/", "", $cnpj);
$cnpj = str_replace("-", "", $cnpj);	// Entradas POST devem ser tratadas para evitar injections
$captcha_cnpj = $_GET['captcha_cnpj'];	// Entradas POST devem ser tratadas para evitar injectio
if($cnpj AND $captcha_cnpj)
{
	$getHtmlCNPJ = getHtmlCNPJ($cnpj, $captcha_cnpj);
	$campos = parseHtmlCNPJ($getHtmlCNPJ);
	print_r($campos);
}
?>