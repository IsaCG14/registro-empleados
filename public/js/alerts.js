/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/JavaScript.js to edit this template
 */


//Edicion de persona
if (new URLSearchParams(window.location.search).get("editado") == 1) {
    Swal.fire({
        position: "bottom-end",
        icon: "success",
        title: "\xA1Actualizado!",
        text: "Los datos de la persona se han actualizado.",
        showConfirmButton: false,
        timer: 5000
    })
}

//Registro de persona
if (new URLSearchParams(window.location.search).get("registrado") == 1) {
    Swal.fire({
        position: "bottom-end",
        icon: "success",
        title: "\xA1Registrado!",
        text: "Los datos de la persona fueron registrados exitosamente.",
        showConfirmButton: false,
        timer: 5000
    })
}

//Eliminacion de empleado
$(".eliminar-persona").on("click", function (e) {
    e.preventDefault();
    const href = $(this).attr("href");

    Swal.fire({
        title: "\xBFSeguro?",
        text: "Toda la información del asunto ser\u00e1 eliminado.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "\xA1Asunto eliminado!",
                text: "El asunto fue eliminado de la base de datos.",
                icon: "success"
            }).then(() => {
                document.location.href = href;
            })
        }
    })
})

//Eliminacion de usuario
$(".eliminar-usuario").on("click", function (e) {
    e.preventDefault();
    const href = $(this).attr("href");

    Swal.fire({
        title: "\xBFSeguro?",
        text: "El usuario ser\u00e1 desactivado.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Desactivar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "\xA1Usuario eliminado!",
                text: "El usuario fue desactivado.",
                icon: "success"
            }).then(() => {
                document.location.href = href;
            })
        }
    })
})

//Eliminacion de usuario
$(".eliminar-cita").on("click", function (e) {
    e.preventDefault();
    const href = $(this).attr("href");

    Swal.fire({
        title: "\xBFSeguro?",
        text: "La cita ser\u00e1 cancelada.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "\xA1Cita cancelada!",
                text: "La cita fue cancelada.",
                icon: "success"
            }).then(() => {
                document.location.href = href;
            })
        }
    })
})
               