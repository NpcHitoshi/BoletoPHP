<?php

if (!defined("DS")) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined("BASE_DIR")) {
    define('BASE_DIR', dirname(dirname(__FILE__)) . DS);
}

require_once BASE_DIR . "model" . DS . "Banco.php";
require_once BASE_DIR . "model" . DS . "Cliente.php";
require_once BASE_DIR . "dao" . DS . "BancoDAO.php";
require_once BASE_DIR . "dao" . DS . "Database.php";
require_once BASE_DIR . "dao" . DS . "ClienteDAO.php";

class BoletoDAO {

    private function populaBoleto($row) {
        $boleto = new Boleto();
        $boleto->setCodigoBoleto($row['id_boleto']);
        $boleto->setDataEmissao($row['data_emissao']);
        $boleto->setDataVencimento($row['data_vencimento']);
        $boleto->setValor($row['valor']);
        $boleto->setNossoNumero($row['nosso_numero']);
        $boleto->setNumeroDocumento($row['numero_documento']);
        $boleto->setSituacao($row['situacao']);
        $boleto->setMulta($row['multa']);
        $boleto->setJuros($row['juros']);
        $bDao = new BancoDAO();
        $boleto->setBanco($bDao->buscarBanco($row['id_banco']));
        $cDao = new ClienteDAO();
        $boleto->setCliente($cDao->buscarCliente($row['id_cliente']));
        return $boleto;
    }

    public function listarBoletos() {
        try {
            $sql = "SELECT * FROM boleto ORDER BY nosso_Numero";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $boletos = array();
            foreach ($lista as $l) {
                $boletos[] = $this->populaBoleto($l);
            }
            return $boletos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarBoletosAbertos() {
        try {
            $sql = "SELECT * FROM boleto WHERE situacao = 1 ORDER BY numero_documento";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $boletos = array();
            foreach ($lista as $l) {
                $boletos[] = $this->populaBoleto($l);
            }
            return $boletos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarBoletosPagos() {
        try {
            $sql = "SELECT * FROM boleto WHERE situacao = 2 ORDER BY numero_documento";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $boletos = array();
            foreach ($lista as $l) {
                $boletos[] = $this->populaBoleto($l);
            }
            return $boletos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarBoletosVencidos() {
        try {
            $sql = "SELECT * FROM boleto WHERE situacao = 3 ORDER BY numero_documento";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $boletos = array();
            foreach ($lista as $l) {
                $boletos[] = $this->populaBoleto($l);
            }
            return $boletos;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarBoleto($codigo) {
        try {
            $sql = "SELECT * FROM boleto WHERE id_boleto = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaBoleto($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function inserirBoleto($boleto) {
        try {
            $sql = "INSERT INTO boleto(id_cliente, id_banco, data_vencimento, valor, numero_documento, nosso_numero, data_emissao, "
                    . "situacao, multa, juros) VALUES (:codigoCliente, :codigoBanco, :dataVencimento, :valor, :numeroDocumento, "
                    . ":nossoNumero, :dataEmissao, 1, :multa, :juros)";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigoCliente", $boleto->getCliente()->getCodigoCliente());
            $stmt->bindValue(":codigoBanco", $boleto->getBanco()->getCodigoBanco());
            $stmt->bindValue(":dataVencimento", $boleto->getDataVencimento());
            $stmt->bindValue(":valor", $boleto->getValor());
            $stmt->bindValue(":multa", $boleto->getMulta());
            $stmt->bindValue(":juros", $boleto->getJuros());
            $stmt->bindValue(":numeroDocumento", $boleto->getNumeroDocumento());
            $stmt->bindValue(":nossoNumero", $boleto->getNossoNumero());
            $stmt->bindValue(":dataEmissao", $boleto->getDataEmissao());
            $stmt->execute();
            return Database::conexao()->lastInsertId();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function nossoNumero() {
        try {
            $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'boleto' AND "
                    . "table_schema = 'gerenciadordeboleto'";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->execute();
            $nossoNumero = $stmt->fetch(PDO::FETCH_ASSOC);
            while (strlen($nossoNumero['AUTO_INCREMENT']) < 5) {
                $nossoNumero['AUTO_INCREMENT'] = "0" . $nossoNumero['AUTO_INCREMENT'];
            }
            return $nossoNumero['AUTO_INCREMENT'];
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function numDocumento($codigo) {
        try {
            $sql = "SELECT u.id_cliente AS codigo, COUNT(b.id_boleto) as quant FROM cliente u INNER JOIN boleto b ON "
                    . "u.id_cliente = b.id_cliente WHERE u.id_cliente = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            $retorno = $stmt->fetch(PDO::FETCH_ASSOC);
            while (strlen($retorno['codigo']) < 5) {
                $retorno['codigo'] = "0" . $retorno['codigo'];
            }
            return $retorno['codigo'] . "/" . ($retorno['quant'] + 1);
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function atualizaBoleto($boleto) {
        try {
            $sql = "UPDATE boleto SET valor = :valor, data_vencimento = :dataVencimento situacao = WHERE id_boleto = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $boleto->getCodigoBoleto());
            $stmt->bindValue(":dataVencimento", $boleto->getDataVencimento());
            $stmt->bindValue(":valor", $boleto->getValor());
            $stmt->execute();
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function validaCampos($boleto) {
        return $boleto->getNumeroDocumento() != null && $boleto->getValor() != null && $boleto->getDataVencimento() != null &&
                $boleto->getCliente() != null && $boleto->getBanco() != null;
    }

}
