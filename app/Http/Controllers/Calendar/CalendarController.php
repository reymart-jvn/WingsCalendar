<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventActivity;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calendar.calendar',
        [
            'title' => "Calendar",
            'subtitle' => "Calendar",
            'table_title' => "Calendar",
            'module' => "",
            'label' => "A system refers to a collection or database of companies or organizations that are registered or recognized within the system. This list helps in managing and organizing information related to different companies and their associated data. The specific details included in the list can vary depending on the system's purpose and requirements."
        ]);
    }

    public function eventActivityList()
    {
        $company_id = company();
        $events = EventActivity::with('events.company', 'activity_location.location', 'eventActivityInCharge.personIncharge')
        ->whereHas('events.company', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
            // $query->where(DB::raw("company_id"), "==", $company_id);
        })->where('status', '1')->orderBy('date_time', 'asc')->get();
        return response()->json([
            'success'   => true,
            'data'      =>  $events,
            'message'   => 'Retrieved successfully'
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
