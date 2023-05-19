    <style>
        .contenedordet {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        
        .tarjeta {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .tarjeta img {
            max-width: 100%;
            margin-bottom: 10px;
        }
        
        .tarjeta-descripcion {
            text-align: left;
            margin-top: 20px;
        }
        
        .rating {
            margin-top: 10px;
        }
        
        .rating span {
            font-size: 20px;
            color: gold;
        }
        
        .rating-numbers {
            margin-top: 5px;
            font-size: 16px;
        }
        
        .boton {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }
        
        .btn-primario {
            background-color: #007bff;
        }
        
        .btn-secundario {
            background-color: #6c757d;
        }
    </style>
<body class="app">
    <div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="contenedordet">
        <h1>Detalle del Servicio</h1>
        <div class="tarjeta">
            <img src="/plantilla/images/mecanico.jpg" alt="Foto del servicio">
            <h3>Servicio: Mecanico</h3>
            <p>Prestador: <a href="catalogo">Ramiro Pérez</a></p>
            <div class="rating">
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9733;</span>
                <span>&#9734;</span>
            </div>
            <div class="rating-numbers">
                <span>4.0</span> (12 opiniones)
            </div>
            <div class="tarjeta-descripcion">
                <h4>Descripción del Servicio</h4>
                <p>Nuestro servicio de mecánico ofrece soluciones confiables y eficientes para tus necesidades automotrices. Contamos con un equipo de profesionales altamente capacitados en diagnóstico, reparación y mantenimiento de vehículos. Desde revisiones periódicas hasta reparaciones complejas, estamos comprometidos a mantener tu automóvil en excelente estado y garantizar tu seguridad en la carretera. Utilizamos tecnología de vanguardia y herramientas especializadas para asegurar un trabajo preciso y de calidad. Ya sea que necesites un cambio de aceite, revisión de frenos o solución de problemas mecánicos, nuestro equipo está listo para brindarte un servicio amigable, transparente y a un precio justo. Confía en nosotros para mantener tu vehículo en óptimas condiciones.</p>
            </div>
            <a href="inicio" class="boton btn-primario">Volver</a>
            <a href="chatear" class="boton btn-secundario">Contactar</a>
        </div>
    </div>
    </div>
    </div>
    </body>