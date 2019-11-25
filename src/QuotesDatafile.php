<?php 
/**
 * Datafile handler representing data source for the quotes
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

use QuotesApi\DataSourceInterface;
use QuotesApi\DataHelper;
use QuotesApi\ApiResponse;

class QuotesDatafile implements DataSourceInterface
{
    private $json_data;

    function __construct($config)
    {    
        $this->json_data = $this->loadData($config);
    }

    /**
     *Getting array of quotes by author's name
     *@param string $author_name Author's name
     *@return array of quotes
     */
    public function getQuotesByAuthor(string $author_name) : array
    {
        $quotes = array();
        $author_name = DataHelper::unifyAuthorName($author_name);

        foreach ($this->json_data as $author_quote) {
            if (DataHelper::unifyAuthorName($author_quote->author) == $author_name) {
                $quotes[] = DataHelper::formatReturningQuote($author_quote->quote);
            }
        }

        return $quotes;
    }

    /**
     *Decode JSON data and returns quotes portion
     *@param string $data JSON string data
     *@return array of quotes
     */
    private function parseJsonData(string $data) : array
    {
        $data = json_decode($data);
        return $data->quotes;
    }

    /**
     *Load data file based on the config gile
     *@param array $config Parsed configuration file
     *@return array of quotes
     */
    private function loadData(array $config) : array
    {

        if(!$data = @file_get_contents($config["data_file_name"])) {
            ApiResponse::returnExit(
                500, 
                $config["message_data_error"]
            );
        }

        return $this->parseJsonData($data);
    }    
}