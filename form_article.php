<?php
require_once 'include/_init.php';


# Si le formulaire a été soumis
if($_POST) {

    # On extrait le nom des clés sous forme de variable : $_POST['titre'] => devient $titre
    extract($_POST);

    // classe bootstrap : bordure rouge
    $border="border border-rounded border-danger";

    # Si l'action est bien la soumission du formulaire de création d'article
    if (isset($_GET['action']) && $_GET['action'] === 'submit_create') {

        # Gestion des erreurs
        if (empty($titre)) {
            $errorTitre = "<p class='text-danger font-italic mt-2'>Il faut un titre d'article</p>";
            $error = true;
        }
        if (strlen($titre) > 255) {
            $errorTitre = "<p class='text-danger font-italic mt-2'>Le titre ne peut dépasser 255 caractères.</p>";
            $error = true;
        }
        if (empty($auteur)) {
            $errorAuteur = "<p class='text-danger font-italic mt-2'>Il faut renseigner l'auteur de l'article</p>";
            $error = true;
        }
        if (strlen($auteur) > 30) {
            $errorAuteur = "<p class='text-danger font-italic mt-2'>Le nom de l'auteur ne peut dépasser 30 caractères.</p>";
            $error = true;
        }
        if (empty($contenu)) {
            $errorContenu = "<p class='text-danger font-italic mt-2'>Un contenu doit être ajouté à l'article</p>";
            $error = true;
        }

        # Si la variable $error n'est pas set
        if(!isset($error)) {

            # Requête préparée, cela permet de prévenir les failles d'injection SQL
            $query = $pdo->prepare("INSERT INTO article VALUES (NULL, :titre, :contenu, :auteur, NOW())");

            # Liaison des paramètres (:param) avec les valeurs.
            # Ces valeurs sont sécurisées grâce à htmlspecialchars(), cela permet de prévenir les failles XSS.
            $query->bindValue(':titre', htmlspecialchars(trim($titre), ENT_QUOTES));
            $query->bindValue(':contenu', htmlspecialchars(trim($contenu), ENT_QUOTES));
            $query->bindValue(':auteur', htmlspecialchars(trim($auteur), ENT_QUOTES));

            # Si l'exécution se passe correctement on redirige vers la page d'accueil avec un paramètre dans $_GET
           if($query->execute()) {
               header('location: index.php?create=success');
           }
           else {
               $executeError = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Oups ! </strong> Une erreur est survenue lors de l\'insertion en BDD. Veuillez réessayer !
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
           }

        }
    } // end if(isset($_GET['action']))

} // end if($_POST)

require_once 'include/_header.php';
?>


    <h1 class="mx-auto text-center mt-3 col-10 bg-light p-5 rounded shadow">Créer un article pour le blog</h1>

    <div class="row mt-5">

        <div class="col-8 mx-auto">

            <!-- Affiche le message d'erreur si la variable est set -->
            <?= $executeError ?? '' ?>

            <form action="?action=submit_create" method="post" class="mt-4">

                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="titre">Titre</span>
                            <input type="text"
                                   class="form-control <?php if(isset($errorTitre)) echo $border; ?>"
                                   name="titre" aria-label="titre" aria-describedby="titre">
                        </div>
                        <!-- Condition ternaire (raccourcie) pour if (isset($errorTitre) echo $errorTitre else echo '' -->
                        <!-- Affiche le message d'erreur si la variable est set -->
                        <?= $errorTitre ?? '' ?>
                    </div>

                    <div class="col-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="auteur">Auteur</span>
                            <input type="text"
                                   class="form-control <?php if(isset($errorAuteur)) echo $border; ?>"
                                   name="auteur" aria-label="auteur" aria-describedby="auteur">
                        </div>
                        <!-- Affiche le message d'erreur si la variable est set -->
                        <?= $errorAuteur ?? '' ?>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-text">Contenu</span>
                    <textarea class="form-control <?php if(isset($errorContenu)) echo $border; ?>"
                              aria-label="With textarea"
                              name="contenu"></textarea>
                </div>
                <!-- Affiche le message d'erreur si la variable est set -->
                <?= $errorContenu ?? '' ?>

                <button type="submit" class="d-block mx-auto btn btn-success col-4 mt-4">Créer article</button>
            </form>
        </div>

    </div>


    <?php require_once 'include/_footer.php'?>