<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use App\Models\EventActivity;
use App\Models\EventActivityInCharge;
use App\Models\Events;
use App\Models\PersonInCharge;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\CompanyProfile;

class EventActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($isSuperAdmin, $companyId)
    {
        // $events = EventActivity::with('events','activity_location.activity','activity_location.location','eventActivityInCharge.personIncharge')->get();
        // return response()->json([
        //     'success'   => true,
        //     'data'      =>  $events,
        //     'message'   => 'Retrieved successfully'
        // ], 200);

        if ($isSuperAdmin == 1) {
            $events = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')->where('status', '1')->orderBy('date_time', 'asc')->get();
        } else {
            $events = EventActivity::with('events.company', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->whereHas('events.company', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                    // $query->where(DB::raw("company_id"), "==", $company_id);
                })->where('status', '1')->orderBy('date_time', 'desc')->get();
        }


        return response()->json([
            'success'   => true,
            'data'      =>  $events,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getTodayEventsActivity($isSuperAdmin, $companyId)
    {
        $today = Carbon::today()->toDateString();

        if ($isSuperAdmin == 1) {
            $events = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->where('status', '1')
                ->whereDate('date_time', $today)
                ->orderBy('date_time', 'asc')
                ->get();
        } else {
            $events = EventActivity::with('events.company', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->whereHas('events.company', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                    // $query->where(DB::raw("company_id"), "==", $company_id);
                })->where('status', '1')
                ->whereDate('date_time', $today)
                ->orderBy('date_time', 'asc')
                ->get();
        }

        return response()->json([
            'success'   => true,
            'data'      => $events,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getEventsActivityDateRange($from, $to)
    {
        $fromDate = Carbon::parse($from)->format('Y-m-d');
        $toDate = Carbon::parse($to)->format('Y-m-d');

        $events = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
            ->where('status', '1')
            ->whereBetween('date_time', array($fromDate, $toDate))
            ->orderBy('date_time', 'asc')
            ->get();


        return response()->json([
            'success'   => true,
            'data'      => $events,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getMonthEventsActivity($isSuperAdmin, $companyId)
    {
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth()->toDateString();
        $endOfMonth = $today->copy()->endOfMonth()->toDateString();

        if ($isSuperAdmin == 1) {
            $events = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->where('status', '1')
                ->whereBetween('date_time', [$today, $endOfMonth])
                ->orderBy('date_time', 'asc')
                ->get();
        } else {
            $events = EventActivity::with('events.company', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->whereHas('events.company', function ($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                    // $query->where(DB::raw("company_id"), "==", $company_id);
                })
                ->where('status', '1')
                ->whereBetween('date_time', [$today, $endOfMonth])
                ->orderBy('date_time', 'asc')
                ->get();
        }


        return response()->json([
            'success'   => true,
            'data'      => $events,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getMonthEventsActivityByCompany($company_id)
    {
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth()->toDateString();
        $endOfMonth = $today->copy()->endOfMonth()->toDateString();

        $events = EventActivity::with('events.company', 'activity_location.location', 'eventActivityInCharge.personIncharge')
            ->whereHas('events.company', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
                // $query->where(DB::raw("company_id"), "==", $company_id);
            })->where('status', '1')
            ->whereBetween('date_time', [$today, $endOfMonth])
            ->orderBy('date_time', 'asc')
            ->get();

        return response()->json([
            'success'   => true,
            'data'      => $events,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function cancelEventActivity(Request $request)
    {
        $event = Events::where('id', intval($request['event_id']))->where('status', '1')->first();
        $event_activity = EventActivity::where('event_id', intval($request['event_id']))->where('status', '1')->first();
        $event_in_charge = EventActivityInCharge::where('event_activity_id', $event_activity->id)->where('status', '1')->get();

        try {
            DB::beginTransaction();

            $event->status = "0";
            $event->save();

            $event_activity->status = "0";
            $event_activity->save();

            foreach ($event_in_charge as $incharge) {
                $incharge->status = "0";
                $incharge->save();
            }

            $message = 'Record successfully Canceled!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
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
    function areAllDatesSameMonth($dates)
    {
        // Convert each date string to Carbon instance and get their month
        $months = array_map(function ($date) {
            return Carbon::parse($date)->month;
        }, $dates);

        // Check if all months are the same as the first month
        return count(array_unique($months)) === 1;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {




        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $input = $request->only([
            'pickdate',
            'company',
            'title',
            'activity_id',
            'location_id',
            'picktime'
        ]);

        // Validate input
        $validator = Validator::make($input, [
            'pickdate' => 'required',
            'company' => 'required',
            'title' => 'required|string|max:255',
            'activity_id' => 'required',
            'location_id' => 'required',
            'picktime' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }


        // $datesString = trim($request['pickdate'], '{}');
        // $datesArray = explode(', ', $datesString);

        // dd($datesArray);


        // dd($request['picktime']);
        try {
            DB::beginTransaction();

            $selecteddates = $request['pickdate'];

            // Remove the unnecessary parts to leave just the dates
            $pattern = '/\d{4}-\d{2}-\d{2}/';
            preg_match_all($pattern, $selecteddates, $matches);
            $datesArray = $matches[0];


            $companyId = $request['company'];

            foreach ($datesArray as $date) {
                // $carbonDate = Carbon::parse($date);
                // $formattedDate = $carbonDate->format('Y-m-d');

                // Parse the date string using Carbon
                $selectdate = Carbon::parse($date);


                // Get the current month from the parsed date
           

                $event = new Events();
                $event->code = '';
                $event->company_id = $companyId;
                $event->title = strtoupper(convertData($request['title']));
                $event->description = strtoupper(convertData($request['title']));
                $event->status = "1";
                $event->save();
                $event->code = generateCode("EVNT", $event->id);
                $event->save();


                $activitylocation = new ActivityLocation();
                $activitylocation->activity_id = intval($request['activity_id']);
                $activitylocation->location_id = intval($request['location_id']);
                $activitylocation->status = "1";
                $activitylocation->save();

                $carbonTime = Carbon::createFromFormat('g:i A', $request['picktime']);
                $formattedTime = $carbonTime->format('H:i:s');

                $datetime = $date . " " .  $formattedTime;



                $checkIfExist = EventActivity::with('events')->whereHas('events', function ($checkIfExist) use ($companyId) {
                    $checkIfExist->where('company_id', $companyId)->where('status', '1');
                })->where('date_time', $datetime)->where('status', '1')->first();



                if (!$checkIfExist) {
                    $eventactivity = new EventActivity();
                    $eventactivity->company_id = $companyId;
                    $eventactivity->event_id =  $event->id;
                    $eventactivity->activity_location_id =  $activitylocation->id;
                    $eventactivity->date_time = $datetime;
                    $eventactivity->status = "1";
                    $eventactivity->save();



                    $eventDateTime = Carbon::parse($date);
                    // Parse the event date and time using Carbon
                    // $dayType = $eventDateTime->isWeekday() ? '平日' : '週末';

                    $day = strtoupper($eventDateTime->format('l'));

                    $daysInJapanese = [
                        'SUNDAY'    => '日曜日',
                        'MONDAY'    => '月曜日',
                        'TUESDAY'   => '火曜日',
                        'WEDNESDAY' => '水曜日',
                        'THURSDAY'  => '木曜日',
                        'FRIDAY'    => '金曜日',
                        'SATURDAY'  => '土曜日'
                    ];

                    $dayType = $daysInJapanese[$day] ?? 'Unknown day';

                    // $getAlreadyIncharge = EventActivityInCharge::with('eventsActivity2', 'personIncharge')->whereHas('eventsActivity2', function ($getAlreadyIncharge) {
                    //     $getAlreadyIncharge->where('status', '1');
                    // })->whereHas('personIncharge', function ($getAlreadyIncharge) use ($dayType) {
                    //     $getAlreadyIncharge->where('availability', $dayType)->orWhere('availability', '全て')->where('status', '1');
                    // })->where('company_id', $companyId)
                    //     ->where('status', '1')
                    //     ->orderBy('id')
                    //     ->pluck('personincharge_id')

                    //     ->toArray(); // 2 3 4 5 6 7 2 3

                    // $getAllPersonInCharge = PersonInCharge::where(function ($query) use ($dayType) {
                    //     $query->where('availability', $dayType)
                    //         ->orWhere('availability', '全て');
                    // })
                    //     ->where('company_id', $companyId)->where('status', '1')
                    //     ->pluck('id')
                    //     ->toArray();

                    // if (empty($getAlreadyIncharge)) {
                    //     // If no one is already in charge, get the first 2 available persons
                    //     $nextPersonsInCharge = array_slice($getAllPersonInCharge, 0, 2);
                    // } else {

                    //     $lastIncharge = array_slice($getAlreadyIncharge, -2);

                    //     // Find the positions of the last persons in charge in the sorted list
                    //     $lastInchargeIndex1 = array_search($lastIncharge[0], $getAllPersonInCharge);
                    //     $lastInchargeIndex2 = array_search($lastIncharge[1], $getAllPersonInCharge);


                    //     // Ensure you start from the later index
                    //     $startIndex = max($lastInchargeIndex1, $lastInchargeIndex2);

                    //     // Get the next two available persons in charge in a cyclic manner
                    //     $nextPersonsInCharge = [];
                    //     $totalPersons = count($getAllPersonInCharge);
                    //     for ($i = 1; count($nextPersonsInCharge) < 2; $i++) {
                    //         $nextIndex = ($startIndex + $i) % $totalPersons;
                    //         // dd( $nextIndex);

                    //         $nextPersonsInCharge[] = $getAllPersonInCharge[$nextIndex];
                    //     }
                    // }

                    $selectedMonth = $selectdate->month;
                    $selectedYear = $selectdate->year;

                    $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');

                    $currentMonth = Carbon::now()->month;
                    $currentYear = Carbon::now()->year;

                    $companyProfile = CompanyProfile::where('id', $companyId)->first();

                    $resetCounterStartDate = $companyProfile->reset_counter_start_date != null
                        ? Carbon::createFromFormat('m/d/Y',  $companyProfile->reset_counter_start_date)->format('Y-m-d H:i:s')
                        : $startOfYear;


                    // Get the assignments for this month
                    // $assignments = EventActivityInCharge::with('eventsActivity2', 'personIncharge')->where('company_id', $companyId)
                    //     ->whereHas('eventsActivity2', function ($query) use ($selectedMonth, $selectedYear) {
                    //         $query->whereMonth('date_time', $selectedMonth)
                    //             ->whereYear('date_time', $selectedYear)
                    //             ->where('status', '1');
                    //     })->whereHas('personIncharge', function ($query) use ($dayType) {
                    //         $query->where('availability', $dayType)->orWhere('availability', '全て')
                    //             ->where('status', '1');
                    //     })
                    //     ->select('personincharge_id')
                    //     ->get()
                    //     ->groupBy('personincharge_id')
                    //     ->map(function ($group) {
                    //         return $group->count();
                    //     })
                    //     ->toArray();

                    $assignments = EventActivityInCharge::with('eventsActivity2', 'personIncharge')
                    ->where('company_id', $companyId)
                    ->where('status', '1')
                    ->whereHas('eventsActivity2', function ($query) use ($resetCounterStartDate, $selectdate) {
                        $query->whereBetween('date_time', [$resetCounterStartDate, $selectdate]) //10/05/2024 - 10/08/2024
                            ->where('status', '1');
                    })
                    ->whereHas('personIncharge', function ($query) use ($dayType) {
                        $query->where('availability', 'LIKE', "%$dayType%")
                            ->where('status', '1');
                    })
                    ->select('personincharge_id')
                    ->get()
                    ->groupBy('personincharge_id')
                    ->map(function ($group) {
                        return $group->count();
                    })
                    ->toArray();
  


                    // $allPersonsInCharge = PersonInCharge::where(function ($query) use ($dayType) {
                    //     $query->where('availability', $dayType)
                    //         ->orWhere('availability', '全て');
                    // })
                    //     ->where('company_id', $companyId)
                    //     ->where('status', '1')
                    //     ->pluck('id')
                    //     ->toArray();

                    $allPersonsInCharge = PersonInCharge::where(function ($query) use ($dayType) {
                        $query->where('availability', 'LIKE', "%$dayType%");
                        // ->orWhere('availability', '全て');
                    })
                        ->where('company_id', $companyId)
                        ->where('status', '1')
                        ->pluck('id')
                        ->toArray();


                    // dd( $assignments);

                    // $personsWithNoAssignments = array_diff($allPersonsInCharge, array_keys($assignments));
                    // if (!empty($personsWithNoAssignments)) {
                    //     // If there are persons with zero assignments, return them
                    //     $nextPersonsInCharge = array_slice($personsWithNoAssignments, 0, 2);
                    // } else {
                    //     // Sort counts in ascending order
                    //     asort($assignments); // Sort by value in ascending order (fewest assignments first)

                    //     // Get the IDs of the two persons with the lowest counts
                    //     $lowestAssignments = array_slice($assignments, 0, 2, true);
                    //     $nextPersonsInCharge = array_keys($lowestAssignments);

                    //     // If we don't have exactly 2 IDs, handle this case
                    //     if (count($nextPersonsInCharge) < 2) {
                    //         // If fewer than 2, fill the selection from available persons
                    //         $remainingPersons = array_diff($allPersonsInCharge, $nextPersonsInCharge);

                    //         // Handle wrapping to the start of the list
                    //         $additionalPersonsNeeded = 2 - count($nextPersonsInCharge);
                    //         $nextPersonsInCharge = array_merge($nextPersonsInCharge, array_slice($remainingPersons, 0, $additionalPersonsNeeded));

                    //         // If still fewer than 2 persons, wrap to the beginning of the all persons list
                    //         if (count($nextPersonsInCharge) < 2) {
                    //             $nextPersonsInCharge = array_merge($nextPersonsInCharge, array_slice($allPersonsInCharge, 0, 2 - count($nextPersonsInCharge)));
                    //         }

                    //         // Ensure there are no duplicates
                    //         $nextPersonsInCharge = array_unique($nextPersonsInCharge);
                    //     }
                    // }

                    // // If the last ID is selected and wrap occurs, ensure it's handled correctly
                    // if (count($nextPersonsInCharge) < 2) {
                    //     $remainingPersons = array_diff($allPersonsInCharge, $nextPersonsInCharge);
                    //     $nextPersonsInCharge = array_merge($nextPersonsInCharge, array_slice($remainingPersons, 0, 2 - count($nextPersonsInCharge)));
                    // }

                     // Step 1: Identify persons with no assignments
                     $personsWithNoAssignments = array_diff($allPersonsInCharge, array_keys($assignments));

                     if (!empty($personsWithNoAssignments)) {
                         // If there are persons with zero assignments, prioritize them
                         $nextPersonsInCharge = array_slice($personsWithNoAssignments, 0, 2);
                     } else {
                         // Step 2: Sort counts in ascending order (fewest assignments first)
                         asort($assignments);
 
                         // Step 3: Get the IDs of the two persons with the lowest counts
                         $lowestAssignments = array_slice($assignments, 0, 2, true);
                         $nextPersonsInCharge = array_keys($lowestAssignments);
 
                         // Step 4: Check if we have fewer than 2 persons, fill from available persons
                         if (count($nextPersonsInCharge) < 2) {
                             // Get remaining persons
                             $remainingPersons = array_diff($allPersonsInCharge, $nextPersonsInCharge);
 
                             // Handle wrapping to the start of the list if necessary
                             $additionalPersonsNeeded = 2 - count($nextPersonsInCharge);
                             $nextPersonsInCharge = array_merge($nextPersonsInCharge, array_slice($remainingPersons, 0, $additionalPersonsNeeded));
 
                             // If still fewer than 2 persons, wrap to the beginning of the all persons list
                             // if (count($nextPersonsInCharge) < 2) {
                             //     $nextPersonsInCharge = array_merge($nextPersonsInCharge, array_slice($allPersonsInCharge, 0, 2 - count($nextPersonsInCharge)));
                             // }
 
                             // Ensure no duplicates
                             // $nextPersonsInCharge = array_unique($nextPersonsInCharge);
                         }
                     }
 
                     // Step 5: Handle availability fairness for the current day
                     foreach ($nextPersonsInCharge as $key => $personId) {
                         $personAvailability = PersonInCharge::find($personId)->availability;
 
                         // Ensure the person is available on the event's day
                         if (strpos($personAvailability, $dayType) === false) {
                             unset($nextPersonsInCharge[$key]);
                         }
                     }

                     $finalPersonsInCharge = [];
                     foreach ($nextPersonsInCharge as $personId) {
                         if (in_array($personId, $finalPersonsInCharge)) {
                             continue; // Skip if already selected
                         }
                         $finalPersonsInCharge[] = $personId;
                     }
 


                    for ($i = 0; $i < count($finalPersonsInCharge); $i++) {
                        DB::beginTransaction();
                        $events = new EventActivityInCharge();
                        $events->company_id = $companyId;
                        $events->personincharge_id = $finalPersonsInCharge[$i];
                        $events->event_activity_id = $eventactivity->id;
                        $events->status = "1";
                        $events->save();

                        DB::commit();
                    }

                    $message = '追加場所を保存しました';
                    DB::commit();
                } else {
                    DB::rollBack();
                    return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Event Schedule Conflict (' . $datetime . ')'));
                }
            }





            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }

    public function assignPersonsInCharge($eventActivityId, $availability)
    {
        // // Get all persons in charge based on availability
        // $personsInCharge = PersonInCharge::where('availability', $availability)->where('status', '1')->orderBy('id')
        //     ->get();
        // $totalPersons = count($personsInCharge);

        // // Edge case: if there are fewer than two persons in charge
        // if ($totalPersons < 2) {
        //     return response()->json(['success' => false, 'error' => 'Not enough persons in charge to assign pairs.']);
        // }

        // Retrieve the last two persons in charge for the specific event_activity_id from the database
        $lastAssignedPersons = EventActivityInCharge::where('status', '1')
            ->orderBy('id', 'desc')
            ->take(2)
            ->pluck('personincharge_id')
            ->toArray();

        // Get the maximum ID of the last assigned pair
        $maxPersonId = max($lastAssignedPersons);

        // Find the next available pair of persons in charge
        $nextPerson = PersonInCharge::where('availability', $availability)
            ->where('status', '1')
            ->where('id', '>', $maxPersonId)
            ->orderBy('id')
            ->first();

        if ($nextPerson) {
            // If there is a person with ID greater than $maxPersonId, get the next available pair
            $nextAvailablePair = PersonInCharge::where('availability', $availability)
                ->where('status', '1')
                ->where('id', '>', $maxPersonId)
                ->orderBy('id')
                ->take(2)
                ->pluck('id')
                ->toArray();
        } else {
            // If there is no person with ID greater than $maxPersonId, start assigning pairs from the beginning
            $nextAvailablePair = PersonInCharge::where('availability', $availability)
                ->where('status', '1')
                ->orderBy('id')
                ->take(2)
                ->pluck('id')
                ->toArray();
        }

        // dd($nextAvailablePair);


        for ($i = 0; $i > count($nextAvailablePair); $i++) {
            DB::beginTransaction();
            $events = new EventActivityInCharge();
            $events->personincharge_id = $nextAvailablePair[$i];
            $events->event_activity_id = $eventActivityId;
            $events->status = "1";
            $events->save();
            DB::commit();
        }

        return response()->json(['success' => true, 'message' => 'Persons in charge assigned successfully.']);
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
