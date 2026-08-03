//Descargar pdf individual (una grafica por hoja A4)
$(".generarPdf").on("click", function() {
    var canvas = $(this).parent().find("canvas").attr("id")
    const grafica = document.getElementById(canvas)
    const pdfImage = grafica.toDataURL('image/jpeg', 1.0)
    let pdf = new jsPDF('landscape', 'mm', 'a4')
    pdf.setFontSize(20)
    var title = $(this).parent().find("h5").text()
    title += " - " + dia_inicio + " a " + dia_fin

    pdf.text(title, 10, 10)

    pdf.addImage(pdfImage, 'JPEG', 15, 15, 270, 150)

    if (title.includes("Gráfica de asuntos atendidos por usuario")) {
            var userId = $("#user").val();
            var userName = $("#user option:selected").text();
            if (userId != 0) {
                pdf.text("Usuario: " + userName, 10, 170)
            } else {
                pdf.text("Usuario: General", 10, 170)
            }
        } else if (title.includes("municipio")) {
            var estadoId = $("#estado-municipio").val();
            var estadoName = $("#estado-municipio option:selected").text();
            pdf.text("Estado: " + estadoName, 10, 170)
        } else if (title.includes("parroquia")) {
            var estadoId = $("#estado").val();
            var estadoName = $("#estado option:selected").text();
            pdf.text("Estado: " + estadoName, 10, 170)
            var municipioId = $("#municipio").val();
            var municipioName = $("#municipio option:selected").text();
            pdf.text("Municipio: " + municipioName, 10, 180)
        }

    pdf.setProperties({
        title: "Report"
    });

    const blob = pdf.output('blob');
    const url = URL.createObjectURL(blob);
    window.open(url, '_blank');
})

//Descargar pdf general (una grafica por hoja A4)
$("#generarPdfGeneral").on("click", function(e) {
    e.preventDefault();
    let pdf = new jsPDF('landscape', 'mm', 'a4')
    let firstPage = true;

    $("canvas").each(function(index) {
        if (!firstPage) {
            pdf.addPage();
        }
        firstPage = false;

        var canvas = $(this).attr("id")
        var grafica = document.getElementById(canvas)
        var pdfImage = grafica.toDataURL("image/jpeg", 1.0)

        pdf.setFontSize(20)
        var title = $(this).parent().find("h5").text()
        title += " - " + dia_inicio + " y " + dia_fin

        pdf.text(title, 10, 15)
        pdf.addImage(pdfImage, 'JPEG', 15, 25, 270, 150)

        if (title.includes("Gráfica de asuntos atendidos por usuario")) {
            var userId = $("#user").val();
            var userName = $("#user option:selected").text();
            if (userId != 0) {
                pdf.text("Usuario: " + userName, 10, 185)
            } else {
                pdf.text("Usuario: General", 10, 185)
            }
        } else if (title.includes("municipio")) {
            var estadoId = $("#estado-municipio").val();
            var estadoName = $("#estado-municipio option:selected").text();
            pdf.text("Estado: " + estadoName, 10, 185)
        } else if (title.includes("parroquia")) {
            var estadoId = $("#estado").val();
            var estadoName = $("#estado option:selected").text();
            pdf.text("Estado: " + estadoName, 10, 185)
            var municipioId = $("#municipio").val();
            var municipioName = $("#municipio option:selected").text();
            pdf.text("Municipio: " + municipioName, 10, 195)
        }
    })
    const blob = pdf.output('blob');
    const url = URL.createObjectURL(blob);
    window.open(url, '_blank');
})