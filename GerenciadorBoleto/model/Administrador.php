<?php

class Administrador {

    private $codigoAdministrador;
    private $endereco;
    private $dadosBancario;
    private $nomeAdministrador;
    private $documento;
    private $email;
    private $senha;
    private $tipoConta;

    function getCodigoAdministrador() {
        return $this->codigoAdministrador;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getDadosBancario() {
        return $this->dadosBancario;
    }

    function getNomeAdministrador() {
        return $this->nomeAdministrador;
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

    function setCodigoAdministrador($codigoAdministrador) {
        $this->codigoAdministrador = $codigoAdministrador;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setDadosBancario($dadosBancario) {
        $this->dadosBancario = $dadosBancario;
    }

    function setNomeAdministrador($nomeAdministrador) {
        $this->nomeAdministrador = $nomeAdministrador;
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

}
