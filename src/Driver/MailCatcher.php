<?php
namespace tPayne\BehatMailExtension\Driver;

use GuzzleHttp\Client;
use tPayne\BehatMailExtension\Message;
use tPayne\BehatMailExtension\MessageFactory;

class MailCatcher implements Mail
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get all messages
     *
     * @return Message[]
     */
    public function getMessages()
    {
        $messageData = $this->client->get('/messages')->json();

        $messages = [];

        foreach ($messageData as $message) {
            $messages[] = $this->mapToMessage($message);
        }

        return $messages;
    }

    /**
     * Get the latest message
     *
     * @return Message
     */
    public function getLatestMessage()
    {
        $messageData = $this->client->get('/messages')->json()[0];

        return $this->mapToMessage($messageData);
    }

    /**
     * Delete the messages from the inbox
     */
    public function deleteMessages()
    {
        $this->client->delete('/messages');
    }

    /**
     * Map data from API to a message
     *
     * @param array $message
     * @return Message
     */
    private function mapToMessage($message)
    {
        $html = $this->client->get("/messages/{$message['id']}.html")
            ->getBody()
            ->getContents();

        $text = $this->client->get("/messages/{$message['id']}.plain")
            ->getBody()
            ->getContents();

        return MessageFactory::fromMailCatcher($message, $html, $text);
    }
}
