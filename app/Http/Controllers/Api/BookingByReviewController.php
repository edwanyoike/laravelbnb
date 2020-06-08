<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewBookableShowResource;
use App\Http\Resources\BookingByReviewShowResource;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $reviewKey
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function __invoke($reviewKey,Request $request)
    {
        $booking = Booking::findByReviewkey($reviewKey);

        return $booking !== null ? new BookingByReviewShowResource($booking) : abort(404);

    }
}
