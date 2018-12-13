@extends('app')

@section('title', 'Prototype')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger rounded-0">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-dark mt--6">
	<div class="container text-center">
		<div class="row justify-content-center align-items-center vh-100">
			<div class="col-md-4">
				<h1 class="header-title">Life Happens...</h1>
				<p class="header-subtitle">Enter your birthday below, to see what has happened in your life so far, without you probably not knowing.</p>
				<hr>
				<div class="card">
					<div class="card-body">
						<form method="get" action="/stats">
							<div class="form-group">
                      			<input type="number" class="form-control mb-2" name="day" placeholder="Day" autofocus="true">
                    		</div>
		                    <div class="form-group">
		                      	<input type="number" class="form-control mb-2" name="month" placeholder="Month">
		                    </div>
		                    <div class="form-group">
		                      	<input type="number" class="form-control mb-2" name="year" placeholder="Year">
		                    </div>
                    		<button type="submit" class="btn btn-primary mb-2 btn-block">Submit</button>
		       			</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@if ($human_birthday)
<div id="stats" class="bg-light p-5">
	<div class="container text-center">
		<p class="display-4 light mt-5 mb-4">Born on <span class="text-warning">{{ $human_birthday }}</span></p>
		<p class="lead">Which was <span class="text-info">{{ number_format($time_between_now_and_birthday->days) }}</span> {{ str_plural('day', $time_between_now_and_birthday->days) }} ago.</p>
		<p class="lead mt-3">You are <span class="text-info">{{ $time_between_now_and_birthday->y }}</span> {{ str_plural('year', $time_between_now_and_birthday->y) }}, <span class="text-warning">{{ $time_between_now_and_birthday->m }}</span> {{ str_plural('month', $time_between_now_and_birthday->m) }} and <span class="text-danger">{{ $time_between_now_and_birthday->d }}</span> {{ str_plural('day', $time_between_now_and_birthday->d) }} old</p>
        <p class="lead">You have been alive for <span class="text-warning" id="hours_alive"></span> hours or <span class="text-danger" id="minutes_alive"></span> minutes or <span class="text-info" id="seconds_alive"></span> seconds.</p>
	</div>
</div>

<div class="bg-dark p-5">
	<div class="container">
		<div class="row p-5">
			<div class="col-12 col-md-6">
				<div class="card">
				  <div class="card-body text-center">
				  	<img src="{{ asset('starsigns/gemini.png') }}">
				  	<h4 class="display-4 mt-4">You are a <span class="text-info">{{ $starsign }}</span></h4>
				  </div>
				</div>				
			</div>
			<div class="col-12 col-md-6">
				<div class="card">
				  <div class="card-body text-center">
				<div class="d-flex justify-content-center pt-5 pb-5">
				@for ($i = 9; $i > 0; $i--)
					<div style="height: 19px; width: 19px; background-color: {{ $birthstone['color'] }}; opacity:0.{{ $i }}" class="m-1"></div>
				@endfor
				</div>
				  	<h4 class="display-4 mt-4">Your Birthstone is <span style="color: {{ $birthstone['color'] }}">{{ ucfirst($birthstone['name']) }}</span></h4>
				  </div>
				</div>				
			</div>						
		</div>
	</div>
</div>

<div class="bg-light p-5">
	<div class="container text-center">
		<div class="row p-5">
			@foreach ($milestone_values as $key => $milestone)
			<div class="col-12 col-md-4">
				<div class="card bg-dark">
					<div class="card-body">
					  <h2 class="light">{{ number_format($key) }} Days Old</h3>
					  <p class="lead {{ \Carbon\Carbon::parse($milestone)->isPast() ? 'text-success' : 'text-danger' }} mb-0">{{ $milestone }}</p>
					</div>
				</div>
			</div>
			@endforeach
			<div class="col-12 col-md-4">
				<div class="card bg-dark">
					<div class="card-body">
					  <h2 class="light">44,694 Days Old</h3>
					  <p class="lead text-info mb-0">Longest Recorded Lifespan</p>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>




@endif


	<!-- @if ($human_birthday)
	<div class="bg-success mt-0 p-5">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-8 text-center">
					<span class="display-4">{{ $human_birthday }}</span>
				</div>
			</div>
		</div>
	</div>
	<div class"bg-black">
		sadkfopsfpkopkfpsdko
	</div>
	@endif -->
@endsection

@push('scripts')
 <script type="application/javascript">
 	var seconds = {!! $seconds_between_now_and_birthday !!};
 	var minutes = {!! $minutes_between_now_and_birthday !!};
 	var hours = {!! $hours_between_now_and_birthday !!};
 
	show_value();
	setInterval(function(){
	    seconds += 1;
	    show_value();
	}, 1000);
	setInterval(function(){
	    minutes += 1;
	    show_value();
	}, 60000);
	setInterval(function(){
	    hours += 1;
	    show_value();
	}, 3600000);	
	function show_value(){
	    document.getElementById("seconds_alive").innerHTML = seconds.toLocaleString();
	    document.getElementById("minutes_alive").innerHTML = minutes.toLocaleString();
	    document.getElementById("hours_alive").innerHTML = hours.toLocaleString();
	}
 </script>
@endpush