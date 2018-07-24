<?php
/**
 * Created by PhpStorm.
 * User: iuli
 * Date: 5/17/2018
 * Time: 9:49 PM
 */

namespace App;


class Customer
{
    protected $com;
    public function __construct()
    {
        $com=new Communication();
        $this->com=$com;
    }

    /**
     * Get the revenue of a customer by id
     * @param int $id
     * @return float (revenue value)
     */
    public function getRevenue($id){
        $file = $this->com->callApi("customers");
        $data = json_decode($file);

        foreach($data as $arrayInf) {
            if((int)$arrayInf->id == (int)$id) {
                return floatval($arrayInf->revenue);
            }
        }
        return null;
    }
}