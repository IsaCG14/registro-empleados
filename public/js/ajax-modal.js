$(document).ready(function () {
    function formatearFecha(fecha) {
        let dia = String(fecha.getDate()).padStart(2, "0");
        let mes = String(fecha.getMonth() + 1).padStart(2, "0");
        let año = fecha.getFullYear();
        return dia + "/" + mes + "/" + año;
    }

    function generarFecha(fecha) {
        let partes = fecha.split("-");
        return new Date(partes[0], partes[1] - 1, partes[2]);
    }

    $(document).on("click", ".ver-persona", function () {
        var id = $(this).attr("id");

        $(".informacion-personal, .informacion-atendido").empty();

        $.ajax({
            url: "/obtener-informacion/" + id,
            type: "GET",
            success: function (data) {
                var p = data[0].personas;
                var fecha_actual = new Date();
                var fecha_nac = generarFecha(p.fecha_nacimiento);
                var fecha_atencion = generarFecha(data[0].fecha_atencion);
                var edad = Math.floor((fecha_actual - fecha_nac) / (1000 * 60 * 60 * 24 * 365.25));

                var consejo = p.consejo_comunal || "Sin especificar";
                var comuna = p.comuna || "Sin especificar";
                var detalles = data[0].detalles || "Ninguno";
                var ubicacion = data[1]
                    ? data[1].parroquia + " (Municipio " + data[1].municipio.municipio + ", Estado " + data[1].municipio.estado.estado + ")"
                    : "No especificada";

                var sexo = p.sexo == 0 ? "Femenino" : "Masculino";

                $(".informacion-personal").html(`
                    <div class="card-section h-100">
                        <h4><i class="bi bi-person-fill"></i> Datos personales</h4>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="fw-semibold ps-0" style="width:130px">Nombre:</td><td>${p.nombre}</td></tr>
                            <tr><td class="fw-semibold ps-0">Cédula:</td><td>${p.cedula}</td></tr>
                            <tr><td class="fw-semibold ps-0">F. nacimiento:</td><td>${formatearFecha(fecha_nac)} (${edad} años)</td></tr>
                            <tr><td class="fw-semibold ps-0">Sexo:</td><td>${sexo}</td></tr>
                            <tr><td class="fw-semibold ps-0">Correo:</td><td>${p.correo || "—"}</td></tr>
                            <tr><td class="fw-semibold ps-0">Teléfono:</td><td>${p.telefono || "—"}</td></tr>
                            <tr><td class="fw-semibold ps-0">Proveniencia:</td><td>${ubicacion}</td></tr>
                            <tr><td class="fw-semibold ps-0">Circuito comunal:</td><td>${consejo}</td></tr>
                            <tr><td class="fw-semibold ps-0">Comuna:</td><td>${comuna}</td></tr>
                        </table>
                    </div>
                `);

                var asuntosHtml = data[0].asuntos.map(a =>
                    `<span class="badge bg-danger me-1">${a.patria.opciones}</span>`
                ).join("") || '<span class="text-muted">N/A</span>';

                $(".informacion-atendido").html(`
                    <div class="card-section h-100">
                        <h4><i class="bi bi-clipboard-data"></i> Datos de atención</h4>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="fw-semibold ps-0" style="width:130px">Asuntos:</td><td>${asuntosHtml}</td></tr>
                            <tr><td class="fw-semibold ps-0">Fecha de atención:</td><td>${formatearFecha(fecha_atencion)}</td></tr>
                            <tr><td class="fw-semibold ps-0">Detalles:</td><td>${detalles}</td></tr>
                            <tr><td class="fw-semibold ps-0">Registrado por:</td><td>${data[0].usuarios.name}</td></tr>
                        </table>
                    </div>
                `);
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
});