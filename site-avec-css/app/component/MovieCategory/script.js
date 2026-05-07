import { Movie } from "../Movie/script.js";

let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (category, favoriteIds) {
  let html = template;
  html = html.replace("{{name}}", category.name);
  html = html.replace("{{name}}", category.name);
  html = html.replace("{{movies}}", Movie.formatMany(category.movies, favoriteIds));
  return html;
};

MovieCategory.formatMany = function (categories, favoriteIds) {
  let html = "";
  for (let category of categories) {
    html = html + MovieCategory.format(category, favoriteIds);
  }
  return html;
};

export { MovieCategory };
