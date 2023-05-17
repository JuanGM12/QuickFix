document.addEventListener("DOMContentLoaded", function() {
    var messageContainer = document.getElementById("message-container");
    var messageInput = document.getElementById("message-input");
    var sendButton = document.getElementById("send-button");

    sendButton.addEventListener("click", sendMessage);
    messageInput.addEventListener("keypress", function(event) {
        if (event.keyCode === 13) {
            sendMessage();
        }
    });

    function sendMessage() {
        var message = messageInput.value.trim();
        if (message !== "") {
            var messageElement = document.createElement("div");
            messageElement.classList.add("message");
            messageElement.textContent = message;
            messageContainer.appendChild(messageElement);
            messageInput.value = "";
            messageContainer.scrollTop = messageContainer.scrollHeight;

            // Enviar el mensaje al servidor (PHP) para almacenarlo o procesarlo
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "send_message.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Respuesta del servidor
                    var response = xhr.responseText;
                    console.log(response);
                }
            };
            xhr.send("message=" + encodeURIComponent(message));
        }
    }
});