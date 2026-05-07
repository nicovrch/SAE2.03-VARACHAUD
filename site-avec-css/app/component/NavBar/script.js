let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let templateOption = '<option value="{{id}}"{{selected}}>{{name}}</option>';
let templateFavLink = '<li><a class="navbar__item" href="favorites.html?id_profile={{id}}">Mes favoris</a></li>';

let NavBar = {};

NavBar.format = function (hAbout, hSelectProfile, profiles, profilActif) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hSelectProfile}}", hSelectProfile);
  let options = "";
  for (let profile of profiles) {
    let selected = "";
    if (profile.id == profilActif) {
      selected = " selected";
    }
    let opt = templateOption;
    opt = opt.replace("{{id}}", profile.id);
    opt = opt.replace("{{selected}}", selected);
    opt = opt.replace("{{name}}", profile.name);
    options = options + opt;
  }
  html = html.replace("{{profiles}}", options);
  let homeLink = "index.html";
  let statsLink = "stats.html";
  let favLink = "";
  if (profilActif != null) {
    homeLink = "index.html?id_profile=" + profilActif;
    statsLink = "stats.html?id_profile=" + profilActif;
    favLink = templateFavLink.replace("{{id}}", profilActif);
  }
  html = html.replace("{{homeLink}}", homeLink);
  html = html.replace("{{statsLink}}", statsLink);
  html = html.replace("{{favoriteLink}}", favLink);
  return html;
};

export { NavBar };
