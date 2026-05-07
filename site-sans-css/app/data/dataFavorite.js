let HOST_URL = "../..";

let DataFavorite = {};

DataFavorite.add = async function (id_profile, id_movie) {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=addFavorite&id_profile=" + id_profile + "&id_movie=" + id_movie);
  let data = await answer.json();
  return data;
};

DataFavorite.read = async function (id_profile) {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readFavorites&id_profile=" + id_profile);
  let data = await answer.json();
  return data;
};

DataFavorite.remove = async function (id_profile, id_movie) {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=removeFavorite&id_profile=" + id_profile + "&id_movie=" + id_movie);
  let data = await answer.json();
  return data;
};

export { DataFavorite };
