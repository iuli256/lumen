<?php
/**
 * Created by PhpStorm.
 * User: iuli
 * Date: 5/17/2018
 * Time: 6:18 PM
 */

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\Finder\Finder;

class DiscountController extends Controller{

    /**
     * Application entry point. On request is sent data and it check on all classes located in folder
     * App\Discount by executing static method checkDiscount with order as input param and if the return
     * is different from None it means that the current class meet all the necesary condition to apply a
     * discount. The it is execeuting getDiscount method with order as inpu parameter and will return the
     * value of discount
     * In order to add a new discount type you have to add a new class in App\Discount folder and the class
     * should have 2 static methods checkDiscount and getDiscount.
     * if checkDiscount return a different string than 'None' it means that it have a discount and the return
     * string is the name of the discount type. If it has a discount then it should be executed the static
     * method getDiscount in order to get the amount of the discount value
     * @param array $data order json decoded
     * @return array $return (discountType - the name of the discount, discount - the amount of discount)
     */
    public function discount(Request $request){
        $app = app()->basePath().'/app/Discount';
        $return = array();
        try {
            $data = json_decode($request->input('data'));

            $d = $this->_get_filenames($app);
            foreach($d as $s){
                $hasDiscount = $s::checkDiscount($data);
                if($hasDiscount != "None"){
                    $return['discountType'] = $hasDiscount;
                    $return['discount'] = $s::getDiscount($data);
                    return response()->json($return);
                }
            }

            $return['discountType'] = "None";
            $return['discount'] = 0;
        }
        catch (Exception $e){
            $return['error'] = $e->getCode();
        }
        return response()->json($return);
    }

    /**
     * Get the names of all files that are located in App\Discount directory on lumen folder
     * @param string $path absolute path to lumen root folder
     * @return array (discount value)
     */
    function _get_filenames($path) {
        $finderFiles = Finder::create()->files()->in($path)->name('*.php');
        $filenames = array();
        foreach ($finderFiles as $finderFile) {
            $filenames[] = "App\\Discount\\".$this->_get_classname($finderFile->getRealpath());
    }

        return $filenames;
    }

    /**
     * Get class name from file path
     * @param string $filename file path
     * @return string class name
     */
    function _get_classname($filename) {
        $directoriesAndFilename = explode('/', $filename);
        $filename = array_pop($directoriesAndFilename);
        $nameAndExtension = explode('.', $filename);
        $className = array_shift($nameAndExtension);

        return $className;
    }
}