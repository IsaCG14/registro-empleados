//Funcion al seleccionar dia inicio y fin
$("#inicio_cita").on("change", function(){
    var dia_inicio = $("#inicio_cita").val()
    var dia_fin = $("#fin_cita").val()
    //Redirigir a la misma pagina con el parametro dia
    window.location.href = "/citas?inicio=" + dia_inicio + "&fin=" + dia_fin
})

$("#fin_cita").on("change", function(){
    var dia_inicio = $("#inicio_cita").val()
    var dia_fin = $("#fin_cita").val()
    //Redirigir a la misma pagina con el parametro dia
    window.location.href = "/citas?inicio=" + dia_inicio + "&fin=" + dia_fin
})