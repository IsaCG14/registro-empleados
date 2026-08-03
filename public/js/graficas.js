function ubicacion_persona_promesa(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/parroquia/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                console.error('Error al obtener la ubicación:', error);
                resolve(null);
            }
        });
    });
}

const plugin = {
    id: 'customCanvasBackgroundColor',
    beforeDraw: (chart, args, options) => {
        const {
            ctx
        } = chart;
        ctx.save();
        ctx.globalCompositeOperation = 'destination-over';
        ctx.fillStyle = options.color || '#ffffff';
        ctx.fillRect(0, 0, chart.width, chart.height);
        ctx.restore();
    }
};

const url = new URLSearchParams(window.location.search)

var tipo = (url.get("ver") != null) ? url.get("ver") : '';
var asuntoCounts = {};

if (tipo == 'mis-estadisticas') {
    $(".btn-secondary.dropdown-toggle").text("Mis estadísticas")
    atendidos.forEach(cita => {
        if (cita.usuarios && cita.usuarios.id == id_usuario) {
            var asuntos = cita.asuntos;
            asuntos.forEach(asunto => {
                var opcion = asunto.patria.opciones;
                if (opcion in asuntoCounts) {
                    asuntoCounts[opcion]++;
                } else {
                    asuntoCounts[opcion] = 1;
                }
            });
        }
    });
} else {
    $(".btn-secondary.dropdown-toggle").text("Estadísticas generales")
    atendidos.forEach(cita => {
        var asuntos = cita.asuntos;
        asuntos.forEach(asunto => {
            var opcion = asunto.patria.opciones;
            if (opcion in asuntoCounts) {
                asuntoCounts[opcion]++;
            } else {
                asuntoCounts[opcion] = 1;
            }
        });
    });
}

Chart.getChart("grafica-asunto")?.destroy();
const grafica_asunto = document.getElementById('grafica-asunto');
new Chart(grafica_asunto, {
    type: "bar",
    data: {
        labels: Object.keys(asuntoCounts).map(asunto => asunto + " (" + asuntoCounts[asunto] + ")"),
        datasets: [{
            label: 'Asuntos atendidos',
            data: Object.values(asuntoCounts),
            backgroundColor: [
                'rgba(255, 99, 133, 0.8)',
                'rgba(255, 160, 64, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(201, 203, 207, 0.8)'
            ],
            borderWidth: 1
        }]
    },
    plugins: [plugin],
})


var num_f = 0
var num_m = 0

var rango1 = 0
var rango2 = 0
var rango3 = 0
var rango4 = 0
var rango5 = 0

atendidos.forEach(cita => {
    if (cita.personas.sexo == 1) {
        num_m++
    } else {
        num_f++
    }

    var fecha_actual = new Date();
    var fecha_nac = new Date(cita.personas.fecha_nacimiento);
    var edad = fecha_actual - fecha_nac;
    var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
    edad = Math.floor(anios)

    if (edad >= 18 && edad <= 24) {
        rango1++
    } else if (edad >= 25 && edad <= 30) {
        rango2++
    } else if (edad >= 31 && edad <= 45) {
        rango3++
    } else if (edad >= 46 && edad <= 55) {
        rango4++
    } else if (edad >= 56) {
        rango5++
    }
    var asuntos = cita.asuntos;
    asuntos.forEach(asunto => {
        var opcion = asunto.patria.opciones;
        if (opcion in asuntoCounts) {
            asuntoCounts[opcion]++;
        } else {
            asuntoCounts[opcion] = 1;
        }
    })
})

const grafica_sexo = document.getElementById('grafica-sexo');
new Chart(grafica_sexo, {
    type: 'bar',
    data: {
        labels: ['Masculino: ' + String(num_m), 'Femenino: ' + String(num_f)],
        datasets: [{
            label: '# sexo de personas atendidas',
            data: [num_m, num_f],
            backgroundColor: [
                'rgba(54, 163, 235, 0.8)',
                'rgba(255, 99, 133, 0.8)'
            ]
        }]
    },
    plugins: [plugin],
});

const grafica_edad = document.getElementById('grafica-edad');

new Chart(grafica_edad, {
    type: 'bar',
    data: {
        labels: ["18 a 24 (" + rango1 + ")", "25 a 30 (" + rango2 + ")", "31 a 45 (" + rango3 + ")",
        "46 a 55 (" + rango4 + ")", "56+ (" + rango5 + ")"
        ],
        datasets: [{
            label: 'Personas entre rango de edad',
            data: [rango1, rango2, rango3, rango4, rango5],
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)'
            ]
        }]
    },
    plugins: [plugin],
})

