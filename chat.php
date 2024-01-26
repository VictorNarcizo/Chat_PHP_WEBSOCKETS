<?php
session_start();

ob_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>

<body>
    <h2>Chat</h2>

    <p>Bem vindo <span id="nome-usuario"><?php echo $_SESSION['usuario']; ?></span></p>

    <label for="">Nova mensagem: </label>
    <input type="text" name="mensagem" id="mensagem" placeholder="Digite a mensagem...">
    <br><br>

    <input type="button" onclick="enviar()" value="Enviar">
    <br><br>

    <span id="mensagem-chat"></span>

    <script>
        const mensagemChat = document.getElementById("mensagem-chat");

        const ws = new WebSocket('ws://localhost:8080')

        ws.onopen = (e) => {
            console.log('Conectado!');
        }

        ws.onmessage = (messagemRecebida) => {

            let resultado = JSON.parse(messagemRecebida.data);

            mensagemChat.insertAdjacentHTML('beforeend', `${resultado.mensagem} <br>`);

        }

        const enviar = () => {

            let mensagem = document.getElementById("mensagem");

            let nomeUsuario = document.getElementById("nome-usuario").textContent;

            let dados = {
                mensagem: `${nomeUsuario}: ${mensagem.value} <br>`
            }

            ws.send(JSON.stringify(dados));

            mensagemChat.insertAdjacentHTML('beforeend', `${nomeUsuario}: ${mensagem.value} <br>`);

            mensagem.value = '';
        }
    </script>
</body>

</html>