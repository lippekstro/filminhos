<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/db/conexao.php";

class GrupoFilme
{
    public $id_grupo_filme;
    public $id_grupo;
    public $id_filme_api;

    public function __construct($id_grupo_filme = false)
    {
        if ($id_grupo_filme) {
            $this->id_grupo_filme = $id_grupo_filme;
            $this->carregar();
        }
    }

    public function carregar()
    {
        $query = "SELECT id_grupo, id_filme_api FROM grupo_filme WHERE id_grupo_filme = :id_grupo_filme";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo_filme', $this->id_grupo_filme);
        $stmt->execute();

        $lista = $stmt->fetch();
        $this->id_grupo = $lista['id_grupo'];
        $this->id_grupo = $lista['id_filme_api'];
    }

    public function criar()
    {
        $query = "INSERT INTO grupo_filme (id_grupo, id_filme_api) VALUES (:id_grupo, :id_filme_api)";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo', $this->id_grupo);
        $stmt->bindValue(':id_filme_api', $this->id_filme_api);
        $stmt->execute();
        $this->id_grupo_filme = $conexao->lastInsertId();
        return $this->id_grupo_filme;
    }

    public static function listar()
    {
        $query = "SELECT * FROM grupo_filme";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public function editar()
    {
        $query = "UPDATE grupo_filme SET id_grupo = :id_grupo, id_filme_api = :id_filme_api WHERE id_grupo_filme = :id_grupo_filme";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":id_grupo", $this->id_grupo);
        $stmt->bindValue(":id_filme_api", $this->id_filme_api);
        $stmt->bindValue(":id_grupo_filme", $this->id_grupo_filme);
        $stmt->execute();
    }

    public function deletar()
    {
        $query = "DELETE FROM grupo_filme WHERE id_grupo_filme = :id_grupo_filme";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo_filme', $this->id_grupo_filme);
        $stmt->execute();
    }

    public static function listaFilmesDoGrupo($id_grupo)
    {
        $query = "SELECT * FROM grupo_filme WHERE id_grupo = :id_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo', $id_grupo);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

}
