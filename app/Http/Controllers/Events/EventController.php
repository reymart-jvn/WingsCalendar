<?php

namespace App\Http\Controllers\Events;

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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\CompanyProfile;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'events.manage-events',
            [
                'title' => "Events Schedule Management",
                'subtitle' => "Events Schedule Management",
                'table_title' => "イベントリスト",
                'module' => "",
                'label' => "A company refers to a collection or inventory of different job persons or roles within the organizational structure. This list helps in defining and categorizing the various positions within the company, enabling effective human resources management, organizational planning, and workflow coordination. The specific positions included in the list can vary depending on the company's size, industry, and organizational structure."
            ]
        );
    }

    public function view(Request $request)
    {
        $columns = array(
            0 => 'title',
        );

        if (access_level() == 1) {
            $totalData = Events::with('eventsActivityWeb.activity_location.activity', 'eventsActivityWeb.activity_location.location', 'eventsActivityWeb.eventActivityInCharge.personIncharge')->where('status', '1')->count();
            $query = Events::with('eventsActivityWeb', 'eventsActivityWeb.activity_location.activity', 'eventsActivityWeb.activity_location.location', 'eventsActivityWeb.eventActivityInCharge.personIncharge')->whereHas('eventsActivityWeb', function ($query) {
                $query->orderBy('date_time', 'asc');
            })->where('status', '1');
        } else {
            $totalData = Events::with('eventsActivityWeb.activity_location.activity', 'eventsActivityWeb.activity_location.location', 'eventsActivityWeb.eventActivityInCharge.personIncharge')->where('company_id', company())->where('status', '1')->count();
            $query = Events::with('eventsActivityWeb', 'eventsActivityWeb.activity_location.activity', 'eventsActivityWeb.activity_location.location', 'eventsActivityWeb.eventActivityInCharge.personIncharge')->where('company_id', company())->whereHas('eventsActivityWeb', function ($query) {
                $query->orderBy('date_time', 'asc');
            })->where('status', '1');
        }

        //  dd( $query->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $event = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $event = with(clone $query)->where('description', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDelete = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($event)) {
            foreach ($event as $event) {


                $eventDate = Carbon::createFromFormat('Y-m-d H:i:s', $event->eventsActivityWeb->date_time); // Assuming this is in YYYY-MM-DD format

                // Get today's date
                $todayDate = date('Y-m-d H:i:s');

                // Compare dates
                if ($eventDate >= $todayDate) {
                    // Display the button if event date is today or in the future

                    if (Gate::allows('permission', 'updateEvent')) {
                        $btnUpdate = '<button type="button" onclick="update(' . $event->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                     更新
                 </button>';
                    }
                    if (Gate::allows('permission', 'deleteEvent')) {
                        $btnDelete = '<button onclick="remove(' . $event->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">
                                                                             
                 削除
               </button>';
                    }
                } else {
                    // Do not display the button if event date is in the past
                    $btnUpdate = ''; // or set to null or any default value if needed
                    $btnDelete = '';
                }


                if ($event->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">非アクティブ</span>';
                }
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $event->eventsActivityWeb->date_time);

                $buttons = $btnUpdate . " " . $btnDelete;
                $nestedData['title'] = $event->title;
                $nestedData['type'] = $event->eventsActivityWeb->activity_location->activity->title;
                $nestedData['location'] = $event->eventsActivityWeb->activity_location->location->description;
                $nestedData['date_time'] = strtoupper($date->format('F j, Y g:i A'));
                $nestedData['person_in_charge'] = $event->eventsActivityWeb->eventActivityInCharge[0]->personIncharge->fullname . '<br>' . $event->eventsActivityWeb->eventActivityInCharge[1]->personIncharge->fullname;
                $nestedData['status'] = $status;
                $nestedData['actions'] = $buttons;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        // Sort the data array by date_time
        usort($json_data['data'], function ($a, $b) {
            return strtotime($a['date_time']) - strtotime($b['date_time']);
        });

        return json_encode($json_data);
    }

    public function filterEventScheduleFromTo(Request $request)
    {
        $columns = array(
            0 => 'date_time',
        );

        $from = Carbon::parse($request['valueFrom'])->format('Y-m-d');
        $to = Carbon::parse($request['valueTo'])->format('Y-m-d');

        $from = Carbon::parse($from)->startOfDay();
        $to = Carbon::parse($to)->endOfDay();

        if ($request['valueFrom'] != "" || $request['valueFrom'] != null) {

            $totalData = EventActivity::with('events', 'activity_location.location', 'activity_location.activity', 'eventActivityInCharge.personIncharge')->where('status', '1')->whereBetween('date_time', array($from, $to))->count();
            $query = EventActivity::with('events', 'activity_location.location', 'activity_location.activity', 'eventActivityInCharge.personIncharge')->whereBetween('date_time', array($from, $to))->where('status', '1');
        } else {
            // $totalData = Events::with('eventsActivityWeb.activity_location.activity', 'eventsActivityWeb.activity_location.location', 'eventsActivityWeb.eventActivityInCharge.personIncharge')->where('status', '1')->count();
            $totalData = EventActivity::with('events', 'activity_location.location', 'activity_location.activity', 'eventActivityInCharge.personIncharge')->where('status', '1')->count();
            $query = EventActivity::with('events', 'activity_location.location', 'activity_location.activity', 'eventActivityInCharge.personIncharge')->where('status', '1');
        }


        //  dd( $query->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $event = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $event = with(clone $query)->where('description', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDelete = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($event)) {
            foreach ($event as $event) {


                $eventDate = Carbon::createFromFormat('Y-m-d H:i:s', $event->date_time); // Assuming this is in YYYY-MM-DD format

                // Get today's date
                $todayDate = date('Y-m-d H:i:s');

                // Compare dates
                if ($eventDate >= $todayDate) {
                    // Display the button if event date is today or in the future
                    $btnUpdate = '<button type="button" onclick="update(' . $event->event_id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                     Update
                 </button>';

                    $btnDelete = '<button onclick="remove(' . $event->event_id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">
                                                                             
                 Delete
               </button>';
                } else {
                    // Do not display the button if event date is in the past
                    $btnUpdate = ''; // or set to null or any default value if needed
                    $btnDelete = '';
                }


                if ($event->status == '1') {
                    $status = '<span class="badge badge-success">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger">Inactive</span>';
                }
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $event->date_time);

                $buttons = $btnUpdate . " " . $btnDelete;
                $nestedData['title'] = $event->events->title;
                $nestedData['type'] = $event->activity_location->activity->title;
                $nestedData['location'] = $event->activity_location->location->description;
                $nestedData['date_time'] = strtoupper($date->format('F j, Y g:i A'));
                $nestedData['person_in_charge'] = $event->eventActivityInCharge[0]->personIncharge->fullname . '<br>' . $event->eventActivityInCharge[1]->personIncharge->fullname;
                $nestedData['status'] = $status;
                $nestedData['actions'] = $buttons;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        // Sort the data array by date_time
        usort($json_data['data'], function ($a, $b) {
            return strtotime($a['date_time']) - strtotime($b['date_time']);
        });

        return json_encode($json_data);
    }

    public function getTotalEventsPerCategory()
    {
        $currentYear = date('Y');

        // Get the first day of the current month
        $firstDayOfMonth = Carbon::now()->startOfMonth();

        // Get the last day of the current month
        $lastDayOfMonth = Carbon::now()->endOfMonth();


        // Get the start of the current week (assuming week starts on Monday)
        $startOfWeek = Carbon::now()->startOfWeek();

        // Get the end of the current week (assuming week ends on Sunday)
        $endOfWeek = Carbon::now()->endOfWeek();


        // Get the current date
        $currentDate = Carbon::today();


        if (access_level() == 1) {
            $year = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->whereYear('date_time', $currentYear)
                ->where('status', '1')
                ->count();

            // Retrieve event counts for the current month
            $month = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->whereBetween('date_time', [$firstDayOfMonth, $lastDayOfMonth])
                ->where('status', '1')
                ->count();

            // Retrieve event counts for the current week
            $week = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->whereBetween('date_time', [$startOfWeek, $endOfWeek])
                ->where('status', '1')
                ->count();

            // Retrieve event counts for the current day
            $today = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->whereDate('date_time', $currentDate)
                ->where('status', '1')
                ->count();
        } else {
            $year = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->where('company_id', company())
                ->whereYear('date_time', $currentYear)
                ->where('status', '1')
                ->count();

            // Retrieve event counts for the current month
            $month = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->where('company_id', company())
                ->whereBetween('date_time', [$firstDayOfMonth, $lastDayOfMonth])
                ->where('status', '1')
                ->count();

            // Retrieve event counts for the current week
            $week = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->where('company_id', company())
                ->whereBetween('date_time', [$startOfWeek, $endOfWeek])
                ->where('status', '1')
                ->count();

            // Retrieve event counts for the current day
            $today = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')
                ->where('company_id', company())
                ->whereDate('date_time', $currentDate)
                ->where('status', '1')
                ->count();
        }










        return response()->json([
            'success'   => true,
            'year'      =>  $year,
            'month'      =>  $month,
            'week'      =>  $week,
            'today'      =>  $today,
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
        return view(
            'events.create-event-schedule',
            [
                'title' => "イベントスケジュール作成",
                'subtitle' => "イベントスケジュール作成",
                'table_title' => "イベントスケジュール作成",
                'module' => "",
                'label' => "A comprehensive plan detailing the sequence of events and activities scheduled to take place at a specific venue or location. It outlines timings for presentations, sessions, breaks, and other important milestones, ensuring efficient use of the venue and providing attendees with a clear agenda for the event's duration. This schedule serves as a crucial tool for organizers and participants alike, facilitating smooth coordination and maximizing the venue's utility throughout the event"
            ]
        );
    }

    public function eventActivityList()
    {
        if (access_level() == 1) {
            $events = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')->where('status', '1')->orderBy('date_time', 'asc')->get();
        } else {
            $events = EventActivity::with('events', 'activity_location.location', 'eventActivityInCharge.personIncharge')->where('company_id', company())->where('status', '1')->orderBy('date_time', 'asc')->get();
        }

        return response()->json([
            'success'   => true,
            'data'      =>  $events,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request['add_company']);
        // if (access_level() == 1) {
        //     $input = $request->only([
        //         'selectedDates',
        //         'add_company',
        //         'add_title',
        //         'add_type',
        //         'add_location',
        //         'add_time'
        //     ]);

        //     // Validate input
        //     $validator = Validator::make($input, [
        //         'selectedDates' => 'required',
        //         'add_company' => 'required',
        //         'add_title' => 'required|string|max:255',
        //         'add_type' => 'required',
        //         'add_location' => 'required',
        //         'add_time' => 'required'
        //     ]);
        // } else {
        //     $input = $request->only([
        //         'selectedDates',
        //         'add_title',
        //         'add_type',
        //         'add_location',
        //         'add_time'
        //     ]);

        //     // Validate input
        //     $validator = Validator::make($input, [
        //         'selectedDates' => 'required',
        //         'add_title' => 'required|string|max:255',
        //         'add_type' => 'required',
        //         'add_location' => 'required',
        //         'add_time' => 'required'
        //     ]);
        // }


        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'error' => 'Validation error!',
        //         'messages' => $validator->errors()
        //     ]);
        // }

        // $input = $request->only([
        //     'selectedDates',
        //     'add_company',
        //     'add_title',
        //     'add_type',
        //     'add_location',
        //     'add_time'
        // ]);

        // // Validate inputs
        // $validator = Validator::make($input, [
        //     'selectedDates' => ['required|string'], // Ensures availability is present and is an array
        //     'add_company' => 'required',
        //     'add_title' => 'required|string|max:255',
        //     'add_type' => 'required',
        //     'add_location' => 'required',
        //     'add_time' => 'required'
        // ]);


        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'error' => 'Validation error!',
        //         'messages' => $validator->errors()
        //     ]);
        // }
        // dd("here");

        $selectedDates = json_decode($request['selectedDates'], true);
        // dd($selectedDates);
        $companyId = is_super_admin() == true ? convertData($request['add_company']) : company();
        try {
            DB::beginTransaction();
            foreach ($selectedDates  as $selectedDates) {

                $selectdate = Carbon::parse($selectedDates)->format('Y-m-d H:i:s');

                $event = new Events();
                $event->code = '';
                $event->company_id = is_super_admin() == true ? convertData($request['add_company']) : company();
                $event->title = strtoupper(convertData($request['add_title']));
                $event->description = strtoupper(convertData($request['add_title']));
                $event->status = "1";
                $event->save();
                $event->code = generateCode("EVNT", $event->id);
                $event->save();

                $activitylocation = new ActivityLocation();
                $activitylocation->activity_id = intval($request['add_type']);
                $activitylocation->location_id = intval($request['add_location']);
                $activitylocation->status = "1";
                $activitylocation->save();

                $carbonTime = Carbon::createFromFormat('H:i', $request['add_time'])->format('H:i:s');

                // $formattedTime = $carbonTime->format('H:i:s');

                $datetime = $selectedDates . " " .   $carbonTime;

                // dd( $datetime);

                $checkIfExist = EventActivity::where('date_time', $datetime)->where('company_id', $companyId)->where('status', '1')->first();


                // dd(!$checkIfExist);
                if (!$checkIfExist) {
                    // dd('here');
                    $eventactivity = new EventActivity();
                    $eventactivity->event_id =  $event->id;
                    $eventactivity->company_id = $companyId;
                    $eventactivity->activity_location_id =  $activitylocation->id;
                    $eventactivity->date_time = $datetime;
                    $eventactivity->status = "1";
                    $eventactivity->save();

                    $eventDateTime = Carbon::parse($selectedDates);
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

                    $today = now()->format('Y-m-d H:i:s');
                    $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');

                    // dd($dayType);

                    // $geteventactivityofincahrgethismonth = EventActivityInCharge::with('eventsActivity2')
                    // // ->whereHas('eventsActivity2', function ($query) use ($startOfMonth, $today) {
                    // //     $query->whereBetween('date_time', [$startOfMonth, $today])->where('status', '1');
                    // // })
                    // ->where('status', '1')
                    // ->get();

                    // $selectedMonth = $selectdate->month;
                    // $selectedYear = $selectdate->year;
                    $companyProfile = CompanyProfile::where('id', $companyId)->first();

                    $resetCounterStartDate = $companyProfile->reset_counter_start_date != null
                        ? Carbon::createFromFormat('m/d/Y',  $companyProfile->reset_counter_start_date)->format('Y-m-d H:i:s')
                        : $startOfYear;


                    // if ($selectdate <= $resetCounterStartDate) {
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
      


                    // dd(  $assignments);


                    // Get all persons in charge
                    $allPersonsInCharge = PersonInCharge::where(function ($query) use ($dayType) {
                        $query->where('availability', 'LIKE', "%$dayType%");
                        // ->orWhere('availability', '全て');
                    })
                        ->where('company_id', $companyId)
                        ->where('status', '1')
                        ->pluck('id')
                        ->toArray();

                    // dd($allPersonsInCharge);


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



                    // Step 5: Check if the last ID is selected and wrapping occurred
                    // if (count($nextPersonsInCharge) < 2) {
                    //     $remainingPersons = array_diff($allPersonsInCharge, $nextPersonsInCharge);
                    //     $nextPersonsInCharge = array_merge($nextPersonsInCharge, array_slice($remainingPersons, 0, 2 - count($nextPersonsInCharge)));
                    // }

                    // Step 6: Ensure the assignments are fair, especially for weekends
                    // foreach ($nextPersonsInCharge as $personId) {
                    //     $personAvailability = PersonInCharge::find($personId)->availability;

                    //     // Check if the person is available on the event's day
                    //     // $eventDay = $eventDateTime->format('l'); // Get the event day (e.g., Monday)

                    //     if (strpos($personAvailability, $dayType) === false) {
                    //         // If the person is not available on that day, find the next available person
                    //         $nextPersonsInCharge = array_diff($allPersonsInCharge, [$personId]);
                    //         // Pick the next available person and check again
                    //         continue;
                    //     }
                    // }

                    // Step 6: Skip tied assignments and get the next person
                    $finalPersonsInCharge = [];
                    foreach ($nextPersonsInCharge as $personId) {
                        if (in_array($personId, $finalPersonsInCharge)) {
                            continue; // Skip if already selected
                        }
                        $finalPersonsInCharge[] = $personId;
                    }


                    // dd($finalPersonsInCharge);
                    for ($i = 0; $i < count($finalPersonsInCharge); $i++) {
                        DB::beginTransaction();
                        $events = new EventActivityInCharge();
                        $events->company_id = is_super_admin() == true ? $request['add_company'] : company();
                        $events->personincharge_id = $finalPersonsInCharge[$i];
                        $events->event_activity_id = $eventactivity->id;
                        $events->status = "1";
                        $events->save();
                        DB::commit();
                    }

                    // dd(count($nextPersonsInCharge));
                    $message = '追加場所を保存しました';
                    DB::commit();
                    return response()->json(array('success' => true, 'messages' => $message));
                } else {
                    DB::rollBack();
                    return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Event Schedule Conflict (' . $datetime . ')'));
                }
            }
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events = Events::with('eventsActivityWeb.activity_location.activity', 'eventsActivityWeb.activity_location.location', 'eventsActivityWeb.eventActivityInCharge.personIncharge')->where('status', '1')->findOrFail($id);
        return response()->json([
            'success'   => true,
            'data'      =>  $events,
            'message'   => 'Retrieved successfully'
        ], 200);
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
    public function update(Request $request)
    {

        $event = Events::where('id', $request['update_id'])->where('status', '1')->first();
        $event_activity = EventActivity::where('event_id', $event->id)->where('status', '1')->first();
        $activity_location = ActivityLocation::where('id', $event_activity->activity_location_id)->where('status', '1')->first();
        $previous_date_time = $event_activity->date_time;

        try {
            DB::beginTransaction();

            $event->title = convertData($request['update_title']);
            $event->description = convertData($request['update_title']);
            $event->save();

            $activity_location->activity_id = $request['update_type'];
            $activity_location->location_id = $request['update_location'];
            $activity_location->save();
            // dd( $request['update_time']);
            $carbonTime = Carbon::createFromFormat('H:i', $request['update_time'])->format('H:i:s');

            // Create DateTime object
            $dateTimeObj = new \DateTime($previous_date_time);


            $date = $dateTimeObj->format('Y-m-d'); // '2024-06-24'
            $time = $dateTimeObj->format('H:i:s'); // '10:00:00'

            $event_activity->date_time =  $date . " " .   $carbonTime;
            $event_activity->save();

            $message = 'Record successfully Canceled!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Events::where('id', $id)->where('status', '1')->first();
        $event_activity = EventActivity::where('event_id', $event->id)->where('status', '1')->first();
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
}
