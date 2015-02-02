<?php

namespace spec\tPayne\BehatMailExtension\ServiceContainer\Driver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailTrapFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('tPayne\BehatMailExtension\ServiceContainer\Driver\MailTrapFactory');
    }

    public function it_should_throw_an_exception_when_missing_config_options()
    {
        $this->shouldThrow('Exception')->duringBuildDriver([]);
    }
}
