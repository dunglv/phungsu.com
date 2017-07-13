<?php

namespace App\Helpers;

/**
* 
*/
class Helper
{
	
	function __construct()
	{
		# code...
	}

	public static function str_rand($len='')
	{
		$pattern = 'abc0def1ghi2jkl3mno4pqr5stu6vwx7yzA8BCD9EFG0HIJ_KLMNOPQRSTUVWXYZ';
		$str = '';
		for ($i=0; $i < $len; $i++) { 
			$str .= $pattern[rand(0, strlen($pattern)-1)];
		}

		return '_PS_'.$str;
	}
}