<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function index(Request $request)
	{
		$time_between_now_and_birthday = null;
		$human_birthday = null;
		
		if ($request) {
		  if ($request->day && $request->month && $request->year) {
			$birthday = $request->year.'-'.$request->month.'-'.$request->day;
			$human_birthday = Carbon::parse($birthday)->format('l jS F Y');
			$seconds_between_now_and_birthday = Carbon::parse($birthday)->diffInSeconds(now());
			$minutes_between_now_and_birthday = Carbon::parse($birthday)->diffInMinutes(now());
			$hours_between_now_and_birthday = Carbon::parse($birthday)->diffInHours(now());
			$time_between_now_and_birthday = Carbon::parse($birthday)->diff(now());
			
			function zodiac($day, $month) {
			 // returns the zodiac sign according to $day and $month ( https://coursesweb.net/ )
			  $zodiac = array('', 'Capricorn', 'Aquarius', 'Pisces', 'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn');
			  $last_day = array('', 19, 18, 20, 20, 21, 21, 22, 22, 21, 22, 21, 20, 19);
			  return ($day > $last_day[$month]) ? $zodiac[$month + 1] : $zodiac[$month];
			}

            function birthstone($month) {
            	if ($month === 1) {
            		return ['name' => 'garnet', 'color' => '#781c2e'];
            	} elseif ($month === 2) {
            		return ['name' => 'amethyst', 'color' => '#9966CC'];
            	} elseif ($month === 3) {
            		return ['name' => 'aquamarine', 'color' => '#7fffd4'];
            	} elseif ($month === 4) {
            		return ['name' => 'diamond', 'color' => '#b9f2ff'];
            	} elseif ($month === 5) {
            		return ['name' => 'emerald', 'color' => '#27592D'];
            	} elseif ($month === 6) {
            		return ['name' => 'pearl', 'color' => '#eae0c8'];
            	} elseif ($month === 7) {
            		return ['name' => 'ruby', 'color' => '#e0115f'];
            	} elseif ($month === 8) {
            		return ['name' => 'peridot', 'color' => '#e6e200'];
            	} elseif ($month === 9) {
            		return ['name' => 'sapphire', 'color' => '#0f52ba'];
            	} elseif ($month === 10) {
            		return ['name' => 'opal', 'color' => '#AAC4C4'];
            	} elseif ($month === 11) {
            		return ['name' => 'topaz', 'color' => '#ffc87c'];
            	} elseif ($month === 12) {
            		return ['name' => 'turqoise', 'color' => '#40E0D0'];
            	}
            }			
			
			$starsign = zodiac(Carbon::parse($birthday)->format('d'), Carbon::parse($birthday)->format('n'));
			$birthstone = birthstone((int) Carbon::parse($birthday)->format('n'));
			$birth_month = Carbon::parse($human_birthday)->format('F');
			$birth_digit = Carbon::parse($human_birthday)->format('j');
			
			$milestones = [500, 1000, 2000, 5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000];
			$milestone_values = [];
			
			foreach ($milestones as $key => $milestone) {
				$milestone_values[$milestone] = Carbon::parse($birthday)->addDays($milestone)->format('l jS F Y');
			}
			
		  }
		}
		
		
	
//$jsondata = file_get_contents('https://history.muffinlabs.com/date/1/1');

//dd(json_decode($jsondata, true));

		
		return view('welcome', 
			compact([
			  'time_between_now_and_birthday',
			  'human_birthday',
			  'seconds_between_now_and_birthday',
			  'hours_between_now_and_birthday',
			  'minutes_between_now_and_birthday',
			  'starsign',
			  'birthstone',
			  'birth_month',
			  'birth_digit',
			  'milestone_values',
			])
		);
	}
	
	public function stats(Request $request)
	{
		
		$request->validate([
		    'day' => 'required',
		    'month' => 'required',
		    'year' => 'required',
		]);
		
		try {
    		Carbon::parse($request->get('year').'-'.$request->get('month').'-'.$request->get('day'));
		} catch (\Exception $e) {
    		return redirect('/')->withErrors('There was an error with the date you selected. Please try again.');
		}
		
		return redirect ('/'.$request->get('day').'/'.$request->get('month').'/'.$request->get('year').'#stats');
	}
}

