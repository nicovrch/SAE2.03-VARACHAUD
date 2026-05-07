let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let templateBtnAdd = '<button class="movie__fav" onclick="C.handlerAddFavorite({{id}})">Ajouter aux favoris</button>';
let templateBtnDone = '<button class="movie__fav" disabled>Déjà en favoris</button>';
let templateBtnRemove = '<button class="movie__fav" onclick="C.handlerRemoveFavorite({{id}})">Retirer des favoris</button>';

let Movie = {};

Movie.format = function (movie, isFavorite, isFavoritePage) {
  let html = template;
  html = html.replace("{{id}}", movie.id);
  html = html.replace("{{image}}", movie.image);
  html = html.replace("{{name}}", movie.name);
  html = html.replace("{{name}}", movie.name);
  let button = "";
  if (isFavoritePage) {
    button = templateBtnRemove.replace("{{id}}", movie.id);
  } else if (isFavorite) {
    button = templateBtnDone;
  } else {
    button = templateBtnAdd.replace("{{id}}", movie.id);
  }
  html = html.replace("{{favoriteButton}}", button);
  return html;
};

Movie.formatMany = function (movies, favoriteIds, isFavoritePage) {
  let html = "";
  for (let movie of movies) {
    let isFav = false;
    for (let favId of favoriteIds) {
      if (movie.id == favId) {
        isFav = true;
      }
    }
    html = html + Movie.format(movie, isFav, isFavoritePage);
  }
  return html;
};

export { Movie };
