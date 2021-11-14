<?php

namespace App\Http\Controllers\AppUser;

use App\Models\Company;
use App\Models\Location;
use App\Models\Town;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function renderView()
    {
        $trips_data = [];

        foreach (Trip::all() as $trip){
            $trips_data[] = [
                'id' => $trip->id,
                'vehicle' => $trip->vehicle,
                'origin' => $trip->locations()->where('type' , 'start_loc')->first()->town()->first(),
                'destination' => $trip->locations()->where('type' , 'end_loc')->first()->town()->first(),
                'start_time' => $trip->locations()->where('type' , 'start_loc')->first()->time_hit,
                'end_time' => $trip->locations()->where('type' , 'end_loc')->first()->time_hit,
            ];
        }
        $data = [
            'user' => Auth::user(),
            'role' => Auth::user()->roles()->get()->toArray(),
            'vehicles' => Vehicle::where('company_id', Auth::id())->get()->toArray(),
            'towns' => Town::all()->toArray(),
            'trips' => $trips_data
        ];
        return view('dashboards.company.company', $data);
    }
}
