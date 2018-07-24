<?php
/**
 * Created by PhpStorm.
 * User: iuli
 * Date: 5/23/2018
 * Time: 9:18 PM
 */
namespace App\Discount;
use App;
class DiscountTools
{
    /**
     * Check if order meet the condition for applying discount
     * if order have products in category 1 then it has discount and return
     * Tools if not will return None
     * @param array $data order json decoded
     * @return string ('Tools' if has discount / 'None' if it hasn't)
     */
    public static function checkDiscount($data)
    {
            $product = new App\Product();
            foreach ($data->items as $item) {
                $category = $product->getCategory($item->{'product-id'});
                if ((int)$category == 1) {
                    return "Tools";
                }
            }
            return "None";
    }


    /**
     * Compute discount value by getting 20% from the value of the cheapest
     * product from order
     * @param array $data order json decoded
     * @return float (discount value)
     */

    public static function getDiscount($data){
        $product = new App\Product();
        $minimUnitPrice = 0;
        $i = 0;
        $total = 0;
        foreach ($data->items as $item) {
            $category = $product->getCategory($item->{'product-id'});
            if ((int)$category == 1) {
                if ($i == 0) {
                    $minimUnitPrice = floatval($item->{'unit-price'});
                    $total = floatval($item->total);
                }
                if ($minimUnitPrice > floatval($item->{'unit-price'})) {
                    $minimUnitPrice = floatval($item->{'unit-price'});
                    $total = floatval($item->total);
                }
                $i++;
            }
        }

        return $total * 0.2;
    }
}