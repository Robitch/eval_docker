const amqp = require('amqplib');

async function connectAndSend() {
    try {
        console.log("Connexion au serveur RabbitMQ...");
        // Connexion au serveur RabbitMQ
        const host = 'rabbitmq';
        const port = 5672;
        const username = 'guest';
        const password = 'guest';

        const url = `amqp://${username}:${password}@${host}:${port}`;

        const connection = await amqp.connect(url);
        const channel = await connection.createChannel();

        // Déclaration de la file d'attente
        const queue = 'mds';
        await channel.assertQueue(queue, { durable: false });

        // Envoi du message à la file d'attente toutes les secondes
        setInterval(() => {
            // Envoi de la date et de l'heure
            const message = new Date().toLocaleString();
            channel.sendToQueue(queue, Buffer.from(message));
            console.log("Message envoyé avec succès :", message);
        }, 1000); // 1000 ms = 1 seconde

    } catch (error) {
        console.error("Une erreur s'est produite :", error);
        process.exit(1);
    }
}

connectAndSend();
