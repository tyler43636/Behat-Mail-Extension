<?php

namespace spec\tPayne\BehatMailExtension\ServiceContainer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('tPayne\BehatMailExtension\ServiceContainer\MailExtension');
        $this->shouldHaveType('Behat\Testwork\ServiceContainer\Extension');
    }

    public function it_gets_the_config_key()
    {
        $this->getConfigKey()->shouldReturn('MailExtension');
    }
}
