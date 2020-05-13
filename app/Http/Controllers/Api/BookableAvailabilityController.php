<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function __invoke($id,Request $request)
    {
        $data = $request->validate(
            [
                'from' => 'required|date_format:Y-m-d|after_or_equal:now',
                'to' => 'required|date_format:Y-m-d|after_or_equal:from'


            ]
        );

        $bookable = Bookable::findOrFail($id);

        return $bookable->availableFor($data['from'],$data['to']) ? response()->json([]) : response()->json([],404) ;

    }
}
