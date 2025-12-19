const button_search = document.querySelector("#button-search");

button_search.addEventListener("click", function () {
    const cedulaInput = document.querySelector("#cedula");
    const cedula = cedulaInput.value;

    fetch(`/api/persona/${cedula}`)
        .then((response) => response.json())
        .then((data) => {
            //Si hay datos llenar el formulario con los datos traidos y sino poner mensaje de persona aun no registrada
            if (data.nombre !== undefined) {
                //Llenar el formulario
                document.querySelector("#nombre").value = data.nombre;
                document.querySelector("#nombre").disabled = true;
                document.querySelector("#fecha_nacimiento").value =
                    data.fecha_nacimiento;
                document.querySelector("#fecha_nacimiento").disabled = true;
                document.querySelector("#telefono").value = data.telefono;
                document.querySelector("#telefono").disabled = true;
                document.querySelector("#correo").value = data.correo;
                document.querySelector("#correo").disabled = true;
                //Poner valor radio sexo
                if (data.sexo === 1) {
                    document.querySelector("#sexo-m").checked = true;
                } else {
                    document.querySelector("#sexo-f").checked = true;
                }
                document.querySelector("input[name='sexo']").disabled = true;
                
                //Poner datos de donde vive
                var parroquia = data.id_parroquia;
                fetch(`/api/parroquia/${parroquia}`)
                    .then((response) => response.json())
                    .then((data_parroquia) => {
                        //Seleccionar estado, municipio y parroquia
                        document.querySelector("#estado").value = data_parroquia.municipio.estado.id_estado;
                        document.querySelector("#estado").disabled = true;
                        const nuevoMunicipio = new Option(data_parroquia.municipio.municipio, data_parroquia.municipio.id_municipio);
                        document.querySelector("#municipio").add(nuevoMunicipio);
                        document.querySelector("#municipio").value = data_parroquia.municipio.id_municipio;
                        document.querySelector("#municipio").disabled = true;
                        const nuevaParroquia = new Option(data_parroquia.parroquia, data_parroquia.id_parroquia);
                        document.querySelector("#parroquia").add(nuevaParroquia);
                        document.querySelector("#parroquia").value = data_parroquia.id_parroquia;
                        document.querySelector("#parroquia").disabled = true;
                    })
                    .catch((error) =>
                        console.error("Error parroquia:", error)
                    );

                //Mostrar alerta de que la persona ya existe
                Swal.fire({
                    icon: "info",
                    title: "Persona encontrada",
                    text: "Los datos han sido cargados en el formulario.",
                });
                document.querySelector("#messaje-cedula").innerHTML = "";
                
            } else {
                //Mostrar mensaje de que la persona no existe
                document.querySelector("#messaje-cedula").innerHTML =
                    '<div class="alert alert-warning mt-2" role="alert">Persona no registrada. Por favor, complete el formulario.</div>';
                //Limpiar el formulario
                document.querySelector("#nombre").value = "";
                document.querySelector("#fecha_nacimiento").value = "";
                document.querySelector("#telefono").value = "";
                document.querySelector("#correo").value = "";
                document.querySelector("#sexo-m").checked = true;
                //Habilitar campos de nuevo
                document.querySelector("#nombre").disabled = false;
                document.querySelector("#fecha_nacimiento").disabled = false;
                document.querySelector("#telefono").disabled = false;
                document.querySelector("#correo").disabled = false;
                document.querySelector("input[name='sexo']").disabled = false;
                document.querySelector("#estado").disabled = false;
                document.querySelector("#municipio").disabled = false;
                document.querySelector("#municipio").innerHTML = "<option value=''>Municipio</option>";
                document.querySelector("#parroquia").disabled = false;
                document.querySelector("#parroquia").innerHTML = "<option value=''>Parroquia</option>";
            }
        })
        .catch((error) => console.error("Error:", error));
});

//Añadir campo consejo comunal al seleccionar si en el select
const radioButtonsConsejo = document.querySelectorAll('input[name="consejo"]');
const consejoCampo = document.querySelector("#nombre_consejo");

radioButtonsConsejo.forEach((radio) => {
    radio.addEventListener("change", function () {
        if (this.value == 1) {
            consejoCampo.disabled = false;
        } else if (this.value == 0) {
            consejoCampo.disabled = true;
            consejoCampo.value = "";
        }
    });
});

//Añadir campo consejo comunal al seleccionar si en el select
const radioButtonsComuna = document.querySelectorAll('input[name="comuna"]');
const comunaCampo = document.querySelector("#nombre_comuna");

radioButtonsComuna.forEach((radio) => {
    radio.addEventListener("change", function () {
        if (this.value == 1) {
            comunaCampo.disabled = false;
        } else if (this.value == 0) {
            comunaCampo.disabled = true;
            comunaCampo.value = "";
        }
    });
});