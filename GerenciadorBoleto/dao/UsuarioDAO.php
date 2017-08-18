<?php

require_once "Database.class.php";
require_once "../model/Usuario.php";


$db = new Database();
$pdo = $db->getConnection();

class UsuarioDAO {

    public function BuscarFuncionario($codigo) {
        try {
            $sql = "SELECT * FROM usuario WHERE id_usuario = :codigo";
            $stmt = Database::conexao()->prepare($sql);
            $stmt->bindValue(":codigo", $codigo);
            $stmt->execute();
            return $this->populaUsuario($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                            getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    private function populaUsuario($row) {
        $usuario = new Usuario;
        $usuario->setCodigoUsuario($row['id_usuario']);
        $usuario->setEndereco($row['id_endereco']);
        $usuario->setRazaoSocial($row['razao_social']);
        $usuario->setCnpj($row['cnpj']);
        $usuario->setEmail($row['email']);
        $usuario->setSenha($row['senha']);
        $usuario->setTipoConta($row['tipo_conta']);
        $usuario->setAtivo($row['ativo']);
        return $usuario;
    }

    public function Inserir(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuario(id_endereco, razao_social, cnpj , email, senha, tipo_conta, ativo VALUES (:endereco,"
                    . "UPPER(:razaoSocial), :cnpj, UPPER(:email), :senha, 0, 1)";
            $stmt = Conexao::getInstance()->prepare($sql);

            $stmt->bindValue(":id_endereco", $usuario->getCodigoEndereco());
            $stmt->bindValue(":razao_social", $usuario->getRazaoSocial());
            $stmt->bindValue(":cnpj", $usuario->getCnpj());
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":senha", $usuario->getSenha());

            return $stmt->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
 um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " .
                    $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

}
