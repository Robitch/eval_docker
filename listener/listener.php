<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Informations de connexion RabbitMQ
$host = 'rabbitmq';
$port = 5672;
$user = 'guest';
$password = 'guest';
$vhost = '/';

// Établissement de la connexion
$connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);

// Création du canal
$channel = $connection->channel();

// Déclaration de la queue
$queue = 'mds';
$channel->queue_declare($queue, false, false, false, false);

echo 'En attente de messages. Appuyez sur Ctrl+C pour quitter.' . PHP_EOL;

// Fonction de rappel (callback) pour traiter les messages
$callback = function (AMQPMessage $message) {
    $body = $message->body;
    echo 'Message reçu : ' . $body . PHP_EOL;

    // Traitez le message selon vos besoins
    // ...

    // Accuser réception du message
    $message->ack();
};

// Consommation de la queue avec la fonction de rappel
$channel->basic_consume($queue, '', false, false, false, false, $callback);

// Attendre les messages entrants
while ($channel->is_consuming()) {
    $channel->wait();
}

// Fermeture de la connexion
$channel->close();
$connection->close();
