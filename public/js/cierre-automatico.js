var tiempoInactividad = 0;
var intervaloInactividad = null;
var tiempoAlerta = 5; // Tiempo en segundos para mostrar la alerta
var intervaloAlerta = null;
var tiempoCierreAutomatico = 60; // Tiempo en segundos para el cierre automático
var intervaloCierreAutomatico = null;

function reiniciarTemporizador() {
    tiempoInactividad = 0;
}

function iniciarTemporizador() {
    intervaloInactividad = setInterval(verificarInactividad, 1000);
}

function verificarInactividad() {
    tiempoInactividad++;
    //console.log("Tiempo inactivo: " + tiempoInactividad + " segundos");
    if (tiempoInactividad >= 15) {
        clearInterval(intervaloInactividad);
        mostrarAlerta();
    }
}

function mostrarAlerta() {
    clearInterval(intervaloAlerta);
    var contador = tiempoCierreAutomatico;
    console.log("Alerta mostrada");
    // console.log("Cierre automático en " + contador + " segundos");

    intervaloAlerta = setInterval(function () {
        contador--;
        //console.log("Cierre automático en " + contador + " segundos");
        if (contador <= 0) {
            clearInterval(intervaloAlerta);
            cerrarSesionAutomaticamente();
        }
    }, 1000);

    bootbox.confirm({
        title: "Cierre de sesión automático",
        message: "¿Desea reanudar la sesión o cerrarla?",
        buttons: {
            confirm: {
                label: "Cerrar sesión",
                className: "btn-danger",
            },
            cancel: {
                label: "Reanudar sesión",
                className: "btn-primary",
            },
        },
        callback: function (result) {
            clearInterval(intervaloAlerta);
            if (result) {
                // Redirigir al usuario a la página de cierre de sesión automatico

                $.ajax({
                    type: "POST",
                    url: "",
                    success: function (response) {
                        // Manejar la respuesta del servidor
                        console.log(response);
                        // Mostrar un mensaje de éxito o error al usuario
                        window.location.href =
                            "../../ajax/perfilUsuario/login.php?op=" + op;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Manejar el error de la solicitud
                        console.log(jqXHR, textStatus, errorThrown);
                        // Mostrar un mensaje de error al usuario
                    },
                });
            } else {
                // Reiniciar el temporizador de inactividad y continuar la sesión
                reiniciarTemporizador();
                iniciarTemporizador();
            }
        },
    });
}

function cerrarSesionAutomaticamente() {
    clearInterval(intervaloInactividad);
    clearInterval(intervaloAlerta);
    console.log("Sesión cerrada automáticamente");
    // Cerrar sesión automáticamente manual
    $.ajax({
        type: "POST",
        url: "",
        success: function (response) {
            // Manejar la respuesta del servidor
            console.log(response);
            // Mostrar un mensaje de éxito o error al usuario
            window.location.href = "";
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Manejar el error de la solicitud
            console.log(jqXHR, textStatus, errorThrown);
            // Mostrar un mensaje de error al usuario
        },
    });
}

$(document).ready(function () {
    // Reiniciar el temporizador de inactividad cuando el usuario interactúa con la página
    $(document).on("mousemove keydown click", reiniciarTemporizador);

    // Iniciar el temporizador de inactividad
    iniciarTemporizador();
});
