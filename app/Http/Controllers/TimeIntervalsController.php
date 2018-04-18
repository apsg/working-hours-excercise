<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Rules\Time;
use App\Rules\EndingTime;
use App\Rules\FutureDate;
use App\TimeInterval;
use Illuminate\Http\Request;

class TimeIntervalsController extends Controller
{
    
	/**
	 * Zwraca godziny pracy w najbliższych N dniach
	 * @param  integer $days    [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function index($days){

		$startingDate = Carbon::now()->addDays(1)->format('Y-m-d');
		$endingDate = Carbon::now()->addDays($days)->format('Y-m-d');

		$intervals = TimeInterval::where('date', '>=', $startingDate)
			->where('date', '<=', $endingDate)
			->orderBy('date')
			->orderBy('starting_hour')
			->get()
			->groupBy('date')
			->all();

		foreach ($intervals as $key => $group) {
			$intervals[$key] = TimeInterval::reduce($group->all());
		}

		return $intervals;
	}

	/**
	 * Tworzy nowe godziny pracy dla podanego pracownika lub
	 * aktualizuje istniejące godziny pracy.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function storeOrUpdate(Request $request){

		$request->validate([
			'employee_id' 	=> 'required|numeric|exists:employees,id',
			'date'			=> ['required','date', new FutureDate],
			'starting_hour' => ['required', new Time],
			'ending_hour' 	=> ['required', new Time, new EndingTime],
		]);

		$ti = TimeInterval::where('employee_id', $request->employee_id)
			->where('date', $request->date)
			->first();

		if($ti){
			$ti->update([
				'starting_hour' => $request->starting_hour,
				'ending_hour'	=> $request->ending_hour,
			]);

			return response()
				->json("Employee's working hours updated", 200);
		}else{
			TimeInterval::create([
				'employee_id'	=> $request->employee_id,
				'date'			=> $request->date,
				'starting_hour' => $request->starting_hour,
				'ending_hour'	=> $request->ending_hour,
			]);

			return response()
				->json("Employee's working hours created", 200);
		}

	}

}
