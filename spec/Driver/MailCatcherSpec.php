<?php

namespace spec\tPayne\BehatMailExtension\Driver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Stream\StreamInterface;

class MailCatcherSpec extends ObjectBehavior
{
    public function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('tPayne\BehatMailExtension\Driver\MailCatcher');
    }

    public function it_gets_all_messages_from_mailcatcher_format(
        Client $client,
        ResponseInterface $response,
        ResponseInterface $response2,
        StreamInterface $stream,
        StreamInterface $stream2
    ) {
        // Call to get message collection
        $stream->getContents()->shouldBeCalled()->willReturn($this->getMailCatcherStub());
        $response->getBody()->shouldBeCalled()->willReturn($stream);
        $client->get('/messages')->shouldBeCalled()->willReturn($response);

        // Calls to get Message data
        $stream2->getContents()->willReturn('Some Text');
        $response2->getBody()->willReturn($stream2);
        $client->get('/messages/1.html')->shouldBeCalled()->willReturn($response2);
        $client->get('/messages/1.plain')->shouldBeCalled()->willReturn($response2);
        $client->get('/messages/2.html')->shouldBeCalled()->willReturn($response2);
        $client->get('/messages/2.plain')->shouldBeCalled()->willReturn($response2);

        $this->getMessages()->shouldBeArray();
        $this->getMessages()->shouldHaveCount(2);
    }

    public function it_gets_the_latests_message_from_mailcatcher_format(
        Client $client,
        ResponseInterface $response,
        ResponseInterface $response2,
        StreamInterface $stream,
        StreamInterface $stream2
    ) {
        // Call to get message collection
        $stream->getContents()->shouldBeCalled()->willReturn($this->getMailCatcherStub());
        $response->getBody()->shouldBeCalled()->willReturn($stream);
        $client->get('/messages')->shouldBeCalled()->willReturn($response);

        // Calls to get Message data
        $stream2->getContents()->willReturn('Some Text');
        $response2->getBody()->willReturn($stream2);
        $client->get('/messages/1.html')->shouldBeCalled()->willReturn($response2);
        $client->get('/messages/1.plain')->shouldBeCalled()->willReturn($response2);

        $this->getLatestMessage()->shouldReturnAnInstanceOf('tPayne\BehatMailExtension\Message');
    }

    public function it_deletes_all_messages(Client $client)
    {
        $client->delete('/messages')->shouldBeCalled();

        $this->deleteMessages();
    }

    private function getMailCatcherStub()
    {
        return json_encode(
            [
                [
                    "id" => 1,
                    "sender" => "<test@example.com>",
                    "recipients" => [
                        "<joe@example.com>"
                    ],
                    "subject" => "Welcome!",
                    "created_at" => "2015-01-28T09:19:40+00:00"
                ],
                [
                    "id" => 2,
                    "sender" => "<test@example.com>",
                    "recipients" => [
                        "<joe@example.com>"
                    ],
                    "subject" => "Password Reset!",
                    "created_at" => "2015-01-28T09:19:40+00:00"
                ],
            ]
        );
    }
}
