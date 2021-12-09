<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenPdfRequest;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PDFController extends Controller
{
    public function generatePDF(GenPdfRequest $request)
    {
        $validated = $request->safe()->only(['ticket_id']);

        $ticket = Ticket::find($validated['ticket_id']);

        $passenger_first_name = $ticket->ticketable->name;
        $passenger_last_name = $ticket->ticketable->last_name;
        $ticket_create_date = $ticket->created_at->format('Y/m/d H:i:s');
        $origin = $ticket->reserve->trip->locations->where('type', 'start_loc')->first()->town->name;
        $destination = $ticket->reserve->trip->locations->where('type', 'end_loc')->first()->town->name;
        $company_name = $ticket->reserve->trip->vehicle->company->name;
        $departure_date_time = $ticket->reserve->trip->locations->where('type', 'start_loc')->first()->time_hit;
        $seats_number = $ticket->seat_number;

        $ticket = [
            'passenger_first_name' => $passenger_first_name,
            'passenger_last_name' => $passenger_last_name,
            'ticket_create_date' => $ticket_create_date,
            'origin' => $origin,
            'destination' => $destination,
            'company_name' => $company_name,
            'departure_date_time' => $departure_date_time,
            'seats_number' => $seats_number,
        ];


        $html1 = view('myPDF')->with($ticket)->render();
        $html = mb_convert_encoding($html1, 'HTML-ENTITIES', 'UTF-8');

        $pdf = PDF::loadHtml($html);
        return $pdf->stream("ticket", array("Attachment" => 0));

//        $pdf = PDF::loadView('myPDF', $ticket);
//        return $pdf->download('name.pdf');
    }
}
