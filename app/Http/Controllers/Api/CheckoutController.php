<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Bookable;
use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {

        $data = $request->validate(
            [
                'bookings.*.bookable_id' => 'required|exists:bookables,id',
                'bookings.*.from' => 'required|after_or_equal:today',
                'bookings.*.to' => 'required|after_or_equal:bookings.*.from',
                'customer.firstname' => 'required|min:3',
                'customer.lastname' => 'required|min:3',
                'customer.email' => 'required|email',
                'customer.street' => 'required|min:3',
                'customer.city' => 'required|min:3',
                'customer.country' => 'required|min:3',
                'customer.state' => 'required|min:3',
                'customer.zip' => 'required|min:3',
            ]

        );

        $data = array_merge($data,

            $request->validate([
                    'bookings.*' => ['required',
                        function ($attribute, $value, $fail) {

                            $bookable = Bookable::findOrFail($value['bookable_id']);

                            if (!$bookable->availableFor($value['from'], $value['to'])) {

                                $fail($bookable->title . ' is not available between ' . $value['from'] . ' and ' . $value['to']);
                            }

                        }
                    ]

                ]
            )

        );

        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];

        $bookings = collect($bookingsData)->map(function ($bookingData) use ($addressData) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($bookingData['from'],$bookingData['to'])['total'];
            $booking->bookable()->associate($bookable);

            $booking->address()->associate(Address::create($addressData));

            $booking->save();

            return $booking;
        });

    }
}
