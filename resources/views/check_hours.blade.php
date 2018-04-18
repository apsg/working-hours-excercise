@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Check working hours</div>

                <div class="card-body">
					
					<show-hours days=5></show-hours>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection