<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "SAE203");
define("DBLOGIN", "usersae203");
define("DBPWD", "azerty");


function getAllMovies(){
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer le menu avec des paramètres
    $sql = "select id, name, image from Movie";
    // Prépare la requête SQL
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

function insertMovie($name, $year, $length, $description, $director, $id_category, $image, $trailer, $min_age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Movie (name, year, length, description, director, id_category, image, trailer, min_age)
            VALUES (:name, :year, :length, :description, :director, :id_category, :image, :trailer, :min_age)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':length', $length);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':director', $director);
    $stmt->bindParam(':id_category', $id_category);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':trailer', $trailer);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function getMovieDetail($id){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, year, length, description, director, image, trailer, min_age, Category.name AS category
            FROM Movie JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function insertProfile($name, $min_age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Profile (name, min_age) VALUES (:name, :min_age)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function getAllProfiles(){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, avatar, min_age FROM Profile ORDER BY name";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function updateProfile($id, $name, $min_age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Profile SET name = :name, min_age = :min_age WHERE id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function insertFavorite($id_profile, $id_movie){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);

    $sql = "SELECT id_profile FROM Favorite WHERE id_profile = :id_profile AND id_movie = :id_movie";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profile', $id_profile);
    $stmt->bindParam(':id_movie', $id_movie);
    $stmt->execute();
    $existing = $stmt->fetch(PDO::FETCH_OBJ);

    if ($existing != false) {
        return 0;
    }

    $sql = "INSERT INTO Favorite (id_profile, id_movie) VALUES (:id_profile, :id_movie)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profile', $id_profile);
    $stmt->bindParam(':id_movie', $id_movie);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function getFavoritesByProfile($id_profile){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, Movie.image
            FROM Favorite
            JOIN Movie ON Favorite.id_movie = Movie.id
            WHERE Favorite.id_profile = :id_profile
            ORDER BY Movie.name";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profile', $id_profile);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function removeFavorite($id_profile, $id_movie){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "DELETE FROM Favorite WHERE id_profile = :id_profile AND id_movie = :id_movie";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_profile', $id_profile);
    $stmt->bindParam(':id_movie', $id_movie);
    $stmt->execute();
    $res = $stmt->rowCount();
    return $res;
}

function getFeaturedMovies($age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, image, description
            FROM Movie
            WHERE is_featured = 1 AND min_age <= :age
            ORDER BY name";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':age', $age);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function getStats(){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);

    $stmt = $cnx->prepare("SELECT COUNT(*) AS cnt FROM Profile");
    $stmt->execute();
    $totalProfiles = $stmt->fetch(PDO::FETCH_OBJ)->cnt;

    $stmt = $cnx->prepare("SELECT COUNT(*) AS cnt FROM Movie");
    $stmt->execute();
    $totalMovies = $stmt->fetch(PDO::FETCH_OBJ)->cnt;

    $stmt = $cnx->prepare("SELECT id_profile, COUNT(*) AS cnt FROM Favorite GROUP BY id_profile");
    $stmt->execute();
    $counts = $stmt->fetchAll(PDO::FETCH_OBJ);
    $avgMoviesPerProfile = 0;
    if (count($counts) > 0) {
        $total = 0;
        foreach ($counts as $c) {
            $total = $total + $c->cnt;
        }
        $avgMoviesPerProfile = round($total / count($counts), 2);
    }

    $stmt = $cnx->prepare("SELECT Movie.name AS name, COUNT(*) AS cnt FROM Favorite JOIN Movie ON Favorite.id_movie = Movie.id GROUP BY Movie.id, Movie.name");
    $stmt->execute();
    $movieCounts = $stmt->fetchAll(PDO::FETCH_OBJ);
    $mostFavoriteMovie = "Aucun";
    $maxMovieCnt = 0;
    foreach ($movieCounts as $row) {
        if ($row->cnt > $maxMovieCnt) {
            $maxMovieCnt = $row->cnt;
            $mostFavoriteMovie = $row->name;
        }
    }

    $stmt = $cnx->prepare("SELECT Category.name AS name, COUNT(*) AS cnt FROM Favorite JOIN Movie ON Favorite.id_movie = Movie.id JOIN Category ON Movie.id_category = Category.id GROUP BY Category.id, Category.name");
    $stmt->execute();
    $catCounts = $stmt->fetchAll(PDO::FETCH_OBJ);
    $mostPopularCategory = "Aucune";
    $maxCatCnt = 0;
    foreach ($catCounts as $row) {
        if ($row->cnt > $maxCatCnt) {
            $maxCatCnt = $row->cnt;
            $mostPopularCategory = $row->name;
        }
    }

    $res = [
        "totalProfiles" => $totalProfiles,
        "totalMovies" => $totalMovies,
        "avgMoviesPerProfile" => $avgMoviesPerProfile,
        "mostFavoriteMovie" => $mostFavoriteMovie,
        "mostPopularCategory" => $mostPopularCategory
    ];
    return $res;
}

function getMoviesGroupedByCategory($age){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, Movie.image, Category.name AS category
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.min_age <= :age
            ORDER BY Category.name";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':age', $age);
    $stmt->execute();
    $movies = $stmt->fetchAll(PDO::FETCH_OBJ);

    $res = [];
    foreach ($movies as $movie) {
        $res[$movie->category][] = $movie;
    }
    return $res;
}