<?php


// Le try/catch permet de gérer l'erreur si la connexion avec PDO échoue
try {
    # Création d'une connexion à la BDD 'blog' avec PDO
    $pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '',  [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]
    );
} catch (PDOException $exception) {
    # Si une erreur est lancée (throw) par PDO, alors on l'attrape (catch) et on affiche le message d'erreur
    die("Erreur de connexion à la BDD (voir le fichier 'include/_init.php') : ". $exception->getMessage());
}


?>