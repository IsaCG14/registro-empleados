const button_search = document.querySelector("#button-search");

function seleccionarRadioConsejo(valor) {
    const radios = document.querySelectorAll('input[name="consejo"]');
    radios.forEach(radio => {
        if (radio.value == valor) {
            radio.checked = true;
        }
        radio.disabled = true; // Deshabilita la opción para que no la cambien
    });
}

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

                console.log(data.comuna)
                console.log(data.consejo_comunal)

                // Elementos de la vista
                const divComuna = document.querySelector("#nombre_comuna");
                const inputComuna = document.querySelector("#nombre_comuna_input");

                const divConsejo = document.querySelector("#nombre_consejo");
                const inputConsejo = document.querySelector("#nombre_consejo_input");

                // Lógica condicional
                if (data.comuna) {
                    // 1. Marcar radio Comuna (value = 1)
                    seleccionarRadioConsejo(1);

                    // 2. Mostrar u ocultar contenedores
                    divComuna.classList.remove("hidden");
                    divConsejo.classList.add("hidden");

                    // 3. Asignar valor y deshabilitar el input interno
                    inputComuna.value = data.comuna;
                    inputComuna.disabled = true;

                } else if (data.consejo_comunal) {
                    // 1. Marcar radio Consejo/Circuito (value = 0)
                    seleccionarRadioConsejo(0);

                    // 2. Mostrar u ocultar contenedores
                    divConsejo.classList.remove("hidden");
                    divComuna.classList.add("hidden");

                    // 3. Asignar valor y deshabilitar el input interno
                    inputConsejo.value = data.consejo_comunal;
                    inputConsejo.disabled = true;

                } else {
                    // 1. Marcar radio "No sabe" (value = 3)
                    seleccionarRadioConsejo(3);

                    // 2. Ocultar ambos
                    divConsejo.classList.add("hidden");
                    divComuna.classList.add("hidden");
                }

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

//Añadir campo consejo comunal o comuna al seleccionar en el select
const radioButtonsConsejo = document.querySelectorAll('input[name="consejo"]');
const consejoCampo = document.querySelector("#nombre_consejo");
const comunaCampo = document.querySelector("#nombre_comuna");

radioButtonsConsejo.forEach((radio) => {
    radio.addEventListener("change", function () {
        if (this.value == 0) {
            // Mostrar consejo, ocultar comuna
            consejoCampo.classList.remove("hidden");
            comunaCampo.classList.add("hidden");
            comunaCampo.value = ""; // Limpiar valor al ocultar
        } else if (this.value == 1) {
            // Ocultar consejo, mostrar comuna
            consejoCampo.classList.add("hidden");
            comunaCampo.classList.remove("hidden");
            consejoCampo.value = ""; // Limpiar valor al ocultar
        } else {
            // Ocultar ambos
            consejoCampo.classList.add("hidden");
            comunaCampo.classList.add("hidden");
            consejoCampo.value = "";
            comunaCampo.value = "";
        }
    });
});