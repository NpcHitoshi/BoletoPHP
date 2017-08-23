<?php

class Endereco {

    private $codigoEndereco;
    private $cep;
    private $rua;
    private $numero;
    private $bairro;
    private $cidade;
    private $complemento;

    function getCodigoEndereco() {
        return $this->codigoEndereco;
    }

    function getCep() {
        return $this->cep;
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

    function getCidade() {
        return $this->cidade;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function setCodigoEndereco($codigoEndereco) {
        $this->codigoEndereco = $codigoEndereco;
    }

    function setCep($cep) {
        $this->cep = $cep;
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

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

}
