<?php

namespace spec\tPayne\BehatMailExtension\Driver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use GuzzleHttp\Client;
use GuzzleHttp\Message\ResponseInterface;

class MailTrapSpec extends ObjectBehavior
{
    public function let(Client $client)
    {
        $this->beConstructedWith($client, $mailboxId = 12345);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('tPayne\BehatMailExtension\Driver\MailTrap');
    }

    public function it_gets_all_messages_from_mailtrap_format(Client $client, ResponseInterface $response)
    {
        $response->json()->shouldBeCalled()->willReturn($this->getMailTrapStub());
        $client->get('/api/v1/inboxes/12345/messages')->shouldBeCalled()->willReturn($response);

        $this->getMessages()->shouldBeArray();
        $this->getMessages()->shouldHaveCount(2);
    }

    public function it_gets_the_latest_message_from_mailtrap_format(Client $client, ResponseInterface $response)
    {
        $response->json()->willReturn($this->getMailTrapStub());
        $client->get('/api/v1/inboxes/12345/messages')->willReturn($response);

        $this->getLatestMessage()->shouldReturnAnInstanceOf('tPayne\BehatMailExtension\Message');
    }

    public function it_deletes_all_messages(Client $client)
    {
        $client->patch('/api/v1/inboxes/12345/clean')->shouldBeCalled();

        $this->deleteMessages();
    }

    private function getMailTrapStub()
    {
        return [
            [
                'id' => 1,
                'subject' => 'Welcome!',
                'sent_at' => '2015-01-28T21:28:56.000Z',
                'from_email' => 'test@example.com',
                'to_email' => 'joe@example.com',
                'html_body' => "<html><body><h1>Welcome to the App!</h1><p>Thanks Joe</p></body></html>",
                'text_body' => 'Welcome to the App! Thanks Joe'
            ],
            [
                'id' => 2,
                'subject' => 'Password Reset',
                'sent_at' => '2015-01-28T21:28:56.000Z',
                'from_email' => 'test@example.com',
                'to_email' => 'joe@example.com',
                'html_body' => "<html><body><h1>Reset your password</h1></body></html>",
                'text_body' => 'Reset your password'
            ]
        ];
    }
}
