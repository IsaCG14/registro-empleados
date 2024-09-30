/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/JavaScript.js to edit this template
 */

$(document).ready(function (){
    //datatable
    var table = $(".table-striped").DataTable({
        "language" : {
            "info" : "Mostrando _PAGE_ de _PAGES_ entradas",
            "sSearch" : "Buscar:",
            "paginate" : {
                "first" : "Primero",
                "last" : "Último",
                "next" : "Siguiente",
                "previous" : "Anterior"
            },
            "lengthMenu": "Mostrar _MENU_ Entradas"
        },
        "ordering" : false,
        "lengthMenu": [25, 50, 75, 100]
    })
})
