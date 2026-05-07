// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "../..";

let DataMovie = {};

DataMovie.add = async function (fdata) {
  let config = {
    method: "POST",
    body: fdata,
  };
  let answer = await fetch(HOST_URL + "/server/script.php?todo=addMovie", config);
  let data = await answer.json();
  return data;
};

export { DataMovie };
