
  <style>
    
    .formulario {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .formulario label {
      display: block;
      margin-bottom: 10px;
      color: #333;
    }
    
    .formulario input[type="text"],
    textarea,
    input[type="number"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-bottom: 20px;
    }
    
    .formulario input[type="submit"],
    button {
      background-color: #4caf50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      text-transform: uppercase;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .formulario button {
      background-color: #ccc;
      margin-left: 10px;
    }
    .formulario .etiquetas-group {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      grid-gap: 10px;
      align-items: center;
    }
    
    .formulario .etiquetas-group label {
      white-space: nowrap;
    }
    
    .formulario .etiquetas-group input {
      width: 100%;
    }
  </style>
</head>
<body class="app">
    <div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
  <h2>Modificar Servicio</h2>
  
  <form action="panel" class="formulario" method="POST" enctype="multipart/form-data">
    <label for="nombre">Nombre del servicio:</label>
    <input type="text" id="nombre" name="nombre" required>
    
    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" required></textarea>
    
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" required>
    <label for="imagen">Etiquetas:</label>
    <div class="etiquetas-group">
      <input type="text" id="etiqueta1" name="etiquetas[]">
      <input type="text" id="etiqueta2" name="etiquetas[]">
      <input type="text" id="etiqueta3" name="etiquetas[]">
      <input type="text" id="etiqueta3" name="etiquetas[]">
      
      <!-- Agrega más etiquetas si es necesario -->
    </div>
    
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen">
    
    <input type="submit" value="Guardar cambios">
    <button type="button" onclick="window.location.href='panel'">Cancelar</button>
  </form>
</div>
</div>
</body>