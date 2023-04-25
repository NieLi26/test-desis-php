/* VALIDACION DE DATOS */
let form = document.querySelector("form");
let nombre = form.elements.nombre;
let alias = form.elements.alias;
let region = form.elements.region;
let comuna = form.elements.comuna;
let candidato = form.elements.candidato;
let email = form.elements.email;
let rut = form.elements.rut;
let web = form.elements.web;
let tv = form.elements.tv;
let social = form.elements.social;
let amigo = form.elements.amigo;

const alphanumericRegex = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]{5,}$/;
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
form.addEventListener("submit", async function (event) {
  event.preventDefault();

  let errors = [];

  let checkboxes = document.querySelectorAll("input[type='checkbox']:checked");
  checkboxes.length < 2 && errors.push("Como se entero de nosotros: Debe seleccionar al menos 2 formas");
  !region.value && errors.push("Region: Debe seleccioanar una opcion");
  !comuna.value && errors.push("Comuna: Debe seleccioanar una opcion");
  !form.elements.candidato.value && errors.push("Candidato: Debe seleccionar una opcion");
  !nombre.value && errors.push("Nombre: no puede estar vacio");
  !alias.value && errors.push("Alias: no puede estar vacio");
  !email.value && errors.push("Email: no puede estar vacio");
  !rut.value && errors.push("Rut: no puede estar vacio");
  !alphanumericRegex.test(alias.value) && alias.value && errors.push( "Alias: debe contener solo letras y numeros, y debe ser minimo 5 caracteres");
  !emailRegex.test(email.value) && email.value && errors.push("Email: Ingrese formato correcto");
  validate(rut.value) === false && rut.value && errors.push("Rut: Ingrese formato correcto sin puntos y con guion ");
  
  if (validate(rut.value) && rut.value) {
    let message = await validateRutExists(rut.value)
    message && errors.push(message)
  }

  let showErrors = document.getElementById("show-errors");
  showErrors.style.display = "none"
  showErrors.textContent = "";
  let showSuccess = document.getElementById("show-success");
  showSuccess.style.display = "none"
  showSuccess.textContent = "";

  // Verificar si existen errores sino proceder a guardar registro
  if (!errors.length) {
    const url = "registrar.php";
    const options = {
      method: "POST",
      mode: "same-origin",
    };
    const formData = new FormData();
    formData.append("nombre", nombre.value);
    formData.append("alias", alias.value);
    formData.append("region", region.value);
    formData.append("comuna", comuna.value);
    formData.append("candidato", candidato.value);
    formData.append("email", email.value);
    formData.append("rut", rut.value);
    formData.append("web", web.checked);
    formData.append("tv", tv.checked);
    formData.append("social", social.checked);
    formData.append("amigo", amigo.checked);

    options["body"] = formData;

    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            let ul = document.createElement("ul");
            let li = document.createElement("li");
            if(data.hasOwnProperty('success')){
                li.textContent = data.success;
                ul.appendChild(li);
                showSuccess.style.display = 'block'
                showSuccess.appendChild(ul);
            }else {
                li.textContent = data.error;
                ul.appendChild(li);
                showErrors.style.display = 'block'
                showErrors.appendChild(ul);
            }

        })
        .catch(error => console.log(error.message));

  } else {
    let ul = document.createElement("ul");

    for (let err of errors) {
        let li = document.createElement("li");
        li.textContent = err;
        ul.appendChild(li);
    }
    showErrors.style.display = 'block'
    showErrors.appendChild(ul);
  }
});

/* CARGAR COMUNA */
region.addEventListener("change", (event) => {
  const url = "get_commune.php";
  const options = {
    method: "POST",
    mode: "same-origin",
  };
  const formData = new FormData();
  formData.append("id_region", event.target.value);
  options["body"] = formData;
  fetch(url, options)
    .then((response) => response.text())
    .then((data) => {
      comuna.innerHTML = data;
    })
    .catch((error) => console.log(error.message));
});

/* VALIDAR DUPLICIDAD DE RUT */
async function validateRutExists(rut) {
  const url = "validate_rut.php";
  const options = {
    method: "POST",
    mode: "same-origin",
  };
  const formData = new FormData();
  formData.append("rut", rut);
  options["body"] = formData;

  return fetch(url, options)
    .then((response) => response.text())
    .catch(error => console.log(error.message));
}

/* VALIDAR FORMATO DE RUT */
function clean(rut) {
  return typeof rut === "string"
    ? rut.replace(/^0+|[^0-9kK]+/g, "").toUpperCase()
    : "";
}

function validate(rut) {
  if (typeof rut !== "string") {
    return false;
  }

  // if it starts with 0 we return false
  // so a rut like 00000000-0 will not pass
  if (/^0+/.test(rut)) {
    return false;
  }

  if (!/^\d{7,8}-[\dkK]$/.test(rut)) {
    return false;
  }

  rut = clean(rut);

  let t = parseInt(rut.slice(0, -1), 10);
  let m = 0;
  let s = 1;

  while (t > 0) {
    s = (s + (t % 10) * (9 - (m++ % 6))) % 11;
    t = Math.floor(t / 10);
  }

  const v = s > 0 ? "" + (s - 1) : "K";
  return v === rut.slice(-1);
}

