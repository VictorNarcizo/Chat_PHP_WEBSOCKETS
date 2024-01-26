<?php
// para iniciar o servidor digite no prompt  php servidor_chat.php

namespace Api\Websocket;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class SistemaChat implements MessageComponentInterface
{
    protected $cliente;

    public function __construct()
    {
        $this->cliente = new \SplObjectStorage;
    }

    //conexao
    public function onOpen(ConnectionInterface $conn)
    {
        //adicionar o cliente na lista
        $this->cliente->attach($conn);

        echo "Nova conexão: {$conn->resourceId}\n\n";
    }

    //enviar mensagem para os usuarios
    public function onMessage(ConnectionInterface $from, $msg)
    {
        //percorrer lista de usuarios conectados
        foreach ($this->cliente as $cliente) {

            //nao enviar mensagem para quem enviou
            if ($from !== $cliente) {
                //enviar mensagem para os usuarios
                $cliente->send($msg);
            }
        }

        echo "Usuario {$from->resourceId} enviou uma mensagem \n\n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        //fechar conexao
        $this->cliente->detach($conn);

        echo "Usuario {$conn->resourceId} desconectou. \n\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->close();

        echo "Ocorreu um erro: {$e->getMessage()}. \n\n";
    }
}
