<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ApplicationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
    public function testBasicExample()
    {
        $this->json('POST', '/api/discount/', ['data' => '{"id": "3","customer-id": "3","items": [{"product-id": "A101", "quantity": "2", "unit-price": "9.75", "total": "19.50"}, {"product-id": "A102", "quantity": "1", "unit-price": "49.50", "total": "49.50"}],"total": "69.00"}'])
            ->seeJson([
                'discountType' => 'Tools',
                'discount' => 3.9
            ]);
    }

    public function testDiscountAllGetDiscount(){
        $data = "{
              \"id\": \"2\",
              \"customer-id\": \"2\",
              \"items\": [
                {
                  \"product-id\": \"B102\",
                  \"quantity\": \"5\",
                  \"unit-price\": \"4.99\",
                  \"total\": \"24.95\"
                }
              ],
              \"total\": \"24.95\"
            }";
        $d = \App\Discount\DiscountAll::checkDiscount($data);
        $res = "{
    \"discountType\": \"All\",
    \"discount\": 2.495
},lo0";
        $this->assertEquals($d, $res);
    }
}
