<?php

class Estado {

    private $codigoEstado;
    private $uf;

    function __construct($uf) {
        $this->uf = $uf;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function getUf() {
        return $this->uf;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

}
