<?php

namespace App\Services;

use App\User;
use App\UserPort;
use App\StockSymbol;

class PortValue
{
    /**
     * Update user port value.
     *
     * @param int $user_id
     * @return array
     */
    public static function update ($user_id)
    {
        $user = User::find($user_id)->first();
        $portValue = $user->cash;
        foreach ($user->stocks()->get() as $stock) {
            $portValue += $stock->volume * StockSymbol::find($stock->symbol)->close_price;
        }
        $user->port_value = $portValue;
        $user->save();
    }
}

?>
