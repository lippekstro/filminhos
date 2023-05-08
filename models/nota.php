<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/db/conexao.php";

class Nota
{
    public $id_nota;
    public $nota;
    public $id_usuario;
    public $id_filme_api;
    public $data_avaliacao;

    public function __construct($id_nota = false)
    {
        if ($id_nota) {
            $this->id_nota = $id_nota;
            $this->carregar();
        }
    }

    public function carregar()
    {
        $query = "SELECT nota, id_usuario, id_filme_api, data_avaliacao FROM nota WHERE id_nota = :id_nota";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_nota', $this->id_nota);
        $stmt->execute();

        $lista = $stmt->fetch();
        $this->nota = $lista['nota'];
        $this->id_usuario = $lista['id_usuario'];
        $this->id_filme_api = $lista['id_filme_api'];
        $this->data_avaliacao = $lista['data_avaliacao'];
    }

    public function criar()
    {
        $query = "INSERT INTO nota (nota, id_usuario, id_filme_api) VALUES (:nota, :id_usuario, :id_filme_api)";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':nota', $this->nota);
        $stmt->bindValue(':id_usuario', $this->id_usuario);
        $stmt->bindValue(':id_filme_api', $this->id_filme_api);
        $stmt->execute();
        $this->id_nota = $conexao->lastInsertId();
        return $this->id_nota;
    }

    public static function listar()
    {
        $query = "SELECT * FROM nota";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public function editar()
    {
        $query = "UPDATE nota SET nota = :nota, id_usuario = :id_usuario, id_filme_api = :id_filme_api WHERE id_nota = :id_nota";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":nota", $this->nota);
        $stmt->bindValue(":id_usuario", $this->id_usuario);
        $stmt->bindValue(":id_filme_api", $this->id_filme_api);
        $stmt->bindValue(":id_nota", $this->id_nota);
        $stmt->execute();
    }

    public function deletar()
    {
        $query = "DELETE FROM nota WHERE id_nota = :id_nota";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_nota', $this->id_nota);
        $stmt->execute();
    }

    public static function pegarMinhaNota($id_usuario, $id_filme_api)
    {
        $query = "SELECT * FROM nota WHERE id_usuario = :id_usuario AND id_filme_api = :id_filme_api LIMIT 1";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_filme_api', $id_filme_api);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    public static function calcularMediaPorGrupo($id_filme_api, $id_grupo)
    {
        $query = "SELECT AVG(nota) AS media FROM nota JOIN usuario_grupo ON nota.id_usuario = usuario_grupo.id_usuario WHERE nota.id_filme_api = :id_filme_api AND usuario_grupo.id_grupo = :id_grupo";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_filme_api', $id_filme_api);
        $stmt->bindValue(':id_grupo', $id_grupo);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['media'];
    }

    public static function jaVotou($id_usuario, $id_filme_api){
        $query = "SELECT * FROM nota WHERE id_usuario = :id_usuario AND id_filme_api = :id_filme_api LIMIT 1";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_filme_api', $id_filme_api);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        $resultado = $stmt->fetch();
        if($stmt->rowCount() > 0){
            return $resultado['id_nota'];
        } else {
            return False;
        }
    }

    public static function listarUltimasNotas($id_usuario)
    {
        $query = "SELECT * FROM nota WHERE id_usuario = :id_usuario ORDER BY data_avaliacao DESC";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        $lista = $stmt->fetchAll();
        return $lista;
    }

    
}
