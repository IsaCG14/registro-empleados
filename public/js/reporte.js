//Descargar pdf
$(".generarPdf").on("click", function() {
    //Obtener canvas
    var canvas = $(this).parent().find("canvas").attr("id")
    const grafica = document.getElementById(canvas)
    //crear imagen
    const pdfImage = grafica.toDataURL('image/jpeg', 1.0)
    //imagen a pdf
    let pdf = new jsPDF('landscape')
    //Añadir titulo y descripcion 
    pdf.setFontSize(20)
    var title = $(this).parent().find("h5").text()

    pdf.text(title, 10, 10)

    // Escalar la imagen al 400%
    const imgWidth = grafica.width * 4; // 400% del ancho
    const imgHeight = grafica.height * 4; // 400% de la altura

    pdf.addImage(pdfImage, 'JPEG', 15, 15, 270, 150)

    if (title.includes("asunto")) {
        var userId = $("#user").val();
        var userName = $("#user option:selected").text();
        if (userId != 0) {
            pdf.text("Usuario: " + userName, 10, 170)
        } else {
            pdf.text("Usuario: General", 10, 170)
        }
    }

    pdf.setProperties({
        title: "Report"
    });

    pdf.output('dataurlnewwindow');
})

//Descargar pdf
$("#generarPdfGeneral").on("click", function(e) {
    e.preventDefault();
    let heightText = 10
    let heightGrafica = 15
    let heightTotal = 200
    let pdf = new jsPDF('p', 'mm', [1400, 300])

    $("canvas").each(function(index) {
        var canvas = $(this).attr("id")
        var grafica = document.getElementById(canvas)
        var pdfImage = grafica.toDataURL("image/jpeg", 1.0)

        pdf.setFontSize(20)
        var title = $(this).parent().find("h5").text()
        title += " - Registrados entre " + dia_inicio + " y " + dia_fin

        pdf.text(title, 10, heightText)

        pdf.addImage(pdfImage, 'JPEG', 15, heightGrafica, 270, 150)

        if (title.includes("asunto")) {
            var userId = $("#user").val();
            var userName = $("#user option:selected").text();
            if (userId != 0) {
                pdf.text("Usuario: " + userName, 10, heightGrafica + 160)
            } else {
                pdf.text("Usuario: General", 10, heightGrafica + 160)
            }
        }

        heightText += 200
        heightGrafica += 200
    })
    pdf.output('dataurlnewwindow')
})