// const grafica_sexo_usuario = document.getElementById('grafica-sexo-usuario');
// var usuarioLabels = {};
// atendidos.forEach(cita => {
//     var usuario = cita.usuarios.name;
//     if (!(usuario in usuarioLabels)) {
//         usuarioLabels[usuario] = {
//             male: 0,
//             female: 0
//         };
//     }
//     if (cita.personas.sexo == 1) {
//         usuarioLabels[usuario].male++;
//     } else {
//         usuarioLabels[usuario].female++;
//     }
// });
// new Chart(grafica_sexo_usuario, {
//     type: 'bar',
//     data: {
//         labels: Object.keys(usuarioLabels),
//         datasets: [{
//             axis: 'y',
//             label: 'Masculino',
//             data: Object.values(usuarioLabels).map(data => data.male),
//             backgroundColor: 'rgba(54, 162, 235, 0.8)',
//         },
//         {
//             axis: 'y',
//             label: 'Femenino',
//             data: Object.values(usuarioLabels).map(data => data.female),
//             backgroundColor: 'rgba(255, 99, 132, 0.8)',
//         }
//         ]
//     },
//     plugins: [plugin],
//     options: {
//         indexAxis: 'y'
//     }
// });

async function generarGraficaPorUbicacion(atendidos, nivel, filterId, plugin) {
    Chart.getChart("grafica-ubicacion")?.destroy();
    const canvas = document.getElementById('grafica-ubicacion');
    var counts = {};

    const promesas = atendidos.map(cita => {
        return ubicacion_persona_promesa(cita.personas.id_parroquia.toString());
    });

    const resultados = await Promise.all(promesas);

    resultados.forEach((ubicacion) => {
        if (!ubicacion) return;

        if (nivel === 'estado') {
            if (ubicacion.municipio && ubicacion.municipio.estado) {
                let estado = ubicacion.municipio.estado.estado || "Desconocido";
                counts[estado] = (counts[estado] || 0) + 1;
            }
        } else if (nivel === 'municipio') {
            if (ubicacion.municipio && ubicacion.municipio.estado && ubicacion.municipio.estado.id_estado.toString() === filterId) {
                let municipio = ubicacion.municipio.municipio || "Desconocido";
                counts[municipio] = (counts[municipio] || 0) + 1;
            }
        } else if (nivel === 'parroquia') {
            if (ubicacion.municipio && ubicacion.municipio.id_municipio.toString() === filterId) {
                let parroquia = ubicacion.parroquia || "Desconocido";
                counts[parroquia] = (counts[parroquia] || 0) + 1;
            }
        }
    });

    var label = nivel === 'estado' ? 'Proveniencia de personas por estado'
        : nivel === 'municipio' ? 'Proveniencia de personas por municipio'
            : 'Proveniencia de personas por parroquia';

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: Object.keys(counts).map(key => key + " (" + counts[key] + ")"),
            datasets: [{
                label: label,
                data: Object.values(counts),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)', 'rgba(255, 159, 64, 0.8)', 'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)'
                ]
            }]
        },
        plugins: [plugin],
    });
}

generarGraficaPorUbicacion(atendidos, 'estado', null, plugin);

async function generarGraficaGeneral(atendidos, plugin) {
    Chart.getChart("grafica-ubicacion")?.destroy();
    const canvas = document.getElementById('grafica-ubicacion');

    const promesas = atendidos.map(cita => {
        return ubicacion_persona_promesa(cita.personas.id_parroquia.toString());
    });

    const resultados = await Promise.all(promesas);

    var estadoCounts = {};
    var municipioCounts = {};

    resultados.forEach((ubicacion) => {
        if (ubicacion && ubicacion.municipio && ubicacion.municipio.estado) {
            let estado = ubicacion.municipio.estado.estado;
            let municipio = ubicacion.municipio.municipio;
            estadoCounts[estado] = (estadoCounts[estado] || 0) + 1;
            municipioCounts[municipio] = (municipioCounts[municipio] || 0) + 1;
        }
    });

    var labels = Object.keys(estadoCounts).sort();
    var data = labels.map(e => estadoCounts[e]);

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels.map(estado => estado + " (" + estadoCounts[estado] + ")"),
            datasets: [{
                label: 'Asuntos atendidos por estado',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)', 'rgba(255, 159, 64, 0.8)', 'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)'
                ]
            }]
        },
        plugins: [plugin],
    });
}

