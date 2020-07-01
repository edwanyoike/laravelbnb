<?php

namespace App;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Bookable
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $title
 * @property string $description
 * @property-read Collection|Booking[] $bookings
 * @property-read int|null $bookings_count
 * @method static Builder|Bookable newModelQuery()
 * @method static Builder|Bookable newQuery()
 * @method static Builder|Bookable query()
 * @method static Builder|Bookable whereCreatedAt($value)
 * @method static Builder|Bookable whereDescription($value)
 * @method static Builder|Bookable whereId($value)
 * @method static Builder|Bookable whereTitle($value)
 * @method static Builder|Bookable whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Bookable extends Model
{

    protected $table = 'bookables';


    public function availableFor($from, $to): bool
    {
        return 0 === $this->bookings()->betweenDates($from, $to)->count();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function priceFor($from, $to)
    {
        try {
            $days = (new Carbon($from))->diffInDays(new Carbon($to)) + 1;
            $price = $days * $this->price;

            return[
                    'total' => $price,
                    'breakdown' => [
                        $this->price => $days
                    ]
            ];

        }
        catch (Exception $e) {
        }
    }
}
