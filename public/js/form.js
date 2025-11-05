const estado_select = $("#estado")
const municipio_select = $("#municipio")
const parroquia_select = $("#parroquia")

estado_select.on("change", function(){
    var id_estado = estado_select.val()
    $.ajax({
        url: '/obtener-municipios/' + id_estado,
        type: 'GET',
        success: function(data){
            //console.log(data);
            //Eliminar lista anterior
            municipio_select.html("")
            //Añadir nueva lista
            data.forEach(element => {
                municipio_select.append("<option value='"+element.id_municipio+"'>"+element.municipio+"</option>")
            });
        },
        error: function(xhr, status, error) {
            console.log(error)
        }
    })
})

municipio_select.on("change", function(){
    var id_municipio = municipio_select.val()
    $.ajax({
        url: '/obtener-parroquias/' + id_municipio,
        type: 'GET',
        success: function(data){
            //console.log(data);
            //Eliminar lista anterior
            parroquia_select.html("")
            //Añadir nueva lista
            data.forEach(element => {
                parroquia_select.append("<option value='"+element.id_parroquia+"'>"+element.parroquia+"</option>")
            });
        },
        error: function(xhr, status, error) {
            console.log(error)
        }
    })
})

//Funcion al seleccionar dia
$("#dia").on("change", function(){
    var dia = $("#dia").val()
    //Redirigir a la misma pagina con el parametro dia
    window.location.href = "/grafica?dia=" + dia
})