<?php
use PHPUnit\Framework\TestCase;
use QuotesApi\RequestValidator;

class RequestTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $config = parse_ini_file('config/conf.ini'); 

        $this->http = new GuzzleHttp\Client([
            'base_uri' => $config["base_uri"], 
            'exceptions' => false
        ]);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testGetSteveJobs()
    {
        $response = $this->http->request('GET', 'steve-jobs');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetStevaJobs()
    {
        $response = $this->http->request('GET', 'steva-jobs');
        $this->assertEquals(404, $response->getStatusCode());
    }    

    public function testGetSteve_Jobs()
    {
        $response = $this->http->request('GET', 'steve_jobs');
        $this->assertEquals(400, $response->getStatusCode());
    }  

    public function testSmallLimitParam()
    {
        $response = $this->http->request('GET', 'steve-jobs?limit=1');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLimitSetTo1()
    {
        $response = $this->http->request('GET', 'steve-jobs?limit=1');
        $this->assertEquals(1, count(json_decode($response->getBody())));
    }  

    public function testReturning1QuoteIfNoLimitSet()
    {
        $response = $this->http->request('GET', 'steve-jobs');
        $this->assertEquals(1, count(json_decode($response->getBody())));
    }      

    public function testLargeLimitParam()
    {
        $response = $this->http->request('GET', 'steve-jobs?limit=999999');
        $this->assertEquals(400, $response->getStatusCode());
    } 

    public function testPutReturningNotAllowed()
    {
        $response = $this->http->request('PUT', 'user-agent', ['http_errors' => false]);

        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testPostReturningNotAllowed()
    {
        $response = $this->http->request('POST', 'user-agent', ['http_errors' => false]);

        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testDeleteReturningNotAllowed()
    {
        $response = $this->http->request('DELETE', 'user-agent', ['http_errors' => false]);

        $this->assertEquals(405, $response->getStatusCode());
    }    
}