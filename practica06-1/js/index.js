// Esta llamanda AJAX genera un error porque a donde queremos hacer
// la petición no está dentro del dominio donde está la página
fetch("http://primosoft.com.mx/games/api/getgames.php")
    .then(res => res.json())
    .then(games => {console.log(games);});
        