<?php
require_once 'include/_init.php';


if(isset($_GET['create']) && $_GET['create'] === 'success') {
    $successMsg = '<div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Bravo ! </strong>Votre article est bien en ligne, vous pouvez le visualisé ci-dessous.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
}

# Utilisation du sélecteur ALL (*) pour sélectionner toutes les colonnes
$query = $pdo->query("SELECT * FROM article ORDER BY date_creation DESC");

# Variabilisation des résultats de la requête $query
$articles = $query->fetchAll(PDO::FETCH_ASSOC);

require_once 'include/_header.php';
?>

    <!-- Affiche le message si la variable est set -->
    <?= $successMsg ?? '' ?>

    <h1 class="mx-auto text-center mt-5 col-10 bg-light p-5 rounded shadow">Tous les articles du blog</h1>

    <div class="row mt-5 mx-auto">

    <!-- Cette condition permet de ne pas avoir d'erreur si la BDD est vide -->
        <?php if (isset($articles) && ! empty($articles)) : ?>

        <!-- Pour chaque index dans $articles -->
            <?php foreach($articles as $article) : ?>

            <div class="col-3 mb-3">
                <!-- On affiche l'article sous forme de carte -->
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?= strlen($article['titre']) > 20 ? substr($article['titre'], 0, 20) . '...' : $article['titre'] ?></h5>
                        <p class="card-text"><?= strlen($article['contenu']) > 20 ? substr($article['contenu'], 0, 20) . '...' : $article['contenu'] ?></p>
                        <!-- Si le fichier 'show_article.php' est créé, vous pourrez afficher l'article en question de cette manière -->
                        <a href="show_article.php?id=<?= $article['id_article'] ?>" class="btn btn-primary">Voir l'article</a>
                    </div>
                    <div class="card-footer text-muted">
                        <span>Auteur : <?= $article['auteur'] ?></span>
                        <span>Ajouté le : <?= $article['date_creation'] ?></span>
                    </div>
                </div>

            </div>

            <?php endforeach; ?>
        <?php else : ?>
            <!-- Si aucun article n'est récupéré par la requête SELECT, on affiche ce message -->
            <div class="col-12 mx-auto text-center text-warning h3">Aucun article encore publié.</div>
        <?php endif; ?>
    </div>


    <?php require_once 'include/_footer.php'?>