<?php

class Cliente {

    private $codigoCliente;
    private $endereco;
    private $nomeCliente;
    private $documento;
    private $email;
    private $senha;
    private $tipoConta;
    private $ativo;

    public function __construct() {
        
    }

    function getCodigoCliente() {
        return $this->codigoCliente;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getNomeCliente() {
        return $this->nomeCliente;
    }

    function getDocumento() {
        return $this->documento;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getTipoConta() {
        return $this->tipoConta;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function setCodigoCliente($codigoCliente) {
        $this->codigoCliente = $codigoCliente;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setNomeCliente($nomeCliente) {
        $this->nomeCliente = $nomeCliente;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setTipoConta($tipoConta) {
        $this->tipoConta = $tipoConta;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

}
