$(document).ready(function () {
    function formatearFecha(fecha) {
        let dia = fecha.getDate();
        let mes = fecha.getMonth() + 1; // El mes es 0-indexado
        let año = fecha.getFullYear();
        return dia + "/" + mes + "/" + año;
    }

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
                fecha_nac = new Date(data.empleado.fecha_nacimiento);
                var edad = fecha_actual - fecha_nac;
                var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
                //console.log(anios);
                var estudiante = data.empleado.estudiante == 0 ? "No" : "Si";

                $(".informacion-personal").html(
                    "<p><b>Nombre:</b> " +
                        data.empleado.nombre +
                        "</p>" +
                        "<p><b>Cédula:</b> " +
                        data.empleado.cedula +
                        "</p>" +
                        "<p><b>Fecha de nacimiento:</b> " +
                        formatearFecha(fecha_nac) +
                        " (" +
                        Math.floor(anios) +
                        " años)" +
                        "</p>" +
                        "<p><b>Sexo:</b> " +
                        data.empleado.sexo +
                        "</p>" +
                        "<p><b>Correo:</b> " +
                        data.empleado.correo +
                        "</p>" +
                        "<p><b>Teléfono:</b> " +
                        data.empleado.telefono +
                        "</p>" +
                        "<p><b>Dirección:</b> " +
                        data.empleado.direccion +
                        "</p>" +
                        "<p><b>Peso:</b> " +
                        data.empleado.peso +
                        "</p>" +
                        "<p><b>Talla de camisa:</b> " +
                        data.empleado.talla_camisa +
                        "</p>" +
                        "<p><b>Talla de pantalón:</b> " +
                        data.empleado.talla_pantalon +
                        "</p>" +
                        "<p><b>Talla de zapato:</b> " +
                        data.empleado.talla_zapato +
                        "</p>" +
                        "<p><b>Estudiante:</b> " +
                        estudiante +
                        "</p>"
                );

                var patologia =
                    data.empleado.patologia != null
                        ? data.empleado.patologia
                        : "Ninguna";

                var tipo = "";
                if (data.empleado.tipo == 0) {
                    tipo = "Contratado";
                } else if (data.empleado.tipo == 1) {
                    tipo = "Trabajador fijo";
                } else if (data.empleado.tipo == 2) {
                    tipo = "Pasante";
                } else {
                    tipo = "Jubilado";
                }

                $(".informacion-laboral").append(
                    "<p><b>Patologia:</b> " +
                        patologia +
                        "</p>" +
                        "<p><b>Centro electoral:</b> " +
                        data.centro.nombre_centro +
                        "<p><b>Tipo de empleado:</b> " +
                        tipo +
                        "</p><br>"
                );
                $(".informacion-laboral").append(
                    "<h5>Datos laborales</h5><br>"
                );
                //Calcular años de servicio
                fecha_actual = new Date();
                //const partes = data.empleado.fecha_ingreso.split("/");
                //fecha_in = new Date(partes[2], partes[1] - 1, partes[0]);
                fecha_in = new Date(data.empleado.fecha_ingreso);
                var tiempo = fecha_actual - fecha_in;
                var anios_servicio = tiempo / (1000 * 60 * 60 * 24 * 365.25);
                //console.log(anios_servicio);
                $(".informacion-laboral").append(
                    "<p><b>Cargo:</b> " +
                        data.empleado.cargo +
                        "</p>" +
                        "<p><b>Fecha de ingreso:</b> " +
                        formatearFecha(fecha_in) +
                        " (" +
                        Math.floor(anios_servicio) +
                        " años)</p>"
                );

                $.ajax({
                    url: "/obtener-area/" + data.empleado.area,
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
                    let fecha_nacimiento = new Date(hijo.fecha_nacimiento);
                    $("#mostrar-hijos").append(
                        "<tr><td>" +
                            hijo.nombre +
                            "</td><td>" +
                            formatearFecha(fecha_nacimiento) +
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
