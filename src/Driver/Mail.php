<?php
namespace tPayne\BehatMailExtension\Driver;

use tPayne\BehatMailExtension\Message;

interface Mail
{

    /**
     * Get the latest message
     *
     * @return Message
     */
    public function getLatestMessage();

    /**
     * Get all messages
     *
     * @return Message[]
     */
    public function getMessages();

    /**
     * Delete the messages from the inbox
     *
     * @return mixed
     */
    public function deleteMessages();
}
