/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/JavaScript.js to edit this template
 */


//Edicion de empleado
if (new URLSearchParams(window.location.search).get("editado") == 1) {
    Swal.fire({
        position: "bottom-end",
        icon: "success",
        title: "\xA1Actualizado!",
        text: "Los datos del empleado se han actualizado.",
        showConfirmButton: false,
        timer: 5000
    })
}

//Eliminacion de empleado
$(".eliminar-empleado").on("click", function (e) {
    e.preventDefault();
    const href = $(this).attr("href");

    Swal.fire({
        title: "\xBFSeguro?",
        text: "El empleado ser\u00e1 eliminado.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "\xA1Empleado eliminado!",
                text: "El empleado fue eliminado de la base de datos.",
                icon: "success"
            }).then(() => {
                document.location.href = href;
            })
        }
    })
})