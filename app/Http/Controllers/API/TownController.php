<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;
use Throwable;
use App\Models\Town;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class TownController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'name' => 'required|unique:towns,name',
            ]);

            $input = $request->only(['name']);

            //Save a new city
            $town = Town::create(['name' => $input['name']]);

            return response()->json([
                'data' => [
                    'town' => $town,
                ],
                'message' => 'successful town added',
                'status' => Response::HTTP_OK,
            ]);

        }catch (ValidationException $exception){

            return response()->json([
                'message' => $exception->getMessage(),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);

        }catch(Throwable $exception){

            return response()->json([
                'message' => 'failed town add',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);

        }
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
