<?php
namespace App\Models;
use MF\Model\Model;

class Usuario extends Model{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($atr){
        return $this->$atr;
    }

    public function __set($atr, $valor){
        $this->$atr = $valor;
    }

    // Salvar os dados para cadastro
    public function salvar(){
        $sql = "insert into usuarios(nome, email, senha) values(:nome, :email, :senha)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":nome", $this->__get("nome"));
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->bindValue(":senha", $this->__get("senha"));  // Requer MD5

        $stmt->execute();
        return $this;
    }
    // Validar se o cadastro pode ser feito
    public function validarCadastro(){
        $valido = true;
        if(strlen($this->__get('nome')) <= 3 || strlen($this->__get('email')) <= 3 || strlen($this->__get('senha')) <= 3){
            $valido = false;
        }

        return $valido;
    }
    // Recuperar usuário por e-mail
    public function getUsuarioPorEmail(){
        $sql = "select email from usuarios where email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    // Autenticar tentativa de login
    public function Autenticar(){
        $query = "select id, nome, email from usuarios where email = :email and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->bindValue(":senha", $this->__get("senha"));
        $stmt->execute();

        $retorno = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($retorno){
            $this->__set('id', $retorno['id']);
            $this->__set('nome', $retorno['nome']);
            $this->__set('email', $retorno['email']);
        }

        return $retorno;  // FETCH_ASSOC para retornar um array associativo email => abc@gmail.com
    }
}

?>