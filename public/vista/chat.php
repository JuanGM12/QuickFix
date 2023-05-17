<!DOCTYPE html>
<html>
<head>
    <title>Chat de Mensajería</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<style>
#chat-container {
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f1f1f1;
    border-radius: 5px;
}

#message-container {
    height: 300px;
    overflow-y: scroll;
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 10px;
    margin-bottom: 10px;
}

#input-container {
    display: flex;
}

#message-input {
    flex-grow: 1;
    padding: 5px;
    margin-right: 10px;
}

#send-button {
    padding: 5px 10px;
    background-color: #4CAF50;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}
</style>
<body>
    <div id="chat-container">
        <div id="message-container"></div>
        <div id="input-container">
            <input type="text" id="message-input" placeholder="Escribe tu mensaje...">
            <button id="send-button">Enviar</button>
        </div>
    </div>

    <script src="../plantilla/js/chat.js"></script>
</body>
</html>
<?php
session_start();

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    // Aquí puedes guardar o procesar el mensaje como desees
    // Por ejemplo, puedes almacenarlo en una base de datos

    // Respuesta de ejemplo
    $response = "¡Hola! Has enviado el mensaje: " . $message;
}