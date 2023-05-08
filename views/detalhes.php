<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/cabecalho.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/nota.php";

$id_filme = $_GET['id_filme'];
$url = "https://api.themoviedb.org/3/movie/$id_filme?api_key=$api_key&language=$lang";
$data_nome = file_get_contents($url);
$result = json_decode($data_nome);

if (isset($_SESSION['usuario']['id_usuario'])) {
    try {
        $nota = Nota::pegarMinhaNota($_SESSION['usuario']['id_usuario'], $id_filme);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<section class="detalhes">
    <img src="https://image.tmdb.org/t/p/w500<?= $result->poster_path ?>">
    <div class="ratings">
        <div class="alinha">
            <span class="material-symbols-outlined preenchido">star</span><?= round($result->vote_average, 1) ?>
        </div>

    </div>
    <div class="conteiner-generos">
        <?php foreach ($result->genres as $genero) : ?>
            <div class="btn-genero">
                <?= $genero->name ?>
            </div>
        <?php endforeach; ?>
    </div>
    <h1><?= $result->title ?></h1>
    <p><?= $result->release_date ?></p>
    <p style="text-align: justify;"><?= $result->overview ?></p>
</section>

<?php if (isset($_SESSION['usuario']['id_usuario'])) : ?>
    <section class="avaliacao">
        <h2>Avalie este filme:</h2>
        <div class="rating-stars">
            <span class="star" data-rating="1"><span class="material-symbols-outlined voto">star</span></span>
            <span class="star" data-rating="2"><span class="material-symbols-outlined voto">star</span></span>
            <span class="star" data-rating="3"><span class="material-symbols-outlined voto">star</span></span>
            <span class="star" data-rating="4"><span class="material-symbols-outlined voto">star</span></span>
            <span class="star" data-rating="5"><span class="material-symbols-outlined voto">star</span></span>
        </div>
        <p id="rating-message"></p>
    </section>

    <script>
        window.onload = function() {
            var stars = document.querySelectorAll(".rating-stars .voto");
            var currentRating = 0;
            <?php if (isset($nota) && $nota != NULL) : ?>
                currentRating = <?= $nota[0]['nota']; ?>;
                // Definir a cor das estrelas com base na avaliação atual
                for (var i = 0; i < currentRating; i++) {
                    stars[i].style.fontVariationSettings = "'FILL' 1";
                }
            <?php endif; ?>

            stars.forEach(function(star, index) {
                star.addEventListener("mouseover", function() {
                    // Trocar a cor das estrelas anteriores e atuais
                    for (var i = 0; i <= index; i++) {
                        stars[i].style.fontVariationSettings = "'FILL' 1";
                    }
                    for (var i = index + 1; i < stars.length; i++) {
                        stars[i].style.fontVariationSettings = "'FILL' 0";
                    }
                });

                star.addEventListener("mouseout", function() {
                    // Restaurar a cor das estrelas quando o mouse sair
                    for (var i = 0; i < stars.length; i++) {
                        if (i < currentRating) {
                            stars[i].style.fontVariationSettings = "'FILL' 1";
                        } else {
                            stars[i].style.fontVariationSettings = "'FILL' 0";
                        }
                    }
                });

                star.addEventListener("click", function() {
                    // Atualizar a avaliação atual e exibir mensagem
                    currentRating = index + 1;
                    /* document.getElementById("rating-message").textContent = "Você selecionou " + currentRating + " estrela(s)."; */

                    // Enviar os dados para o servidor
                    var data = {
                        id_usuario: <?= $_SESSION['usuario']['id_usuario']; ?>, // Coloque o ID do usuário aqui
                        id_filme: <?= $id_filme; ?>, // Coloque o ID do filme aqui
                        nota: currentRating // Coloque a nota selecionada aqui
                    };

                    fetch('/filminhos/controllers/add_avaliacao_controller.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    }).then(function(response) {
                        
                    }).catch(function(error) {
                        console.error('Erro:', error);
                    });
                });

            });
        };
    </script>
<?php endif; ?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/templates/rodape.php";
?>