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
        $body        = $this->client->get('/messages')->getBody()->getContents();
        $messageData = json_decode($body, true);

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
        $body        = $this->client->get('/messages')->getBody();
        $data        = json_decode($body->getContents(), true);
        $messageData = $data[0];

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
        try {
            $html = $this->client->get("/messages/{$message['id']}.html")
                ->getBody()
                ->getContents();
        }
        catch (\Exception $exception) {
            $html = sprintf('Error while retrieving HTML message "%s": %s', $message['id'], $exception->getMessage());
        }

        try {
            $text = $this->client->get("/messages/{$message['id']}.plain")
                ->getBody()
                ->getContents();
        }
        catch (\Exception $exception) {
            $text = sprintf('Error while retrieving Plain message "%s": %s', $message['id'], $exception->getMessage());
        }

        return MessageFactory::fromMailCatcher($message, $html, $text);
    }
}
