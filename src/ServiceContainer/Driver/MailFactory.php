<?php
namespace tPayne\BehatMailExtension\ServiceContainer\Driver;

interface MailFactory
{
    /**
     * Build the mail driver
     *
     * @param array $config
     * @return mixed
     */
    public function buildDriver(array $config);
}
