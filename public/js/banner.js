window.onload = function () {
    if (!$(".alert-danger").length) {
        Swal.fire({
            title: "¡Bienvenido al registro de empleados de Corpocentro!",
            width: 700,
            padding: "4em",
            color: "#fff",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Registrarse ahora",
            background: "#fff url(/img/veneco.jpg)",
            backdrop: `
          rgba(0,0,0,0.4)
          url("/images/nyan-cat.gif")
          left top
          no-repeat
        `,
            customClass: {},
        });
    }
};
