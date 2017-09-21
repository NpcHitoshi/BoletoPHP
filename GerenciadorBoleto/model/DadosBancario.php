<?php

class DadosBancario {

    private $codigoDadosBancario;
    private $agencia;
    private $contaCorrente;
    private $digitoVerificador;
    private $jurosPadrao;
    private $multaPadrao;

    function getCodigoDadosBancario() {
        return $this->codigoDadosBancario;
    }

    function getAgencia() {
        return $this->agencia;
    }

    function getContaCorrente() {
        return $this->contaCorrente;
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
