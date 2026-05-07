// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "../..";//"http://mmi.unilim.fr/~????"; // CHANGE THIS TO MATCH YOUR CONFIG

let DataMovie = {};

DataMovie.requestMovies = async function(age){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies&age=" + age);
    let data = await answer.json();
    return data;
}

DataMovie.requestMovieDetails = async function(id){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readMovieDetail&id=" + id);
    let data = await answer.json();
    return data;
}

DataMovie.requestFeatured = async function(age){
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readFeatured&age=" + age);
    let data = await answer.json();
    return data;
}

export {DataMovie};
