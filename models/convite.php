<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/db/conexao.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario_grupo.php";

class Convite
{
    public $id_convite;
    public $id_grupo;
    public $id_usuario;

    public function __construct($id_convite = false)
    {
        if ($id_convite) {
            $this->id_convite = $id_convite;
            $this->carregar();
        }
    }

    public function carregar()
    {
        $query = "SELECT id_grupo, id_usuario FROM convite WHERE id_convite = :id_convite";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_convite', $this->id_convite);
        $stmt->execute();

        $lista = $stmt->fetch();
        $this->id_grupo = $lista['id_grupo'];
        $this->id_usuario = $lista['id_usuario'];
    }

    public function criar()
    {
        $query = "INSERT INTO convite (id_grupo, id_usuario) VALUES (:id_grupo, :id_usuario)";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_grupo', $this->id_grupo);
        $stmt->bindValue(':id_usuario', $this->id_usuario);
        $stmt->execute();
        $this->id_convite = $conexao->lastInsertId();
        return $this->id_convite;
    }

    public static function listar()
    {
        $query = "SELECT * FROM convite";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public function editar()
    {
        $query = "UPDATE convite SET id_grupo = :id_grupo, id_usuario = :id_usuario WHERE id_convite = :id_convite";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":id_grupo", $this->id_grupo);
        $stmt->bindValue(":id_usuario", $this->id_usuario);
        $stmt->bindValue(":id_convite", $this->id_convite);
        $stmt->execute();
    }

    public function deletar()
    {
        $query = "DELETE FROM convite WHERE id_convite = :id_convite";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_convite', $this->id_convite);
        $stmt->execute();
    }

    public static function listarMeusConvites($id_usuario){
        $query = "SELECT * FROM convite WHERE id_usuario = :id_usuario";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public static function obterNomeGrupo($id_grupo){
        $query = "SELECT nome FROM grupo WHERE id_grupo = :id_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":id_grupo", $id_grupo);
        $stmt->execute();
        $nome = $stmt->fetchColumn();
        return $nome;
    }

    public function confirmaConvite($id_grupo, $id_usuario){
        $usuario_grupo = new UsuarioGrupo();
        $usuario_grupo->id_usuario = $id_usuario;
        $usuario_grupo->id_grupo = $id_grupo;
        $usuario_grupo->criar();
    }
    
    
}
