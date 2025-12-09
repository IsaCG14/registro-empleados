function ubicacion_persona_promesa(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/api/parroquia/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Si tiene éxito, resolvemos (devolvemos) los datos
                resolve(data);
            },
            error: function(error) {
                console.error('Error al obtener la ubicación:', error);
                // Si falla, resolvemos con null para manejarlo en el bucle
                resolve(null); 
            }
        });
    });
}

//Obtener tipo de grafica
const url = new URLSearchParams(window.location.search)

var tipo = (url.get("tipo") == null) ? 'pie' : url.get("tipo");

//Llenar select de usuarios
var usuarios = {};
citas.forEach(cita => {
    var usuario = cita.usuarios;
    if (!(usuario.name in usuarios)) {
        usuarios[usuario.name] = true;
        $("#user").append(`<option value="${usuario.id}">${usuario.name}</option>`);
    }
});
//Obtener id del option seleccionado
$("#user").on("change", function() {
    var userId = $(this).val();
    //Mostrar solo asuntos registrados por ese usuario
    var asuntoCounts = {};
    citas.forEach(cita => {
        if (cita.usuarios.id == userId) {
            var asuntos = cita.asuntos;
            asuntos.forEach(asunto => {
                var opcion = asunto.patria.opciones;
                if (opcion in asuntoCounts) {
                    asuntoCounts[opcion]++;
                } else {
                    asuntoCounts[opcion] = 1;
                }
            });
        } else if (userId == 0) {
            var asuntos = cita.asuntos;
            asuntos.forEach(asunto => {
                var opcion = asunto.patria.opciones;
                if (opcion in asuntoCounts) {
                    asuntoCounts[opcion]++;
                } else {
                    asuntoCounts[opcion] = 1;
                }
            })
        }
    });

    //Destruir grafica anterior
    Chart.getChart("grafica-asunto")?.destroy();
    //Actualizar grafica
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
})

var num_f = 0
var num_m = 0

//Grafica por edades
var rango1 = 0
var rango2 = 0
var rango3 = 0
var rango4 = 0
var rango5 = 0

//Grafica por asuntos
var asuntoCounts = {};

