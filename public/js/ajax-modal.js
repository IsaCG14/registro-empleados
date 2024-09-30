$(document).ready(function () {
    $(".ver-empleado").on("click", function () {
        var id = $(this).attr("id");
        var oficina;

        $(".informacion-personal").empty();
        $(".informacion-laboral").empty();

        //Mostrar datos en el modal de ver
        $.ajax({
            url: "/obtener-informacion/" + id,
            type: "GET",
            success: function (data) {
                //Calcular edad
                fecha_actual = new Date();
                fecha_nac = new Date(data.fecha_nacimiento);
                var edad = fecha_actual - fecha_nac;
                var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
                console.log(anios);
                var estudiante = data.estudiante == 0 ? "No" : "Si";

                $(".informacion-personal").html(
                    "<p><b>Nombre:</b> " +
                        data.nombre +
                        "</p>" +
                        "<p><b>Cédula:</b> " +
                        data.cedula +
                        "</p>" +
                        "<p><b>Fecha de nacimiento:</b> " +
                        data.fecha_nacimiento +
                        " (" +
                        Math.floor(anios) +
                        " años)" +
                        "</p>" +
                        "<p><b>Sexo:</b> " +
                        data.sexo +
                        "</p>" +
                        "<p><b>Correo:</b> " +
                        data.correo +
                        "</p>" +
                        "<p><b>Teléfono:</b> " +
                        data.telefono +
                        "</p>" +
                        "<p><b>Dirección:</b> " +
                        data.direccion +
                        "</p>" +
                        "<p><b>Peso:</b> " +
                        data.peso +
                        "</p>" +
                        "<p><b>Talla de camisa:</b> " +
                        data.talla_camisa +
                        "</p>" +
                        "<p><b>Talla de pantalón:</b> " +
                        data.talla_pantalon +
                        "</p>" +
                        "<p><b>Talla de zapato:</b> " +
                        data.talla_zapato +
                        "</p>" +
                        "<p><b>Estudiante:</b> " +
                        estudiante +
                        "</p>"
                );

                var patologia =
                    data.patologia != null ? data.patologia : "Ninguna";
                var tipo = data.tipo == 0 ? "Contratado" : "Trabajador fijo";
                $(".informacion-laboral").append(
                    "<p><b>Patologia:</b> " +
                        patologia +
                        "</p>" +
                        "<p><b>Centro electoral:</b> " +
                        data.centro_electoral +
                        "<p><b>Tipo de empleado:</b> " +
                        tipo +
                        "</p><br>"
                );
                $(".informacion-laboral").append(
                    "<h5>Datos laborales</h5><br>"
                );
                //Calcular años de servicio
                fecha_actual = new Date();
                fecha_in = new Date(data.fecha_ingreso);
                var tiempo = fecha_actual - fecha_in;
                var anios_servicio = tiempo / (1000 * 60 * 60 * 24 * 365.25);
                console.log(anios_servicio);
                $(".informacion-laboral").append(
                    "<p><b>Cargo:</b> " +
                        data.cargo +
                        "</p>" +
                        "<p><b>Fecha de ingreso:</b> " +
                        data.fecha_ingreso +
                        " (" +
                        Math.floor(anios_servicio) +
                        " años)</p>"
                );

                $.ajax({
                    url: "/obtener-area/" + data.area,
                    type: "GET",
                    success: function (area) {
                        $(".informacion-laboral").append(
                            "<p><b>Area:</b> " + area.oficina + "</p>"
                        );
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    },
                });
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });

        $.ajax({
            url: "/obtener-hijos/" + id,
            type: "GET",
            success: function (hijos) {
                //reiniciar div
                $("#mostrar-hijos").empty();

                //console.log(hijos)
                $.each(hijos, function (index, hijo) {
                    $("#mostrar-hijos").append(
                        "<tr><td>" +
                            hijo.nombre +
                            "</td><td>" +
                            hijo.fecha_nacimiento +
                            "</td><td>" +
                            hijo.sexo +
                            "</td></tr>"
                    );
                });
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });

        $.ajax({
            url: "/obtener-carnet/" + id,
            type: "GET",
            success: function (carnet) {
                $(".informacion-carnet").empty();
                if (carnet.codigo != null) {
                    $(".informacion-carnet").append("<br><h5>Carnet</h5>");
                    $(".informacion-carnet").append(
                        "<p><b>Código:</b> " +
                            carnet.codigo +
                            "</p>" +
                            "<p><b>Serial:</b> " +
                            carnet.serial +
                            "</p>"
                    );
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
});
