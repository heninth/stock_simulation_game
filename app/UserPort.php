<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPort extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function symbol()
    {
        return $this->belongsTo('App\StockSymbol', 'symbol', 'symbol');
    }
}
