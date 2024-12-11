//Obtener contenedores
const contenedores = Array.from(document.querySelectorAll(".contenedor"));

//Funcion de avanzar
$(".next-button").on("click", function (event) {
    const boton = event.target; // El botón que fue clickeado
    const contenedor = boton.closest(".contenedor"); // Encuentra el contenedor más cercano

    // Obtener el índice del contenedor en el array
    const indice = contenedores.indexOf(contenedor);

    //Ocultar contenedor
    contenedor.classList.toggle("contenedor-hide");

    //Aparecer siguiente contenedor
    const contenedorSiguiente = contenedores[indice + 1];
    contenedorSiguiente.classList.toggle("contenedor-hide");

    //Colorear puntero
    $(".paso-" + (indice + 2) + " i").addClass("imhere");
});

//Funcion de retroceder
$(".back-button").on("click", function (event) {
    const boton = event.target; // El botón que fue clickeado
    const contenedor = boton.closest(".contenedor"); // Encuentra el contenedor más cercano

    // Obtener el índice del contenedor en el array
    const indice = contenedores.indexOf(contenedor);

    //Ocultar contenedor
    contenedor.classList.toggle("contenedor-hide");

    //Aparecer contenedor anterior
    const contenedorSiguiente = contenedores[indice - 1];
    contenedorSiguiente.classList.toggle("contenedor-hide");

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
                contenedor.classList.toggle("contenedor-hide");

                //Colorear puntero
                // Obtener el índice del contenedor donde empieza el error
                const indice = contenedores.indexOf(contenedor);
                console.log(indice);

                //Quitar color a todos los ultimos punteros
                $(".progreso div i").each(function () {
                    $(this).removeClass("imhere");
                });

                //Colorear en donde se está y antes
                var i = 0;
                while (i <= indice) {
                    $(".paso-" + (i + 1) + " i").addClass("imhere");
                    i++;
                }

                //Ocultar ultimo contenedor
                const lastContenedor = contenedores[4];
                lastContenedor.classList.add("contenedor-hide");
            }
        });
    }
});
