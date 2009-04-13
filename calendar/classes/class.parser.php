<?php
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html 
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Parser Class
 * 
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Parser
 * @author		Rick Ellis
 * @link		http://www.codeigniter.com/user_guide/libraries/parser.html
 */
class Parser {

	var $l_delim = '{';
	var $r_delim = '}';
	var $object;
		
	/**
	 *  Parse a template
	 *
	 * Parses pseudo-variables contained in the specified template, 
	 * replacing them with the data in the second param
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */
	function parse($template, $data, $return = TRUE, $empty = TRUE)
	{
		
		if ($template == '')
		{
			return FALSE;
		}
		
		foreach ($data as $key => $val)
		{
			if ( ! is_array($val))
			{
				$template = $this->_parse_single($key, $val, $template);
			}
			else
			{
				$template = $this->_parse_pair($key, $val, $template);		
			}
		}

        if ($empty)
        {
            $pattern  = array(  '/{(\w*)}+(.*){\/\\1}/Us',
                                '/{(\w*)}/Us',
                        );
            $replace  = '';
            $template = preg_replace($pattern, $replace, $template);
        }
        		
		if ($return == FALSE)
		{
			echo $template;
		}
		
		return $template;
	}
	// END set_method()
	
	// --------------------------------------------------------------------
	
	/**
	 *  Set the left/right variable delimiters
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	function set_delimiters($l = '{', $r = '}')
	{
		$this->l_delim = $l;
		$this->r_delim = $r;
	}
	// END set_method()
	
	// --------------------------------------------------------------------
	
	/**
	 *  Parse a single key/value
	 *
	 * @access	private
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function _parse_single($key, $val, $string)
	{
		return str_replace($this->l_delim.$key.$this->r_delim, $val, $string);
	}
	// END set_method()
	
	// --------------------------------------------------------------------
	
	/**
	 *  Parse a tag pair
	 *
	 * Parses tag pairs:  {some_tag} string... {/some_tag}
	 *
	 * @access	private
	 * @param	string
	 * @param	array
	 * @param	string
	 * @return	string
	 */
	function _parse_pair($variable, $data, $string)
	{	
		if (FALSE === ($match = $this->_match_pair($string, $variable)))
		{
			return $string;
		}

		$str = '';
		foreach ($data as $row)
		{
			$temp = $match['1'];
			foreach ($row as $key => $val)
			{
				if ( ! is_array($val))
				{
					$temp = $this->_parse_single($key, $val, $temp);
				}
				else
				{
					$temp = $this->_parse_pair($key, $val, $temp);
				}
			}
			
			$str .= $temp;
		}
		
		return str_replace($match['0'], $str, $string);
	}
	// END set_method()
	
	// --------------------------------------------------------------------
	
	/**
	 *  Matches a variable pair
	 *
	 * @access	private
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	function _match_pair($string, $variable)
	{
		if ( ! preg_match("|".$this->l_delim . $variable . $this->r_delim."(.+)".$this->l_delim . '/' . $variable . $this->r_delim."|s", $string, $match))
		{
			return FALSE;
		}
		
		return $match;
	}
	// END _match_pair()

}

?>