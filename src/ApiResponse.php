<?php 
/**
 * Handles valid HTTP responses
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

class ApiResponse
{
	/**
     *Returns message and specific HTTP code, exiting
     *@param int $code HTTP Code
     *@param string $message Mesage with description
     *@return void
     */
	public static function returnExit(int $code, string $message) : void
	{
		echo $message;
		http_response_code($code);
		exit();
	}

	/**
     *Returns data as JSON
     *@param array $data Data to be returned
     *@return void
     */
	public static function returnData(array $data) : void
	{
		echo json_encode($data);
	}
}