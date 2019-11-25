<?php 
/**
 * Predis client for Redis - Caching
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

use QuotesApi\CachingInterface;
use \Predis;

class PredisCaching implements CachingInterface
{

    private $predis;
    private $selected_quotes = array();

    function __construct($config)
    {    
        require "predis/autoload.php";
        Predis\Autoloader::register();
        $this->connect($config["redis_scheme"], $config["redis_host"], $config["redis_port"]);
    }

    /**
     *Putting author and his/her quotes to the cache
     *@param string $author_name Author's name
     *@param array $quotes Author's quotes
     *@return void
     */
    public function cacheQuotesForAuthor (string $author_name, array $quotes) : void
    {
        foreach ($quotes as $quote) {
            $this->putQuote($author_name, $quote);
        }
    }

    /**
     *Clearing the cache
     *@return void
     */
    public function emptyCache () : void
    {
        $this->predis->flushAll();
    }

    /**
     *Clearing cached quotes for specific author
     *@param string $author_name Author's name
     *@return void
     */
    public function emptyCachedQuotesForAuthor (string $author_name) : void
    {
        $this->predis->ltrim($author_name, -1, 0);
    }    

    /**
     *Getting all the author's quotes from the cache
     *@param string $author_name Author's name
     *@return array
     */
    public function getAllQuotesByAuthor (string $author_name) : array
    {
        return $this->predis->lrange($author_name, 0, -1);
    }

    /**
     *Put one quote to the cache's list
     *@param string $author_name Author's name
     *@param string $quote Author's quote
     *@return void
     */
    private function putQuote (string $author_name, string $quote) : void
    {
        $this->predis->rpush($author_name, $quote);
    }

    /**
     *Estabilishing connection to the Redis
     *@param string $redis_scheme Redis' scheme
     *@param string $redis_host Redis' host name
     *@param int $redis_port Redis host's port
     *@return void
     */
    private function connect (string $redis_scheme, string $redis_host, int $redis_port) : void
    {
        try {
            $this->predis = new Predis\Client(array(
                "scheme" => $redis_scheme,
                "host" => $redis_host,
                "port" => $redis_port));
        }
        catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
