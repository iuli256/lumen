<?php
/**
 * Created by PhpStorm.
 * User: iuli
 * Date: 5/23/2018
 * Time: 9:17 PM
 */
namespace App\Discount;
use App;
class DiscountSwitches
{
    /**
     * Check if order meet the condition for applying discount
     * if order have products in category 2 and quantity > 5 then
     * it has discount and return Switches if not will return None
     * @param array $data order json decoded
     * @return string ('Switches' if has discount / 'None' if it hasn't)
     */

    public static function checkDiscount($data)
    {
        $product = new App\Product();
        foreach ($data->items as $item) {
            $category = $product->getCategory($item->{'product-id'});
            if ((int)$category == 2 && (int)$item->quantity > 5) {
                return "Switches";
            }
        }
        return "None";
    }


    /**
     * Compute discount value by substracting the value of 6th product on
     * category 2 from order
     * @param array $data order json decoded
     * @return float (discount value)
     */

    public static function getDiscount($data){
        $product = new App\Product();
        $discount = 0;
        foreach ($data->items as $item) {
            $category = $product->getCategory($item->{'product-id'});
            if ((int)$category == 2 && (int)$item->quantity > 5){
                $x = (int)$item->quantity % 6;
                $freeProducts = ((int)$item->quantity  - $x)  / 6;
                $discount += $freeProducts * floatval($item->{'unit-price'});
            }
        }

        return $discount;
    }
}