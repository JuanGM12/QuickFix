  <style>

    .container {
      display: flex;
      height: 100vh;
    }

    .chat-list {
      width: 300px;
      background-color: #f2f2f2;
      padding: 20px;
    }

    .chat-list-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .chat-list-item.selected {
      font-weight: bold;
    }

    .chat-list-item img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .chat-area {
      flex-grow: 1;
      padding: 20px;
    }

    .message {
      margin-bottom: 10px;
      display: flex;
    }

    .message .sender {
      font-weight: bold;
      width: 80px;
    }

    .message .text {
      margin-top: 5px;
    }

    .my-message {
      margin-left: auto;
      text-align: right;
    }

    .my-message .sender {
      text-align: right;
    }

    .message .sender,
    .my-message .sender {
      color: #888;
    }

    .message .text,
    .my-message .text {
      background-color: #e2f7fe;
      padding: 8px;
      border-radius: 8px;
    }

    .message img,
    .my-message img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      margin-right: 5px;
    }

    .message .text img,
    .my-message .text img {
      max-width: 100%;
      height: auto;
      margin-top: 5px;
    }

    .message .text a,
    .my-message .text a {
      color: #007bff;
      text-decoration: none;
    }
  </style>
  <body class="app">
    <div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
  <div class="container">
    <div class="chat-list">
      <div class="chat-list-item selected">
        <img src="/plantilla/images/profiles/profile-1.png" alt="Perfil">
        Amy Holland
      </div>
      <p>Muchas gracias, acá lo espero.</p>
      <div class="chat-list-item">
        <img src="/plantilla/images/profiles/jose.jpg" alt="Perfil">
        Jose Quirós
      </div>
      <p>Buenas, tiene vibradores?</p>
      <div class="chat-list-item">
        <img src="/plantilla/images/profiles/profile-3.png" alt="Perfil">
        Reina Brooks
      </div>
      <p>Buenas tardes.</p>
      <!-- Agrega más chats anteriores aquí -->
    </div>

    <div class="chat-area">
      <div class="message">
        <img src="/plantilla/images/profiles/profile-1.png" alt="Perfil">
        <div>
          <div class="sender">Amy</div>
          <div class="text">Buenas tardes, necesito que me ayudes con mi coche, quedé varada en una autopista</div>
        </div>
      </div>
      <div class="my-message">
        <div>
          <div class="sender">Yo <img src="/plantilla/images/user.png" alt="Perfil"></div>
          <div class="text">Buenas tardes, claro que si, envíeme por favor su ubicación y que tipo de coche es?</div>
        </div>
        
      </div>
      <div class="message">
        <img src="/plantilla/images/profiles/profile-1.png" alt="Perfil">
        <div>
          <div class="sender">Amy</div>
          <div class="text">Es un Renault Twingo, esta es mi direccion. <a>Ver dirección</a></div>
        </div>
      </div>
      <div class="my-message">
        <div>
        <div class="sender">Yo <img src="/plantilla/images/user.png" alt="Perfil"></div>
          <div class="text">Voy en camino, quedese donde está</div>
        </div>
      </div>
      <div class="message">
        <img src="/plantilla/images/profiles/profile-1.png" alt="Perfil">
        <div>
          <div class="sender">Amy</div>
          <div class="text">Muchas gracias, acá lo espero.</div>
        </div>
      </div>
      <!-- Agrega más mensajes del chat abierto aquí -->
        <div class="message-bar d-flex p-3">
            <input type="text" placeholder="Escribe un mensaje..." class="form-control search-input">
            <button>Enviar</button>
        </div>
    </div>
  </div>
</div>
</div>
</body>
