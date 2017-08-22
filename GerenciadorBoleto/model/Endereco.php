<?php

class Endereco {

    private $codigoEndereco;
    private $cep;
    private $rua;
    private $numero;
    private $bairro;
    private $codigoCidade;

    function __construct() {
        
    }

    function getCodigoEndereco() {
        return $this->codigoEndereco;
    }

    function getRua() {
        return $this->rua;
    }

    function getNumero() {
        return $this->numero;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCep() {
        return $this->cep;
    }

    function getCodigoCidade() {
        return $this->codigoCidade;
    }

    function setCodigoEndereco($codigoEndereco) {
        $this->codigoEndereco = $codigoEndereco;
    }

    function setRua($rua) {
        $this->rua = $rua;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setCodigoCidade($codigoCidade) {
        $this->codigoCidade = $codigoCidade;
    }

}
