<?php

class AuthenticationHandler extends Handler implements HandlerInterface
{
    public function sign_in_as_customer(string $phone_number, string $verification_code) : array {

        $customers_handler = new CustomersHandler();

        // Verifica se o usuário está cadastrado
        $is_signed_up = $customers_handler -> is_signed_up($phone_number);
        
        if(!$is_signed_up)
            throw new Exception('E160820201929');


        // Obtêm o ID do usuário
        $customer_id = $customers_handler -> get_id_by_phone_number($phone_number);

        if(!$customer_id)
            throw new Exception('E160820201936');


        // Verifica se o código de verificação está correto
        $is_verification_code_valid = $customers_handler -> is_verification_code_valid($customer_id, $verification_code);

        if(!$is_verification_code_valid)
            throw new Exception('E160820201920');
    

        // Gera o token de acesso
        $customers_tokens_handler = new CustomersTokensHandler();
        $token = $customers_tokens_handler -> generate_token($customer_id);

        if(!$token)
            throw new Exception('E170820202049');

        return [
            'token' => $token
        ];
    }
    public function send_verification_code_to_customer(string $phone_number) : bool {

        $customers_handler = new CustomersHandler();
        $sms_handler = new SMSHandler();


        // Verifica se o usuário está cadastrado
        $is_signed_up = $customers_handler -> is_signed_up($phone_number);


        // Se o usuário não estiver cadastrado nós vamos cadastrar
        $customer_id = null;
        if(!$is_signed_up) $customer_id = $customers_handler -> sign_up($phone_number);
        else $customer_id = $customers_handler -> get_id_by_phone_number($phone_number);


        if(!$customer_id)
            throw new Exception('E160820201931');


        // Vamos gerar um código de verificação para o usuário
        $verification_code = $customers_handler -> generate_verification_code();
        $is_verification_code_updated = $customers_handler -> update_verification_code($customer_id, $verification_code);


        if(!$is_verification_code_updated)
            throw new Exception('E160820201933');

        
        // Vamos enviar um SMS com o código de verificação
        $verification_code_message = 'Esse é o seu código do Tanga ' . $verification_code;
        $is_verification_code_sent = $sms_handler -> send($phone_number, $verification_code_message);


        if(!$is_verification_code_sent)
            throw new Exception('E160820201934');

        return true;
    }
}

?>