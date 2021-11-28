<?php

namespace App\Http\Controllers\API;

use App\Models\Location;
use App\Models\Town;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            //Suppose the company enters the following fields through Request
            //departure_date, departure_time , Arriving_time, Origin city, Destination city
            //Name or plate of the vehicle(because the name of the vehicle is not required)
            //we need to refine the information for storage in the database

            //Request Field Validation
            $this->validate($request, [
                'start_time' => 'required|date|date_format:Y-m-d H:i',
                'end_time' => 'required|date|date_format:Y-m-d H:i',
                'vehicle_id' => 'required|integer',
                'origin_town_id' => 'required|integer',
                'destination_town_id' => 'required|integer',

            ]);

            $input = $request->only([
                'start_time', 'end_time', 'vehicle_id', 'origin_town_id', 'destination_town_id'
            ]);

            DB::transaction(function () use ($input) {

                //We have trip and location tables. we have to set records in them

                //Generate a trip
                $new_trip = Trip::create(['vehicle_id' => $input['vehicle_id']]);

                //Generate timestamps for start and end locations
                $start_time_hit = strtotime($input['start_time']);
                $end_time_hit = strtotime($input['end_time']);

                //Generate start and end locations
                $start_location_data = [
                    'trip_id' => $new_trip->id,
                    'time_hit' => $start_time_hit,
                    'type' => 'start_loc',
                    'town_id' => $input['origin_town_id'],
                ];

                $end_location_data = [
                    'trip_id' => $new_trip->id,
                    'time_hit' => $end_time_hit,
                    'type' => 'end_loc',
                    'town_id' => $input['destination_town_id'],
                ];

                Location::create($start_location_data);
                Location::create($end_location_data);

            });
            return response()->json([
//                'data'=> [
//                    'trip' => [$new_trip , $start_location, $end_location],
//                ],
                'message' => 'successful trip added',
                'status' => Response::HTTP_OK,
            ]);
        } catch (ValidationException $exception) {

            return response()->json([
                'message' => $exception->getMessage(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'failed trip add',
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
        try {
            //Return the values to display trip information
            $trip = Trip::find($id);

            return response()->json([
                'data' => [
                    'trip' => $trip,
                ],
                'message' => 'successful vehicle fetched',
                'status' => Response::HTTP_OK,
            ]);
        } catch (Throwable $exception) {

            return response()->json([
                'message' => 'failed to fetch trip data',
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
            //Update database with new values entered for travel

            $this->validate($request, [
                'start_time' => 'date|date_format:Y-m-d H:i',
                'end_time' => 'date|date_format:Y-m-d H:i',
                'vehicle_id' => 'integer',
                'origin_town_id' => 'integer',
                'destination_town_id' => 'integer',
                'origin_id' => 'integer',
                'destination_id' => 'integer',
            ]);

            $input = $request->only([
                'start_time', 'end_time', 'vehicle_id', 'origin_town_id',
                'destination_town_id', 'origin_id', 'destination_id'
            ]);


            DB::transaction(function () use ($input, $id) {

                //Find the modified trip
                $trip = Trip::find($id);

                if (!Gate::allows('update-trip', $trip)) {
                    return response()->json([
                        'message' => 'forbidden',
                        'code' => Response::HTTP_FORBIDDEN,
                    ]);
                }

                //Find modified locations
                if (isset($input['origin_id']))
                    $destination_location = Location::find($input['destination_id']);

                if (isset($input['origin_id']))
                    $origin_location = Location::find($input['origin_id']);

                //Refine and reset new values
                if (isset($input['start_time']))
                    $origin_location->time_hit = strtotime($input['start_time']);
                if (isset($input['end_time']))
                    $destination_location->time_hit = strtotime($input['end_time']);
                if (isset($input['origin_town_id']))
                    $origin_location->town_id = $input['origin_town_id'];
                if (isset($input['destination_town_id']))
                    $destination_location->town_id = $input['destination_town_id'];

                if (isset($input['vehicle']))
                    $trip->vehicle_id = $input['vehicle'];

                //Save new values of Locations(origin and destination) and trip Models
                $trip->save();

                if (isset($origin_location))
                    $origin_location->save();
                if (isset($destination_location))
                    $destination_location->save();

            });

            return response()->json([
                'data' => [
                    'trip' => Trip::find($id),
                ],
                'message' => 'successful trip updated',
                'status' => Response::HTTP_OK,
            ]);

        } catch (ValidationException $exception) {

            return response()->json([
                'message' => $exception->getMessage(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'fail trip updated',
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

            $trip = Trip::find($id);

            if (Gate::allows('update-trip', $trip)) {
                return response()->json([
                    'message' => 'forbidden',
                    'code' => Response::HTTP_FORBIDDEN,
                ]);
            }
            $trip->delete();

            return response()->json([
                'message' => 'successful trip deleted',
                'status' => Response::HTTP_OK,
            ]);

        } catch (\Throwable $exception) {

            return response()->json([
                'message' => 'failed vehicle delete',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }

    }
}
