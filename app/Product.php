<?php
/**
 * Created by PhpStorm.
 * User: iuli
 * Date: 5/17/2018
 * Time: 9:49 PM
 */

namespace App;


class Product
{
    protected $com;
    public function __construct()
    {
        $com=new Communication();
        $this->com=$com;
    }

    /**
     * Get product category by product id
     * @param int $id product id
     * @return int (category)
     */
    public function getCategory($id){
        $file = $this->com->callApi("products");
        $data = json_decode($file);

        foreach($data as $arrayInf) {
            if((int)$arrayInf->id == (int)$id) {
                return intval($arrayInf->category);
            }
        }
        return null;
    }
}