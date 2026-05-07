let HOST_URL = "../..";

let DataProfile = {};

DataProfile.read = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readProfiles");
  let data = await answer.json();
  return data;
};

export { DataProfile };