citas.forEach(cita => {
    //valorar genero
    // console.log(cita.personas.sexo)
    if (cita.personas.sexo == 1) {
        num_m++
    } else {
        num_f++
    }

    //valorar edades

    //Calcular edad
    var fecha_actual = new Date();
    var fecha_nac = new Date(cita.personas.fecha_nacimiento);
    var edad = fecha_actual - fecha_nac;
    var anios = edad / (1000 * 60 * 60 * 24 * 365.25);
    edad = Math.floor(anios)

    //console.log(edad)

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
    //valorar asuntos
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
//Grafica por sexo
const grafica_sexo = document.getElementById('grafica-sexo');
new Chart(grafica_sexo, {
    type: tipo,
    data: {
        labels: ['Masculino: ' + String(num_m), 'Femenino: ' + String(num_f)],
        datasets: [{
            label: '# personas',
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

//Grafica por edades 
new Chart(grafica_edad, {
    type: tipo,
    data: {
        labels: ["18 a 24 (" + rango1 + ")", "25 a 30 (" + rango2 + ")", "31 a 45 (" + rango3 + ")",
            "46 a 55 (" + rango4 + ")", "56+ (" + rango5 + ")"
        ],
        datasets: [{
            label: 'Personas entre rango de edad',
            data: [rango1, rango2, rango3, rango4, rango5],
            bacgroundColor: [
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

const grafica_asunto = document.getElementById('grafica-asunto');
//Grafica por asuntos
new Chart(grafica_asunto, {
    type: "bar",
    data: {
        labels: Object.keys(asuntoCounts).map(asunto => asunto + " (" + asuntoCounts[asunto] + ")"),
        datasets: [{
            label: 'Asuntos atendidos',
            data: Object.values(asuntoCounts),
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(201, 203, 207, 0.8)'
            ]
        }]
    },
    plugins: [plugin],
})

const grafica_sexo_usuario = document.getElementById('grafica-sexo-usuario');
//Grafica por sexo registrado por usuario dividido por femenino y masculino en doble barra
var usuarioLabels = {};
citas.forEach(cita => {
    var usuario = cita.usuarios.name;
    if (!(usuario in usuarioLabels)) {
        usuarioLabels[usuario] = {
            male: 0,
            female: 0
        };
    }
    if (cita.personas.sexo == 1) {
        usuarioLabels[usuario].male++;
    } else {
        usuarioLabels[usuario].female++;
    }
});
new Chart(grafica_sexo_usuario, {
    type: 'bar',
    data: {
        labels: Object.keys(usuarioLabels),
        datasets: [{
                label: 'Masculino',
                data: Object.values(usuarioLabels).map(data => data.male),
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
            },
            {
                label: 'Femenino',
                data: Object.values(usuarioLabels).map(data => data.female),
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
            }
        ]
    },
    plugins: [plugin],
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

async function generarGraficaPorEstado(citas, tipo, plugin) {
    const grafica_estado = document.getElementById('grafica-estado');
    var estadoCounts = {};

    // Crear un array de Promesas
    // Mapeamos cada cita a una llamada a la función Promesa
    const promesas = citas.map(cita => {
        return ubicacion_persona_promesa(cita.personas.id_parroquia.toString());
    });

    // Esperar que TODAS las promesas se resuelvan
    // El array 'resultados' tendrá el resultado de cada llamada AJAX
    const resultados = await Promise.all(promesas);

    // Procesar los resultados una vez que TODOS hayan llegado
    resultados.forEach((ubicacion) => {
        let estado = null;

        // Comprobación de seguridad
        if (ubicacion && ubicacion.municipio && ubicacion.municipio.estado) {
            estado = ubicacion.municipio.estado.estado;
        } else {
            // Si falla la búsqueda, usamos un valor por defecto o un placeholder
            estado = "Desconocido"; 
        }

        // Contar los estados
        if (estado in estadoCounts) {
            estadoCounts[estado]++;
        } else {
            estadoCounts[estado] = 1;
        }
    });

    // Dibujar la Gráfica con los datos finales
    new Chart(grafica_estado, {
        type: tipo,
        data: {
            labels: Object.keys(estadoCounts).map(estado => estado + " (" + estadoCounts[estado] + ")"),
            datasets: [{
                label: 'Proveniencia de personas por estado',
                data: Object.values(estadoCounts),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)', 'rgba(255, 159, 64, 0.8)', 'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)'
                ]
            }]
        },
        plugins: [plugin],
    });
    
    console.log("Gráfica dibujada con los datos finales.");
}

// Llama a la nueva función
// Asegúrate de que 'tipo' y 'plugin' están definidos
generarGraficaPorEstado(citas, tipo, plugin);

async function generarGraficaPorMunicipio(citas, tipo, plugin) {
    const grafica_municipio = document.getElementById('grafica-municipio');
    var municipioCounts = {};
    var estado = $("#estado-municipio").val();

    // Crear un array de Promesas
    const promesas = citas.map(cita => {
        return ubicacion_persona_promesa(cita.personas.id_parroquia.toString());
    });

    // Esperar que TODAS las promesas se resuelvan
    const resultados = await Promise.all(promesas);

    // Procesar los resultados
    resultados.forEach((ubicacion) => {
        let municipio = null;

        if (ubicacion && ubicacion.municipio) {
            municipio = ubicacion.municipio.municipio;
        } else {
            municipio = "Desconocido"; 
        }

        if (municipio in municipioCounts) {
            //Solo incluir municipios del estado seleccionado
            if (ubicacion.municipio.estado.id_estado.toString() === estado) {
                municipioCounts[municipio]++;
            }
        } else {
            if (ubicacion.municipio.estado.id_estado.toString() === estado) {
                municipioCounts[municipio] = 1;
            }
        }
    });

    // Dibujar la Gráfica
    new Chart(grafica_municipio, {
        type: tipo,
        data: {
            labels: Object.keys(municipioCounts).map(municipio => municipio + " (" + municipioCounts[municipio] + ")"),
            datasets: [{
                label: 'Proveniencia de personas por municipio',
                data: Object.values(municipioCounts),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)', 'rgba(255, 159, 64, 0.8)', 'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)'
                ]
            }]
        },
        plugins: [plugin],
    });
    
    console.log("Gráfica de municipios dibujada con los datos finales.");
}

// Llama a la nueva función
generarGraficaPorMunicipio(citas, tipo, plugin);
//Llamar al cambiar el estado
$("#estado-municipio").on("change", function() {
    //Destruir grafica anterior
    Chart.getChart("grafica-municipio")?.destroy();
    //Generar nueva grafica
    generarGraficaPorMunicipio(citas, tipo, plugin);
});

async function generarGraficaPorParroquia(citas, tipo, plugin) {
    const grafica_parroquia = document.getElementById('grafica-parroquia');
    var parroquiaCounts = {};
    var municipio = $("#municipio").val();

    const promesas = citas.map(cita => {
        return ubicacion_persona_promesa(cita.personas.id_parroquia.toString());
    });

    const resultados = await Promise.all(promesas);

    resultados.forEach((ubicacion) => {
        let parroquia = null;

        if (ubicacion && ubicacion.parroquia) {
            parroquia = ubicacion.parroquia;
        } else {
            parroquia = "Desconocido"; 
        }

        if (parroquia in parroquiaCounts) {
            //Solo incluir parroquias del municipio seleccionado
            if (ubicacion.municipio.id_municipio.toString() === municipio) {
                parroquiaCounts[parroquia]++;
            }
        } else {
            if (ubicacion.municipio.id_municipio.toString() === municipio) {
                parroquiaCounts[parroquia] = 1;
            }
        }
    });

    new Chart(grafica_parroquia, {
        type: tipo,
        data: {
            labels: Object.keys(parroquiaCounts).map(parroquia => parroquia + " (" + parroquiaCounts[parroquia] + ")"),
            datasets: [{
                label: 'Proveniencia de personas por parroquia',
                data: Object.values(parroquiaCounts),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)', 'rgba(255, 159, 64, 0.8)', 'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)'
                ]
            }]
        },
        plugins: [plugin],
    });
    
    console.log("Gráfica de parroquias dibujada con los datos finales.");
}

generarGraficaPorParroquia(citas, tipo, plugin);
//Llamar al cambiar el municipio
$("#municipio").on("change", function() {
    //Destruir grafica anterior
    Chart.getChart("grafica-parroquia")?.destroy();
    //Generar nueva grafica
    generarGraficaPorParroquia(citas, tipo, plugin);
});

//Funcion al seleccionar dia inicio y fin
$("#inicio").on("change", function(){
    var dia_inicio = $("#inicio").val()
    var dia_fin = $("#fin").val()
    //Redirigir a la misma pagina con el parametro dia
    window.location.href = "/grafica?inicio=" + dia_inicio + "&fin=" + dia_fin
})

$("#fin").on("change", function(){
    var dia_inicio = $("#inicio").val()
    var dia_fin = $("#fin").val()
    //Redirigir a la misma pagina con el parametro dia
    window.location.href = "/grafica?inicio=" + dia_inicio + "&fin=" + dia_fin
})