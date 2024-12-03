const sFechaHora = document.querySelector('#s-fecha-hora');
const btnGetFechaHora = document.querySelector('#btn-get-fecha-hora');

btnGetFechaHora.addEventListener('click', btnGetFechaHoraAsync_click);

function btnGetFechaHora_click(e) {
    fetch('get_fecha_hora.php')
        .then(res => res.json())
        .then(resObj => {
            btnGetFechaHora.disable = false;
            sFechaHora.textContent = resObj.fechaHora;
        });
}

async function btnGetFechaHoraAsync_click(e) {
    btnGetFechaHora.disable = true;
    const res = await fetch('get_fecha_hora.php');
    const resObj = await res.json();
    sFechaHora.textContent = resObj.fechaHora;
    btnGetFechaHora.disable = false;
}