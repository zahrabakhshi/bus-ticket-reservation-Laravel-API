<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Town;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;
use Throwable;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $trip_data = [
                    'vehicle_id' => $request->vehicle
                ];
                $new_trip = Trip::create($trip_data);

                $start_time_hit = strtotime($request->date . ' ' . $request->start_time);
                if (strtotime($request->end_time) <= strtotime($request->start_time)) {
                    $end_time_hit = strtotime('+1 day', $request->date . ' ' . $request->end_time);
                } else {
                    $end_time_hit = strtotime($request->date . ' ' . $request->end_time);
                }
//        dd($start_time_hit);
                $origin_location = [
                    'trip_id' => $new_trip->id,
                    'time_hit' => $start_time_hit,
                    'type' => 'start_loc',
                    'town_id' => $request->origin,
                ];

                $destination_location = [
                    'trip_یid' => $new_trip->id,
                    'time_hit' => $end_time_hit,
                    'type' => 'end_loc',
                    'town_id' => $request->destination,
                ];

                Location::create($origin_location);
                Location::create($destination_location);

                    return back()->withInput();

            });
        }catch (Throwable $e){
            return back()->with(['error' => 'errors here']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Trip $trip
     * //     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip = Trip::find($id);
        $origin_town_id = $trip->locations()->where('type', 'start_loc')->first()->town()->first()->id;
        $destination_town_id = $trip->locations()->where('type', 'end_loc')->first()->town()->first()->id;
        $data = [
            'user' => Auth::user(),
            'towns' => Town::all()->toArray(),
            'vehicles' => Vehicle::where('company_id', Auth::id())->get()->toArray(),
            'id' => $trip->id,
            'vehicle' => $trip->vehicle,
            'origin_town' => $trip->locations()->where('type', 'start_loc')->first()->town()->first(),
            'destination_town' => $trip->locations()->where('type', 'end_loc')->first()->town()->first(),
            'origin_location' => $trip->locations()->where('type', 'start_loc')->first(),
            'destination_location' => $trip->locations()->where('type', 'end_loc')->first(),
            'start_time' => $trip->locations()->where('type', 'start_loc')->first()->time_hit,
            'end_time' => $trip->locations()->where('type', 'end_loc')->first()->time_hit,
        ];
        return view('dashboards.company.trip', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trip = Trip::find($id);
        $origin_location = Location::find($request->origin_location_id);
        $destination_location = Location::find($request->destination_location_id);

        $origin_date_time_string = $request->date . ' ' . $request->start_time;
        $destination_date_time_string = $request->date . ' ' . $request->end_time;
        $origin_time_hit = strtotime($origin_date_time_string);
        $destination_time_hit = strtotime($destination_date_time_string);

        $trip->vehicle_id = $request->vehicle;
        $origin_location->time_hit = $origin_time_hit;
        $destination_location->time_hit = $destination_time_hit;
        $origin_location->town_id = $request->origin;
        $destination_location->town_id = $request->destination;

        $trip->save();
        $origin_location->save();
        $destination_location->save();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Trip::find($id)->delete();
        }catch (\Throwable $exception){
            //?
        }
    }
}