$("#nivel-ubicacion").on("change", function () {
    var nivel = $(this).val();

    // Ocultar todos los filtros primero
    $("#estado-filter-wrapper").hide();
    $("#municipio-filter-wrapper").hide();
    $("#actualizar-wrapper").hide();

    // Limpiar y reiniciar selects cuando cambia el nivel
    if (nivel === 'municipio' || nivel === 'parroquia') {
        $("#estado-ubicacion").val(''); // Resetear estado
        $("#municipio-ubicacion").empty().append('<option value="">Seleccione un municipio</option>'); // Resetear municipio
    }

    // Mostrar filtros según el nivel seleccionado
    if (nivel === 'municipio') {
        $("#estado-filter-wrapper").show();
        // Si hay un estado seleccionado (debería estar vacío por el reset), cargar gráfica
        var estadoId = $("#estado-ubicacion").val();
        if (estadoId) {
            generarGraficaPorUbicacion(atendidos, 'municipio', estadoId, plugin);
            $("#actualizar-wrapper").show();
        }
    } else if (nivel === 'parroquia') {
        $("#estado-filter-wrapper").show();
        $("#municipio-filter-wrapper").show();
        // Si hay un municipio seleccionado (debería estar vacío por el reset), cargar gráfica
        var municipioId = $("#municipio-ubicacion").val();
        if (municipioId) {
            generarGraficaPorUbicacion(atendidos, 'parroquia', municipioId, plugin);
            $("#actualizar-wrapper").show();
        }
    } else if (nivel === 'estado') {
        generarGraficaPorUbicacion(atendidos, 'estado', null, plugin);
    }
});

// ========== EVENTO: Cambio de estado ==========
$("#estado-ubicacion").on("change", function () {
    var estadoId = $(this).val();
    var nivel = $("#nivel-ubicacion").val();

    // Si no hay estado seleccionado, limpiar municipio y ocultar actualizar
    if (!estadoId) {
        $("#municipio-ubicacion").empty().append('<option value="">Seleccione un municipio</option>');
        $("#actualizar-wrapper").hide();
        return;
    }

    if (nivel === 'municipio') {
        // Generar gráfica por municipio del estado seleccionado
        generarGraficaPorUbicacion(atendidos, 'municipio', estadoId, plugin);
        $("#actualizar-wrapper").show();
    } else if (nivel === 'parroquia') {
        // Cargar municipios para el estado seleccionado
        $.ajax({
            url: '/obtener-municipios/' + estadoId,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                var $select = $("#municipio-ubicacion");
                $select.empty();
                $select.append('<option value="">Seleccione un municipio</option>');
                data.forEach(function (m) {
                    $select.append('<option value="' + m.id_municipio + '">' + m.municipio + '</option>');
                });

                // Seleccionar automáticamente el primer municipio
                if (data.length > 0) {
                    $select.val(data[0].id_municipio);
                    // Forzar el evento change del municipio
                    $select.trigger('change');
                }
            },
            error: function () {
                console.error('Error al cargar los municipios');
            }
        });
    }
});

// ========== EVENTO: Cambio de municipio ==========
$("#municipio-ubicacion").on("change", function () {
    var municipioId = $(this).val();
    var nivel = $("#nivel-ubicacion").val();

    // Solo ejecutar si estamos en modo parroquia y hay un municipio seleccionado
    if (nivel === 'parroquia' && municipioId) {
        generarGraficaPorUbicacion(atendidos, 'parroquia', municipioId, plugin);
        $("#actualizar-wrapper").show();
    } else if (nivel === 'parroquia' && !municipioId) {
        // Si se deselecciona el municipio, ocultar el botón de actualizar
        $("#actualizar-wrapper").hide();
    }
});

const grafica_cita = document.getElementById('grafica-cita');
var statusCounts = {
    "Atendida": 0,
    "Pendiente": 0,
    "Reagendada": 0,
    "Retrasada": 0
};

citas.forEach(cita => {
    var status = cita.status;
    if (status in statusCounts) {
        statusCounts[status]++;
    } else {
        statusCounts[status] = 1;
    }
});

new Chart(grafica_cita, {
    type: 'bar',
    data: {
        labels: Object.keys(statusCounts).map(status => status + " (" + statusCounts[status] + ")"),
        datasets: [{
            label: 'Status de citas',
            data: Object.values(statusCounts),
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ]
        }]
    },
    plugins: [plugin],
});

generarGraficaPorComuna(atendidos, tipo, plugin);

async function generarGraficaPorComuna(atendidos, tipo, plugin) {
    const grafica_comuna = document.getElementById('grafica-comuna');
    var proveniencia = {
        "Comunas": comunas,
        "Circuitos comunales": circuitos,
        "Sin conocimiento": sin_conocimiento
    }

    new Chart(grafica_comuna, {
        type: 'bar',
        data: {
            labels: Object.keys(proveniencia).map(key => key + " (" + proveniencia[key] + ")"),
            datasets: [{
                label: 'Personas pertenecientes a Comunas o Circuitos Comunales',
                data: Object.values(proveniencia),
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ]
            }]
        },
        plugins: [plugin],
    });

    console.log("Gráfica de comunas dibujada con los datos finales.");
}

$("#inicio").on("change", function () {
    var dia_inicio = $("#inicio").val()
    var dia_fin = $("#fin").val()
    window.location.href = "/grafica?inicio=" + dia_inicio + "&fin=" + dia_fin + "&ver=" + tipo
})

$("#fin").on("change", function () {
    var dia_inicio = $("#inicio").val()
    var dia_fin = $("#fin").val()
    window.location.href = "/grafica?inicio=" + dia_inicio + "&fin=" + dia_fin + "&ver=" + tipo
})