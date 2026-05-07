let templateFile = await fetch("./component/MovieFeatured/template.html");
let template = await templateFile.text();

let MovieFeatured = {};

MovieFeatured.format = function (movie) {
  let html = template;
  html = html.replace("{{id}}", movie.id);
  html = html.replace("{{image}}", movie.image);
  html = html.replace("{{name}}", movie.name);
  html = html.replace("{{name}}", movie.name);
  html = html.replace("{{description}}", movie.description);
  return html;
};

MovieFeatured.formatMany = function (movies) {
  let html = "";
  for (let movie of movies) {
    html = html + MovieFeatured.format(movie);
  }
  return html;
};

export { MovieFeatured };
