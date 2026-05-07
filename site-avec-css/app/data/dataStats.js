let HOST_URL = "../..";

let DataStats = {};

DataStats.read = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readStats");
  let data = await answer.json();
  return data;
};

export { DataStats };
