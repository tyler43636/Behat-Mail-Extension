<?php
namespace tPayne\BehatMailExtension\ServiceContainer\Driver;

use Exception;
use GuzzleHttp\Client;
use tPayne\BehatMailExtension\Driver\MailCatcher;
use tPayne\BehatMailExtension\Driver\MailTrap;

class MailTrapFactory
{
    /**
     * Build the mail driver
     *
     * @param array $config
     * @return MailCatcher
     * @throws Exception
     */
    public function buildDriver(array $config)
    {
        if (isset($config['api_key']) && isset($config['mailbox_id'])) {
            $client = new Client([
                'base_uri' => 'https://mailtrap.io',
                'headers' => [
                    'Api-Token' => $config['api_key'],
                ],
            ]);

            return new MailTrap($client, $config['mailbox_id']);
        }

        throw new Exception(
            "To use the mailtrap driver you must set the api_key and the mailbox_id"
        );
    }
}
