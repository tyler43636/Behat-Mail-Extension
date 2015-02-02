<?php
namespace tPayne\BehatMailExtension\Context;

use Behat\Behat\Context\Context;
use tPayne\BehatMailExtension\Driver\Mail;

interface MailAwareContext extends Context
{

    /**
     * Set the mail driver on the context
     *
     * @param Mail $mail
     * @return mixed
     */
    public function setMail(Mail $mail);
}
