<?php
/**
 * Created by PhpStorm.
 * User: skycheung
 * Date: 2017/1/11
 * Time: 14:36
 */

namespace ecjtunet\schoolservice;

use GuzzleHttp\Client;

class SchoolServiceAPI
{
    function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('SCHOOL_SERVICE_API_URI')
        ]);
    }

    public function confirmName($student_id)
    {
        $response = $this->client->post('confirmName',[
            'form_params' => [
                'student_id' => $student_id
            ]
        ]);
        dd($response);
    }
}