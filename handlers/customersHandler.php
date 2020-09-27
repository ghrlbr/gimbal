<?php

class CustomersHandler extends Handler implements HandlerInterface
{
    public function is_verification_code_valid(int $customer_id, string $verification_code) : bool {

        $customers_service = new CustomersService();
        return $customers_service -> exists(
            [
                'id' => $customer_id,
                'verification_code' => $verification_code
            ]
        );
    }
    public function get_id_by_phone_number(string $phone_number) : int {

        $customers_service = new CustomersService();
        $customers = $customers_service -> search(
            [
                'phone_number' => $phone_number
            ]
        );

        return $customers[0] -> id;
    }
    public function generate_verification_code() : string {

        $position_0 = rand(0, 9);
        $position_1 = rand(0, 9);
        $position_2 = rand(0, 9);
        $position_3 = rand(0, 9);

        return $position_0 . $position_1 . $position_2 . $position_3;
    }
    public function update_verification_code(int $customer_id, string $verification_code) : bool {

        $customers_service = new CustomersService();
        return $customers_service -> edit($customer_id,
            [
                'verification_code' => $verification_code
            ]
        );
    }
    public function sign_up(string $phone_number) : int{

        $customers_service = new CustomersService();
        return $customers_service -> add(
            [
                'phone_number' => $phone_number
            ]
        );
    }
    public function is_signed_up(string $phone_number) : bool {

        $customers_service = new CustomersService();
        return $customers_service -> exists(
            [
                'phone_number' => $phone_number
            ]
        );
    }
}

?>