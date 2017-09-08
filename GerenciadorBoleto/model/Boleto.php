<?php

class Boleto {

    private $codigoBoleto;
    private $cliente;
    private $banco;
    private $dataVencimento;
    private $valor;
    private $multa;
    private $numeroDocumento;
    private $nossoNumero;
    private $dataEmissao;
    private $situacao;

    function __construct() {
        
    }

    function getCliente() {
        return $this->cliente;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function getMulta() {
        return $this->multa;
    }

    function setMulta($multa) {
        $this->multa = $multa;
    }

    function getCodigoBoleto() {
        return $this->codigoBoleto;
    }

    function getBanco() {
        return $this->banco;
    }

    function getDataVencimento() {
        return $this->dataVencimento;
    }

    function getValor() {
        return $this->valor;
    }

    function getNumeroDocumento() {
        return $this->numeroDocumento;
    }

    function getNossoNumero() {
        return $this->nossoNumero;
    }

    function getDataEmissao() {
        return $this->dataEmissao;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setCodigoBoleto($codigoBoleto) {
        $this->codigoBoleto = $codigoBoleto;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setDataVencimento($dataVencimento) {
        $this->dataVencimento = $dataVencimento;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setNumeroDocumento($numeroDocumento) {
        $this->numeroDocumento = $numeroDocumento;
    }

    function setNossoNumero($nossoNumero) {
        $this->nossoNumero = $nossoNumero;
    }

    function setDataEmissao($dataEmissao) {
        $this->dataEmissao = $dataEmissao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

}
