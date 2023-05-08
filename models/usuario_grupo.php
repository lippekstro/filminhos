<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/db/conexao.php";

class UsuarioGrupo
{
    public $id_usuario_grupo;
    public $id_usuario;
    public $id_grupo;

    public function __construct($id_usuario_grupo = false)
    {
        if ($id_usuario_grupo) {
            $this->id_usuario_grupo = $id_usuario_grupo;
            $this->carregar();
        }
    }

    public function carregar()
    {
        $query = "SELECT id_usuario, id_grupo FROM usuario_grupo WHERE id_usuario_grupo = :id_usuario_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_usuario_grupo', $this->id_usuario_grupo);
        $stmt->execute();

        $lista = $stmt->fetch();
        $this->id_usuario = $lista['id_usuario'];
        $this->id_grupo = $lista['id_grupo'];
    }

    public function criar()
    {
        $conexao = Conexao::conectar();
        $conexao->beginTransaction();

        try {
            $query = "INSERT INTO usuario_grupo (id_usuario, id_grupo) VALUES (:id_usuario, :id_grupo)";
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':id_usuario', $this->id_usuario);
            $stmt->bindValue(':id_grupo', $this->id_grupo);
            $stmt->execute();
            $this->id_usuario_grupo = $conexao->lastInsertId();
            $conexao->commit();
            return $this->id_usuario_grupo;
        } catch (\Exception $e) {
            $conexao->rollback();
            $query = "DELETE FROM grupo WHERE id_grupo = :id_grupo";
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':id_grupo', $this->id_grupo);
            $stmt->execute();
            throw $e;
        }
    }

    public static function listar()
    {
        $query = "SELECT * FROM usuario_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public function editar()
    {
        $query = "UPDATE usuario_grupo SET id_usuario = :id_usuario, id_grupo = :id_grupo WHERE id_usuario_grupo = :id_usuario_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":id_usuario", $this->id_usuario);
        $stmt->bindValue(":id_grupo", $this->id_grupo);
        $stmt->bindValue(":id_usuario_grupo", $this->id_usuario_grupo);
        $stmt->execute();
    }

    public function deletar()
    {
        $query = "DELETE FROM usuario_grupo WHERE id_usuario_grupo = :id_usuario_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_usuario_grupo', $this->id_usuario_grupo);
        $stmt->execute();
    }

    public static function listarMeusGrupos($id_usuario)
    {
        $query = "SELECT grupo.id_grupo, grupo.nome, grupo.descricao 
              FROM usuario_grupo 
              INNER JOIN grupo ON usuario_grupo.id_grupo = grupo.id_grupo 
              WHERE usuario_grupo.id_usuario = :id_usuario";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public static function listarUsuariosDoGrupo($id_grupo)
    {
        $query = "SELECT usuario.id_usuario, usuario.nome, usuario.email, usuario.foto FROM usuario_grupo INNER JOIN usuario ON usuario_grupo.id_usuario = usuario.id_usuario WHERE id_grupo = :id_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo', $id_grupo);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }
}
