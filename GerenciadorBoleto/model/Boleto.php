<?php

class Boleto {

    private $codigoBoleto;
    private $usuario;
    private $banco;
    private $dataVencimento;
    private $valor;
    private $numeroDocumento;
    private $nossoNumero;
    private $dataEmissao;
    private $status;

    function __construct($usuario, $banco, $dataVencimento, $valor, $numeroDocumento, $nossoNumero, $dataEmissao) {
        $this->usuario = $usuario;
        $this->banco = $banco;
        $this->dataVencimento = $dataVencimento;
        $this->valor = $valor;
        $this->numeroDocumento = $numeroDocumento;
        $this->nossoNumero = $nossoNumero;
        $this->dataEmissao = $dataEmissao;
    }

    function getCodigoBoleto() {
        return $this->codigoBoleto;
    }

    function getUsuario() {
        return $this->usuario;
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

    function getStatus() {
        return $this->status;
    }

    function setCodigoBoleto($codigoBoleto) {
        $this->codigoBoleto = $codigoBoleto;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
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

    function setStatus($status) {
        $this->status = $status;
    }

}
