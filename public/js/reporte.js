$(document).ready(function () {
    //Limitar checks
    $("input[type='checkbox']").on("click", function () {
        if ($("input[type='checkbox']:checked").length > 8) {
            $(this).prop("checked", false);
            alert("Solo puedes seleccionar hasta 8 atributos");
        }
    });
    //Generar reporte con lo seleccionado
    $(".reporteForm").on("submit", function (e) {
        e.preventDefault();

        // Limpiar campos ocultos existentes para evitar duplicados
        $(this).find("input[name='atributos[]']").remove();

        location.reload();

        //Obtener atributos seleccionados
        $("input[type='checkbox']").each(function (index, element) {
            //Crear campo para cada atributo
            if (element.checked) {
                $(".reporteForm").append(
                    "<input type='hidden' name='atributos[]' value='" +
                        element.value +
                        "'>"
                );
            }
        });

        $(this).off("submit").submit();
    });
});
