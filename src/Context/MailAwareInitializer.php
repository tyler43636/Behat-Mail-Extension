<?php
namespace tPayne\BehatMailExtension\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use tPayne\BehatMailExtension\Driver\Mail;

class MailAwareInitializer implements ContextInitializer
{

    /**
     * The Behat context.
     *
     * @var Context
     */
    private $context;

    /**
     * The Mail interface
     *
     * @var Mail
     */
    private $mail;

    /**
     * Construct the initializer.
     *
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context)
    {
        if ($context instanceof MailAwareContext) {
            $context->setMail($this->mail);
        }
    }
}
