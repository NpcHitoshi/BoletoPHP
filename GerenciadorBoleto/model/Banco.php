<?php

class Banco {

    private $codigoBanco;
    private $nomeBanco;

    function __construct() {
        
    }

    function getCodigoBanco() {
        return $this->codigoBanco;
    }

    function getNomeBanco() {
        return $this->nomeBanco;
    }

    function setCodigoBanco($codigoBanco) {
        $this->codigoBanco = $codigoBanco;
    }

    function setNomeBanco($nomeBanco) {
        $this->nomeBanco = $nomeBanco;
    }

}
