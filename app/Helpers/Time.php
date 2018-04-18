<?php

namespace App\Helpers;

class Time{
	
	/**
	 * Porównuje dwie godziny i zwraca wynik -1/0/1
	 * @param  string $time1 [description]
	 * @param  string $time2 [description]
	 * @return Integer        [description]
	 */
	public static function compare($time1, $time2){

		$time1 = explode(":", $time1);
		$time2 = explode(":", $time2);

		if(count($time1) != 2 || count($time2) != 2){
			throw new \Exception('Invalid hours format provided.');
		}

		if($time1[0] < $time2[0])
			return -1;

		if($time1[0] > $time2[0])
			return 1;

		if($time1[0] == $time2[0]){
			if($time1[1] < $time2[1])
				return -1;

			if($time1[1] > $time2[1])
				return -1;
			
			return 0;
		}

		return false;
	}

}