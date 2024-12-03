<div class="rightcolumn">

    <div class="card">
        <h2>About Time</h2>
        <p>Hoy es <strong id="s-fecha"></strong></p>
        <p>La hora es: <strong id="s-hora"></strong></p>
        <div>
            <label for="input-tiempo-actualizacion-datetime">Tiempo Actualización (en milisegundos): </label>
            <br />
            <input type="number" name="" id="input-tiempo-actualizacion-datetime" value="500" />
            <br />
            <button id="btn-empezar-actualizacion-datetime" style="width: 100%;">Empezar</button>
            <br />
            <button id="btn-parar-actualizacion-datetime" style="width: 100%;" disabled>Parar</button>
        </div>
    </div>

    <div class="card">
        <h3>Popular Post</h3>
        <div class="fakeimg"><p>Image</p></div>
        <div class="fakeimg"><p>Image</p></div>
        <div class="fakeimg"><p>Image</p></div>
    </div>

    <div class="card">
        <h3>Follow Me</h3>
        <p>Some text..</p>
    </div>

    <script src="<?=APP_ROOT?>js/about_time.js"></script>

</div>  <!-- End rightcolumn -->
