<?php 
/**
 * Handles API request and routing based on HTTP method
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

use QuotesApi\ApiResponse;
use QuotesApi\QuotesFeed;

class ApiRequest
{
    private $method;
    private $data_source;
    private $caching;
    private $config;

    function __construct($data_source, $config, $caching = false)
    {
        $this->data_source = $data_source;
        $this->caching = $caching;
        $this->config = $config;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     *Processing request to REST API based on the HTTP Method
     *@return void
     */
    public function process() : void
    {
        $this->setHeaders();

        switch($this->method){
            case "GET":
                $this->getQuotesFromFeed();
                break;
            default:
                ApiResponse::returnExit(
                    405, 
                    $this->config["message_method_not_allowed"]
                );
                break;
          }
    }

    /**
     *Starting the process of getting quotes from the feed
     *@return void
     */
    private function getQuotesFromFeed() : void
    {
        # get validated request data
        list($author_name, $limit) = $this->getValidatedRequest();

        # getting quotes from the feed
        $feed = new QuotesFeed($this->data_source, $this->config, $this->caching);
        $quotes = $feed->getQuotes($author_name, $limit);
    }

    /**
     *Setting correct HTTP headers for JSON returning format
     *@return void
     */
    private function setHeaders() : void
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    }

    /**
     *Getting validated author's name and limit of quotes from the request
     *@return array - [string Author's name, integer Limit]
     */
    private function getValidatedRequest() : array
    {
        RequestValidator::validateOrFailHttpGet($this->config);

        # if limit is in use, set its value or set 1
        $limit  = array_key_exists('limit', $_GET) ? $_GET["limit"] : 1;
        $author_name = $_GET["author"];

        return array($author_name, $limit);
    }
}