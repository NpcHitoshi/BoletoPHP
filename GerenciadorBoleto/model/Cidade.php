<?php

class Cidade {

    private $codigoCidade;
    private $nomeCidade;
    private $estado;

    function __construct() {
        
    }

    function getCodigoCidade() {
        return $this->codigoCidade;
    }

    function getNomeCidade() {
        return $this->nomeCidade;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigoCidade($codigoCidade) {
        $this->codigoCidade = $codigoCidade;
    }

    function setNomeCidade($nomeCidade) {
        $this->nomeCidade = $nomeCidade;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
