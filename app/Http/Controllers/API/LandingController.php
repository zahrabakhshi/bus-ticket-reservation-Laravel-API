<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Location;
use App\Models\Passenger;
use App\Models\Reserve;
use App\Models\Trip;
use Illuminate\Http\Request;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LandingController extends Controller
{

    public function getLandingData()
    {
        try {
            return response()->json([
                'data' => [
                    'companies' => $this->getRandomCompanies(),
                    'comments' => $this->getRandomComments(),
                ],
                'message' => 'successful data fetched',
                'status' => Response::HTTP_OK,
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'failed fetched data',
                'status' => $exception->getCode(),
            ]);
        }

    }

    public function getRandomCompanies()
    {
        try {
            return Company::select("name", "email", "phone_number")->inRandomOrder()->limit(5)->get();
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'failed to get random companies',
                'status' => $exception->getCode(),
            ]);
        }
    }

    public function getRandomComments()
    {
        try {
            return Comment::with('company')->inRandomOrder()->limit(5)->get();
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'failed to get random comments',
                'status' => $exception->getCode(),
            ]);
        }
    }

    public function getReservableVehicles(Request $request)
    {
        try {

            //validate user request
            $this->validate($request, [
                'origin' => 'required|exists:towns,id',
                'date' => 'required|integer',
                'destination' => 'required|exists:towns,id',
            ]);

            //To prevent sending unwanted data
            $input = $request->only([
                'origin', 'date', 'destination',
            ]);

            $trips = [];

            //Find the origin location on the user's desired date
            $start_locations_eluquent = Location::where('town_id', $input['origin'])
                ->where('type', 'start_loc')
                ->where('time_hit', '>=', $input['date'])
                ->where('time_hit', '<', strtotime("+1 day", $input['date']));

            //If there is no vehicle from the origin on the user's date, return the appropriate json
            if ($start_locations_eluquent->doesntExist()) {

                return response()->json([
                    'message' => 'no trip exist with this origin in this date',
                    'status' => Response::HTTP_NO_CONTENT,
                ]);

            }

            //get collection of start locations
            $start_locations = $start_locations_eluquent->get();

            //create a flag to determine is there any end location for this trip or not
            $flag = false;

            //To find a trip with the destination intended by the user
            foreach ($start_locations as $start_location) {

                //Find the destination location on the user's desired date
                $end_location_eluquent = Location::where('trip_id', $start_location->trip_id)->where('town_id', $input['destination'])->where('type', 'end_loc');

                //If there is any vehicle with the user's intended destination return the appropriate json
                if ($end_location_eluquent->exists()) {

                    $flag = true;

                    //get Collection object of end locations
                    $end_location = $end_location_eluquent->get();

                    //Find trip with this origin and destination
                    $trip = Trip::find($start_location->trip_id);

                    // Find the remaining capacity of the vehicle:
                    $capacity = $trip->vehicle->capacity;

                    //Add the remaining seats to the number of passengers if the booking record was previously recorded for this trip, otherwise set it to zero.
                    $reserved_seats = Reserve::where('trip_id', $trip->id)->exists() ? Reserve::where('trip_id', $trip->id)->passengers->count() : 0;

                    $remaining_capacity = $capacity - $reserved_seats;

                    if( $remaining_capacity == 0 ){
                        return response()->json([
                            'message' => 'The capacity of the buses is full',
                            'status' => Response::HTTP_NO_CONTENT,
                        ]);
                    }

                    //Add a trip to the trips array by scrolling the loop
                    $trips[] = [
                        'id' => $trip->id,
                        'vehicle' => $trip->vehicle()->get(),
                        'start_location' => $start_location,
                        'end_location' => $end_location,
                        'capacity' => $remaining_capacity
                    ];

                }

                //If there is no vehicle with the user's intended destination return the appropriate json
                if ($flag == false) {

                    return response()->json([
                        'message' => 'no trip exist with this destination in this date',
                        'status' => Response::HTTP_NO_CONTENT,
                    ]);

                }

            }

            //return trips
                return response()->json([
                    'data' => [
                        'trips' => $trips
                    ],
                    'message' => 'successful trips fetched',
                    'status' => Response::HTTP_OK,
                ]);

        }catch (ValidationException$exception){
            return response()->json([
                'message' => $exception->getMessages(),
                'status' => $exception->getCode(),
            ]);

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'failed to fetch trips',
                'status' => $exception->getCode(),
            ]);
        }

    }


}
