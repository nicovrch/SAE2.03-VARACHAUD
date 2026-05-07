let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

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
    options = options + '<option value="' + profile.id + '"' + selected + '>' + profile.name + '</option>';
  }
  html = html.replace("{{profiles}}", options);
  let homeLink = "index.html";
  let statsLink = "stats.html";
  let favLink = "";
  if (profilActif !== null) {
    homeLink = "index.html?id_profile=" + profilActif;
    statsLink = "stats.html?id_profile=" + profilActif;
    favLink = '<li><a class="navbar__item" href="favorites.html?id_profile=' + profilActif + '">Mes favoris</a></li>';
  }
  html = html.replace("{{homeLink}}", homeLink);
  html = html.replace("{{statsLink}}", statsLink);
  html = html.replace("{{favoriteLink}}", favLink);
  return html;
};

export { NavBar };
