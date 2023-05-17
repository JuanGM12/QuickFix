<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #chat-container {
            display: flex;
            flex-direction: row;
        }

        #chat-form {
            flex: 1;
            padding: 20px;
        }

        #chat-history {
            flex: 1;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .message {
            margin-bottom: 10px;
        }

        .message .sender {
            font-weight: bold;
        }

        .message .text {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php
    // Array de mensajes de ejemplo
    $messages = [
        [
            'sender' => 'John',
            'text' => 'Hello there!',
        ],
        [
            'sender' => 'Jane',
            'text' => 'Hi John! How are you?',
        ],
        [
            'sender' => 'John',
            'text' => 'I\'m good, thanks! How about you?',
        ],
        [
            'sender' => 'Jane',
            'text' => 'I\'m doing well too. Thanks for asking.',
        ],
    ];
    ?>

    <div id="chat-container">
        <div id="chat-form">
            <h2>Chat</h2>
            <form method="post" action="">
                <input type="text" name="sender" placeholder="Your Name" required><br>
                <textarea name="message" placeholder="Type your message" required></textarea><br>
                <button type="submit">Send</button>
            </form>
        </div>

        <div id="chat-history">
            <h2>Chat History</h2>
            <?php foreach ($messages as $message) : ?>
                <div class="message">
                    <span class="sender"><?= $message['sender'] ?>:</span>
                    <div class="text"><?= $message['text'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>