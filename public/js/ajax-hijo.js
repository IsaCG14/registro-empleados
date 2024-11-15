$(document).ready(function () {
    var cantidad_hijos = $(".table tbody tr").length;
    $("input[name='nro_hijos']").attr("min", cantidad_hijos);
    $("input[name='nro_hijos']").attr("max", cantidad_hijos);

    $(".registrar-hijo").on("click", function () {
        var name = $("input[name='nombre_hijo']").val();
        var age = $("input[name='fecha_nacimiento_hijo']").val();
        var sex = $("input[name='sexo_hijo']:checked").val();
        var estudiante = $("input[name='estudiante_hijo']").is(":checked")
            ? 1
            : 0;
        var id = $("input[name='id_empleado']").val();
        var token = $("#token").val();

        //Registrar hijo desde formulario de edición
        $.ajax({
            url: "/registrar-hijo",
            method: "POST",
            data: {
                _token: token,
                nombre: name,
                edad: age,
                sexo: sex,
                estudiante: estudiante,
                id_empleado: id,
            },
            //Mostrar en la tabla de hijos de formulario de edición
            success: function (response) {
                var estudia = estudiante == 1 ? "Si" : "No";
                $("tbody").append(
                    "<tr class='" +
                        response.id_hijo +
                        "'><td>" +
                        name +
                        "</td><td>" +
                        age +
                        "</td><td>" +
                        sex +
                        "</td><td>" +
                        estudia +
                        "</td><td><button type='buttom' class='funcion_eliminar_hijo btn btn-sm btn-danger' id=" +
                        response.id_hijo +
                        "><img src='/img/trash.png' width='20px'></button></td></tr>"
                );

                $("#form-hijos").trigger("reset");
                $("#info-hijos").modal("hide");

                cantidad_hijos = $(".table tbody tr").length;
                $("input[name='nro_hijos']").attr("min", cantidad_hijos);
                $("input[name='nro_hijos']").attr("max", cantidad_hijos);
            },
            error: function (xhr, status, error) {
                console.log(error + "Esto es un error");
            },
        });
    });

    //Eliminar de la base de datos al hijo
    $(".funcion_eliminar_hijo").on("click", function (e) {
        e.preventDefault();
        var id = $(this).attr("id");

        $.ajax({
            url: "/eliminar-hijo/" + id,
            method: "GET",
            success: function () {
                $("." + id).remove();

                cantidad_hijos = $(".table tbody tr").length;
                $("input[name='nro_hijos']").attr("min", cantidad_hijos);
                $("input[name='nro_hijos']").attr("max", cantidad_hijos);
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
});
