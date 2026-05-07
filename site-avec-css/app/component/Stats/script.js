let templateFile = await fetch("./component/Stats/template.html");
let template = await templateFile.text();

let Stats = {};

Stats.format = function (stats) {
  let html = template;
  html = html.replace("{{totalProfiles}}", stats.totalProfiles);
  html = html.replace("{{totalMovies}}", stats.totalMovies);
  html = html.replace("{{avgMoviesPerProfile}}", stats.avgMoviesPerProfile);
  html = html.replace("{{mostFavoriteMovie}}", stats.mostFavoriteMovie);
  html = html.replace("{{mostPopularCategory}}", stats.mostPopularCategory);
  return html;
};

export { Stats };
