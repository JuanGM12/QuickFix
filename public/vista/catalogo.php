<style>
        /* Estilos CSS personalizados */
        .provider-container {
            margin-bottom: 20px;
        }

        .provider-container img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .service-container {
            display: inline-block;
            width: 24%;
            margin-right: 2%;
            margin-bottom: 20px;
        }

        .service-container img {
            width: 100%;
            height: auto;
        }

        .service-container .service-info {
            margin-top: 10px;
        }

        .clear {
            clear: both;
        }
    </style>
    <body class="app">
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
    <?php
    // Datos de ejemplo para el prestador de servicios
    $prestador = array(
        'nombre' => 'Ramiro Pérez',
        'descripcion' => 'Mecánico con 15 años de experiencia, trabajo con todo tipo de vehículos y todo tipo de marcas.',
        'foto' => '/plantilla/images/prestador.png'
    );

    // Datos de ejemplo para los servicios (puedes reemplazarlos con tus propios datos o cargarlos desde una base de datos)
    $servicios = array(
        array(
            'titulo' => 'Reparaciones mecánicas',
            'descripcion' => 'Diagnosticar y solucionar problemas mecánicos, como fallos en el motor, problemas de transmisión, sistemas de dirección y suspensión, frenos, sistemas de escape, sistemas de climatización, etc.',
            'foto' => '/plantilla/images/mecanicas.png'
        ),
        array(
            'titulo' => 'Reparaciones eléctricas',
            'descripcion' => 'Identificar y solucionar problemas eléctricos en el vehículo, como problemas con el sistema de encendido, luces, sistema de carga de la batería, sistemas de seguridad y sistemas de entretenimiento.',
            'foto' => '/plantilla/images/reparacionElectrica.png'
        ),
        array(
            'titulo' => 'Reparación y reemplazo de piezas',
            'descripcion' => 'Realizar la reparación o el reemplazo de piezas defectuosas o desgastadas en el vehículo, como frenos, embragues, baterías, alternadores, bombas de agua, radiadores, etc.',
            'foto' => '/plantilla/images/reemplazo.png'
        ),
        array(
            'titulo' => 'Alineación y balanceo de ruedas',
            'descripcion' => 'Ajustar la alineación de las ruedas y equilibrarlas adecuadamente para asegurar un manejo seguro y un desgaste uniforme de los neumáticos.',
            'foto' => '/plantilla/images/alineacion.png'
        )
        // Puedes agregar más servicios aquí
    );

    // Mostrar información del prestador de servicios
    echo '<div class="provider-container">';
    echo '<h1>' . $prestador['nombre'] . '</h1>';
    echo '<img src="' . $prestador['foto'] . '" alt="Foto del prestador">';
    echo '<p>' . $prestador['descripcion'] . '</p>';
    echo '</div>';

     // Mostrar información de cada servicio
    $contador = 0;

    foreach ($servicios as $servicio) {
        if ($contador % 4 === 0) {
            echo '<div class="clear"></div>';
            echo '<div class="service-column">'; // Iniciar una nueva columna de servicios
        }

        echo '<div class="service-container">';
        echo '<img src="' . $servicio['foto'] . '" alt="Foto del servicio">';
        echo '<div class="service-info">';
        echo '<h2>' . $servicio['titulo'] . '</h2>';
        echo '<p>' . $servicio['descripcion'] . '</p>';
        echo '</div>';
        echo '<a href="detalles" class="btn btn-primary">Ver más</a>'; // Botón "Ver más"
        echo '</div>';

        $contador++;

        if ($contador % 4 === 0) {
            echo '</div>'; // Cerrar la columna actual después de mostrar 4 servicios
        }
    }

    if ($contador % 5 !== 0) {
        echo '</div>'; // Cerrar la columna final si no se completaron 4 servicios
    }

    ?>
    </div>
</div>
</body>