// Seleccionamos el formulario con el que estamos trabajando
const formulario = document.querySelector('#formulario');

// Prevenir comportamiento por defecto del submit al enviar formulario (GET)
formulario.addEventListener('submit', function(evento) {
    evento.preventDefault();

    // Obtenemos los campos del formulario para que PHP pueda interpretarlos posteriormente
    const datos = new FormData(formulario);

        // fetch a PHP, metodo POST y datos del formulario
        fetch('guardar.php', {
        method: 'POST',
        body: datos  
        })

        .then (respuesta => respuesta.json())
        .then (datos => {
            if (datos.success) {
            
            // Seleccionamos los datos de la tabla (tbody)
            const cuerpoTabla = document.querySelector('#cuerpoTabla');

            console.log(cuerpoTabla);
console.log(document.querySelector('#cuerpoTabla'));

            // Fila 
            const fila = document.createElement('tr');
                
            // ID de la idea
            const celdaID = document.createElement('td');
            celdaID.textContent = datos.id;

            // MODIFICAR
            const celdaIdea = document.createElement('td');

                // Formulario modificar
                const formModificar = document.createElement('form');
                formModificar.action = 'modificar.php';
                formModificar.method = 'POST';
                formModificar.classList.add('d-flex', 'align-items-center', 'gap-2');
                
                // Texto Idea
                const inputIdea = document.createElement('input');
                inputIdea.classList.add('form-control');
                inputIdea.name = 'texto';
                inputIdea.value = datos.texto;
                inputIdea.required = true;

                // Elemento modificar (hidden)
                const modificarHidden = document.createElement('input');
                modificarHidden.type = 'hidden';
                modificarHidden.name = 'id';
                modificarHidden.value = datos.id;


                // Boton Guardar
                const botonGuardar = document.createElement('button');
                botonGuardar.classList.add('btn', 'btn-secondary');
                botonGuardar.type='submit';
                botonGuardar.textContent = 'Guardar';


            // ELIMINAR
            const eliminarIdea = document.createElement('td');
                
                // Formulario eliminar
                const formEliminar = document.createElement('form');
                formEliminar.action = 'eliminar.php';
                formEliminar.method = 'POST';

                // Elemento eliminar (hidden)
                const eliminarHidden = document.createElement('input');
                eliminarHidden.type = 'hidden';
                eliminarHidden.name = 'id';
                eliminarHidden.value = datos.id;

                // Boton eliminar
                const botonEliminar = document.createElement('button');
                botonEliminar.classList.add('btn', 'btn-danger');
                botonEliminar.type='submit';
                botonEliminar.textContent = 'Eliminar';
                       


            // Unimos elementos
                formEliminar.appendChild(eliminarHidden);
                formEliminar.appendChild(botonEliminar);
                eliminarIdea.appendChild(formEliminar);
                

                formModificar.appendChild(inputIdea);
                formModificar.appendChild(modificarHidden);
                formModificar.appendChild(botonGuardar);
                celdaIdea.appendChild(formModificar);
                

                fila.appendChild(celdaID);
                fila.appendChild(celdaIdea);
                fila.appendChild(eliminarIdea);

                cuerpoTabla.appendChild(fila);
                

            }
        })
    });

