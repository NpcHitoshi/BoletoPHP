<?php

require_once "Database.php";
require_once BASE_DIR . "model" . DS . "Usuario.php";
require_once BASE_DIR . "dao" . DS . "EnderecoDAO.php";

$db = new Database();
$pdo = $db->conexao();

class UsuarioDAO {

    private function populaUsuario($row) {
        $usuario = new Usuario();
        $usuario->setCodigoUsuario($row['id_usuario']);
        $usuario->setRazaoSocial($row['razao_social']);
        $usuario->setCnpj($row['cnpj']);
        $usuario->setEmail($row['email']);
        $usuario->setSenha($row['senha']);
        $usuario->setTipoConta($row['tipo_conta']);
        $usuario->setAtivo($row['ativo']);
        $eDao = new EnderecoDAO();
        $usuario->setEndereco($eDao->buscaEndereco($row['id_endereco']));
        return $usuario;
    }

    public function autenticaUsuario($cnpj, $senha) {
        try {
            $sql = "SELECT * FROM usuario WHERE cnpj = :cnpj AND senha = :senha";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":cnpj", $cnpj);
            $stmt->bindValue(":senha", $senha);
            $stmt->execute();
            return $this->populaUsuario($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarUsuariosAtivos() {
        try {
            $sql = "SELECT * FROM usuario WHERE ativo = (1)  AND tipo_conta = (0) ORDER BY razao_social";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $usuarios = array();
            foreach ($lista as $l) {
                $usuarios[] = $this->populaUsuario($l);
            }
            return $usuarios;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function listarUsuariosDesativados() {
        try {
            $sql = "SELECT * FROM usuario WHERE ativo = (0)  AND tipo_conta = (0) ORDER BY razao_social";
            $result = Database::conexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $usuarios = array();
            foreach ($lista as $l) {
                $usuarios[] = $this->populaUsuario($l);
            }
            return $usuarios;
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function buscarUsuario($codigo) {
        try {
            $sql = "SELECT * FROM usuario WHERE id_usuario = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaUsuario($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function inserirUsuario(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuario(id_endereco, razao_social, cnpj , email, senha, tipo_conta, ativo) VALUES (:endereco,"
                    . "UPPER(:razaoSocial), :cnpj, UPPER(:email), :senha, 0, 1)";
            $stmt = Database::conexao()->prepare($sql);
            $eDao = new EnderecoDAO();
            $cnpj = preg_replace("/(\/|-|\.)/", "", $usuario->getCnpj());
            $stmt->bindValue(":razaoSocial", $usuario->getRazaoSocial());
            $stmt->bindValue(":cnpj", $cnpj);
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":senha", $cnpj);
            $codigoEndereco = $eDao->inserirEndereco($usuario->getEndereco());
            $stmt->bindValue(":endereco", $codigoEndereco);
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function editaUsuario(Usuario $usuario) {
        try {
            $sql = "UPDATE usuario u, endereco e, cidade c, estado s SET u.razao_social = UPPER(:razaoSocial), u.email = "
                    . "UPPER(:email), e.cep = UPPER(:cep), e.rua = UPPER(:rua), e.numero = UPPER(:numero), s.uf = UPPER(:uf), "
                    . "s.nomeEstado = UPPER(:nomeEstado), c.nomeCidade = UPPER(:nomeCidade), e.bairro = UPPER(:bairro), "
                    . "e.complemento = UPPER(:complemento) WHERE u.id_usuario = :codigoUsuario AND u.id_endereco = e.id_endereco "
                    . "AND e.id_cidade = c.id_cidade AND c.id_estado = s.id_estado";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigoUsuario", $usuario->getCodigoUsuario());
            $stmt->bindValue(":razaoSocial", $usuario->getRazaoSocial());
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":cep", $usuario->getEndereco()->getCep());
            $stmt->bindValue(":bairro", $usuario->getEndereco()->getBairro());
            $stmt->bindValue(":rua", $usuario->getEndereco()->getRua());
            $stmt->bindValue(":numero", $usuario->getEndereco()->getNumero());
            $stmt->bindValue(":complemento", $usuario->getEndereco()->getComplemento());
            $stmt->bindValue(":nomeCidade", $usuario->getEndereco()->getCidade()->getNomeCidade());
            $stmt->bindValue(":uf", $usuario->getEndereco()->getCidade()->getEstado()->getUf());
            //$stmt->bindValue(":nomeEstado", $usuario->getEndereco()->getCidade()->getEstado()->getNomeEstado());
            $stmt->bindValue(":nomeEstado", "PR");
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function validaCampos($usuario) {
        return $usuario->getCNPJ() != null && $usuario->getRazaoSocial() != null && $usuario->getEmail() && 
                $usuario->getEndereco()->getCep() != null && $usuario->getEndereco()->getCidade()->getNomeCidade() != null
                && $usuario->getEndereco()->getCidade()->getEstado()->getUf() != null;
    }

    public function desativarUsuario($codigo) {
        try {
            $sql = "UPDATE usuario SET ativo = (0) WHERE id_usuario = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

    public function ativarUsuario($codigo) {
        try {
            $sql = "UPDATE usuario SET ativo = (1) WHERE id_usuario = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            return $stmt->execute();
        } catch (Exception $e) {
            print "Codigo: " . $e->getCode() . ", Mensagem:" . $e->getMessage();
        }
    }

}
