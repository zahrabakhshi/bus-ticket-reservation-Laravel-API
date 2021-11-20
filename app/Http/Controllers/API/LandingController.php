<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Location;
use App\Models\Trip;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LandingController extends Controller
{

    public function getLandingData()
    {
        return response()->json([
            'data' => [
                'companies' => $this->getRandomCompanies(),
                'comments' => $this->getRandomComments(),
            ],
            'message' => 'successful data fetched',
            'status' => Response::HTTP_OK,
        ]);
    }

    public function getRandomCompanies()
    {
        return Company::select("name", "email", "phone_number")->inRandomOrder()->limit(5)->get();
    }

    public function getRandomComments()
    {
//        return Company::has('comments')->->inRandomOrder()->limit(5)->get();
//        return Comment::with('company:name,email,phone_number')->inRandomOrder()->limit(5)->get(['content','created_at']);
//        return Comment::select('content','created_at')->with('company:name,email,phone_number')->inRandomOrder()->limit(5)->get();
        return Comment::with('company')->inRandomOrder()->limit(5)->get();
    }

    public function getReservableVehicles(Request $request)
    {

        $trip_exist = true;
        $trips = [];

        $start_locations_eluquent = Location::where('town_id', $request->origin)->where('type', 'start_loc')->where('time_hit', '>=', $request->date)->where('time_hit', '<=', strtotime("+1 day", $request->date));
        if ($start_locations_eluquent->doesntExist()) {
            $trip_exist = false;
        }
        $start_locations = $start_locations_eluquent->get();

        foreach ($start_locations as $start_location) {

            $end_location = Location::where('trip_id', $start_location->trip_id)->get();

            if ($start_location->trip_id == 15) {
                dd(Trip::find(15));
            }

            $trip = Trip::find($start_location->trip_id);
            $trips[] = [
                'id' => $trip->id,
                'vehicle' => $trip->vehicle()->get(),
                'start_location' => $start_location,
                'end_location' => $end_location,
            ];


        }
        if (!$trip_exist) {
            return response()->json([
                'message' => 'no trip exist with this origin and destination in this time',
                'status' => Response::HTTP_OK,
            ]);
        }

        return response()->json([
            'data' => [
                'trips' => $trips
            ],
            'message' => 'successful trips fetched',
            'status' => Response::HTTP_OK,
        ]);

    }


}
