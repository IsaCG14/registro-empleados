$("#new_centro").on("change", function () {
    if ($(this).prop("checked")) {
        $("#otro_centro").html(
            "<input class='form-control my-2' placeholder='Escribe un nuevo centro electoral' type='text' name='nombre_centro' id='centro_nuevo' required>"
        );
    } else {
        $("#centro_nuevo").remove();
    }
});

//Funcion modal
$("#añadirHijo").on("click", function () {
    var cantidad = $("input[name='nro_hijos']").val();
    var cantidadTabla = $(".table tbody tr").length;

    if (cantidadTabla < cantidad) {
        $("#info-hijos").modal("show");
    }
});

$("#agregar-hijo").on("click", function () {
    //
});
