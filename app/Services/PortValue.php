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
     * @param User $user
     * @return array
     */
    public static function update (User $user)
    {
        $portValue = $user->cash;
        foreach ($user->stocks() as $stock) {
            $portValue += $stock->volume * StockSymbol::find($stock->symbol)->close_price;
        }
        $user->port_value = $portValue;
        $user->save();
    }
}

?>
