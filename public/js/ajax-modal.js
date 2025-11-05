$(document).ready(function () {
    function formatearFecha(fecha) {
        let dia = fecha.getDate();
        let mes = fecha.getMonth() + 1; // El mes es 0-indexado
        let año = fecha.getFullYear();
        return dia + "/" + mes + "/" + año;
    }

    function generarFecha(fecha) {
        let partes = fecha.split('-');
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
                
                fecha_nac = generarFecha(data[0].personas.fecha_nacimiento)
                fecha_cita = generarFecha(data[0].fecha_cita)

                //Obtener edad
                var edad = fecha_actual - fecha_nac;
                var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
                console.log(data[1])

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
                        ((data[0].personas.sexo == 0) ? "Femenino" : "Masculino") +
                        "</p>" +
                        "<p><b>Correo:</b> " +
                        data[0].personas.correo +
                        "</p>" +
                        "<p><b>Teléfono:</b> " +
                        data[0].personas.telefono +
                        "</p>" +
                        "<p><b>Proveniencia:</b> " +
                        data[1].parroquia + " (Municipio "+ data[1].municipio.municipio+", Estado "+data[1].municipio.estado.estado+")"+
                        "</p>"
                );

                $(".informacion-cita").html(
                    "<p><b>Asunto:</b> " +
                        data[0].patria.opciones +
                        "</p>" +
                        "<p><b>Fecha cita:</b> " +
                        formatearFecha(fecha_cita) +
                        "<p><b>Detalles:</b> " +
                        data[0].detalles +
                        "</p><br>"
                );
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
});
