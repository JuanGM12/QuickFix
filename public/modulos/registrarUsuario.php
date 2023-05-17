<style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="tel"],
        form input[type="password"],
        form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        form input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
<body>
    <h2>Registro de Usuario</h2>

    <form method="POST" action="/modulos/procesarRegistro.php" enctype="multipart/form-data">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required><br><br>

        <label>Confirmar Contraseña:</label>
        <input type="password" name="confirmar_contrasena" required><br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required><br><br>

        <label>Correo Electrónico:</label>
        <input type="email" name="correo" required><br><br>

        <label>Teléfono:</label>
        <input type="tel" name="telefono" required><br><br>

        <label>Departamento:</label>
        <input type="text" name="departamento" required><br><br>

        <label>Ciudad:</label>
        <input type="text" name="ciudad" required><br><br>

        <label>Código Postal:</label>
        <input type="text" name="codigo_postal" required><br><br>

        <label>Dirección:</label>
        <input type="text" name="direccion" required><br><br>

        <label>Número de Documento:</label>
        <input type="text" name="numero_documento" required><br><br>

        <label>Tipo de Documento:</label>
        <select name="tipo_documento">
            <option value="DNI">DNI</option>
            <option value="Pasaporte">Pasaporte</option>
            <option value="Carnet de Identidad">Carnet de Identidad</option>
        </select><br><br>

        <label>Tipo de Usuario:</label><br>
        <input type="radio" name="tipo_usuario" value="cliente" required> Cliente<br>
        <input type="radio" name="tipo_usuario" value="prestador_servicio" required> Prestador de Servicio<br><br>

        <label>Foto de Perfil:</label>
        <input type="file" name="foto_perfil"><br><br>
        
        <input type="submit" value="Registrarse">
        <input type="submit" value="Atrás" onclick="location.href='../inicio'">
    </form>