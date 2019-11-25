<?php 
/**
 * Interface for caching
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

interface CachingInterface
{
    public function cacheQuotesForAuthor(string $author_name, array $quotes) : void;
    public function getAllQuotesByAuthor(string $author_name) : array;
    public function emptyCachedQuotesForAuthor(string $author_name) : void;
    public function emptyCache() : void;
}