const TEXTO_OBTENIENDO_FECHA_HORA = "[Obteniendo Fecha Hora]";

// HTML Elements
const lblFechaHora = document.getElementById('lbl-fecha-hora');
const btnObtenerFechaHora = document.getElementById('btn-obtener-fecha-hora');
const btnObtenerFechaHoraAsync = document.getElementById('btn-obtener-fecha-hora-async');
const formPostAjax = document.getElementById('form-post-ajax');
const txtNombre = document.getElementById('txt-nombre');
const txtApellidos = document.getElementById('txt-apellidos');
const formPostAjaxJson = document.getElementById('form-post-ajax-json');
const txtNombreJson = document.getElementById('txt-nombre-json');
const txtApellidosJson = document.getElementById('txt-apellidos-json');
const txtOtroDato = document.querySelector("#txt-otro-dato");
const inputArchivo = document.querySelector("#input-archivo");
const btnEnviarArchivo = document.querySelector("#btn-enviar-archivo");

// Evento click del botón btnEnviarArchivo
btnEnviarArchivo.addEventListener("click", async e => {
    e.preventDefault();

    if (!inputArchivo.files.length) {
        alert("Por favor selecciona un archivo.");
        inputArchivo.focus();
        return;
    }

    const archivo = inputArchivo.files[0];
    const tiposPermitidos = ["image/jpeg", "image/png", "image/gif"];
    if (!tiposPermitidos.includes(archivo.type)) {
        alert("Solo se permiten archivos JPG, PNG o GIF.");
        return;
    }

    const maxSize = 2 * 1024 * 1024;
    if (archivo.size > maxSize) {
        alert("El archivo no debe superar los 2 MB.");
        return;
    }

    const datos = new FormData();
    datos.append("archivo", archivo);
    datos.append("otroDato", txtOtroDato.value);

    try {
        const res = await fetch(`http://${PHP_SERVER}/ajax/guardar_archivo.php`, { method: "POST", body: datos });
        if (!res.ok) {
            throw new Error("Error en la respuesta del servidor");
        }
        const resObj = await res.json();

        if (resObj.error) {
            alert(resObj.error);
        } else if (resObj.mensaje) {
            inputArchivo.value = "";
            txtOtroDato.value = "";
            alert(resObj.mensaje);
        }
    } catch (error) {
        alert("Ocurrió un error al subir el archivo.");
        console.error(error);
    }
});



// Evento click del botón btnObtenerFechaHora.
btnObtenerFechaHora.addEventListener('click', e => {

    e.preventDefault();

    // Llamada AJAX (con GET) con API de Fetch para obtener la fecha hora
    lblFechaHora.textContent = TEXTO_OBTENIENDO_FECHA_HORA;
    fetch(`${APP_ROOT}ajax/get_fecha_hora.php`)
        //.then(response => response.json())
        .then(function (response) {
            // Aquí trabajamos con la respuesta que obtenemos del server por la
            // llamada AJAX. Trabajamos con el JSON para obtener un JS Object
            return response.json();
        })
        .then(function (resObj) {  // Ya con el response Object
            lblFechaHora.textContent = resObj.fechaHora;
        });
});

/**
 * Función async que hace la llamada AJAX con la API de Fetch para obtener 
 * la fecha-hora y la muestra en la página, en elemento lbl-fecha-hora.
 */
async function actualizarFechaHoraAsync() {
//^^^ 
    // NOTA IMPORTANTE: En toda función que use "await', se debe declarar como función
    // asíncrona usando "async" antes de la definición de la función

    lblFechaHora.textContent = TEXTO_OBTENIENDO_FECHA_HORA;

    // Se obtiene los datos mediante AJAX, petición para obtener un response
    const res = await fetch(`${APP_ROOT}ajax/get_fecha_hora.php`);

    // Del response obtenemos el JSON como JS object
    const resObj = await res.json();

    // Establecemos en el HTML element el dato de la fechaHora obtenida.
    lblFechaHora.textContent = resObj.fechaHora;
}

btnObtenerFechaHoraAsync.addEventListener('click', async e => {
    //                                             ^^^^^
    //                                              |||
    // NOTA IMPORTANTE: Toda función que llame una función asíncrona, debe
    // especificarse como asíncrona con "async" antes de la definición de la
    // función

    e.preventDefault();

    // ejecución de función asíncrona, por eso usamos "await"
    await actualizarFechaHoraAsync();
});

// Handling del evento submit del form formPostAjax
formPostAjax.addEventListener('submit', async (e) => {

    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    e.preventDefault();

    // Así podemos obtener todos los datos del formulario para hacer la petición
    // por post, solo debemos enviar el objeto HTML que representa al elemento
    // form.
    //const datos = new FormData(formPostAjax);

    // Para enviar los datos manualmente, creamos un objeto de tipo FormData y 
    // se va poniendo los datos que queremos enviar por la petición AJAX por POST.
    const datos = new FormData();
    datos.append("nombre", txtNombre.value);
    datos.append("apellidos", txtApellidos.value);

    // Llamada AJAX enviando datos dentro de la misma petición usando POST.
    const res = await fetch(`${APP_ROOT}ajax/recibe_datos.php`, {method: 'POST', body: datos});
    const resObj = await res.json();  // Del response JSON obtenemos el JS object para poderlo trabajar
        
    // del JSON obtenido, hacemos algo con los datos. 
    if (resObj.errores.length) {
        const errMsg = "Errores: " + resObj.errores.join(" | ");
        alert(errMsg);
        return;
    }
    alert(resObj.mensaje);
});

// Handling del evento submit del form formPostAjaxJson
formPostAjaxJson.addEventListener('submit', async e => {
    
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    e.preventDefault();

    // Creamos un objeto JS, que es lo que vamos a enviar la server en la petición AJAX.
    // De esta forma tenemos la ventaja que podemos enviar datos más estructurados, como
    // objetos y arrays ;)
    const reqObj = {
        nombre: txtNombreJson.value,
        apellidos: txtApellidosJson.value,
        otroDato: 1.234
    };

    // Del reqObj (object JS nativo), obtenemos su representación en JSON, que es
    // el que vamos a enviar en la llamada AJAX.
    const reqObjJson = JSON.stringify(reqObj);

    const urlToCall = `${APP_ROOT}ajax/recibe_datos_json.php`;   // URL de la petición.
    const callParams = {
        method: 'POST',    // el método HTTP POST.
        headers: {   // Aquí modificamos los headers del request.
            'Content-Type': 'application/json'   // el contenido es JSON.
        },
        body: reqObjJson   // El contenido que vamos a enviar.
    };
    const res = await fetch(urlToCall, callParams);  // Llamada AJAX
    const resObj = await res.json();  // del response obtenemos el JSON.

    // del JSON obtenido, hacemos algo con los datos.
    // Aquí trabajamos con los datos recibidos del server, en este momento
    // el JSON ya es un object de JS
    console.log(resObj);
    if (resObj.errores.length) {  // Si hay algun error, en este caso, que no se enviaron algunos datos.
        alert("Errores: " + resObj.errores.join(" | "));
        return;  // fin de la ejecución.
    }
    alert(resObj.mensaje);        
});
