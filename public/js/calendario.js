const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons span");
const ocupadosArray = [];

const fechaSeleccionada = document.getElementById("fecha-seleccionada");
const horaSeleccionada = document.getElementById("hora-seleccionada");
//console.log("Citas cargadas:", citas);

//Funciones
function formatearHora(hora) {
    const fechaFicticia = new Date(`1970-01-01T${hora}`);

    const horaNormal = fechaFicticia.toLocaleTimeString("en-US", {
        hour: "numeric",
        minute: "2-digit",
        hour12: true,
    });
    return horaNormal;
}

function obtenerCitasMes(mes, anio) {
    fetch(`/api/citas-mes/${anio}-${mes}`)
        .then((response) => response.json())
        .then((data) => {
            //Llenar array de fechas ocupadas
            console.log("Citas del mes obtenidas:", data);
            return data;
        })
        .catch((error) => console.error("Error:", error));
}

function obtenerCitasPorFecha(fecha) {
    fetch(`/api/citas/${fecha}`)
        .then((response) => response.json())
        .then((data) => {
            //Si hay datos llenar tabla
            const tablaCitas = document.getElementById("tabla-citas");
            const horasOcupadas = [];

            // Poner hora automaticamente segun las citas ocupadas (excepto si ya hay una seleccionada)
            
                data.forEach((cita) => {
                    horasOcupadas.push(cita.hora_cita.slice(0, 5));
                });

                if (Array.isArray(horasOcupadas) && horasOcupadas.length > 0) {
                    // Ordenar horas y obtener la última
                    horasOcupadas.sort();
                    const ultimaHora = horasOcupadas[horasOcupadas.length - 1];
                    const [horasParte, minutosParte] = ultimaHora
                        .split(":")
                        .map(Number);
                    let nuevaHora = new Date();
                    nuevaHora.setHours(horasParte, minutosParte + 10, 0, 0);

                    // Formatear a HH:MM
                    const horaFormateada = nuevaHora.toTimeString().slice(0, 5);
                    if (horaFormateada == "12:00") {
                        horaSeleccionada.value = "13:00"; // Saltar a la una
                    } else {
                        horaSeleccionada.value = horaFormateada;
                    }
                } else {
                    horaSeleccionada.value = "08:00"; // Primera hora disponible
                }
            

            //Limpiar cuerpo de tabla
            tablaCitas.innerHTML = "";

            if (data.length > 0) {
                data.forEach((cita) => {
                    const fila = document.createElement("tr");
                    if (cita.status === "Reagendada") {
                        var badgeClass = "warning text-dark";
                    } else if (cita.status === "Pendiente") {
                        var badgeClass = "secondary";
                    } else if (cita.status === "Atendida") {
                        var badgeClass = "success";
                    } else if (cita.status === "Retrasada") {
                        var badgeClass = "danger";
                    }
                    let asuntos = "";
                    for (let asunto of cita.atendidos.asuntos) {
                        asuntos += asunto.patria.opciones + ", ";
                    }

                    fila.innerHTML = `
                    <td>${cita.atendidos.personas.cedula}</td>
                    <td>${cita.atendidos.personas.nombre}</td>
                    <td>${asuntos}</td>
                    <td>${formatearHora(cita.hora_cita)}</td>
                    <td><span class="badge bg-${badgeClass}">${
                        cita.status
                    }</span></td>
                    `;
                    tablaCitas.appendChild(fila);
                });
            } else {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                <td colspan="4">No hay citas para esta fecha.</td>
            `;
                tablaCitas.appendChild(fila);
            }
        })
        .catch((error) => console.error("Error:", error));
}

function formatearFecha(fecha) {
    const year = fecha.getUTCFullYear();
    const month = fecha.getUTCMonth(); // 0-11
    const day = fecha.getUTCDate();
    const formateadorMes = new Intl.DateTimeFormat("es-ES", {
        month: "long",
        timeZone: "UTC",
    });

    const fechaTemporal = new Date(Date.UTC(year, month, 1));

    const mes = formateadorMes.format(fechaTemporal);

    return `${day} de ${mes} de ${year}`;
}

function esHoraOcupada() {
    const selectedDate = fechaSeleccionada.value;
    const selectedTime = horaSeleccionada.value.slice(0, 5);

    if (!selectedDate || !selectedTime) return;

    // Verificar si ya existe una cita con la misma fecha y hora
    const citaExistente = citas.find(
        (cita) =>
            // console.log("Verificando cita para:", cita.hora_cita, selectedTime)
            cita.fecha_cita === selectedDate &&
            cita.hora_cita.slice(0, 5) === selectedTime
    );

    if (citaExistente) {
        horaSeleccionada.style.borderColor = "red";
        const errorSpan = document.querySelector(".error-hora");
        errorSpan.textContent = "Hora ocupada. Por favor, elija otra hora.";
        errorSpan.style.color = "red";
        horaSeleccionada.value = ""; // Limpiar la selección de hora
    } else {
        horaSeleccionada.style.borderColor = "";
        const errorSpan = document.querySelector(".error-hora");
        errorSpan.textContent = "";
    }
}

// getting new date, current year and month
let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

// storing full name of all months in array
const months = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
];

// conjunto para guardar días seleccionados en formato YYYY-MM-DD
let selectedDay = null;

// helper: pad números a 2 dígitos
function pad(n) {
    return n.toString().padStart(2, "0");
}

function dateString(y, m, d) {
    return `${y}-${pad(m)}-${pad(d)}`;
}

// inyectar estilo para días seleccionados (azul oscuro)
(function injectSelectedStyle() {
    const style = document.createElement("style");
    //Aplicar estilos sin alterar los demas li
    style.textContent = `
        .days li { cursor: pointer; }
        .days li.selected::before {
            background: #4285f4 !important;
            height: 40px;
            width: 40px;
            text-align: center;
            border-radius: 50%;
            z-index: -1;
        }
    `;
    document.head.appendChild(style);
})();

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
        lastDayofMonth = new Date(
            currYear,
            currMonth,
            lastDateofMonth
        ).getDay(), // getting last day of month
        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    let liTag = "";

    // previous month days (inactive)
    for (let i = firstDayofMonth; i > 0; i--) {
        const day = lastDateofLastMonth - i + 1;
        // calcular fecha del día previo
        const prevMonth = currMonth === 0 ? 12 : currMonth;
        const prevYear = currMonth === 0 ? currYear - 1 : currYear;
        const dateAttr = dateString(prevYear, prevMonth, day);
        liTag += `<li class="inactive" data-date="${dateAttr}">${day}</li>`;
    }

    // current month days
    for (let i = 1; i <= lastDateofMonth; i++) {
        let isToday =
            i === date.getDate() &&
            currMonth === new Date().getMonth() &&
            currYear === new Date().getFullYear()
                ? "active"
                : "";
        const dateAttr = dateString(currYear, currMonth + 1, i);
        liTag += `<li class="${isToday}" data-date="${dateAttr}">${i}</li>`;
    }

    // next month days (inactive)
    for (let i = lastDayofMonth; i < 6; i++) {
        const day = i - lastDayofMonth + 1;
        const nextMonth = currMonth === 11 ? 1 : currMonth + 2;
        const nextYear = currMonth === 11 ? currYear + 1 : currYear;
        const dateAttr = dateString(nextYear, nextMonth, day);
        liTag += `<li class="inactive" data-date="${dateAttr}">${day}</li>`;
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
    daysTag.innerHTML = liTag;

    // aplicar clases selected según el conjunto y añadir manejadores de clic
    attachDayHandlers();
};
renderCalendar();

function attachDayHandlers() {
    const lis = daysTag.querySelectorAll("li");
    lis.forEach((li) => {
        const d = li.getAttribute("data-date");

        // marcar si es el seleccionado
        if (selectedDay === d) {
            li.classList.add("selected");
        } else {
            li.classList.remove("selected");
        }

        //No poder seleccionar jueves, sabados y domingos
        const dayOfWeek = new Date(d).getDay();
        if (dayOfWeek === 6 || dayOfWeek === 3 || dayOfWeek === 5) {
            li.onclick = null; // eliminar manejador de clic
            li.style.cursor = "not-allowed";
            li.style.color = "#ccc";
            return; // no añadir manejador
        }

        // solo permitir seleccionar días del mes actual (sin clase inactive)
        li.onclick = function () {
            if (li.classList.contains("inactive")) return;

            // Mostrar citas de ese dia en la tabla
            const fecha = li.getAttribute("data-date");

            // Obtener registros de la cita
            const title = document.getElementById("titulo-cita");
            //Formatear fecha para mostrar
            title.innerText = formatearFecha(new Date(fecha));
            //Llenar tabla de citas y obtener horas ocupadas
            obtenerCitasPorFecha(fecha);

            if (!li.classList.contains("ocupado")) {
                if (selectedDay === d) {
                    // deseleccionar mismo día
                    li.classList.remove("selected");
                    selectedDay = null;
                } else {
                    // quitar selección anterior y marcar la nueva
                    const prev = daysTag.querySelector("li.selected");
                    if (prev) prev.classList.remove("selected");
                    li.classList.add("selected");
                    selectedDay = d;
                }

                fechaSeleccionada.value = selectedDay;
            }
        };
    });
}

prevNextIcon.forEach((icon) => {
    // getting prev and next icons
    icon.addEventListener("click", () => {
        // adding click event on both icons
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if (currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear();
            currMonth = date.getMonth();
        } else {
            date = new Date();
        }

        // renderizar calendario actualizado y luego marcar fechas ocupadas/seleccionadas
        renderCalendar();
        marcarFechaSeleccionada();
    });
});

//Marcar la fecha seleccionada si ya existe una cita programada
function marcarFechaSeleccionada() {
    // obtener id de asunto de forma segura (puede ser undefined)
    const asuntoId =
        typeof asunto !== "undefined" && asunto && asunto.id
            ? String(asunto.id)
            : null;

    // asegurarse de que el calendario está renderizado (li existen)
    const lis = daysTag.querySelectorAll("li");
    if (!lis || lis.length === 0) return;

    // primero quitar marcas previas
    lis.forEach((li) => {
        li.classList.remove("ocupado", "selected");
    });

    // usar array local para evitar acumulación entre llamadas
    const ocupadosLocal = [];

    //Obtener mes actual mostrado
    const mesActual = currMonth + 1; // Ajustar a 1-12

    //Obtener citas del mes actual
    //const citasRegistradas = obtenerCitasMes(mesActual, currYear);

    // Recorrer citas registradas para marcar ocupados y seleccionados
    for (let cita of citasRegistradas) {
        const fechaCita = String(cita.fecha_cita);
        // si la cita pertenece al asunto actual, marcar como seleccionada
        if (asuntoId !== null && String(cita.id_atencion) === asuntoId) {
            selectedDay = fechaCita;
            if (fechaSeleccionada) fechaSeleccionada.value = fechaCita;
            if (horaSeleccionada) horaSeleccionada.value = cita.hora_cita || "";
            const li = daysTag.querySelector(`li[data-date="${fechaCita}"]`);
            if (li) li.classList.add("selected");
        } else {
            ocupadosLocal.push(fechaCita);
        }
    }

    // Contar cuantas citas hay por fecha (usando el array local)
    const conteoFechas = {};
    for (let fecha of ocupadosLocal) {
        conteoFechas[fecha] = (conteoFechas[fecha] || 0) + 1;
    }

    // Marcar fechas ocupadas sólo si tienen 60 o más citas
    for (let fecha in conteoFechas) {
        const li = daysTag.querySelector(`li[data-date="${fecha}"]`);
        if (li && conteoFechas[fecha] >= 60) {
            li.classList.add("ocupado");
        }
    }
}

//No registrar hora de cita repetida
const hora = document.getElementById("hora-seleccionada");
hora.addEventListener("change", esHoraOcupada);

// Al cargar la página, obtener citas del día actual y marcar fecha seleccionada
window.addEventListener("load", () => {
    //obtenerCitasPorFecha(new Date().toISOString().split("T")[0]);
    marcarFechaSeleccionada();
});
