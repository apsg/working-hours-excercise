<?php

namespace App;

use App\Helpers\Time;
use Illuminate\Database\Eloquent\Model;

class TimeInterval extends Model
{
    
	protected $fillable = [
		'employee_id', 
		'date', 
		'starting_hour', 
		'ending_hour',
	];
	
	/**
	 * Pracownik, do którego przypisany jest ten przedział czasowy.
	 * @return [type] [description]
	 */
	public function employee(){
		return $this->belongsTo(\App\Employee::class);
	}

	// ------------ STATIC MEHTODS ----------------------------
	
	/**
	 * Sprawdza, czy dwa przedziały czasowe się zazębiają. 
	 * Jeśli tak, zwraca nowy przedział będący połączeniem
	 * zazębiających się przedziałów.
	 * @param  TimeInterval $time1 [description]
	 * @param  TimeInterval $time2 [description]
	 * @return [type]              [description]
	 */
	public static function intersection(TimeInterval $time1, TimeInterval $time2){

		if($time1->date != $time2->date)
			return false;

		if(Time::compare(
			$time1->starting_hour, 
			$time2->starting_hour
		) == -1 ){

			if(Time::compare(
				$time1->ending_hour, 
				$time2->starting_hour
			) == -1){
				return false;
			}

			$time1->id = null;
			$time1->employee_id = null;
			$time1->ending_hour = $time2->ending_hour;
			return $time1;

		}else{

			if(Time::compare(
				$time2->ending_hour, 
				$time1->starting_hour
			) == -1){
				return false;
			}		

			$time2->id = null;
			$time2->employee_id = null;
			$time2->ending_hour = $time1->ending_hour;
			return $time2;
		}
	}

	/**
	 * Redukuje rekurencyjnie tablicę przedziałów czasowych.
	 * Sprawdza czy którekolwiek przedziały się zazębiają, 
	 * jeśli tak - zwraca zredukowaną tablicę.
	 * @param  [type] $array Tablica przedziałów
	 * @return [type]        Zredukowana tablica
	 */
	public static function reduce($array){

		if(count($array) == 1)
			return $array;

		for($i = 0; $i< count($array); $i++){
			for($j = $i+1; $j < count($array); $j++){

				if($combined = static::intersection($array[$i], $array[$j])){
					unset($array[$i]);
					unset($array[$j]);

					$array = array_merge($array, [$combined]);

					return static::reduce($array);
				}

			}
		}

		// No intersections found in the array - we can return it now.
		return $array;
	}

}
