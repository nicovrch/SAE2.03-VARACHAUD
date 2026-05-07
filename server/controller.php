<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");


function readMoviesController(){
    $age = $_REQUEST['age'];
    $movies = getMoviesGroupedByCategory($age);
    return $movies;
}


function readMovieDetailController(){
    if (isset($_REQUEST['id']) == false || empty($_REQUEST['id']) == true){
        return false;
    }
    $id = $_REQUEST['id'];
    $movie = getMovieDetail($id);
    return $movie;
}


function addMovieController(){
    $name = $_REQUEST['name'];
    $year = $_REQUEST['year'];
    $length = $_REQUEST['length'];
    $description = $_REQUEST['description'];
    $director = $_REQUEST['director'];
    $id_category = $_REQUEST['id_category'];
    $image = $_REQUEST['image'];
    $trailer = $_REQUEST['trailer'];
    $min_age = $_REQUEST['min_age'];

    $ok = insertMovie($name, $year, $length, $description, $director, $id_category, $image, $trailer, $min_age);

    if ($ok != 0){
        return "Le film \"$name\" a été ajouté";
    }
    else{
        return false;
    }
}

function addProfileController(){
    $name = $_REQUEST['name'];
    $min_age = $_REQUEST['min_age'];

    $ok = insertProfile($name, $min_age);

    if ($ok != 0){
        return "Le profil \"$name\" a été ajouté";
    }
    else{
        return false;
    }
}

function readProfilesController(){
    $profiles = getAllProfiles();
    return $profiles;
}

function updateProfileController(){
    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $min_age = $_REQUEST['min_age'];

    $ok = updateProfile($id, $name, $min_age);

    if ($ok != 0){
        return "Le profil \"$name\" a été modifié";
    }
    else{
        return false;
    }
}

function addFavoriteController(){
    $id_profile = $_REQUEST['id_profile'];
    $id_movie = $_REQUEST['id_movie'];

    $ok = insertFavorite($id_profile, $id_movie);

    if ($ok != 0){
        return "Le film a été ajouté à vos favoris";
    }
    else{
        return "Ce film est déjà dans vos favoris";
    }
}

function readFavoritesController(){
    $id_profile = $_REQUEST['id_profile'];
    $favorites = getFavoritesByProfile($id_profile);
    return $favorites;
}

function removeFavoriteController(){
    $id_profile = $_REQUEST['id_profile'];
    $id_movie = $_REQUEST['id_movie'];

    $ok = removeFavorite($id_profile, $id_movie);

    if ($ok != 0){
        return "Le film a été retiré de vos favoris";
    }
    else{
        return false;
    }
}

function readFeaturedController(){
    $age = $_REQUEST['age'];
    $movies = getFeaturedMovies($age);
    return $movies;
}

function readStatsController(){
    $stats = getStats();
    return $stats;
}