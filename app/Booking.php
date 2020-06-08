<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Booking extends Model
{
    protected $fillable = ['to', 'from'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function review(){

        return $this->hasOne(Review::class);
    }


    public function scopeBetweenDates(Builder $query, $from, $to)    {
        return $query->where('to', '>=', $from)->where('from', '<=', $to);

    }

    public static function findByReviewkey(string $reviewKey):?Booking{

        return static::where('review_key',$reviewKey)->with('bookable')->get()->first();


    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(static function ($booking){

            $booking -> review_key = Str::uuid();
        });
    }
}