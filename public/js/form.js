const estado_select = $("#estado")
const municipio_select = $("#municipio")
const parroquia_select = $("#parroquia")

//Funcion para obtener municipios y parroquias
function obtener_municipios_parroquias(select, tipo){
    var id = select.val()
    var url = ''
    if(tipo === 'estado'){
        url = '/obtener-municipios/' + id
    } else if(tipo === 'municipio'){
        url = '/obtener-parroquias/' + id
    }
    $.ajax({
        url: url,
        type: 'GET',
        success: function(data){
            //Eliminar lista anterior
            if(tipo === 'estado'){
                municipio_select.html("")
            } else if(tipo === 'municipio'){
                parroquia_select.html("")
            }
            //Añadir nueva lista
            data.forEach(element => {
                if(tipo === 'estado'){
                    municipio_select.append("<option value='"+element.id_municipio+"'>"+element.municipio+"</option>")
                } else if(tipo === 'municipio'){
                    parroquia_select.append("<option value='"+element.id_parroquia+"'>"+element.parroquia+"</option>")
                }
            });
        },
        error: function(xhr, status, error) {
            console.log(error)
        }
    })
}

estado_select.on("change", function() {
    obtener_municipios_parroquias(estado_select, 'estado')
})
municipio_select.on("change", function(){
    obtener_municipios_parroquias(municipio_select, 'municipio')
})

//Cargar municipios y parroquias al hacer click en el select
estado_select.on("click", function() {
    obtener_municipios_parroquias(estado_select, 'estado')
})
municipio_select.on("click", function(){
    obtener_municipios_parroquias(municipio_select, 'municipio')
})

