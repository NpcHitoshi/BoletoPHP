<?php

class Usuario {

    private $codigoUsuario;
    private $endereco;
    private $razaoSocial;
    private $cnpj;
    private $email;
    private $senha;
    private $tipoConta;
    private $ativo;
    
    public function __construct() {

    }

    public function getCodigoUsuario() {
        return $this->codigoUsuario;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getRazaoSocial() {
        return $this->razaoSocial;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getTipoConta() {
        return $this->codigoUsuario;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    function setCodigoUsuario($codigoUsuario) {
        $this->codigoUsuario = $codigoUsuario;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setRazaoSocial($razaoSocial) {
        $this->razaoSocial = $razaoSocial;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
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
