<?php
namespace tPayne\BehatMailExtension\Context;

use tPayne\BehatMailExtension\Driver\Mail;

trait MailTrait
{

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * Mail property will be set by the initializer
     *
     * @param Mail $mail
     */
    public function setMail(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Clear all messages from the inbox
     *
     * @AfterScenario @mail
     */
    public function clearInbox()
    {
        $this->mail->deleteMessages();
    }
}
