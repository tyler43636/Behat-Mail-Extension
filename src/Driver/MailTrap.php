<?php
namespace tPayne\BehatMailExtension\Driver;

use GuzzleHttp\Client;
use tPayne\BehatMailExtension\MessageFactory;
use tPayne\BehatMailExtension\Message;

class MailTrap implements Mail
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $mailboxId;

    public function __construct(Client $client, $mailboxId)
    {
        $this->client = $client;
        $this->mailboxId = $mailboxId;
    }

    /**
     * Get the latest message
     *
     * @return Message
     */
    public function getLatestMessage()
    {
        return $this->getMessages()[0];
    }

    /**
     * Get all messages
     *
     * @return Message[]
     */
    public function getMessages()
    {
        $body        = $this->client->get($this->getMessagesUrl())->getBody()->getContents();
        $messageData = json_decode($body, true);

        $messages = [];

        foreach ($messageData as $message) {
            $messages[] = $this->mapToMessage($message);
        }

        return $messages;
    }

    /**
     * Delete the messages from the inbox
     *
     * @return mixed
     */
    public function deleteMessages()
    {
        $this->client->patch($this->getCleanUrl());
    }

    /**
     * Get the URL for fetching messages
     *
     * @return string
     */
    private function getMessagesUrl()
    {
        return "/api/v1/inboxes/{$this->mailboxId}/messages";
    }

    /**
     * Get the URL for cleaning inbox
     *
     * @return string
     */
    private function getCleanUrl()
    {
        return "/api/v1/inboxes/{$this->mailboxId}/clean";
    }

    /**
     * Map data to a message
     *
     * @param array $message
     * @return Message
     */
    private function mapToMessage(array $message)
    {
        return MessageFactory::fromMailTrap($message);
    }
}
