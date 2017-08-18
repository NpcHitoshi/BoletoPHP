<?php

class Endereco {

    private $codigoEndereco;
    private $rua;
    private $numero;
    private $bairro;
    private $cep;
    private $cidade;

    function __construct($rua, $numero, $bairro, $cep, $cidade) {
        $this->rua = $rua;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cep = $cep;
        $this->cidade = $cidade;
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

    function getCidade() {
        return $this->cidade;
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

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

}
