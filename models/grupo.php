<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/db/conexao.php";

class Grupo
{
    public $id_grupo;
    public $nome;
    public $descricao;

    public function __construct($id_grupo = false)
    {
        if ($id_grupo) {
            $this->id_grupo = $id_grupo;
            $this->carregar();
        }
    }

    public function carregar()
    {
        $query = "SELECT nome, descricao FROM grupo WHERE id_grupo = :id_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo', $this->id_grupo);
        $stmt->execute();

        $lista = $stmt->fetch();
        $this->nome = $lista['nome'];
        $this->descricao = $lista['descricao'];
    }

    public function criar()
    {
        $query = "INSERT INTO grupo (nome, descricao) VALUES (:nome, :descricao)";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':descricao', $this->descricao);
        $stmt->execute();
        $this->id_grupo = $conexao->lastInsertId();
        return $this->id_grupo;
    }

    public static function listar()
    {
        $query = "SELECT * FROM grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public function editar()
    {
        $query = "UPDATE grupo SET nome = :nome, descricao = :descricao WHERE id_grupo = :id_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":descricao", $this->descricao);
        $stmt->bindValue(":id_grupo", $this->id_grupo);
        $stmt->execute();
    }

    public function deletar()
    {
        $query = "DELETE FROM grupo WHERE id_grupo = :id_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo', $this->id_grupo);
        $stmt->execute();
    }
}
