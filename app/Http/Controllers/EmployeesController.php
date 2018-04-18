<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    
    /**
     * Pokaż widok dodawania godzin pracy pracownika.
     * @return Response  laravel response
     */
	public function hoursForm(){

		$employees = Employee::orderBy('name', 'ASC')->get();

		return view('employees.hours_form')->with(compact('employees'));
	}

}
