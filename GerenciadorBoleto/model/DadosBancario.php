<?php

class DadosBancario {

    private $codigoDadosBancario;
    private $codigoAdministrador;
    private $banco;
    private $codigoCedente;
    private $agencia;
    private $contaCorrente;
    private $digitoVerificador;
    private $jurosPadrao;
    private $multaPadrao;

    function getCodigoDadosBancario() {
        return $this->codigoDadosBancario;
    }

    function getBanco() {
        return $this->banco;
    }

    function getCodigoAdministrador() {
        return $this->codigoAdministrador;
    }

    function getAgencia() {
        return $this->agencia;
    }

    function getContaCorrente() {
        return $this->contaCorrente;
    }

    function getCodigoCedente() {
        return $this->codigoCedente;
    }

    function setCodigoCedente($codigoCedente) {
        $this->codigoCedente = $codigoCedente;
    }

    function getDigitoVerificador() {
        return $this->digitoVerificador;
    }

    function getJurosPadrao() {
        return $this->jurosPadrao;
    }

    function getMultaPadrao() {
        return $this->multaPadrao;
    }

    function setCodigoDadosBancario($codigoDadosBancario) {
        $this->codigoDadosBancario = $codigoDadosBancario;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setCodigoAdministrador($codigoAdministrador) {
        $this->codigoAdministrador = $codigoAdministrador;
    }

    function setAgencia($agencia) {
        $this->agencia = $agencia;
    }

    function setContaCorrente($contaCorrente) {
        $this->contaCorrente = $contaCorrente;
    }

    function setDigitoVerificador($digitoVerificador) {
        $this->digitoVerificador = $digitoVerificador;
    }

    function setJurosPadrao($jurosPadrao) {
        $this->jurosPadrao = $jurosPadrao;
    }

    function setMultaPadrao($multaPadrao) {
        $this->multaPadrao = $multaPadrao;
    }

}
