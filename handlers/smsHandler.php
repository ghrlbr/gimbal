<?php

class SMSHandler extends Handler implements HandlerInterface
{
    public function send(string $recipient_phone_number, string $content) : bool {
        $sms_service = new SMSService();
        return $sms_service -> send($recipient_phone_number, $content);
    }
}

?>