$("#new_centro").on("change", function () {
    if ($(this).prop("checked")) {
        $("#otro_centro").html(
            "<input class='form-control my-2' placeholder='Escribe un nuevo centro electoral' type='text' name='nombre_centro' id='centro_nuevo' required>"
        );
    } else {
        $("#centro_nuevo").remove();
    }
});
