<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

class VehicleController extends Controller
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

        try{
            $request->validate([
                'plate1' => 'required|regex:/^[0-9]{2}$/',
                'plate2' => 'required|regex:/^[0-9]{3}$/',
                'plate3' => 'required|regex:/^[a-z]{1}$/',
                'plate4' => 'required|regex:/^[0-9]{2}$/',
            ]);

            $input = $request->only([
                'plate1', 'plate2', 'plate3', 'plate4'
            ]);


            $plate = $input['plate1'] . '-' . $input['plate2'] . '-' . $input['plate3'] . '-' . $input['plate4'];

            $new_vehicle = [
                'company_id' => "26",
                'plate' => $plate,
            ];

            Vehicle::create($new_vehicle);

            return response()
                ->view('dashboards.company.vehicle', $new_vehicle, 200);

        }catch (ValidationException $exception){

            abort(400,'validation error');

        }catch ( \Throwable $exception){

            abort(500 );

        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        $plate = explode("-", $vehicle->plate);

        $data = [
            'id' => $vehicle->id,
            'plate0' => $plate[0],
            'plate1' => $plate[1],
            'plate2' => $plate[2],
            'plate3' => $plate[3],
            'type' => $vehicle->type,
            'name' => $vehicle->name,
            'seats_number' => $vehicle->seats_number,
            'is_vip' => [
                'selected' => $vehicle->is_vip ? "VIP" : "regular",
                'other' => $vehicle->is_vip ? "regular" : "VIP",
                'value' => $vehicle->is_vip
            ],
            'catering' => [
                'selected' => $vehicle->catering ? "has catering" : "no catering",
                'other' => $vehicle->catering ? "no catering" : "has catering",
                'value' => $vehicle->catering
            ],
            'seat_bed' => [
                'selected' => $vehicle->seat_bed ? "seat bed" : "regular seat",
                'other' => $vehicle->seat_bed ? "regular seat" : "seat bed",
                'value' => $vehicle->seat_bed
            ],
            'has_monitor' => [
                'selected' => $vehicle->has_monitor ? "has monitor" : "no monitor",
                'other' => $vehicle->has_monitor ? "no monitor" : "has monitor",
                'value' => $vehicle->has_monitor
            ],

            'created_at' => $vehicle->created_at,
            'updated_at' => $vehicle->updated_at,
        ];
        return response()
            ->view('dashboards.company.vehicle', $data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * //     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->name = $request->name;
        $vehicle->type = $request->type;
        $vehicle->seats_number = $request->seats_number;
        $vehicle->is_vip = $request->is_vip;
        $vehicle->catering = $request->catering;
        $vehicle->seat_bed = $request->seat_bed;
        $vehicle->has_monitor = $request->has_monitor;
        $vehicle->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * //     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Vehicle::find($id)->delete();
        } catch (\Throwable $exception) {
            //?
        }
    }
}
