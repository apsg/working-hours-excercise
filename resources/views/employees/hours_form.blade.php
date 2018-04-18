@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Working hours</div>

                <div class="card-body">
                   	<p>Add or update employee's working hours</p>
					
					<employee-working-hours 
						:employees="{{ json_encode($employees) }}"
						@saved="onSaved"></employee-working-hours>

               </div>
           </div>
       </div>
   </div>
</div>
@endsection