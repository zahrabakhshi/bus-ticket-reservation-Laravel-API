<?php

namespace App\Http\Controllers\API\AppUser;

use App\Http\Controllers\Controller;
use App\Models\Town;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        //Return the values required for the dashboard
        //Suppose the company dashboard displays company information and company vehicles and trips

        $trips_data = [];

        foreach (Trip::all() as $trip){ //Generate the required information from each company trip
            $trips_data[] = [
                'id' => $trip->id,
                'vehicle' => $trip->vehicle,
                'origin_town' => $trip->locations()->where('type' , 'start_loc')->first()->town()->first(),
                'destination_town' => $trip->locations()->where('type' , 'end_loc')->first()->town()->first(),
                'start_timestamp' => $trip->locations()->where('type' , 'start_loc')->first()->time_hit,
                'end_timestamp' => $trip->locations()->where('type' , 'end_loc')->first()->time_hit,
            ];
        }


        $data = [
            'user' => Auth::user(),
            'vehicles' => Vehicle::where('company_id', Auth::id())->get()->toArray(),
            'trips' => $trips_data,
            'towns' => Town::all()->toArray(),
        ];
        return response()->json($data);
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
