<?php

class CustomersTokensHandler extends Handler implements HandlerInterface
{
    public function generate_token(int $customer_id) : string {

        $tokens_handler = new TokensHandler();
        return $tokens_handler -> generate_token(
            [
                'platform_id' => CUSTOMER_PLATFORM_ID,
                'customer_id' => $customer_id
            ]
        );
    }
}

?>