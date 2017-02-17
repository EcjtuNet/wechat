<?php
/**
 * Created by PhpStorm.
 * User: skycheung
 * Date: 2017/1/11
 * Time: 14:36
 */

namespace ecjtunet\schoolservice;

use EasyWeChat\Core\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

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
        $json_body = $response->getBody();
        $body = json_decode($json_body, true);
        if ($body['status'])
        {
            return $body['data']['name'];
        }
        else
        {
            return false;
        }
    }

    public function savePassword($student_id, $password)
    {
        $response = $this->client->post('savePassword',[
            'form_params' => [
                'student_id' => $student_id,
                'password' => $password
            ]
        ]);
        $json_body = $response->getBody();
        $body = json_decode($json_body, true);
        if ($body['status'])
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function queryScore($student_id, $password, $year, $term)
    {
        try{
            $response = $this->client->post('queryScore',[
                'form_params' => [
                    'student_id' => $student_id,
                    'password' => $password,
                    'year' => $year,
                    'term' => $term
                ]
            ]);
            $json_body = $response->getBody();
            $body = json_decode($json_body, true);
            if ($body['status'])
            {
                return [
                    'code' => 200,
                    'data' => $body['data']
                ];
            }
            else
            {
                return [
                    'code' => 200,
                    'data' => null
                ];
            }
        }
        catch (ClientException $e)
        {
            // 4xx
            return [
                'code' => 400,
                'data' => null
            ];
        }
        catch (ServerException $e)
        {
            // 5xx
            return [
                'code' => 500,
                'data' => null
            ];
        }
        catch(Exception $e)
        {
            return [
                'code' => false,
                'data' => null
            ];
        }
    }

    public function queryClass($student_id, $password, $year, $term)
    {
        try{
            $response = $this->client->post('queryClass',[
                'form_params' => [
                    'student_id' => $student_id,
                    'password' => $password,
                    'year' => $year,
                    'term' => $term
                ]
            ]);
            $json_body = $response->getBody();
            $body = json_decode($json_body, true);
            if ($body['status'])
            {
                return [
                    'code' => 200,
                    'data' => $body['data']
                ];
            }
            else
            {
                return [
                    'code' => 200,
                    'data' => null
                ];
            }
        }
        catch (ClientException $e)
        {
            // 4xx
            return [
                'code' => 400,
                'data' => null
            ];
        }
        catch (ServerException $e)
        {
            // 5xx
            return [
                'code' => 500,
                'data' => null
            ];
        }
        catch(Exception $e)
        {
            return [
                'code' => false,
                'data' => null
            ];
        }
    }

    public function queryExam($student_id, $password, $year, $term)
    {
        try{
            $response = $this->client->post('queryExam',[
                'form_params' => [
                    'student_id' => $student_id,
                    'password' => $password,
                    'year' => $year,
                    'term' => $term
                ]
            ]);
            $json_body = $response->getBody();
            $body = json_decode($json_body, true);
            if ($body['status'])
            {
                return [
                    'code' => 200,
                    'data' => $body['data']
                ];
            }
            else
            {
                return [
                    'code' => 200,
                    'data' => null
                ];
            }
        }
        catch (ClientException $e)
        {
            // 4xx
            return [
                'code' => 400,
                'data' => null
            ];
        }
        catch (ServerException $e)
        {
            // 5xx
            return [
                'code' => 500,
                'data' => null
            ];
        }
        catch(Exception $e)
        {
            return [
                'code' => false,
                'data' => null
            ];
        }
    }
}