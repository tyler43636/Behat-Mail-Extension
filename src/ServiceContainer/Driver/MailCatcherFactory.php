<?php
namespace tPayne\BehatMailExtension\ServiceContainer\Driver;

use GuzzleHttp\Client;
use tPayne\BehatMailExtension\Driver\MailCatcher;

class MailCatcherFactory implements MailFactory
{

    /**
     * Build the mail driver
     *
     * @param array $config
     * @return MailCatcher
     */
    public function buildDriver(array $config)
    {
        $url = $this->buildUrl($config['base_uri'], $config['http_port']);

        $client = new Client(['base_uri' => $url]);

        return new MailCatcher($client);
    }

    private function buildUrl($address, $port)
    {
        return 'http://' . $address . ':' . $port;
    }
}
