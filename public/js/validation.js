(() => {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll(".needs-validation");

    // Función de validación personalizada para el grupo de checkboxes
    const checks = document.querySelectorAll('input[name="patria[]"]');
    checks.forEach((check) => {
        check.addEventListener("change", () => {
            const form = check.closest("form");
            validarGrupoCheckboxes(form);
        });
    });

    function validarGrupoCheckboxes(form) {
        //Obtener todos los checkboxes dentro del formulario
        const checkboxes = form.querySelectorAll('input[name="patria[]"]');
        let isChecked = false;

        // Comprobar si al menos uno está marcado
        checkboxes.forEach(cb => {
            if (cb.checked) {
                isChecked = true;
            }
        });
        //Obtener el elemento de feedback/error
        const errorFeedback = form.querySelector('#errorFeedback');

        if (!isChecked) {
            // Si FALLA la validación del grupo:
            // Añade la clase 'is-invalid' al mensaje de feedback y a los checkboxes
            errorFeedback.style.display = 'block';
            checkboxes.forEach(cb => {
                //Poner required
                cb.setAttribute('required', 'required');
            });
            // Retorna false para indicar que el formulario NO es válido.
            return false;
        } else {
            // Si PASA la validación del grupo:
            // Oculta el feedback y añade la clase 'is-valid'
            errorFeedback.style.display = 'none';
            checkboxes.forEach(cb => {
                cb.removeAttribute('required');
            });
            // Retorna true para indicar que el formulario es válido.
            return true;
        }
    }
    // Loop over them and prevent submission
    Array.from(forms).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                const grupoValido = validarGrupoCheckboxes(form);
                console.log("Grupo válido:", grupoValido);
                if (!form.checkValidity() || !grupoValido) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
})();
