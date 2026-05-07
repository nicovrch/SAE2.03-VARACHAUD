let templateFile = await fetch("./component/EditProfileForm/template.html");
let template = await templateFile.text();

let EditProfileForm = {};

EditProfileForm.format = function (profiles, handlerSelect, handler) {
  let html = template;
  html = html.replace("{{handlerSelect}}", handlerSelect);
  html = html.replace("{{handler}}", handler);
  let options = "";
  for (let profile of profiles) {
    options = options + '<option value="' + profile.id + '">' + profile.name + '</option>';
  }
  html = html.replace("{{profiles}}", options);
  return html;
};

export { EditProfileForm };
