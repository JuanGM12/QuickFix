<style>
.btn-azul {
    background-color: blue;
    color: white;
}
.btn-azul:hover {
    background-color: black;
    color: white;
}

.btn-gris {
    background-color: gray;
    color: white;
    margin-left: 20px;
}
.btn-gris:hover {
    background-color: black;
    color: white;
}


</style>
<body class="app">
    <div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
    <?php
    // Aquí se pueden cargar los datos de los servicios desde una base de datos o cualquier otra fuente de información
    $servicios = array(
        array(
            'nombre' => 'Reparaciones mecánicas',
            'descripcion' => 'Diagnosticar y solucionar problemas mecánicos, como fallos en el motor, problemas de transmisión, sistemas de dirección y suspensión, frenos, sistemas de escape, sistemas de climatización, etc.',
            'fotos' => array('/plantilla/images/foto1.png', '/plantilla/images/foto2.png'),
            'etiquetas' => array('Mecánica', 'Vehículos')
        ),
        array(
            'nombre' => 'Reparaciones eléctricas',
            'descripcion' => 'Identificar y solucionar problemas eléctricos en el vehículo, como problemas con el sistema de encendido, luces, sistema de carga de la batería, sistemas de seguridad y sistemas de entretenimiento.',
            'fotos' => array('/plantilla/images/foto4.png', '/plantilla/images/foto5.png'),
            'etiquetas' => array('Mecánica', 'Vehículos', 'electricidad')
        ),
        array(
            'nombre' => 'Reparación y reemplazo de piezas',
            'descripcion' => 'Realizar la reparación o el reemplazo de piezas defectuosas o desgastadas en el vehículo, como frenos, embragues, baterías, alternadores, bombas de agua, radiadores, etc..',
            'fotos' => array('/plantilla/images/foto6.png', '/plantilla/images/foto3.png'),
            'etiquetas' => array('Mecánica', 'Vehículos', 'piezas')
        ),
        array(
            'nombre' => 'Alineación y balanceo de ruedas',
            'descripcion' => 'Ajustar la alineación de las ruedas y equilibrarlas adecuadamente para asegurar un manejo seguro y un desgaste uniforme de los neumáticos.',
            'fotos' => array('/plantilla/images/foto1.png'),
            'etiquetas' => array('Mecánica', 'Vehículos')
        )
    );

    // Mostrar el listado de servicios
    foreach ($servicios as $servicio) {
        echo '<h2>' . $servicio['nombre'] . '</h2>';
        echo '<p>' . $servicio['descripcion'] . '</p>';

        // Mostrar las fotos del servicio
        echo '<h3>Fotos:</h3>';
        foreach ($servicio['fotos'] as $foto) {
            echo '<img src="' . $foto . '" alt="Foto del servicio" width="200px">';
        }

        // Etiquetas del servicio (separadas por comas)
        echo '<p>Etiquetas: <strong> ' . implode(', ', $servicio['etiquetas']) . '</strong></p>';

        // Botón "Modificar Servicio"
        echo '<button class="btn btn-azul" onclick="window.location.href=\'modificar_servicio.php?nombre=' . urlencode($servicio['nombre']) . '\'">Modificar Servicio</button>';

        // Botón "Borrar Servicio"
        echo '<button class="btn btn-gris" onclick="window.location.href=\'borrar_servicio.php?nombre=' . urlencode($servicio['nombre']) . '\'">Borrar Servicio</button>';

        echo '<br><br>';
    }
    ?>
    </div>
</div>
</body>

