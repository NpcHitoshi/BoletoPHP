<?php

class Estado {

    private $codigoEstado;
    private $nomeEstado;
    private $uf;

    function __construct() {
        
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function getNomeEstado() {
        return $this->nomeEstado;
    }

    function getUf() {
        return $this->uf;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setNomeEstado($nomeEstado) {
        $this->nomeEstado = $nomeEstado;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

}
