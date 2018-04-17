<?php

namespace App;

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

}
