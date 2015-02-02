<?php

namespace spec\tPayne\BehatMailExtension\Context;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use tPayne\BehatMailExtension\Context\MailAwareContext;
use tPayne\BehatMailExtension\Driver\Mail;

class MailAwareInitializerSpec extends ObjectBehavior
{
    public function let(Mail $mail)
    {
        $this->beConstructedWith($mail);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('tPayne\BehatMailExtension\Context\MailAwareInitializer');
    }

    public function it_initializes_the_context(Mail $mail, MailAwareContext $context)
    {
        $context->setMail($mail)->shouldBeCalled();

        $this->initializeContext($context);
    }
}
