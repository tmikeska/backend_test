<?php 
/**
 * Helper methods for data
 *
 * @copyright  2019 tomas.mikeska@gmail.com
 * @version    Release: 1
 */ 

namespace QuotesApi;

class DataHelper 
{

	/**
     *Unifying Author's name for comparing
     *Dashes are replaced with spaces, dots are removed 
     *and string is converted to lowercaprs
     *@param string $author_name Author's name
     *@return string
     */
	public static function unifyAuthorName($author_name) : string
	{
		# replacing dashes with spaces
		$author_name = str_replace('-', ' ', $author_name);

		# removing dots
		$author_name = str_replace('.', '', $author_name);

		# converting to lowercase
		$author_name = strtolower($author_name);

		return $author_name;
	}

	/**
     *Formating of the quote to desired format
     *Quote is trimmed, converted to uppercases 
     *and placing exclamation mark on the end if appropriate
     *@param string $quote Quote text
     *@return string
     */
	public static function formatReturningQuote($quote) : string
	{
		# removing empty spaces around the quote
		$quote = trim($quote);

		# converting to uppercase
		$quote = strtoupper($quote);

		# removing . or ! from the end of the quote
		if (substr($quote, -1) == '.' || substr($quote, -1) == '!') {
			$quote = substr($quote, 0, -1);
		}

		# adding ! to the end of the quote
		$quote .= '!';

		return $quote;
	}
}