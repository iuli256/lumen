<?php
/**
 * Created by PhpStorm.
 * User: iuli
 * Date: 5/17/2018
 * Time: 8:16 PM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Mockery\Exception;
use GuzzleHttp\Exception\ClientException;

class Communication extends Model
{

    /**
     * Call external api in order to get Customer and Product information
     * @param strimg $key (product or customer )
     * @return string the response from api
     */
    public function callApi($key)
    {
        try {

        $client = new Client();

        $response = $client->request('GET', env('API') . $key . '.json');

        if ($response->getStatusCode() == 200) {
            return $response->getBody()->getContents();
        }
        }
        catch (ClientException $e){
            return $e->getCode();
        }
    }

}