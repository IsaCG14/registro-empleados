//Obtener contenedores
const contenedores = Array.from(document.querySelectorAll(".contenedor"));

//Funcion de avanzar
$(".next-button").on("click", function (event) {
    const boton = event.target; // El botón que fue clickeado

    // Evitar avanzar si hay campos vacios en el contenedor
    const contenedor = boton.closest(".contenedor"); // Encuentra el contenedor más cercano
    var campos = contenedor.querySelectorAll(
        "input:not([type='radio']):not([type='checkbox'])"
    );
    var container = contenedor.querySelector("div[class^='container_']");

    //Verificar si hay campos vacios
    const camposVacios = Array.from(campos)
        .filter((campo) => {
            if (container == null) {
                return true;
            } else {
                if (container.classList.contains("container_carnet_medico")) {
                    var container_carnet =
                        contenedor.querySelector(".container_carnet");
                    var container_patologia = contenedor.querySelector(
                        ".container_patologia"
                    );

                    return (
                        getComputedStyle(container_carnet).display != "none" ||
                        getComputedStyle(container_patologia).display != "none"
                    );
                } else {
                    //Si los campos no estan ocultos
                    return getComputedStyle(container).display != "none";
                }
            }
        })
        .some((campo) => campo.value.trim() === "");

    //Si no estan vacios se avanza
    if (!camposVacios) {
        //Avanzar

        // Obtener el índice del contenedor en el array
        const indice = contenedores.indexOf(contenedor);

        //Obtener siguiente contenedor
        const contenedorSiguiente = contenedores[indice + 1];

        //Ocultar contenedor
        contenedor.classList.add("contenedor-hide");

        //Aparecer siguiente contenedor
        contenedorSiguiente.classList.remove("contenedor-hide");

        //Colorear puntero
        $(".paso-" + (indice + 2) + " i").addClass("imhere");
    } else {
        //Colorear campos vacios
        campos.forEach((campo) => {
            if (campo.value.trim() === "") {
                campo.style.border = "1px solid red";
            }
        });
    }
});

//Funcion de retroceder
$(".back-button").on("click", function (event) {
    const boton = event.target; // El botón que fue clickeado
    const contenedor = boton.closest(".contenedor"); // Encuentra el contenedor más cercano

    // Obtener el índice del contenedor en el array
    const indice = contenedores.indexOf(contenedor);

    //Ocultar contenedor
    contenedor.classList.add("contenedor-hide");

    //Aparecer contenedor anterior
    const contenedorSiguiente = contenedores[indice - 1];
    contenedorSiguiente.classList.remove("contenedor-hide");

    //Colorear puntero
    $(".paso-" + (indice + 1) + " i").removeClass("imhere");
});

//Redirigir al slide con el primer campo erroneo
$(".needs-validation").on("submit", function () {
    // Detectar campos inválidos
    const camposInvalidos = Array.from(this.elements).filter(
        (element) => !element.validity.valid
    );
    if (camposInvalidos.length > 0) {
        camposInvalidos.forEach((campo, indice) => {
            //console.log("Campo inválido:" + campo + "-" + indice); // Mostrar en consola el ID del campo inválido
            if (indice == "0") {
                //Aparecer contenedor donde empiezan los errores
                const contenedor = campo.closest(".contenedor");
                contenedor.classList.remove("contenedor-hide");

                //Colorear puntero
                // Obtener el índice del contenedor donde empieza el error
                const posicion = contenedores.indexOf(contenedor);
                console.log(posicion);

                //Quitar color a todos los ultimos punteros
                $(".progreso div i").each(function () {
                    $(this).removeClass("imhere");
                });

                //Colorear en donde se está y antes
                var i = 0;
                while (i <= posicion) {
                    $(".paso-" + (i + 1) + " i").addClass("imhere");
                    i++;
                }

                //Ocultar ultimo contenedor excepto si los errores empiezan aqui
                if (posicion != 4) {
                    const lastContenedor = contenedores[4];
                    lastContenedor.classList.add("contenedor-hide");
                }
            }
        });
    } else {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll(".needs-validation");
        // Loop over them and prevent submission
        Array.from(forms).forEach((form) => {
            form.addEventListener(
                "submit",
                (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add("was-validated");
                },
                false
            );
        });
    }
});

$("input").on("blur", function () {
    $(this).css("border", "1px solid #ced4da");
});
