$(document).ready(function () {
    //Busqueda en select
    $(".select-oficina").select2();
    $(".select-centro").select2();

    //Ocultar y mostrar opcion de hijos
    if ($("#hijos_si").prop("checked")) {
        $(".container_hijos").css("display", "block");
        $("input[name='nro_hijos']").attr("required", "required");
    } else {
        $(".container_hijos").css("display", "none");
        $("input[name='nro_hijos']").removeAttr("required");
    }

    $("input[name='hijos']").on("change", function () {
        if ($("#hijos_si").prop("checked")) {
            $(".container_hijos").css("display", "block");
            $("input[name='nro_hijos']").attr("required", "required");
        } else {
            $(".container_hijos").css("display", "none");
            $("input[name='nro_hijos']").removeAttr("required");
            $("input[name='nro_hijos']").val("");
        }
    });

    //Ocultar y mostrar opcion de carnet
    if ($("#carnet_si").prop("checked")) {
        $(".container_carnet").css("display", "block");
        $("input[name='codigo']").attr("required", "required");
        $("input[name='serial']").attr("required", "required");
    } else {
        $(".container_carnet").css("display", "none");
        $("input[name='codigo']").removeAttr("required");
        $("input[name='codigo']").val("");
        $("input[name='serial']").removeAttr("required");
        $("input[name='serial']").val("");
    }

    $("input[name='carnet']").on("change", function () {
        if ($("#carnet_si").prop("checked")) {
            $(".container_carnet").css("display", "block");
            $("input[name='codigo']").attr("required", "required");
            $("input[name='serial']").attr("required", "required");
        } else {
            $(".container_carnet").css("display", "none");
            $("input[name='codigo']").removeAttr("required");
            $("input[name='codigo']").val("");
            $("input[name='serial']").removeAttr("required");
            $("input[name='serial']").val("");
        }
    });

    //Ocultar y mostrar opcion de patologia
    if ($("#patologia_si").prop("checked")) {
        $(".patologia_container").css("display", "block");
        $("input[name='patologia']").attr("required", "required");
    } else {
        $(".patologia_container").css("display", "none");
        $("input[name='patologia']").removeAttr("required");
        $("input[name='patologia']").val("");
    }

    $("input[name='patologia']").on("change", function () {
        if ($("#patologia_si").prop("checked")) {
            $(".patologia_container").css("display", "block");
            $("input[name='patologia']").attr("required", "required");
        } else {
            $(".patologia_container").css("display", "none");
            $("input[name='patologia']").removeAttr("required");
            $("input[name='patologia']").val("");
        }
    });

    //LLenar tabla de hijos con formulario
    $("#agregar-hijo").on("click", function () {
        var nombre = $("input[name='nombre_hijo']").val();
        var edad = $("input[name='fecha_nacimiento_hijo']").val();
        var sexo = $("input[name='sexo_hijo']:checked").val();
        var estudiante = $("input[name='estudiante_hijo']").is(":checked")
            ? 1
            : 0;

        //Vallidar que no queden campos vacios
        if (nombre == "" || edad == "" || sexo == "") {
            if (nombre == "") {
                $("#error_nombre")
                    .html("<small>Debe llenar el campo nombre.</small>")
                    .css("color", "red");
            }
            if (edad == "") {
                $("#error_fecha")
                    .html(
                        "<small>Debe llenar el campo fecha de nacimiento.</small>"
                    )
                    .css("color", "red");
            }
        } else {
            //Validar nombre
            const r = /^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$/;

            if (r.test(nombre)) {
                //Generar id
                var id = Math.floor(Math.random() * 100) + 1;
                estudia = estudiante == 1 ? "Si" : "No";

                $("tbody").append(
                    "<tr class='" +
                        id +
                        "'><td>" +
                        nombre +
                        "</td><td>" +
                        edad +
                        "</td><td>" +
                        sexo +
                        "</td><td>" +
                        estudia +
                        "</td><td><button type='buttom' class='eliminar-hijo btn btn-sm btn-danger' onclick='eliminar()'><img src='/img/trash.png' width='20px'></button></td></tr>"
                );
                $(".valores-hijos").append(
                    "<input class='" + id + "' type=hidden name='nombres[]'>"
                );
                $("." + id + "[name='nombres[]']").val(nombre);
                $(".valores-hijos").append(
                    "<input class='" +
                        id +
                        "' type=hidden name='fechas_nac[]' value=" +
                        edad +
                        ">"
                );
                $(".valores-hijos").append(
                    "<input class='" +
                        id +
                        "' type=hidden name='sexos[]' value=" +
                        sexo +
                        ">"
                );
                $(".valores-hijos").append(
                    "<input class='" +
                        id +
                        "' type=hidden name='estudiantes[]' value=" +
                        estudiante +
                        ">"
                );

                $("#form-hijos").trigger("reset");
                $("#info-hijos").modal("hide");

                //Seguir registrando hijos
                document
                    .querySelector("#info-hijos")
                    .addEventListener("hidden.bs.modal", function () {
                        //Aparecer modal si aun faltan hijos por registrar
                        var cantidad = $("input[name='nro_hijos']").val();
                        var cantidadTabla = $(".table tbody tr").length;

                        if (cantidadTabla < cantidad) {
                            $("#info-hijos").modal("show");
                        }
                    });

                cantidad_hijos = $("input[name='nombres[]']").length;

                //alert(cantidad_hijos)
                $("input[name='nro_hijos']").attr("min", cantidad_hijos);
                $("input[name='nro_hijos']").attr("max", cantidad_hijos);

                $(".eliminar-hijo").on("click", function eliminar() {
                    var clase = $(this).closest("tr").attr("class");
                    $("." + clase).remove();
                });
            } else {
                //Validar que tenga solo letras y espacios
                $("#error_nombre")
                    .html("<small>El nombre tiene que ser válido.</small>")
                    .css("color", "red");
            }
        }
    });

    //Más validaciones
    $("#nombre_hijo").on("blur", function () {
        if ($("#nombre_hijo").val() == "") {
            $("#error_nombre")
                .html("<small>Debe llenar el campo nombre.</small>")
                .css("color", "red");
        } else {
            const r = /^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$/;
            if (!r.test($("#nombre_hijo").val())) {
                $("#error_nombre")
                    .html("<small>El nombre tiene que ser válido.</small>")
                    .css("color", "red");
            } else {
                $("#error_nombre small").remove();
            }
        }
    });

    $("#fecha_nacimiento_hijo").on("blur", function () {
        if ($("#fecha_nacimiento_hijo").val() == "") {
            $("#error_fecha")
                .html(
                    "<small>Debe llenar el campo fecha de nacimiento.</small>"
                )
                .css("color", "red");
        } else {
            $("#error_fecha small").remove();
        }
    });
});
