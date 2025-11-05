const button_search = document.querySelector('#button-search');

button_search.addEventListener('click', function() {
    const cedulaInput = document.querySelector('#cedula');
    const cedula = cedulaInput.value;

    fetch(`/api/persona/${cedula}`)
        .then(response => response.json())
        .then(data => {
            //Si hay datos llenar el formulario con los datos traidos y sino poner mensaje de persona aun no registrada
            if(data.nombre !== undefined) {
                console.log(data)
                //Llenar el formulario
                document.querySelector('#nombre').value = data.nombre;
                document.querySelector('#fecha_nacimiento').value = data.fecha_nacimiento;
                document.querySelector('#telefono').value = data.telefono;
                document.querySelector('#correo').value = data.correo;
                //Poner valor radio sexo
                if(data.sexo === 1) {
                    document.querySelector('#sexo-m').checked = true;
                } else {
                    document.querySelector('#sexo-f').checked = true;
                }

                //Mostrar alerta de que la persona ya existe
                Swal.fire({
                    icon: 'info',
                    title: 'Persona encontrada',
                    text: 'Los datos han sido cargados en el formulario.',
                });
                document.querySelector('#messaje-cedula').innerHTML = '';

            } else {
                //Mostrar mensaje de que la persona no existe
                document.querySelector('#messaje-cedula').innerHTML = '<div class="alert alert-warning mt-2" role="alert">Persona no registrada. Por favor, complete el formulario.</div>';
                //Limpiar el formulario
                document.querySelector('#nombre').value = '';
                document.querySelector('#fecha_nacimiento').value = '';
                document.querySelector('#telefono').value = '';
                document.querySelector('#correo').value = '';
                document.querySelector('#sexo-m').checked = true;
            }
        })
        .catch(error => console.error('Error:', error));
});