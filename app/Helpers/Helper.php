<?php

namespace App\Helpers;

use Carbon\Carbon;

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

	public static function datetime_recent($datetime = '2017-7-14 23:26:11')
	{
		Carbon::setLocale('vi');
		$now = Carbon::now('Asia/Ho_Chi_Minh');
		$dt = Carbon::parse($datetime);
		$diff = $now->diffForHumans($dt, true);
		return $diff;
	}
}