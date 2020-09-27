<?php

class SMSService extends Service implements ServiceInterface
{
    private $sms_service_api_token = SMS_SERVICE_API_TOKEN;

    public function send(string $recipient_phone_number, string $content) : bool {

        $total_voice = new TotalVoice\Client($this -> sms_service_api_token);
        $total_voice = $total_voice -> sms -> enviar($recipient_phone_number, $content);

        $total_voice_return_status_code = $total_voice -> getStatusCode();

        if($total_voice_return_status_code === 200)
            return true;
        return false;
    }
}

?>