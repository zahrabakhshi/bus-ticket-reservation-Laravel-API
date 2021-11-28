<?php

namespace App\Http\Controllers\API;

use App\Models\TemporaryReserve;
use Throwable;
use App\Models\Trip;
use App\Models\Ticket;
use App\Models\Reserve;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Rules\uniquePassengerEveryTrip;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ReserveController extends Controller
{

    public function busInfo(Request $request)
    {
        try {

            $this->validate($request, [
                'trip_id' => 'required|exists:trips,id',
            ]);

            //To prevent sending unwanted data
            $input = $request->only('trip_id');

            //Find free seats
            $free_seats = FreeSeats::findFreeSeats($request['trip_id']);

            //Find full seats
            $trip = Trip::find($input['trip_id']);
            $tickets = $trip->tickets;
            $full_seats = $tickets->pluck('ticket_data');

            return response()->json([
                'data' => [
                    'free seats' => $free_seats,
                    'full seats_info' => $full_seats,
                ],
                'message' => 'successful bus info fetched',
                'status' => Response::HTTP_OK,
            ]);

        } catch (ValidationException $exception) {

            return response()->json([
                'message' => $exception->errors(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);

        } catch (Throwable $exception) {

            return response()->json([
                'message' => 'failed to fetch bus info',
                'msg' => $exception->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);

        }

    }

    public function create()
    {
        try {

            if ($user = auth('api')->user()) {
                $passengers = $user->tickets->pluck('passengers');
                $data = [
                    'user' => $user,
                    'passengers' => $passengers,
                ];
            } else {
                $data = null;
            }


            return response()->json([
                'data' => $data,
                'message' => 'successful reserve form data create',
                'status' => Response::HTTP_OK,
            ]);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'failed reserve form data create',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }
    }

    public function temporaryReserve(Request $request): JsonResponse
    {
        try {

            if (Auth::guard('api')->check()) {

                $this->validate($request, [
                    'trip_id' => 'required|exists:trips,id',
                ]);

                //To prevent sending unwanted data
                $input = $request->only(
                    'trip_id',
                );

                //Find free seats
                $free_seats_array = FreeSeats::findFreeSeats($input['trip_id']);

                //If there is no free seat, it means the capacity is full
                if (empty($free_seats_array)) {

                    return response()->json([
                        'message' => 'full capacity',
                        'status' => Response::HTTP_OK,
                    ]);

                }

                //We need free seats separated with commas to validate the seats that the user wants to rese temporarily
                $free_seats_comma_separator = implode(",", $free_seats_array);

                $this->validate($request, [
                    'seats_number.*' => "required|integer|in:$free_seats_comma_separator",
                ]);

                //To prevent sending unwanted data
                $input = $request->only(
                    'trip_id',
                    'seats_number.*'
                );

                $user = auth('api')->user();

                $seats_array = $input['seats_number']['*'];

                //Create a temporary reserve record
                TemporaryReserve::create([
                    'user_id' => $user->id,
                    'trip_id' => $input['trip_id'],
                    'seats_json' => json_encode($seats_array),
                ]);

                return response()->json([
                    'message' => 'successful temporary reservation',
                    'status' => Response::HTTP_OK,
                ]);

            } else {

                return response()->json([
                    'message' => 'you have to be logged in to continue',
                    'status' => Response::HTTP_UNAUTHORIZED,
                ]);

            }

        } catch (ValidationException $exception) {

            return response()->json([
                'message' => $exception->errors(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY
            ]);

        } catch (Throwable $exception) {

            return response()->json([
                'message' => 'failed temporaryReserve',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);

        }

    }

    public function receipts(Request $request)
    {

        try {

            $this->validate($request, [
                'trip_id' => ['required', 'exists:trips,id', new uniquePassengerEveryTrip()],
                'passengers.*.national_code' => 'required|digits:10',
            ]);

            //To prevent sending unwanted data
            $input = $request->only(
                'trip_id',
            );

            $trip = Trip::find($input['trip_id']);
            $free_seats_array = FreeSeats::findFreeSeats($request['trip_id']);

            //We need free seats separated with commas to validate the seats that the user wants to rese temporarily
            $free_seats_comma_seprator = implode(",", $free_seats_array);

            $this->validate($request, [
                'passengers.*.seat_number' => "required|integer|in:$free_seats_comma_seprator",
            ]);

            //To prevent sending unwanted data
            $input = $request->only(
                'trip_id',
                'passengers'
            );

            //Receive ticket prices, number of passengers and total costs
            $trip_price = $trip->price;
            $passengers_count = count($input['passengers']);
            $total_cost = $passengers_count * $trip_price;

            return response()->json([
                'passengers' => $input['passengers'],
                'trip_price' => $trip_price,
                'total cost' => $total_cost,
                'message' => 'successful reserve total cost calculated',
                'status' => Response::HTTP_OK,
            ]);

        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->errors(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'failed recipes create',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }

    }

    public function store(Request $request)
    {
        try {

            $this->validate($request, [
                'trip_id' => ['required', 'exists:trips,id', new uniquePassengerEveryTrip()],
                'passengers.*.national_code' => 'required|digits:10',
                'passengers.*.gender' => 'required|boolean',
                'passengers.*.name' => 'string|min:3|max:50',
                'passengers.*.last_name' => 'string|min:2|max:50',
            ]);
            $input = $request->only(
                'trip_id',
            );

            $trip = Trip::find($input['trip_id']);
            $free_seats_array = FreeSeats::findFreeSeats($request['trip_id']);
            $free_seats_comma_seprator = implode(",", $free_seats_array);

            $this->validate($request, [
                'passengers.*.seat_number' => "required|integer|in:$free_seats_comma_seprator",
            ]);

            $input = $request->only(
                'trip_id',
                'passengers.*.national_code',
                'passengers.*.gender',
                'passengers.*.name',
                'passengers.*.last_name',
                'passengers.*.seat_number'
            );


            for ($i = 0; $i < count($input['passengers']['*']['national_code']); $i++) {
                $passengers[$i]['national_code'] = array_column($input['passengers']['*'], $i)[0];
                $passengers[$i]['gender'] = array_column($input['passengers']['*'], $i)[1];
                $passengers[$i]['name'] = array_column($input['passengers']['*'], $i)[2];
                $passengers[$i]['last_name'] = array_column($input['passengers']['*'], $i)[3];
                $passengers[$i]['seat_number'] = array_column($input['passengers']['*'], $i)[4];
            }

            $user = auth('api')->user();

            $new_reserve = [
                'user_id' => $user->id,
                'trip_id' => $trip->id,
            ];

            $transaction_needle_data = [
                'passengers' => $passengers,
                'new reserve' => $new_reserve
            ];


            $tickets = DB::transaction(function () use ($transaction_needle_data) {

                $new_reserve = Reserve::create($transaction_needle_data['new reserve']);

                $new_tickets = [];

                foreach ($transaction_needle_data['passengers'] as $passenger_input) {


                    if (Passenger::where('national_code', $passenger_input['national_code'])->exists()) {

                        //todo:return passenger qablan voljus sare mikhay updatesh koni?
                        //age are?
                        //age na?

                        $passenger_id = Passenger::where('national_code', $passenger_input['national_code'])->first()->id;
                        $passenger_object = Passenger::find($passenger_id);

                    } else {

                        $passenger_object = Passenger::create(array_except($passenger_input, ['seat_number']));

                    }

                    $ticket_data = [

                        'seat_number' => $passenger_input['seat_number'],
                        'reserve_id' => $new_reserve->id,
                        'passenger_id' => $passenger_object->id,

                    ];

                    $new_tickets[] = Ticket::create($ticket_data);

                }

                return $new_tickets;

            });

            return response()->json([
                'tickets' => $tickets,
                'message' => 'successful reserve form data create',
                'status' => Response::HTTP_OK,
            ]);


        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->errors(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'failed reserve add',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }
    }

}
