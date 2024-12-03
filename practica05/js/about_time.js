// Elementos HTML a usar
const sFecha = document.getElementById("s-fecha");
const sHora = document.getElementById("s-hora");
const inputTiempoActualizacionDateTime = 
        document.getElementById("input-tiempo-actualizacion-datetime");
const btnEmpezarActualizacionDateTime =
        document.getElementById("btn-empezar-actualizacion-datetime");
const btnPararActualizacionDateTime = 
        document.getElementById("btn-parar-actualizacion-datetime");

// Identificador del interval que usamos para actualizar la fecha hora.
let actualizacionFechaHoraIntervalId = null;

function actualizarFechaHora() {
    
    // Esta es la URL a la que se va a hacer la llamada AJAX (que sigue siendo
    // una petición HTTP Request)
    const urlToCall = APP_ROOT + "ajax/get_fecha_hora.php";

    // Realizamos la llamada AJAX (con GET) haciendo uso de la API de Fetch
    fetch(urlToCall)
        //.then(response => response.json())
        .then(function (response) {
            // Aquí trabajamos con la respuesta que obtenemos del server por la
            // llamada AJAX. Como necesitamos el JSON, de la respuesta lo obtenemos.
            return response.json()
        })
        .then(function(data) {
            // Aquí ya tenemos los datos regresados por el server como un object de JS,
            // puesto que el JSON string lo convertimos a JS object para poderlo trabajar
            console.log("Fecha-hora recibida >>> ", data);
            sFecha.textContent = data.fechaAMostrar;
            sHora.textContent = data.horaAMostrar;
        });
}

btnEmpezarActualizacionDateTime.addEventListener("click", function(e) {

    e.preventDefault();

    // si ya hay un interval ejecutandose, no se realiza operación
    if (actualizacionFechaHoraIntervalId) {
        return;
    }

    // Obtenemos el tiempo de actualización, la frecuenta del interval en milisegundos
    const tiempoActualizacion = parseInt(inputTiempoActualizacionDateTime.value);
    if (isNaN(tiempoActualizacion) || !tiempoActualizacion) {
        return;
    }

    // Inicializamos el interval, que es el que nos va a dar una ejecución periódica según
    // una frecuencia de actualización especificada
    actualizacionFechaHoraIntervalId = setInterval(actualizarFechaHora, tiempoActualizacion);

    // Se habilitan y deshabilitan los elementos HTML
    inputTiempoActualizacionDateTime.setAttribute("disabled", "");
    btnEmpezarActualizacionDateTime.setAttribute("disabled", "");
    btnPararActualizacionDateTime.removeAttribute("disabled");
});

btnPararActualizacionDateTime.addEventListener("click", function(e) {

    e.preventDefault();

    // si no hay un interval ejecutandose, no se realiza la operación.
    if (!actualizacionFechaHoraIntervalId) {
        return;
    }

    // Paramos el interval que se está ejecutando según el indentificador obtenido.
    clearInterval(actualizacionFechaHoraIntervalId);

    // Para indicar que ya no se está ejecutando el interval, le ponemos valor null
    actualizacionFechaHoraIntervalId = null;

    // Se habilitan y deshabilitan los elementos HTML
    inputTiempoActualizacionDateTime.removeAttribute("disabled");
    btnEmpezarActualizacionDateTime.removeAttribute("disabled");
    btnPararActualizacionDateTime.setAttribute("disabled", "");
});
