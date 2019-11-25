<?php 
/**
 * Request data validation
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

use QuotesApi\ApiResponse;

class RequestValidator
{

	/**
     *Starting validation of the request parameters
     *@param array $config Parsed configuration file
     *@return void
     */
	public static function validateOrFailHttpGet(array $config) : void
	{
		self::validateAuthorName($config);
		self::validateLimit($config);
	}

	/**
     *Validating author's name from the GET request
     *exit if failing
     *@param array $config Parsed configuration file
     *@return void
     */
	private static function validateAuthorName($config) : void
	{
		$author = $_GET["author"];

		# fail if author contains different characters than alphanumeric and dashes
		if (!preg_match('/^[a-z0-9][a-z0-9-]*[a-z0-9]$/i', $author)) {
			ApiResponse::returnExit(
				400, 
				$config["message_bad_request_author_name"]
			);
		}
	}

	/**
     *Validating limit from the GET request
     *exit if failing
     *@param array $config Parsed configuration file
     *@return void
     */
	private static function validateLimit($config) : void
	{
		# check if limit is provided in the request, if not set as one
		$limit  = array_key_exists('limit', $_GET) ? $_GET["limit"] : 1;

		# fail if limit is larger than maximum allowed qotes for return
		if (($limit > $config["max_returned_qotes"]) === true) {
			ApiResponse::returnExit(
				400, 
				sprintf($config["message_bad_request_larger_limit"], $config["max_returned_qotes"])
			);
		}
	}

}