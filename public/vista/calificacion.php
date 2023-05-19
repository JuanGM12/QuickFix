<style>
.btn-azul {
    background-color: blue;
    color: white;
}
.btn-azul:hover {
    background-color: black;
    color: white;
}
</style>
<body class="app">
    <div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
    <div>
        <img src="/plantilla/images/prestador.png" alt="Foto del prestador de servicios">
    </div>

    <div>
        <h2>Ramón Salazar </h2>
        <p>Mecánico </p>
        <p>Fecha de finalización del servicio: 15/03/2023</p>
        <p>Código del servicio: 1 </p>
    </div>

    <div>
        <h3>Calificación:</h3>
        <select name="calificacion">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>

    <div>
        <h3>Opinión:</h3>
        <textarea name="opinion" rows="4" cols="50"></textarea>
    </div>

    <div>
        <button type="submit" class="btn btn-azul">Finalizar</button>
    </div>
</div>
</div>
</body>