const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons span");

const fechaSeleccionada = document.getElementById("fecha-seleccionada");
const horaSeleccionada = document.getElementById("hora-seleccionada");

console.log("Citas cargadas:", citas);

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

            // mostrar fecha seleccionada
            //Formatear fecha a DD/MM/YYYY
            // const [year, month, day] = selectedDay.split("-");
            // const formattedDate = `${day}/${month}/${year}`;
            fechaSeleccionada.value = selectedDay;
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
    const asuntoId = (typeof asunto !== "undefined" && asunto && asunto.id) ? String(asunto.id) : null;

    // asegurarse de que el calendario está renderizado (li existen)
    const lis = daysTag.querySelectorAll("li");
    if (!lis || lis.length === 0) return;

    // primero quitar marcas previas
    lis.forEach(li => {
        li.classList.remove("ocupado", "selected");
        // restaurar manejador por si fue removido (re-render attachDayHandlers ya lo hace, esto es por seguridad)
    });

    for (let cita of citas) {
        const fechaCita = String(cita.fecha_cita);
        // si la cita pertenece al asunto actual, marcar como seleccionada
        if (asuntoId !== null && String(cita.id_atencion) === asuntoId) {
            selectedDay = fechaCita;
            if (fechaSeleccionada) fechaSeleccionada.value = fechaCita;
            if (horaSeleccionada) horaSeleccionada.value = cita.hora_cita || "";
            // marcar visiblemente en los li actuales (si existe)
            const li = daysTag.querySelector(`li[data-date="${fechaCita}"]`);
            if (li) li.classList.add("selected");
            // no break: puede haber solo una, pero dejamos que marque todas coincidencias si las hay
        } else {
            // marcar como ocupado si la fecha está en el mes visible
            const li = daysTag.querySelector(`li[data-date="${fechaCita}"]`);
            if (li) {
                li.classList.add("ocupado"); // usar string, no array
                li.onclick = null;
            }
        }
    }
}

window.addEventListener("load", () => {
    marcarFechaSeleccionada();
});
