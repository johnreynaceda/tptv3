<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SurveyResult;
use App\Models\SelectedCourse;

class SurveyResultMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       // $user = $request->user(); // Assuming you have authentication and user model

        if (!SurveyResult::where('user_id', auth()->user()->id)->exists() && !SelectedCourse::where('user_id', auth()->user()->id)->exists() ) {
            return redirect()->route('show.survey')->with('error', 'You must have a survey result to access this page.');
        }elseif(SurveyResult::where('user_id', auth()->user()->id)->exists() && !SelectedCourse::where('user_id', auth()->user()->id)->exists() )
        {
            return redirect()->route('select.courses')->with('error', 'You must have a selected course to access this page.');
        }

        return $next($request);
    }
}
