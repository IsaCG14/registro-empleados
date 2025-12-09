$(document).ready(function () {
    function formatearFecha(fecha) {
        let dia = fecha.getDate();
        let mes = fecha.getMonth() + 1; // El mes es 0-indexado
        let año = fecha.getFullYear();
        return dia + "/" + mes + "/" + año;
    }

    function generarFecha(fecha) {
        let partes = fecha.split("-");
        return new Date(partes[0], partes[1] - 1, partes[2]);
    }

    $(".ver-persona").on("click", function () {
        var id = $(this).attr("id");

        $(".informacion-personal").empty();

        //Mostrar datos en el modal de ver
        $.ajax({
            url: "/obtener-informacion/" + id,
            type: "GET",
            success: function (data) {
                //Calcular edad
                fecha_actual = new Date();

                fecha_nac = generarFecha(data[0].personas.fecha_nacimiento);
                fecha_atencion = generarFecha(data[0].fecha_atencion);

                //Obtener edad
                var edad = fecha_actual - fecha_nac;
                var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
                console.log(data[1]);
                var consejo = data[0].consejo_comunal ? data[0].consejo_comunal : "No pertenece";
                var comuna = data[0].comuna ? data[0].comuna : "No pertenece";

                $(".informacion-personal").html(
                    "<p><b>Nombre:</b> " +
                        data[0].personas.nombre +
                        "</p>" +
                        "<p><b>Cédula:</b> " +
                        data[0].personas.cedula +
                        "</p>" +
                        "<p><b>Fecha de nacimiento:</b> " +
                        formatearFecha(fecha_nac) +
                        " (" +
                        Math.floor(anios) +
                        " años)" +
                        "</p>" +
                        "<p><b>Sexo:</b> " +
                        (data[0].personas.sexo == 0
                            ? "Femenino"
                            : "Masculino") +
                        "</p>" +
                        "<p><b>Correo:</b> " +
                        data[0].personas.correo +
                        "</p>" +
                        "<p><b>Teléfono:</b> " +
                        data[0].personas.telefono +
                        "</p>" +
                        "<p><b>Proveniencia:</b> " +
                        data[1].parroquia +
                        " (Municipio " +
                        data[1].municipio.municipio +
                        ", Estado " +
                        data[1].municipio.estado.estado +
                        ")" +
                        "</p>" +
                        "<p><b>Consejo Comunal:</b> " +
                        consejo +
                        "</p>" +
                        "<p><b>Comuna:</b> " +
                        comuna +
                        "</p>"
                );
                var asuntos = data[0].asuntos;
                //Limpiar informacion anterior
                $(".informacion-atendido").empty();
                //Agregar los asuntos
                $(".informacion-atendido").append("<b>Asuntos:</b><ul>");
                asuntos.forEach((asunto) => {
                    $(".informacion-atendido").append(
                        "<li><p>" + asunto.patria.opciones + "</p></li>"
                    );
                });
                var detalles = data[0].detalles ? data[0].detalles : "Ninguno";
                $(".informacion-atendido").append(
                    "</ul><p><b>Fecha de atención:</b> " +
                        formatearFecha(fecha_atencion) +
                        "<p><b>Detalles:</b> " +
                        detalles +
                        "</p><br>" +
                        "<p><b>Registrado por:</b> " +
                        data[0].usuarios.name +
                        "</p>"
                );
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
});
