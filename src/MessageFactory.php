<?php
namespace tPayne\BehatMailExtension;

class MessageFactory
{
    /**
     * Create message from MailCatcher data
     *
     * @param $data
     * @param $html
     * @param $text
     * @return Message
     */
    public static function fromMailCatcher($data, $html, $text)
    {
        return new Message(
            self::sanitizeEmailAddress($data['sender']),
            self::sanitizeEmailAddress($data['recipients'][0]),
            $data['subject'],
            $html,
            $text,
            $data['created_at']
        );
    }

    /**
     * Create message from MailTrap data
     *
     * @param $data
     * @return Message
     */
    public static function fromMailTrap($data)
    {
        return new Message(
            $data['from_email'],
            $data['to_email'],
            $data['subject'],
            $data['html_body'],
            $data['text_body'],
            $data['sent_at']
        );
    }

    /**
     * Remove the carets around email addresses
     *
     * @param $address
     * @return mixed
     */
    private static function sanitizeEmailAddress($address)
    {
        return preg_replace('/([<>])/', '', $address);
    }
}
