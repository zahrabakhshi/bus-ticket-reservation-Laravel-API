<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request)
    {

        try {
            //Suppose the company enters vehicle plate(as required field) through Request
            //we need to refine plate for storage in the database

            //We receive the plate in four parts and to make sure it is done correctly, we concat them ourselves
            $request->validate([
                'plate1' => 'required|regex:/^[0-9]{2}$/',
                'plate2' => 'required|regex:/^[0-9]{3}$/',
                'plate3' => 'required|regex:/^[a-z]$/',
                'plate4' => 'required|regex:/^[0-9]{2}$/',
            ]);

            $input = $request->only([
                'plate1', 'plate2', 'plate3', 'plate4'
            ]);


            //concat plate parts
            $plate = $input['plate1'] . '-' . $input['plate2'] . '-' . $input['plate3'] . '-' . $input['plate4'];

            $new_vehicle = [
                'company_id' => Auth::id(),
                'plate' => $plate,
            ];
            $vehicle = Vehicle::create($new_vehicle);


            return response()->json([
                'data' => [
                    'vehicle' => $vehicle
                ] ,
                'message' => 'successful vehicle added',
                'status' => Response::HTTP_OK,
            ]);

        } catch (ValidationException $exception) {

            return response()->json([
                'message' => $exception->getMessage(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'failed vehicle add',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //Return the values to display vehicle information
        try {
            $vehicle = Vehicle::find($id);

            return response()->json([
                'data' => [
                    'vehicle' => $vehicle,
                ],
                'message' => 'successful vehicle fetched',
                'status' => Response::HTTP_OK,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'failed to fetch vehicle data',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        try {

            //We receive the plate in four parts and to make sure it is done correctly, we concat them ourselves
            $request->validate([
                'plate1' => 'regex:/^[0-9]{2}$/',
                'plate2' => 'regex:/^[0-9]{3}$/',
                'plate3' => 'required|regex:/^[a-z]$/',
                'plate4' => 'regex:/^[0-9]{2}$/',
                'name' => 'string',
                'seats_number' => 'integer',
                'catering' => 'boolean',
                'seat_bed' => 'boolean',
                'has_monitor' => 'boolean',
                'is_vip' => 'boolean',
            ]);

            $input = $request->only([
                'plate1', 'plate2', 'plate3', 'plate4',
                'name', 'seats_number', 'catering', 'seat_bed', 'has_monitor', 'is_vip'
            ]);

//            dd($request->name);

            //Update database with new values entered for travel

            //Find the modified trip
            $vehicle = Vehicle::find($id);

            if (!Gate::allows('update-vehicle', $vehicle)) {
                return response()->json([
                    'message' => 'forbidden',
                    'status' => 403,
                ]);
            }

            if (
                isset($input['plate1']) &&
                isset($input['plate2']) &&
                isset($input['plate3']) &&
                isset($input['plate4'])
            ) {
                $plate = $input['plate1'] . '-' . $input['plate2'] . '-' . $input['plate3'] . '-' . $input['plate4'];
            }

            //reset new values
            if (isset($plate))
                $vehicle->plate = $plate;

            if (isset($input['name']))
                $vehicle->name = $input['name'];

            if (isset($input['type']))
                $vehicle->type = $input['type'];

            if (isset($input['seats_number']))
                $vehicle->seats_number = $input['seats_number'];

            if (isset($input['is_vip']))
                $vehicle->is_vip = $input['is_vip'];

            if (isset($input['catering']))
                $vehicle->catering = $input['catering'];

            if (isset($input['seat_bed']))
                $vehicle->seat_bed = $input['seat_bed'];

            if (isset($input['has_monitor']))
                $vehicle->has_monitor = $input['has_monitor'];

            $vehicle->save();

            return response()->json([
                'data' => [
                    'vehicle' => Vehicle::find($id),
                ],
                'message' => 'successful vehicle updated',
                'status' => Response::HTTP_OK,
            ]);
        } catch (ValidationException $exception) {

            return response()->json([
                'message' => $exception->getMessage(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'failed vehicle updated',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        try {

            $vehicle = Vehicle::find($id);

            if (!Gate::allows('update-vehicle', $vehicle)) {

                return response()->json([
                    'message' => 'forbidden',
                    'code' => 403,
                ]);
            }

            $vehicle->delete();

            return response()->json([
                'message' => 'successful vehicle deleted',
                'status' => Response::HTTP_OK,
            ]);

        } catch (Throwable $exception) {

            return response()->json([
                'message' => 'failed vehicle delete',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }

    }
}
