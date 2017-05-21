<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class StatsController extends Controller
{
    /**
     * Display statistics on actions overdues by managers.
     *
     * @return \Illuminate\View\View
     */
    public function overdue(Request $request)
    {
    	$managersActive = User::active()->get();
    	$managersFired = User::fired()->get();

    	return view('stats.overdue', compact('managersActive', 'managersFired'));
    }

    /**
     * Display statistics on actions quantity by managers for time period.
     *
     * @return \Illuminate\View\View
     */
    public function output(Request $request)
    {
        if ($request->has('outputDates'))
        {
            $dtArray = preg_split('/ - /', $request->outputDates);
            $dtFrom = Carbon::parse($dtArray[0]);
            $dtTo = Carbon::parse($dtArray[1]);
        }
        else
        {
            $dtFrom = Carbon::parse("first day of this month");
            $dtTo = Carbon::parse("last day of this month");
        }

    	$managersActive = User::active()->get();
    	$managersFired = User::fired()->get();

    	return view('stats.output', compact('managersActive', 'managersFired', 'dtFrom', 'dtTo'));
    }

    /**
     * Display statistics on clients quantity by managers.
     *
     * @return \Illuminate\View\View
     */
    public function clients(Request $request)
    {
    	$managersActive = User::active()->get();
    	$managersFired = User::fired()->get();

    	return view('stats.clients', compact('managersActive', 'managersFired'));
    }

}
