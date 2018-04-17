<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    
	protected $fillable = ['name'];

	/**
	 * Interwały dla danego pracownika.
	 * @return [type] [description]
	 */
	public function time_intervals(){
		return $this->hasMany(\App\TimeInterval::class);
	}

}
