<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>

    <form method="POST" action="procesar_registro.php" enctype="multipart/form-data">
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
    </form>
</body>
</html>