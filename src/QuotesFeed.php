<?php
/**
 * Feed of quotes
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

use QuotesApi\ApiResponse;
use QuotesApi\QuotesDatafile;

class QuotesFeed
{
    private $data_source;
    private $caching;
    private $config;

    function __construct(DataSourceInterface $data_source, $config, $caching = false)
    {
        $this->data_source = $data_source;
        $this->caching = $caching;
        $this->config = $config;
    }

    /**
     *Decode JSON data and returns quotes portion
     *@param string $author_name Author's name
     *@param int $limit Limit of returned quotes
     *@return void
     */
    public function getQuotes(string $author_name, int $limit) : void
    {
        
        # fetch and limit quotes
        $quotes = $this->limitQuotes(
            $this->fetchQuotesFromCacheOrDataSource($author_name), 
            $limit);

        if (empty($quotes)) {
            ApiResponse::returnExit(
                404,
                $this->config["message_not_found"]
            );
        } else {
            ApiResponse::returnData($quotes);
        }
        
    }

    /**
     *Fetching quotes by author's name from the cache or from the data source
     *@param string $author_name Author's name
     *@return array Full list of quotes
     */
    private function fetchQuotesFromCacheOrDataSource(string $author_name) : array
    {
        # if caching is in use, get all quotes from the cache first
        if ($this->caching) {
            $quotes = $this->caching->getAllQuotesByAuthor($author_name);
        }

        # if there are no cached quotes for this author_name, get them from the data source and cache them
        if (empty($quotes)) {
            $quotes = $this->data_source->getQuotesByAuthor($author_name);

            if ($this->caching) {
                $this->caching->cacheQuotesForAuthor($author_name, $quotes);
            }
        }

        # if randomizing the result is set then randomize order of outputed quotes
        if ($this->config["randomized_result"]) {
            $quotes = $this->randomizeQuotes($quotes);
        }

        return $quotes;
        
    }

    /**
     *Limiting number of returned quotes
     *@param array $quotes Quotes
     *@param int $limit Limit of returned quotes
     *@return void
     */
    private function limitQuotes(array $quotes, int $limit) : array
    {
        return array_slice($quotes, 0, $limit);
    }

    /**
     *Randomizing order of returned quotes if set so in the config file
     *@param array $quotes Quotes
     *@return array Randomized quotes
     */
    private function randomizeQuotes(array $quotes) : array
    {
        shuffle($quotes);
        return $quotes;
    }
}