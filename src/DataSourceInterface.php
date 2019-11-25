<?php 
/**
 * Interface for data sources
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

interface DataSourceInterface
{
    public function getQuotesByAuthor(string $author_name) : array;
}